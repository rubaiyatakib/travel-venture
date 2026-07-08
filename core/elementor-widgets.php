<?php
/**
 * Elementor Custom Widgets Integration
 *
 * @package Travel_Venture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Hotel Booking Search Widget for Elementor
 */
class Travel_Venture_Search_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'travel_venture_search';
    }

    public function get_title() {
        return esc_html__( 'Hotel Booking Search', 'tripazai' );
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return array( 'general' );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Content Settings', 'tripazai' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'placeholder_location',
            array(
                'label'       => esc_html__( 'Location Placeholder', 'tripazai' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Where are you going?', 'tripazai' ),
                'placeholder' => esc_html__( 'Type placeholder here...', 'tripazai' ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $hotel_archive = get_post_type_archive_link( 'hotel' );
        if ( ! $hotel_archive ) {
            $hotel_archive = home_url( '/' );
        }
        ?>
        <div class="booking-search-container glass-morphic">
            <form action="<?php echo esc_url( $hotel_archive ); ?>" method="GET" class="booking-search-form">
                <input type="hidden" name="post_type" value="hotel" />
                
                <div class="form-group search-location">
                    <label for="search_location"><i class="dashicons dashicons-location"></i> Destination</label>
                    <input type="text" id="search_location" name="location" placeholder="<?php echo esc_attr( $settings['placeholder_location'] ); ?>" required />
                </div>

                <div class="form-group search-check-in">
                    <label for="search_check_in"><i class="dashicons dashicons-calendar-alt"></i> Check-in</label>
                    <input type="date" id="search_check_in" name="check_in" min="<?php echo esc_attr( date('Y-m-d') ); ?>" required />
                </div>

                <div class="form-group search-check-out">
                    <label for="search_check_out"><i class="dashicons dashicons-calendar-alt"></i> Check-out</label>
                    <input type="date" id="search_check_out" name="check_out" min="<?php echo esc_attr( date('Y-m-d', strtotime('+1 day')) ); ?>" required />
                </div>

                <div class="form-group search-guests">
                    <label for="search_guests"><i class="dashicons dashicons-admin-users"></i> Guests</label>
                    <select id="search_guests" name="guests">
                        <option value="1">1 Guest</option>
                        <option value="2" selected>2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                        <option value="5">5+ Guests</option>
                    </select>
                </div>

                <button type="submit" class="search-submit-btn">
                    <i class="dashicons dashicons-search"></i> Search Hotels
                </button>
            </form>
        </div>
        <?php
    }
}

/**
 * Hotels Grid Listing Widget for Elementor
 */
class Travel_Venture_Grid_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'travel_venture_grid';
    }

    public function get_title() {
        return esc_html__( 'Hotels Grid', 'tripazai' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return array( 'general' );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_grid_content',
            array(
                'label' => esc_html__( 'Grid Settings', 'tripazai' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'posts_per_page',
            array(
                'label'   => esc_html__( 'Number of Hotels to Show', 'tripazai' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => 1,
                'max'     => 100,
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $args = array(
            'post_type'      => 'hotel',
            'posts_per_page' => intval( $settings['posts_per_page'] ),
            'post_status'    => 'publish',
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) :
            ?>
            <div class="hotels-grid">
                <?php
                while ( $query->have_posts() ) :
                    $query->the_post();
                    $id = get_the_ID();
                    $price = get_post_meta( $id, '_hotel_price', true );
                    $location = get_post_meta( $id, '_hotel_location', true );
                    $amenities = get_post_meta( $id, '_hotel_amenities', true );
                    ?>
                    <div class="hotel-card glass-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="hotel-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'large' ); ?>
                                </a>
                                <?php if ( $price ) : ?>
                                    <div class="hotel-price-badge">
                                        $<?php echo esc_html( $price ); ?><span> / night</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="hotel-card-details">
                            <?php if ( $location ) : ?>
                                <span class="hotel-location"><i class="dashicons dashicons-location"></i> <?php echo esc_html( $location ); ?></span>
                            <?php endif; ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="hotel-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?></p>
                            <?php if ( $amenities ) : ?>
                                <div class="hotel-amenities-tags">
                                    <?php
                                    $tags = explode( ',', $amenities );
                                    $limit_tags = array_slice( $tags, 0, 3 );
                                    foreach ( $limit_tags as $tag ) :
                                        ?>
                                        <span class="amenity-tag"><?php echo esc_html( trim( $tag ) ); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="view-details-btn">View Hotel</a>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php
        else :
            ?>
            <p><?php esc_html_e( 'No hotels found.', 'tripazai' ); ?></p>
            <?php
        endif;
    }
}

