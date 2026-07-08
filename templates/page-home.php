<?php
/**
 * Template Name: Homepage Template
 *
 * @package Travel_Venture
 */

get_header();

// Default Hero background image (high-quality Unsplash landscape)
$hero_bg = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80';
$hotel_archive_url = get_post_type_archive_link( 'hotel' ) ? get_post_type_archive_link( 'hotel' ) : home_url( '/hotel/' );
?>

<!-- Hero Section -->
<section class="relative bg-slate-900 text-white pt-24 pb-48 px-4 sm:px-6 lg:px-8 flex flex-col justify-center items-center text-center">
    <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('<?php echo esc_url($hero_bg); ?>');"></div>
    <div class="absolute inset-0 bg-slate-900 bg-opacity-40"></div>
    <div class="relative max-w-4xl mx-auto space-y-6">
        <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight font-montserrat leading-none">
            Find Your Next <span class="bg-gradient-to-r from-teal-400 to-emerald-300 bg-clip-text text-transparent">Luxury Escape</span>
        </h1>
        <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto font-light leading-relaxed">
            Book directly with top Cox's Bazar hotels to secure the best rates. Enjoy a complimentary arrival breakfast and a free private transfer from the airport or station at no extra cost.
        </p>
        <!-- Custom Search Panel with Rooms & Guests -->
        <div class="w-full max-w-5xl mx-auto mt-8 relative z-20">
            <form action="<?php echo esc_url( $hotel_archive_url ); ?>" method="GET" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end text-left" id="search-form-index">
                
                <!-- Destination Select -->
                <div class="space-y-1.5">
                    <label for="location" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Destination</label>
                    <div class="relative flex items-center">
                        <select id="location" name="location" class="w-full pl-10 pr-8 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all appearance-none bg-white text-slate-800">
                            <option value="">Any Destination</option>
                            <option value="Cox's Bazar" selected>Cox's Bazar, Bangladesh</option>
                            <option value="Amalfi Coast">Amalfi Coast</option>
                            <option value="Bali">Bali</option>
                            <option value="Banff">Banff</option>
                            <option value="Barcelona">Barcelona</option>
                            <option value="Big Sur">Big Sur</option>
                            <option value="Bora Bora">Bora Bora</option>
                            <option value="Cairo">Cairo</option>
                            <option value="Cape Town">Cape Town</option>
                            <option value="Chamonix">Chamonix</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Dubrovnik">Dubrovnik</option>
                            <option value="Dubai">Dubai</option>
                            <option value="Galapagos">Galapagos</option>
                            <option value="Iceland">Iceland</option>
                            <option value="Kyoto">Kyoto</option>
                            <option value="Lake Como">Lake Como</option>
                            <option value="Lofoten">Lofoten</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Marrakech">Marrakech</option>
                            <option value="Maui">Maui</option>
                            <option value="Oaxaca">Oaxaca</option>
                            <option value="Oahu">Oahu</option>
                            <option value="Paris">Paris</option>
                            <option value="Patagonia">Patagonia</option>
                            <option value="Petra">Petra</option>
                            <option value="Phuket">Phuket</option>
                            <option value="Queenstown">Queenstown</option>
                            <option value="Rio de Janeiro">Rio de Janeiro</option>
                            <option value="Sardinia">Sardinia</option>
                            <option value="Sedona">Sedona</option>
                            <option value="Serengeti">Serengeti</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Swiss Alps">Swiss Alps</option>
                            <option value="Sydney">Sydney</option>
                            <option value="Tokyo">Tokyo</option>
                            <option value="Tuscany">Tuscany</option>
                            <option value="Venice">Venice</option>
                            <option value="Vienna">Vienna</option>
                            <option value="Whitsundays">Whitsundays</option>
                        </select>
                        <i class="fa-solid fa-location-dot absolute left-3.5 text-slate-400 text-sm"></i>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <!-- Check-in -->
                <div class="space-y-1.5">
                    <label for="check_in" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Check In</label>
                    <div class="date-input-wrapper relative flex items-center">
                        <input type="text" id="check_in" name="check_in" class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all cursor-pointer text-slate-800 bg-white" readonly />
                        <i class="fa-solid fa-calendar-days absolute right-3.5 text-slate-400 text-sm pointer-events-none"></i>
                    </div>
                </div>

                <!-- Check-out -->
                <div class="space-y-1.5">
                    <label for="check_out" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Check Out</label>
                    <div class="date-input-wrapper relative flex items-center">
                        <input type="text" id="check_out" name="check_out" class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all cursor-pointer text-slate-800 bg-white" readonly />
                        <i class="fa-solid fa-calendar-days absolute right-3.5 text-slate-400 text-sm pointer-events-none"></i>
                    </div>
                </div>

                <!-- Rooms & Guests selector -->
                <div class="space-y-1.5 relative select-none">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Rooms & Guests</label>
                    <div id="rooms-guests-trigger" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm bg-white text-slate-800 flex flex-col justify-center cursor-pointer min-h-[46px] shadow-sm relative">
                        <span id="rooms-guests-display" class="font-bold text-slate-800 text-[13px] leading-tight">1 Room, 2 Guests</span>
                        <span id="rooms-guests-subdisplay" class="text-[9px] text-slate-500 font-semibold leading-none mt-0.5">2 Adults</span>
                        <i class="fa-solid fa-chevron-down absolute right-3.5 text-slate-400 text-xs pointer-events-none"></i>
                        
                        <!-- Hidden guest count input -->
                        <input type="hidden" id="hidden-guests-count" name="guests" value="2" />
                        
                        <!-- Dropdown Popup Card -->
                        <div id="rooms-guests-popup" class="hidden absolute top-full left-1/2 -translate-x-1/2 sm:left-auto sm:translate-x-0 sm:right-0 mt-3 w-[calc(100vw-32px)] sm:w-80 bg-white rounded-2xl border border-slate-200 shadow-2xl p-5 z-50 text-left space-y-4">
                            <div id="rooms-list-container" class="space-y-4 max-h-60 overflow-y-auto pr-1">
                                <!-- Dynamic room items rendered by JS -->
                            </div>
                            
                            <!-- Alert warning for >3 guests inside any room -->
                            <div id="room-guests-warning" class="hidden text-xs text-red-500 font-semibold leading-snug bg-red-50 border border-red-100 rounded-xl p-2.5">
                                More than 3 guests? Add another room to get more options.
                            </div>
                            
                            <!-- Actions row -->
                            <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                                <button type="button" id="add-room-btn" class="px-3 py-1.5 border border-blue-600 text-blue-600 rounded-xl text-xs font-bold hover:bg-blue-50 transition-colors bg-white cursor-pointer">
                                    Add Another Room
                                </button>
                                <button type="button" id="done-guests-btn" class="px-4 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-slate-950 rounded-xl text-xs font-extrabold transition-colors shadow-sm cursor-pointer border-none">
                                    Done
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button -->
                <div>
                    <button type="submit" class="w-full py-3.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 shadow-md transition-all flex items-center justify-center space-x-2 border-none cursor-pointer transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-magnifying-glass text-xs mr-2"></i> <span>Search Hotels</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

