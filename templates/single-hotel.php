<?php
/**
 * The template for displaying a single hotel page.
 *
 * @package Travel_Venture
 */

get_header();

if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
    ?>
    <main class="elementor-content-wrapper py-12">
        <?php the_content(); ?>
    </main>
    <?php
} else {
    $id       = get_the_ID();
    $price    = get_post_meta( $id, '_hotel_price', true );
    $location = get_post_meta( $id, '_hotel_location', true );
    $contact  = get_post_meta( $id, '_hotel_contact', true );
    $rating   = '5.0'; // Default rating
    $currency_symbol = esc_html( get_theme_mod( 'currency_symbol', '৳' ) );
    ?>

    <!-- Breadcrumb -->
    <div class="bg-slate-100 py-4 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-slate-500 flex items-center space-x-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-teal-600 transition-colors">Home</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <?php
            $hotel_archive_url = get_post_type_archive_link( 'hotel' ) ? get_post_type_archive_link( 'hotel' ) : home_url( '/hotel/' );
            ?>
            <a href="<?php echo esc_url( $hotel_archive_url ); ?>" class="hover:text-teal-600 transition-colors">Hotels</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-slate-800 font-medium truncate"><?php the_title(); ?></span>
        </div>
    </div>

    <!-- Detail Grid Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow w-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Title & Labels -->
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <?php if ( $location ) : ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-100">
                                <i class="fa-solid fa-location-dot mr-1"></i> <?php echo esc_html( $location ); ?>
                            </span>
                        <?php endif; ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                            <i class="fa-solid fa-star mr-1"></i> <?php echo esc_html( $rating ); ?> Star Rating
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-semibold font-lato tracking-tight text-slate-900"><?php the_title(); ?></h1>
                </div>

                <!-- Hotel Image Gallery Slider -->
                <div class="rounded-3xl overflow-hidden shadow-md aspect-w-16 h-96 sm:h-128 relative bg-slate-900" id="hotel-gallery-slider">
                    <div id="slides-container" class="absolute inset-0">
                        <?php
                        $gallery = get_post_meta( $id, '_hotel_gallery', true );
                        $attachment_ids = ! empty( $gallery ) ? explode( ',', $gallery ) : array();
                        
                        // Fallback to featured image if no gallery
                        if ( empty( $attachment_ids ) && has_post_thumbnail() ) {
                            $attachment_ids[] = get_post_thumbnail_id();
                        }
                        
                        // Render slides
                        $rendered_slides = 0;
                        if ( ! empty( $attachment_ids ) ) {
                            foreach ( $attachment_ids as $idx => $attachment_id ) {
                                $img_url = wp_get_attachment_image_url( $attachment_id, 'large' );
                                if ( $img_url && ( strpos( $img_url, 'localhost' ) === false || strpos( home_url(), 'localhost' ) !== false ) ) {
                                    $active_class = ( $rendered_slides === 0 ) ? 'active' : '';
                                    echo '<div class="gallery-slide ' . esc_attr( $active_class ) . '"><img src="' . esc_url( $img_url ) . '" alt="" class="object-cover w-full h-full"></div>';
                                    $rendered_slides++;
                                }
                            }
                        }
                        
                        if ( $rendered_slides === 0 ) {
                            // default fallback image
                            echo '<div class="gallery-slide active"><img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80" alt="" class="object-cover w-full h-full"></div>';
                        }
                        ?>
                    </div>
                    
                    <!-- Navigation Buttons -->
                    <button type="button" id="prev-slide-btn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-slate-900 bg-opacity-50 hover:bg-opacity-75 text-white w-10 h-10 rounded-full flex items-center justify-center border-none cursor-pointer z-20">
                        <i class="fa-solid fa-chevron-left text-sm"></i>
                    </button>
                    <button type="button" id="next-slide-btn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-slate-900 bg-opacity-50 hover:bg-opacity-75 text-white w-10 h-10 rounded-full flex items-center justify-center border-none cursor-pointer z-20">
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </button>

                    <!-- Dots Indicators -->
                    <div id="slider-dots-container" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                        <?php
                        if ( $rendered_slides > 0 ) {
                            for ( $i = 0; $i < $rendered_slides; $i++ ) {
                                $active_class = ( $i === 0 ) ? 'active' : '';
                                echo '<span class="slider-dot ' . esc_attr( $active_class ) . '"></span>';
                            }
                        } else {
                            echo '<span class="slider-dot active"></span>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Description -->
                <div class="prose prose-teal max-w-none space-y-6 text-slate-600 leading-relaxed text-base">
                    <h3 class="text-xl font-bold text-slate-950 font-montserrat border-b border-slate-100 pb-2">About The Resort</h3>
                    <p><?php the_content(); ?></p>
                </div>

                <!-- Video Showcase Block -->
                <div class="space-y-4" id="hotel-video-section">
                    <h3 class="text-xl font-bold text-slate-950 font-montserrat border-b border-slate-100 pb-2">Video Showcase</h3>
                    <div class="rounded-3xl overflow-hidden shadow-md aspect-w-16 h-96 sm:h-128 relative bg-black" id="video-container">
                        <?php
                        $video = get_post_meta( $id, '_hotel_video', true );
                        if ( ! empty( $video ) ) {
                            $ytMatch = preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $video, $matches );
                            if ( $ytMatch && isset( $matches[1] ) ) {
                                $youtubeId = $matches[1];
                                echo '<iframe src="https://www.youtube.com/embed/' . esc_attr( $youtubeId ) . '?rel=0" allowfullscreen class="absolute inset-0 w-full h-full border-none rounded-3xl"></iframe>';
                            } else {
                                echo '<video controls src="' . esc_url( $video ) . '" class="absolute inset-0 w-full h-full object-cover rounded-3xl"></video>';
                            }
                        } else {
                            echo '<iframe src="https://www.youtube.com/embed/ScXs7L0fVk0?rel=0" allowfullscreen class="absolute inset-0 w-full h-full border-none rounded-3xl"></iframe>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Amenities -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-slate-950 font-montserrat border-b border-slate-100 pb-2">Premium Amenities Included</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <?php
                        $amenities = get_post_meta( $id, '_hotel_amenities', true );
                        if ( ! empty( $amenities ) ) {
                            $tags = explode( ',', $amenities );
                            foreach ( $tags as $tag ) {
                                $tag_trimmed = trim( $tag );
                                $icon_class = 'fa-circle-check'; // Default icon
                                
                                // Map typical amenities to FontAwesome icons
                                $tag_lower = strtolower( $tag_trimmed );
                                if ( strpos( $tag_lower, 'wi-fi' ) !== false || strpos( $tag_lower, 'wifi' ) !== false ) {
                                    $icon_class = 'fa-wifi';
                                } elseif ( strpos( $tag_lower, 'pool' ) !== false || strpos( $tag_lower, 'swimming' ) !== false ) {
                                    $icon_class = 'fa-water-ladder';
                                } elseif ( strpos( $tag_lower, 'spa' ) !== false || strpos( $tag_lower, 'massage' ) !== false ) {
                                    $icon_class = 'fa-spa';
                                } elseif ( strpos( $tag_lower, 'dining' ) !== false || strpos( $tag_lower, 'restaurant' ) !== false || strpos( $tag_lower, 'breakfast' ) !== false ) {
                                    $icon_class = 'fa-utensils';
                                } elseif ( strpos( $tag_lower, 'fitness' ) !== false || strpos( $tag_lower, 'gym' ) !== false ) {
                                    $icon_class = 'fa-dumbbell';
                                } elseif ( strpos( $tag_lower, 'service' ) !== false || strpos( $tag_lower, 'butler' ) !== false || strpos( $tag_lower, 'front desk' ) !== false ) {
                                    $icon_class = 'fa-bell';
                                }
                                
                                ?>
                                <div class="flex items-center space-x-3 text-slate-600 bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                                    <i class="fa-solid <?php echo esc_attr($icon_class); ?> text-teal-600"></i>
                                    <span class="text-sm font-medium"><?php echo esc_html( $tag_trimmed ); ?></span>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="flex items-center space-x-3 text-slate-600 bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                                <i class="fa-solid fa-circle-check text-teal-600"></i>
                                <span class="text-sm font-medium">Standard luxury amenities</span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Right Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 bg-white rounded-3xl p-8 border border-slate-100 shadow-lg space-y-6">
                    <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                        <div>
                            <span class="text-slate-400 text-xs uppercase tracking-wider block">Exclusive Rate</span>
                            <span id="sidebar-price" class="text-3xl font-extrabold text-slate-900"><?php echo $currency_symbol; ?><?php echo esc_html( $price ); ?></span>
                            <span class="text-slate-500 text-sm">/ night</span>
                        </div>
                        <div class="bg-teal-50 text-teal-700 px-3 py-2 rounded-2xl flex flex-col items-center">
                            <span id="sidebar-rating" class="text-lg font-bold leading-none"><?php echo esc_html( $rating ); ?></span>
                            <span class="text-[10px] font-semibold uppercase text-teal-500">Rating</span>
                        </div>
                    </div>

                    <div class="space-y-4 text-sm text-slate-600">
                        <div class="flex justify-between">
                            <span>Service Fee</span>
                            <span class="font-medium text-slate-900">Included</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Local Tourist Tax</span>
                            <span class="font-medium text-slate-900">Included</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Cancellation Policy</span>
                            <span class="font-medium text-emerald-600">Free cancellation</span>
                        </div>
                    </div>

                    <!-- Booking Trigger Button -->
                    <button type="button" id="details-booking-btn" class="btn-premium w-full px-6 py-4 rounded-full text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 shadow-md text-center inline-block cursor-pointer outline-none border-none transform hover:-translate-y-0.5"
                            data-hotel="<?php the_title_attribute(); ?>"
                            data-phone="<?php echo esc_attr( $contact ); ?>"
                            data-price="<?php echo esc_attr( $price ); ?>">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Click for Booking
                    </button>

                    <div class="text-center pt-2">
                        <span class="text-xs text-slate-400 block"><i class="fa-solid fa-lock text-emerald-500 mr-1"></i> Best Rate Guarantee Secured</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900 bg-opacity-60 backdrop-filter backdrop-blur-md close-modal-trigger">
        <div class="relative w-full max-w-lg p-8 md:p-10 rounded-3xl glassmorphism text-slate-900 shadow-2xl transition-all duration-300 transform scale-95" onclick="event.stopPropagation();">
            
            <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors close-modal-trigger text-2xl font-bold p-2 focus:outline-none">
                &times;
            </button>

            <div class="w-16 h-16 mx-auto mb-6 bg-teal-100 rounded-full flex items-center justify-center text-teal-600 text-2xl shadow-inner">
                <i class="fa-solid fa-phone-volume"></i>
            </div>

            <div class="text-center space-y-2 mb-6">
                <span class="text-teal-600 font-semibold tracking-wider text-xs uppercase font-montserrat">Direct Concierge Route</span>
                <h3 id="modal-hotel-title" class="text-2xl font-bold font-montserrat tracking-tight">Hotel Title</h3>
            </div>

            <div id="modal-welcome-text" class="text-slate-600 text-sm leading-relaxed mb-8 text-center">
                Loading welcome message...
            </div>

            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="text-left">
                    <span class="text-slate-400 text-[10px] uppercase tracking-wider block">Reservations Desk</span>
                    <span id="modal-phone-number-display" class="text-slate-900 font-extrabold text-base font-montserrat">+1 (800) 000-0000</span>
                </div>
                <a id="modal-call-btn" href="#" class="pulse-call-btn inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 text-white font-bold text-sm rounded-xl transition-all shadow-md">
                    <i class="fa-solid fa-phone mr-2"></i> Call to Reserve
                </a>
            </div>
        </div>
    </div>

    <!-- Gallery Slider JS Handler for Single Post (Only loaded if not Elementor) -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.gallery-slide');
        const dots = document.querySelectorAll('.slider-dot');
        let currentSlide = 0;

        function showSlide(index) {
            if (slides.length === 0) return;
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            
            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        const prevBtn = document.getElementById('prev-slide-btn');
        const nextBtn = document.getElementById('next-slide-btn');

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
            nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));
        }

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => showSlide(idx));
        });

        // Booking popup trigger
        const bookingBtn = document.getElementById('details-booking-btn');
        const modal = document.getElementById('booking-modal');
        const closeModalButtons = document.querySelectorAll('.close-modal-trigger');

        if (bookingBtn && modal) {
            bookingBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const hotelName = bookingBtn.getAttribute('data-hotel');
                const phone = bookingBtn.getAttribute('data-phone');
                const price = bookingBtn.getAttribute('data-price');
                const phoneFormatted = phone.replace(/[^+\d]/g, '');

                document.getElementById('modal-hotel-title').textContent = hotelName;
                document.getElementById('modal-phone-number-display').textContent = phone;
                document.getElementById('modal-call-btn').setAttribute('href', 'tel:' + phoneFormatted);

                let welcomeMsg = 'Welcome to the booking gate for <strong>' + hotelName + '</strong>. We are thrilled to assist you with organizing your luxury stay.';
                welcomeMsg += '<br><br>Your reservation will be customized at the exclusive rate starting from <span class="text-teal-600 font-bold">$' + price + '</span> per night.';
                welcomeMsg += '<br><br>To finalize your dates, room selection, and secure your booking, click the call button below to connect with our dedicated reservations desk.';
                document.getElementById('modal-welcome-text').innerHTML = welcomeMsg;

                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }

        closeModalButtons.forEach(trigger => {
            trigger.addEventListener('click', function() {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    });
    </script>

<?php
} // End of Elementor / Static else check

get_footer();
