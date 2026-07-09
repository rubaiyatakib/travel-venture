<?php
/**
 * The template for displaying hotel archives and search results.
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
    // 1. Capture search parameters
    $search_location  = isset( $_GET['location'] ) ? sanitize_text_field( $_GET['location'] ) : '';
    $search_check_in  = isset( $_GET['check_in'] ) ? sanitize_text_field( $_GET['check_in'] ) : '';
    $search_check_out = isset( $_GET['check_out'] ) ? sanitize_text_field( $_GET['check_out'] ) : '';
    $search_name      = isset( $_GET['hotel_name'] ) ? sanitize_text_field( $_GET['hotel_name'] ) : '';

    $is_search_query = ( ! empty( $search_location ) || ! empty( $search_check_in ) || ! empty( $search_check_out ) || ! empty( $search_name ) );

    // 2. Build custom WP_Query arguments
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array(
        'post_type'      => 'hotel',
        'posts_per_page' => 9,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'meta_query'     => array(
            'relation' => 'AND',
        ),
    );

    // Filter by name
    if ( ! empty( $search_name ) ) {
        $args['s'] = $search_name;
    }

    // Filter by Location if set
    if ( ! empty( $search_location ) ) {
        $args['meta_query'][] = array(
            'key'     => '_hotel_location',
            'value'   => $search_location,
            'compare' => 'LIKE',
        );
    }

    $hotel_query = new WP_Query( $args );
    ?>

    <!-- Page Title Hero Section -->
    <section class="relative bg-slate-900 text-white py-16 flex flex-col justify-center items-center text-center">
        <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80');"></div>
        <div class="absolute inset-0 bg-slate-900 bg-opacity-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 text-center">
            <h1 class="text-3xl sm:text-5xl font-bold font-montserrat tracking-tight">Hotels</h1>
            <p class="text-slate-300 max-w-lg mx-auto text-sm sm:text-base font-medium">
                Search over 40 exclusive destinations and filter stays by check-in / check-out dates.
            </p>
        </div>
    </section>

    <!-- Filter Form Panel -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10 w-full">
        <form id="search-filter-form" method="GET" action="<?php echo esc_url( get_post_type_archive_link( 'hotel' ) ); ?>" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            
            <!-- Keyword -->
            <div class="space-y-1.5">
                <label for="hotel_name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Search Stays</label>
                <div class="relative flex items-center">
                    <input type="text" id="hotel_name" name="hotel_name" placeholder="e.g. Grand Emerald" value="<?php echo esc_attr( $search_name ); ?>" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all text-slate-800 bg-white" />
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-sm"></i>
                </div>
            </div>

            <!-- Destination Select -->
            <div class="space-y-1.5">
                <label for="location" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Destination</label>
                <div class="relative flex items-center">
                    <select id="location" name="location" class="w-full pl-10 pr-8 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all appearance-none bg-white text-slate-800">
                        <option value="">Any Destination</option>
                        <?php
                        $unique_locations = travel_venture_get_unique_locations();
                        foreach ( $unique_locations as $loc ) {
                            $selected = ( isset( $search_location ) && $search_location === $loc ) ? 'selected' : '';
                            echo '<option value="' . esc_attr( $loc ) . '" ' . $selected . '>' . esc_html( $loc ) . '</option>';
                        }
                        ?>
                    </select>
                    <i class="fas fa-map-marker-alt absolute left-3.5 text-slate-400 text-sm"></i>
                    <i class="fas fa-chevron-down absolute right-3.5 text-slate-400 text-xs pointer-events-none"></i>
                </div>
            </div>

            <!-- Check-in -->
            <div class="space-y-1.5">
                <label for="check_in" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Check In</label>
                <div class="date-input-wrapper">
                    <input type="text" id="check_in" name="check_in" value="<?php echo esc_attr( $search_check_in ); ?>" class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all cursor-pointer text-slate-800 bg-white" readonly />
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>

            <!-- Check-out -->
            <div class="space-y-1.5">
                <label for="check_out" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Check Out</label>
                <div class="date-input-wrapper">
                    <input type="text" id="check_out" name="check_out" value="<?php echo esc_attr( $search_check_out ); ?>" class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all cursor-pointer text-slate-800 bg-white" readonly />
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>

            <!-- Button -->
            <div>
                <button type="submit" class="w-full py-3.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-sky-500 hover:from-teal-700 hover:to-emerald-600 shadow-md transition-all flex items-center justify-center space-x-2 border-none cursor-pointer transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-filter text-xs"></i> <span>Apply Filters</span>
                </button>
            </div>

        </form>
    </section>

    <!-- Listings Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full flex-grow">
        
        <!-- Active Criteria Pills -->
        <?php if ( $is_search_query ) : ?>
            <div id="active-criteria-pills" class="mb-8 flex flex-wrap items-center gap-2 text-xs font-medium text-slate-600">
                <span class="text-slate-400">Active Criteria:</span>
                <?php if ( ! empty( $search_name ) ) : ?>
                    <span class="bg-slate-200 px-3 py-1 rounded-full">Name: "<?php echo esc_html($search_name); ?>"</span>
                <?php endif; ?>
                <?php if ( ! empty( $search_location ) ) : ?>
                    <span class="bg-slate-200 px-3 py-1 rounded-full">Region: <?php echo esc_html($search_location); ?></span>
                <?php endif; ?>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'hotel' ) ); ?>" class="text-teal-600 hover:underline text-xs ml-2">Clear all</a>
            </div>
        <?php endif; ?>

        <!-- Cards Container -->
        <?php if ( $hotel_query->have_posts() ) : 
            $currency_symbol = esc_html( get_theme_mod( 'currency_symbol', '৳' ) );
            ?>
            <div id="hotels-list-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ( $hotel_query->have_posts() ) :
                    $hotel_query->the_post();
                    $id = get_the_ID();
                    $price = get_post_meta( $id, '_hotel_price', true );
                    $location = get_post_meta( $id, '_hotel_location', true );
                    $rating = '5.0'; // Default rating
                    $detail_url = get_permalink();
                    ?>
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-slate-100 flex flex-col h-full group">
                        <div class="relative overflow-hidden aspect-w-16 h-60">
                            <?php
                            $img_url = get_post_meta( $id, '_hotel_image_featured_url', true );
                            if ( empty( $img_url ) ) {
                                $img_url = get_the_post_thumbnail_url( $id, 'large' );
                            }
                            if ( ! $img_url || ( strpos( $img_url, 'localhost' ) === false && strpos( home_url(), 'localhost' ) === false ) ) {
                                $img_url = 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80';
                            }
                            ?>
                            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                            <?php if ( $location ) : ?>
                                <div class="absolute top-4 left-4 bg-slate-900 bg-opacity-75 backdrop-filter backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1.5 text-teal-400"></i> <?php echo esc_html( $location ); ?>
                                </div>
                            <?php endif; ?>
                            <div class="absolute top-4 right-4 bg-white text-amber-600 px-3 py-1 rounded-full text-xs font-bold flex items-center shadow-sm">
                                <i class="fas fa-star mr-1"></i> <?php echo esc_html( $rating ); ?>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow space-y-4">
                            <div class="h-14 overflow-hidden flex flex-col justify-center">
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-600 transition-colors line-clamp-2 leading-snug">
                                    <a href="<?php echo esc_url( $detail_url ); ?>"><?php the_title(); ?></a>
                                </h3>
                            </div>
                            <div class="h-16 overflow-hidden">
                                <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed">
                                    <?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
                                </p>
                            </div>
                            <div class="border-t border-slate-100 pt-4 mt-auto flex justify-between items-center">
                                <div class="text-slate-500 text-sm">
                                    Rates from <span class="text-2xl font-extrabold text-slate-950 block sm:inline"><?php echo $currency_symbol; ?><?php echo esc_html( $price ); ?></span>
                                </div>
                                <a href="<?php echo esc_url( $detail_url ); ?>" class="btn-premium inline-flex items-center px-4 py-2.5 rounded-full text-xs font-semibold text-white bg-slate-900 hover:bg-teal-700 transition-colors">
                                    Explore Stays <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <!-- Pagination -->
            <div class="archive-pagination flex justify-center items-center gap-2 mt-12 mb-8">
                <?php
                echo paginate_links( array(
                    'total'        => $hotel_query->max_num_pages,
                    'current'      => $paged,
                    'format'       => '?paged=%#%',
                    'show_all'     => false,
                    'type'         => 'plain',
                    'prev_next'    => true,
                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer', 'tripazai' ) ),
                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Older', 'tripazai' ) ),
                ) );
                ?>
            </div>

        <?php else : ?>
            <div id="hotels-list-grid" class="col-span-3 text-center py-12 space-y-3 bg-white border border-slate-100 rounded-3xl shadow-inner p-8">
                <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-400 text-2xl">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <h3 class="text-lg font-bold">No Available Stays Found</h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto">No hotels match your filters.</p>
            </div>
        <?php endif; ?>

    </main>

<?php
} // End of Elementor / Static else check

get_footer();
