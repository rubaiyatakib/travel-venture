<?php
/**
 * Template Name: Explore Template
 *
 * @package Travel_Venture
 */

get_header();

// 1. Capture search parameters
$search_name = isset( $_GET['hotel_name'] ) ? sanitize_text_field( $_GET['hotel_name'] ) : '';
$min_price   = isset( $_GET['min_price'] ) ? intval( $_GET['min_price'] ) : '';
$max_price   = isset( $_GET['max_price'] ) ? intval( $_GET['max_price'] ) : '';

$is_search_query = ( ! empty( $search_name ) || ! empty( $min_price ) || ! empty( $max_price ) );

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

// Filter by min price
if ( ! empty( $min_price ) ) {
    $args['meta_query'][] = array(
        'key'     => '_hotel_price',
        'value'   => $min_price,
        'type'    => 'NUMERIC',
        'compare' => '>=',
    );
}

// Filter by max price
if ( ! empty( $max_price ) ) {
    $args['meta_query'][] = array(
        'key'     => '_hotel_price',
        'value'   => $max_price,
        'type'    => 'NUMERIC',
        'compare' => '<=',
    );
}

$explore_query = new WP_Query( $args );
$currency_symbol = esc_html( get_theme_mod( 'currency_symbol', '৳' ) );
?>

<!-- Header -->
<section class="relative bg-slate-900 text-white py-16 overflow-hidden">
    <!-- Hero Background Image (Clear and high contrast) -->
    <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=1600&q=80');"></div>
    <!-- Dark overlay to ensure white text readability -->
    <div class="absolute inset-0 bg-slate-900 bg-opacity-65"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 text-center">
        <h1 class="text-3xl sm:text-5xl font-bold font-montserrat tracking-tight">Our Premium Hotels</h1>
        <p class="text-slate-300 max-w-lg mx-auto text-sm sm:text-base font-medium">
            Discover and book the finest hotels in Cox's Bazar with simulated check-in date filters.
        </p>
    </div>
</section>

<!-- Content Grid Container -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full flex-grow">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 items-start">
        
        <!-- Right Side: Sidebar Search & Filter (Top on Mobile, Right on Desktop) -->
        <div class="lg:col-span-1 lg:order-2">
            <aside class="sticky top-28 bg-white rounded-3xl p-6 border border-slate-100 shadow-md space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center font-montserrat">
                    <i class="fas fa-filter text-teal-600 mr-2 text-sm"></i> Filter Hotels
                </h3>
                <form method="GET" action="" class="space-y-5">
                    
                    <!-- Keyword search -->
                    <div class="space-y-1.5">
                        <label for="hotel_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Hotel Name</label>
                        <div class="relative flex items-center">
                            <input type="text" id="hotel_name" name="hotel_name" placeholder="Search by name..." value="<?php echo esc_attr($search_name); ?>" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all text-slate-800 bg-white" />
                            <i class="fas fa-search absolute left-3.5 text-slate-400 text-sm"></i>
                        </div>
                    </div>

                    <!-- Price range search -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Price Range (<?php echo $currency_symbol; ?>)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" placeholder="Min" value="<?php echo esc_attr($min_price); ?>" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all text-slate-800 bg-white" />
                            <input type="number" name="max_price" placeholder="Max" value="<?php echo esc_attr($max_price); ?>" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all text-slate-800 bg-white" />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="space-y-3 pt-2">
                        <button type="submit" class="w-full py-3 rounded-xl text-sm font-semibold text-white bg-slate-950 hover:bg-teal-700 shadow-sm transition-all flex items-center justify-center space-x-2 border-none cursor-pointer transform hover:-translate-y-0.5">
                            <i class="fas fa-search text-xs"></i> <span>Search Hotels</span>
                        </button>
                        <?php if ( $is_search_query ) : ?>
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="w-full py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-50 border border-slate-200 hover:bg-slate-100 hover:text-slate-700 transition-all flex items-center justify-center space-x-2 text-center decoration-none">
                                <i class="fas fa-undo"></i> <span>Clear Filters</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </aside>
        </div>

        <!-- Left Side: Listings Grid (Bottom on Mobile, Left on Desktop) -->
        <div class="lg:col-span-3 lg:order-1 space-y-8">
            
            <!-- Active Criteria Pills -->
            <?php if ( $is_search_query ) : ?>
                <div id="active-criteria-pills" class="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-600 bg-slate-50 p-4 rounded-2xl border border-slate-100 shadow-sm">
                    <span class="text-slate-400">Active Criteria:</span>
                    <?php if ( ! empty( $search_name ) ) : ?>
                        <span class="bg-white px-3 py-1.5 rounded-full border border-slate-200">Name: "<?php echo esc_html($search_name); ?>"</span>
                    <?php endif; ?>
                    <?php if ( ! empty( $min_price ) ) : ?>
                        <span class="bg-white px-3 py-1.5 rounded-full border border-slate-200">Min Price: <?php echo $currency_symbol; ?><?php echo esc_html($min_price); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $max_price ) ) : ?>
                        <span class="bg-white px-3 py-1.5 rounded-full border border-slate-200">Max Price: <?php echo $currency_symbol; ?><?php echo esc_html($max_price); ?></span>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="text-teal-600 hover:text-teal-700 hover:underline text-xs ml-auto font-bold flex items-center gap-1">
                        <i class="fas fa-undo text-[10px]"></i> Clear all
                    </a>
                </div>
            <?php endif; ?>

            <!-- Cards Container -->
            <?php if ( $explore_query->have_posts() ) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    while ( $explore_query->have_posts() ) :
                        $explore_query->the_post();
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
                        'total'        => $explore_query->max_num_pages,
                        'current'      => $paged,
                        'format'       => '?paged=%#%',
                        'show_all'     => false,
                        'type'         => 'plain',
                        'prev_next'    => true,
                        'prev_text'    => sprintf( '<i></i> %1$s', __( 'Previous', 'tripazai' ) ),
                        'next_text'    => sprintf( '%1$s <i></i>', __( 'Next', 'tripazai' ) ),
                    ) );
                    ?>
                </div>

            <?php else : ?>
                <div class="bg-slate-50 rounded-3xl p-12 text-center border border-slate-100 shadow-sm max-w-lg mx-auto">
                    <div class="w-16 h-16 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No Hotels Found</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">We couldn't find any hotels matching your current search criteria. Try removing some filters or adjusting your budget range.</p>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="inline-flex items-center px-6 py-3 rounded-full text-sm font-semibold text-white bg-slate-900 hover:bg-teal-700 transition-colors">
                        Clear Search
                    </a>
                </div>
            <?php endif; ?>

        </div>

    </div>
</main>

<!-- Elementor Content Area -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php the_content(); ?>
</div>

<?php
get_footer();