<!-- Feature Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center space-y-3 mb-12">
        <h2 class="text-3xl font-bold font-montserrat tracking-tight">Why Book With TripAzai?</h2>
        <p class="text-slate-500 max-w-xl mx-auto">We redefine coastal hospitality with direct bookings and zero hidden fees.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-3 flex flex-col items-start text-left">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold mb-2">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold">Direct Hotel Contact</h3>
            <p class="text-slate-500 text-sm leading-relaxed">We bypass middleman booking agencies. Connect and communicate directly with resort front desks to negotiate rates and secure bookings on your own terms.</p>
        </div>
        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-3 flex flex-col items-start text-left">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold mb-2">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-11.314l.707.707m11.314 11.314l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold">Complimentary Arrival Breakfast</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Start your getaway with a warm coastal welcome. Every guest booking through TripAzai receives a free, fresh local breakfast on their arrival morning.</p>
        </div>
        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-3 flex flex-col items-start text-left">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold mb-2">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 11-4 0 2 2 0 014 0zM18 17a2 2 0 11-4 0 2 2 0 014 0zM2 6h14a2 2 0 012 2v8a2 2 0 01-2 2H2V6zM18 13h4M18 9h4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold">Free Station/Airport Transfer</h3>
            <p class="text-slate-500 text-sm leading-relaxed">No extra charges or travel stress. We provide free private shuttle transport from your arrival station or airport in Cox's Bazar straight to your hotel door.</p>
        </div>
    </div>
</section>

<!-- Highlighted Grid -->
<section class="bg-slate-100 py-16 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-teal-600 font-semibold tracking-wider text-xs uppercase">Featured Listings</span>
                <h2 class="text-3xl font-bold font-montserrat tracking-tight mt-1">Highlighted Hotels</h2>
            </div>
            <a href="<?php echo esc_url( $hotel_archive_url ); ?>" class="text-teal-600 hover:text-teal-700 font-semibold text-sm mt-4 md:mt-0 flex items-center">
                Explore All Stays <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>

        <?php
        $currency_symbol = esc_html( get_theme_mod( 'currency_symbol', '৳' ) );
        // Dynamic WP Query to pull 3 featured hotels from database
        $args = array(
            'post_type'      => 'hotel',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) :
            ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                while ( $query->have_posts() ) :
                    $query->the_post();
                    $id = get_the_ID();
                    $price = get_post_meta( $id, '_hotel_price', true );
                    $location = get_post_meta( $id, '_hotel_location', true );
                    $rating = '5.0'; // Default rating
                    $detail_url = get_permalink();
                    ?>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-slate-100 flex flex-col h-full group">
                        <div class="relative overflow-hidden aspect-w-16 h-64">
                            <?php
                            $img_url = get_the_post_thumbnail_url( $id, 'large' );
                            if ( ! $img_url || ( strpos( $img_url, 'localhost' ) !== false && strpos( home_url(), 'localhost' ) === false ) ) {
                                $img_url = 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80';
                            }
                            ?>
                            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                            <?php if ( $location ) : ?>
                                <div class="absolute top-4 left-4 bg-slate-900 bg-opacity-75 backdrop-filter backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    <?php echo esc_html( $location ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-6 flex flex-col flex-grow space-y-4">
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl font-bold text-slate-900 group-hover:text-teal-600 transition-colors">
                                    <a href="<?php echo esc_url( $detail_url ); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="flex items-center text-amber-500 font-bold text-sm">
                                    <i class="fa-solid fa-star mr-1"></i> 5.0
                                </div>
                            </div>
                            <p class="text-slate-500 text-xs leading-relaxed flex-grow">
                                <?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
                            </p>
                            <?php if ( $price ) : ?>
                                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                                    <div class="text-slate-500 text-xs">
                                        Price starts from
                                    </div>
                                    <div class="text-lg font-extrabold text-slate-900">
                                        <?php echo $currency_symbol; ?><?php echo esc_html( $price ); ?><span class="text-xs text-slate-400 font-normal"> / night</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <a href="<?php echo esc_url( $detail_url ); ?>" class="w-full py-2.5 rounded-xl text-center text-xs font-bold text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 transition-all duration-300">
                                View Details
                            </a>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <p class="text-center text-slate-500">No hotels found. Make sure sample hotels are seeded.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Elementor Content Area -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php the_content(); ?>
</div>

<?php
get_footer();
