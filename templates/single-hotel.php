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
    
    // Custom scorecard metadata
    $rating_location = get_post_meta( $id, '_hotel_rating_location', true );
    $rating_comfort = get_post_meta( $id, '_hotel_rating_comfort', true );
    $rating_facilities = get_post_meta( $id, '_hotel_rating_facilities', true );
    $reviews_count = get_post_meta( $id, '_hotel_reviews_count', true );
    $couple_friendly = get_post_meta( $id, '_hotel_couple_friendly', true );
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
                        <?php if ( $couple_friendly === 'yes' ) : ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-100">
                                <i class="fa-solid fa-heart mr-1.5 text-pink-500"></i> Couple Friendly
                            </span>
                        <?php endif; ?>
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-semibold font-lato tracking-tight text-slate-900"><?php the_title(); ?></h1>
                </div>

                <?php if ( ! empty( $reviews_count ) ) : ?>
                    <!-- Ratings Score Card -->
                    <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                        <div class="flex items-center space-x-4 border-b md:border-b-0 md:border-r border-slate-200 pb-4 md:pb-0 md:pr-6">
                            <div class="bg-blue-900 text-white w-14 h-14 rounded-2xl flex flex-col items-center justify-center font-bold shadow-md flex-shrink-0">
                                <span class="text-xl leading-none">4.5</span>
                                <span class="text-[9px] uppercase font-semibold text-blue-300">/ 5</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-base">Excellent</h4>
                                <p class="text-xs text-slate-500 font-semibold"><?php echo esc_html( $reviews_count ); ?> Reviews</p>
                            </div>
                        </div>
                        <div class="md:col-span-3 grid grid-cols-3 gap-4 text-xs font-bold text-slate-600">
                            <?php if ( ! empty( $rating_location ) ) : ?>
                                <div class="bg-white p-3.5 rounded-2xl border border-slate-100 text-center">
                                    <span class="text-slate-400 block text-[9px] uppercase tracking-wider mb-0.5 font-bold">Location</span>
                                    <span class="text-slate-800 text-sm font-black"><?php echo esc_html( $rating_location ); ?> / 5</span>
                                </div>
                            <?php endif; ?>
                            <?php if ( ! empty( $rating_comfort ) ) : ?>
                                <div class="bg-white p-3.5 rounded-2xl border border-slate-100 text-center">
                                    <span class="text-slate-400 block text-[9px] uppercase tracking-wider mb-0.5 font-bold">Comfort</span>
                                    <span class="text-slate-800 text-sm font-black"><?php echo esc_html( $rating_comfort ); ?> / 5</span>
                                </div>
                            <?php endif; ?>
                            <?php if ( ! empty( $rating_facilities ) ) : ?>
                                <div class="bg-white p-3.5 rounded-2xl border border-slate-100 text-center">
                                    <span class="text-slate-400 block text-[9px] uppercase tracking-wider mb-0.5 font-bold">Facilities</span>
                                    <span class="text-slate-800 text-sm font-black"><?php echo esc_html( $rating_facilities ); ?> / 5</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Hotel Image Gallery Slider -->
                <div class="rounded-3xl overflow-hidden shadow-md aspect-w-16 h-96 sm:h-128 relative bg-slate-900" id="hotel-gallery-slider">
                    <div id="slides-container" class="absolute inset-0">
                        <?php
                        $gallery_meta = get_post_meta( $id, '_hotel_image_gallery_urls', true );
                        $rendered_slides = 0;
                        
                        if ( ! empty( $gallery_meta ) ) {
                            $external_gallery = explode( ',', $gallery_meta );
                            foreach ( $external_gallery as $idx => $img_url ) {
                                $active_class = ( $rendered_slides === 0 ) ? 'active' : '';
                                echo '<div class="gallery-slide ' . esc_attr( $active_class ) . '"><img src="' . esc_url( trim( $img_url ) ) . '" alt="" class="object-cover w-full h-full"></div>';
                                $rendered_slides++;
                            }
                        } else {
                            $gallery = get_post_meta( $id, '_hotel_gallery', true );
                            $attachment_ids = ! empty( $gallery ) ? explode( ',', $gallery ) : array();
                            
                            // Fallback to featured image if no gallery
                            if ( empty( $attachment_ids ) && has_post_thumbnail() ) {
                                $attachment_ids[] = get_post_thumbnail_id();
                            }
                            
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
                        }
                        
                        if ( $rendered_slides === 0 ) {
                            $default_slides = array(
                                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                                'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=1200&q=80',
                                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80'
                            );
                            if ( strpos( strtolower( get_the_title() ), 'sayeman' ) !== false ) {
                                $default_slides = array(
                                    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
                                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80'
                                );
                            }
                            foreach ( $default_slides as $s_idx => $slide_url ) {
                                $active_class = ( $s_idx === 0 ) ? 'active' : '';
                                echo '<div class="gallery-slide ' . esc_attr( $active_class ) . '"><img src="' . esc_url( $slide_url ) . '" alt="" class="object-cover w-full h-full"></div>';
                            }
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

                <?php
                $nearby_interest = get_post_meta( $id, '_hotel_nearby_interest', true );
                $nearby_terminals = get_post_meta( $id, '_hotel_nearby_terminals', true );
                if ( ! empty( $nearby_interest ) || ! empty( $nearby_terminals ) ) :
                ?>
                    <!-- What's Nearby Section -->
                    <div class="space-y-6 mt-8">
                        <h3 class="text-xl font-bold text-slate-950 font-montserrat border-b border-slate-100 pb-2">What's Nearby</h3>
                        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                            
                            <!-- Custom Map Mockup -->
                            <div class="rounded-2xl overflow-hidden relative h-60 bg-slate-200 border border-slate-100 shadow-inner">
                                <iframe src="https://maps.google.com/maps?q=<?php echo urlencode( $location ); ?>&t=&z=14&ie=UTF8&iwloc=&output=embed" class="absolute inset-0 w-full h-full border-none"></iframe>
                            </div>

                            <!-- Nearby Lists -->
                            <div class="space-y-6 text-sm">
                                <?php if ( ! empty( $nearby_interest ) ) : ?>
                                    <div>
                                        <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs mb-3 flex items-center">
                                            <i class="fa-solid fa-location-dot text-teal-600 mr-2"></i> Points of Interest
                                        </h4>
                                        <ul class="space-y-2.5 text-slate-600 font-semibold text-xs leading-relaxed">
                                            <?php
                                            $lines = explode( "\n", $nearby_interest );
                                            foreach ( $lines as $line ) {
                                                $line_trimmed = trim( $line );
                                                if ( ! empty( $line_trimmed ) ) {
                                                    echo '<li class="flex items-start space-x-2"><i class="fa-solid fa-map-pin text-slate-400 text-xs mt-1"></i> <span>' . esc_html( $line_trimmed ) . '</span></li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $nearby_terminals ) ) : ?>
                                    <div>
                                        <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs mb-3 flex items-center">
                                            <i class="fa-solid fa-plane-departure text-teal-600 mr-2"></i> Nearby Terminals
                                        </h4>
                                        <ul class="space-y-2.5 text-slate-600 font-semibold text-xs leading-relaxed">
                                            <?php
                                            $lines = explode( "\n", $nearby_terminals );
                                            foreach ( $lines as $line ) {
                                                $line_trimmed = trim( $line );
                                                if ( ! empty( $line_trimmed ) ) {
                                                    echo '<li class="flex items-start space-x-2"><i class="fa-solid fa-car-side text-slate-400 text-xs mt-1"></i> <span>' . esc_html( $line_trimmed ) . '</span></li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

                <?php
                $check_in = get_post_meta( $id, '_hotel_check_in', true );
                $check_out = get_post_meta( $id, '_hotel_check_out', true );
                $policy_child = get_post_meta( $id, '_hotel_policy_child', true );
                $policy_pet = get_post_meta( $id, '_hotel_policy_pet', true );
                $policy_house = get_post_meta( $id, '_hotel_policy_house', true );
                $policy_extra = get_post_meta( $id, '_hotel_policy_extra', true );
                
                if ( ! empty( $check_in ) || ! empty( $policy_child ) || ! empty( $policy_house ) ) :
                ?>
                    <!-- Hotel Policies & Guidelines -->
                    <div class="space-y-6 mt-8" id="hotel-policy-section">
                        <h3 class="text-xl font-bold text-slate-950 font-montserrat border-b border-slate-100 pb-2">Hotel Policy</h3>
                        
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-6">
                            
                            <!-- Check-in / Check-out timing rows -->
                            <div class="grid grid-cols-2 gap-4 border-b border-slate-100 pb-6">
                                <div class="flex items-center space-x-3 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg">
                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                    </div>
                                    <div>
                                        <span class="text-[9px] text-slate-400 uppercase tracking-wider block font-bold">Check In Time</span>
                                        <span class="text-slate-800 font-extrabold text-xs"><?php echo esc_html( !empty($check_in) ? $check_in : '14:00' ); ?></span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    </div>
                                    <div>
                                        <span class="text-[9px] text-slate-400 uppercase tracking-wider block font-bold">Check Out Time</span>
                                        <span class="text-slate-800 font-extrabold text-xs"><?php echo esc_html( !empty($check_out) ? $check_out : '12:00' ); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Policies breakdown -->
                            <div class="space-y-6 text-xs font-semibold leading-relaxed">
                                <?php if ( ! empty( $policy_child ) ) : ?>
                                    <div class="space-y-1.5">
                                        <h4 class="font-bold text-slate-900 flex items-center"><i class="fa-solid fa-child text-teal-600 mr-2 text-sm"></i> Child Policy</h4>
                                        <div class="text-slate-500 leading-relaxed font-medium pl-6 text-xs prose prose-sm max-w-none">
                                            <?php echo wpautop( wp_kses_post( $policy_child ) ); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $policy_pet ) ) : ?>
                                    <div class="space-y-1.5">
                                        <h4 class="font-bold text-slate-900 flex items-center"><i class="fa-solid fa-paw text-teal-600 mr-2 text-sm"></i> Pet Policy</h4>
                                        <div class="text-slate-500 leading-relaxed font-medium pl-6 text-xs">
                                            <?php echo esc_html( $policy_pet ); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $policy_extra ) ) : ?>
                                    <div class="space-y-1.5">
                                        <h4 class="font-bold text-slate-900 flex items-center"><i class="fa-solid fa-bed text-teal-600 mr-2 text-sm"></i> Extra Bed &amp; Breakfast Policy</h4>
                                        <div class="text-slate-500 leading-relaxed font-medium pl-6 text-xs prose prose-sm max-w-none">
                                            <?php echo wpautop( wp_kses_post( $policy_extra ) ); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $policy_house ) ) : ?>
                                    <div class="space-y-2 border-t border-slate-100 pt-6">
                                        <h4 class="font-bold text-slate-900 flex items-center mb-3"><i class="fa-solid fa-clipboard-list text-teal-600 mr-2 text-sm"></i> House Rules &amp; Guidelines</h4>
                                        <div class="text-slate-500 leading-relaxed font-medium pl-6 text-xs space-y-4 max-h-96 overflow-y-auto pr-2 prose prose-sm max-w-none">
                                            <?php echo wpautop( wp_kses_post( $policy_house ) ); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

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
