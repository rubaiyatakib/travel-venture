<?php
/**
 * Core Theme Initialization and Hooks Manager
 *
 * @package Travel_Venture
 */

if ( ! class_exists( 'Travel_Venture_Init' ) ) {

    class Travel_Venture_Init {

        /**
         * Instance of this class
         */
        private static $instance = null;

        /**
         * Get instance of the class
         */
        public static function get_instance() {
            if ( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor registers hooks
         */
        private function __construct() {
            // Setup CPT and Theme support
            add_action( 'init', array( $this, 'register_hotel_cpt' ) );
            add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );

            // Customizer Integration
            add_action( 'customize_register', array( $this, 'register_customizer_options' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_customizer_fonts' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_theme_assets' ) );

            // Auto-Seeding Trigger
            add_action( 'after_switch_theme', array( $this, 'trigger_auto_seed' ) );

            // Elementor Compatibility Hooks
            add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );

            // Template Redirections (Antigravity Clean Directory Structure)
            add_filter( 'single_template', array( $this, 'load_single_hotel_template' ) );
            add_filter( 'archive_template', array( $this, 'load_archive_hotel_template' ) );
        }

        /**
         * Setup theme support values
         */
        public function theme_setup() {
            add_theme_support( 'title-tag' );
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'custom-logo', array(
                'height'      => 80,
                'width'       => 240,
                'flex-height' => true,
                'flex-width'  => true,
            ) );
            add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
            
            // Register Navigation
            register_nav_menus( array(
                'menu-1' => esc_html__( 'Primary Menu', 'tripazai' ),
            ) );
        }

        /**
         * Register 'hotel' CPT
         */
        public function register_hotel_cpt() {
            $labels = array(
                'name'                  => _x( 'Hotels', 'Post Type General Name', 'tripazai' ),
                'singular_name'         => _x( 'Hotel', 'Post Type Singular Name', 'tripazai' ),
                'menu_name'             => __( 'Hotels', 'tripazai' ),
                'name_admin_bar'        => __( 'Hotel', 'tripazai' ),
                'archives'              => __( 'Hotel Archives', 'tripazai' ),
                'attributes'            => __( 'Hotel Attributes', 'tripazai' ),
                'parent_item_colon'     => __( 'Parent Hotel:', 'tripazai' ),
                'all_items'             => __( 'All Hotels', 'tripazai' ),
                'add_new_item'          => __( 'Add New Hotel', 'tripazai' ),
                'add_new'               => __( 'Add New', 'tripazai' ),
                'new_item'              => __( 'New Hotel', 'tripazai' ),
                'edit_item'             => __( 'Edit Hotel', 'tripazai' ),
                'update_item'           => __( 'Update Hotel', 'tripazai' ),
                'view_item'             => __( 'View Hotel', 'tripazai' ),
                'view_items'            => __( 'View Hotels', 'tripazai' ),
                'search_items'          => __( 'Search Hotel', 'tripazai' ),
                'not_found'             => __( 'Not found', 'tripazai' ),
                'not_found_in_trash'    => __( 'Not found in Trash', 'tripazai' ),
                'featured_image'        => __( 'Featured Image', 'tripazai' ),
                'set_featured_image'    => __( 'Set featured image', 'tripazai' ),
                'remove_featured_image' => __( 'Remove featured image', 'tripazai' ),
                'use_featured_image'    => __( 'Use as featured image', 'tripazai' ),
                'insert_into_item'      => __( 'Insert into hotel', 'tripazai' ),
                'uploaded_to_this_item' => __( 'Uploaded to this hotel', 'tripazai' ),
                'items_list'            => __( 'Hotels list', 'tripazai' ),
                'items_list_navigation' => __( 'Hotels list navigation', 'tripazai' ),
                'filter_items_list'     => __( 'Filter hotels list', 'tripazai' ),
            );
            $args = array(
                'label'                 => __( 'Hotel', 'tripazai' ),
                'description'           => __( 'TripAzai CPT for Manual Hotels Entries', 'tripazai' ),
                'labels'                => $labels,
                'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-admin-home',
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'show_in_rest'          => true,
            );
            register_post_type( 'hotel', $args );
        }

        /**
         * Register WordPress Customizer color & typography options
         */
        public function register_customizer_options( $wp_customize ) {
            // General Settings Section
            $wp_customize->add_section( 'travel_venture_general', array(
                'title'    => __( 'TripAzai Settings', 'tripazai' ),
                'priority' => 25,
            ) );

            // Currency Symbol Setting
            $wp_customize->add_setting( 'currency_symbol', array(
                'default'           => '৳',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( 'currency_symbol', array(
                'type'     => 'text',
                'label'    => __( 'Currency Symbol', 'tripazai' ),
                'section'  => 'travel_venture_general',
                'settings' => 'currency_symbol',
            ) );

            // Booking Welcome Text Setting
            $wp_customize->add_setting( 'booking_welcome_text', array(
                'default'           => 'Welcome to the booking gate for [hotel_name]. We are thrilled to assist you with organizing your luxury stay[date_range].',
                'sanitize_callback' => 'wp_kses_post',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( 'booking_welcome_text', array(
                'type'     => 'textarea',
                'label'    => __( 'Booking Popup Welcome Text', 'tripazai' ),
                'description'=> __( 'Use [hotel_name] and [date_range] as dynamic placeholders.', 'tripazai' ),
                'section'  => 'travel_venture_general',
                'settings' => 'booking_welcome_text',
            ) );

            // Booking Sub Text Setting
            $wp_customize->add_setting( 'booking_sub_text', array(
                'default'           => 'Your reservation will be customized at the exclusive rate starting from [price] per night.',
                'sanitize_callback' => 'wp_kses_post',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( 'booking_sub_text', array(
                'type'     => 'textarea',
                'label'    => __( 'Booking Popup Rate Text', 'tripazai' ),
                'description'=> __( 'Use [price] as dynamic placeholder.', 'tripazai' ),
                'section'  => 'travel_venture_general',
                'settings' => 'booking_sub_text',
            ) );

            // Booking Footer Text Setting
            $wp_customize->add_setting( 'booking_footer_text', array(
                'default'           => 'To finalize your dates, room selection, and secure your booking, click the call button below to connect with our dedicated reservations desk.',
                'sanitize_callback' => 'wp_kses_post',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( 'booking_footer_text', array(
                'type'     => 'textarea',
                'label'    => __( 'Booking Popup Footer Text', 'tripazai' ),
                'section'  => 'travel_venture_general',
                'settings' => 'booking_footer_text',
            ) );

            // Colors Section
            $wp_customize->add_section( 'travel_venture_colors', array(
                'title'    => __( 'TripAzai Colors', 'tripazai' ),
                'priority' => 30,
            ) );

            // Primary Color setting & control
            $wp_customize->add_setting( 'primary_color', array(
                'default'           => '#1e293b',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
                'label'    => __( 'Primary Accent Color', 'tripazai' ),
                'section'  => 'travel_venture_colors',
                'settings' => 'primary_color',
            ) ) );

            // Secondary Color setting & control
            $wp_customize->add_setting( 'secondary_color', array(
                'default'           => '#d97706',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
                'label'    => __( 'Secondary Highlights Color', 'tripazai' ),
                'section'  => 'travel_venture_colors',
                'settings' => 'secondary_color',
            ) ) );

            // Background Color setting & control
            $wp_customize->add_setting( 'background_color', array(
                'default'           => '#f8fafc',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
                'label'    => __( 'Theme Background Color', 'tripazai' ),
                'section'  => 'travel_venture_colors',
                'settings' => 'background_color',
            ) ) );

            // Typography Section
            $wp_customize->add_section( 'travel_venture_typography', array(
                'title'    => __( 'TripAzai Typography', 'tripazai' ),
                'priority' => 35,
            ) );

            $fonts = array(
                'Outfit'            => 'Outfit',
                'Playfair Display'  => 'Playfair Display',
                'Montserrat'       => 'Montserrat',
                'Lato'              => 'Lato',
                'Inter'             => 'Inter',
                'Open Sans'         => 'Open Sans',
                'Roboto'            => 'Roboto',
                'Lora'              => 'Lora',
                'Work Sans'         => 'Work Sans',
                'Cormorant Garamond'=> 'Cormorant Garamond',
            );

            // Headings Font
            $wp_customize->add_setting( 'headings_font', array(
                'default'           => 'Outfit',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( 'headings_font', array(
                'type'     => 'select',
                'label'    => __( 'Headings Typography', 'tripazai' ),
                'section'  => 'travel_venture_typography',
                'choices'  => $fonts,
                'settings' => 'headings_font',
            ) );

            // Body Font
            $wp_customize->add_setting( 'body_font', array(
                'default'           => 'Inter',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( 'body_font', array(
                'type'     => 'select',
                'label'    => __( 'Body Typography', 'tripazai' ),
                'section'  => 'travel_venture_typography',
                'choices'  => $fonts,
                'settings' => 'body_font',
            ) );
        }

        /**
         * Enqueue Customizer selected fonts from Google CDN
         */
        public function enqueue_customizer_fonts() {
            $headings_font = get_theme_mod( 'headings_font', 'Outfit' );
            $body_font = get_theme_mod( 'body_font', 'Inter' );

            $fonts = array();
            $fonts[] = $headings_font;
            if ( $body_font !== $headings_font ) {
                $fonts[] = $body_font;
            }

            $query_args = array(
                'family'  => urlencode( implode( '|', array_map( function( $font ) {
                    return $font . ':300,400,500,600,700';
                }, $fonts ) ) ),
                'display' => 'swap',
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
            wp_enqueue_style( 'tripazai-google-fonts', $fonts_url, array(), null );
        }

        /**
         * Enqueue theme frontend assets
         */
        public function enqueue_theme_assets() {
            // Tailwind CSS CDN
            wp_enqueue_style( 'tailwind-css', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', array(), '2.2.19' );
            
            // FontAwesome Icons
            wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

            // Flatpickr CSS
            wp_enqueue_style( 'flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', array(), '4.6.13' );

            // Core styles
            wp_enqueue_style( 'tripazai-styles', get_template_directory_uri() . '/assets/css/theme-styles.css', array('tailwind-css'), '1.0.0' );

            // Flatpickr JS
            wp_enqueue_script( 'flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), '4.6.13', true );

            // Date Search helper JS
            wp_enqueue_script( 'tripazai-booking-search', get_template_directory_uri() . '/assets/js/booking-search.js', array('jquery', 'flatpickr-js'), '1.0.0', true );
            
            // Add localized variables for dynamic search
            $explore_page = get_page_by_path('explore');
            $details_page = get_page_by_path('details');
            
            wp_localize_script( 'tripazai-booking-search', 'travelVentureData', array(
                'ajaxurl'         => admin_url( 'admin-ajax.php' ),
                'explore_url'     => $explore_page ? esc_url( get_permalink( $explore_page->ID ) ) : esc_url( home_url( '/explore/' ) ),
                'details_url'     => $details_page ? esc_url( get_permalink( $details_page->ID ) ) : esc_url( home_url( '/details/' ) ),
                'currency_symbol' => esc_html( get_theme_mod( 'currency_symbol', '৳' ) ),
                'booking_welcome_text'=> wp_kses_post( get_theme_mod( 'booking_welcome_text', 'Welcome to the booking gate for [hotel_name]. We are thrilled to assist you with organizing your luxury stay[date_range].' ) ),
                'booking_sub_text'=> wp_kses_post( get_theme_mod( 'booking_sub_text', 'Your reservation will be customized at the exclusive rate starting from [price] per night.' ) ),
                'booking_footer_text'=> wp_kses_post( get_theme_mod( 'booking_footer_text', 'To finalize your dates, room selection, and secure your booking, click the call button below to connect with our dedicated reservations desk.' ) ),
            ) );
        }

        /**
         * Load single-hotel.php from subfolders (Antigravity Clean structure)
         */
        public function load_single_hotel_template( $single_template ) {
            global $post;
            if ( 'hotel' === $post->post_type ) {
                $file = get_template_directory() . '/templates/single-hotel.php';
                if ( file_exists( $file ) ) {
                    return $file;
                }
            }
            return $single_template;
        }

        /**
         * Load archive-hotel.php from subfolders (Antigravity Clean structure)
         */
        public function load_archive_hotel_template( $archive_template ) {
            if ( is_post_type_archive( 'hotel' ) || is_search() ) {
                $file = get_template_directory() . '/templates/archive-hotel.php';
                if ( file_exists( $file ) ) {
                    return $file;
                }
            }
            return $archive_template;
        }

        /**
         * Register Custom Elementor Widgets
         */
        public function register_elementor_widgets( $widgets_manager ) {
            // Check if Elementor class exists (safety check)
            if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
                return;
            }

            // Include files
            require_once get_template_directory() . '/core/elementor-widgets.php';
            
            // Register widgets classes
            $widgets_manager->register( new \Travel_Venture_Search_Widget() );
            $widgets_manager->register( new \Travel_Venture_Grid_Widget() );
        }

        /**
         * Seeding trigger on activation (only runs once)
         */
        public function trigger_auto_seed() {
            // Seed Pages (Home & About) if they do not exist
            $home_page = get_page_by_path('home');
            if ( ! $home_page ) {
                $home_id = wp_insert_post(array(
                    'post_title'    => 'Home',
                    'post_content'  => '<!-- wp:paragraph --><p>Welcome to our homepage</p><!-- /wp:paragraph -->',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                    'post_name'     => 'home'
                ));
                if ( $home_id && ! is_wp_error( $home_id ) ) {
                    update_option( 'show_on_front', 'page' );
                    update_option( 'page_on_front', $home_id );
                }
            }

            $about_page = get_page_by_path('about');
            if ( ! $about_page ) {
                wp_insert_post(array(
                    'post_title'    => 'About Us',
                    'post_content'  => '<!-- wp:paragraph --><p>Welcome to TripAzai. We are a premium hotel booking platform.</p><!-- /wp:paragraph -->',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                    'post_name'     => 'about'
                ));
            }

            $explore_page = get_page_by_path('explore');
            if ( ! $explore_page ) {
                wp_insert_post(array(
                    'post_title'    => 'Explore Stays',
                    'post_content'  => '<!-- wp:paragraph --><p>Search hotels.</p><!-- /wp:paragraph -->',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                    'post_name'     => 'explore'
                ));
            }

            $details_page = get_page_by_path('details');
            if ( ! $details_page ) {
                wp_insert_post(array(
                    'post_title'    => 'Hotel Details',
                    'post_content'  => '<!-- wp:paragraph --><p>Hotel detail view.</p><!-- /wp:paragraph -->',
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                    'post_name'     => 'details'
                ));
            }

            if ( get_option( 'travel_venture_seeded' ) ) {
                return; // Already seeded
            }

            // Setup require file for sideloading images
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            // High-quality travel images from Unsplash to download once and seed
            $unsplash_urls = array(
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=80', // Resort
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1200&q=80', // Pool
                'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=1200&q=80', // Luxury Beach Hotel
                'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1200&q=80', // Modern interior
                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1200&q=80'  // Mountain spa resort
            );

            $attachment_ids = array();

            // Sideload images and store Attachment IDs
            foreach ( $unsplash_urls as $index => $url ) {
                // Sideload the image
                $desc = "Seed Image " . ($index + 1);
                $img_id = media_sideload_image( $url, 0, $desc, 'id' );

                if ( ! is_wp_error( $img_id ) && is_numeric( $img_id ) ) {
                    $attachment_ids[] = (int) $img_id;
                }
            }

            // If sideloading failed entirely, use default placeholder IDs or log it
            if ( empty( $attachment_ids ) ) {
                // Fallback to empty array, the theme will render CSS placeholders
                $attachment_ids = array( 0 );
            }

            // Data lists to seed 40 distinct hotels
            $locations = array(
                'Miami, FL', 'Maldives', 'Zermatt, Switzerland', 'Kyoto, Japan', 
                'Banff, Canada', 'Bali, Indonesia', 'Cape Town, South Africa',
                'Santorini, Greece', 'Queenstown, New Zealand', 'Maui, Hawaii'
            );

            $amenities_pool = array(
                'Free Wi-Fi, Swimming Pool, Fitness Center, Room Service, Private Balcony, Breakfast Included',
                'Spa & Wellness, Beach Access, Ocean View, Fine Dining, Bar/Lounge, Pet Friendly',
                'Air Conditioning, Kitchenette, Smart TV, Mountain View, Fireplace, Hot Tub',
                '24-Hour Front Desk, Laundry Service, Valet Parking, Airport Shuttle, Kids Club, Concierge'
            );

            $prefixes = array(
                'The Royal', 'Grand', 'Elite', 'Serene', 'Mystic', 
                'Crestview', 'Horizon', 'Azure', 'Emerald', 'Sapphire'
            );

            $suffixes = array(
                'Oasis Resort', 'Alpine Lodge', 'Ocean Villa', 'Retreat & Spa', 'Haven Hotel',
                'Cove Palace', 'Sanctuary', 'Plaza Resort', 'Boutique Stay', 'Heights Resort'
            );

            // Generate 42 hotels
            for ( $i = 1; $i <= 42; $i++ ) {
                $location = $locations[ ($i % count($locations)) ];
                $prefix = $prefixes[ ($i % count($prefixes)) ];
                $suffix = $suffixes[ (($i + 3) % count($suffixes)) ];
                $hotel_name = $prefix . ' ' . $suffix;
                
                // Add unique suffix ID to avoid duplicated names if they match
                if ($i > 10) {
                    $hotel_name .= ' ' . chr(65 + ($i % 26)); // e.g. A, B, C...
                }

                $price = 100 + (($i * 17) % 450); // Generates prices between $100 and $550
                $contact = '+1 (800) ' . rand(100, 999) . '-' . sprintf('%04d', rand(0, 9999));
                $amenities = $amenities_pool[ ($i % count($amenities_pool)) ];

                // Set availability: starts from current date to 2 years out
                $available_from = date( 'Y-m-d' );
                $available_to = date( 'Y-m-d', strtotime( '+2 years' ) );

                // Post Content
                $content = 'Experience pure luxury and comfort at ' . $hotel_name . ' located in the heart of ' . $location . '. Enjoy premium amenities including: ' . $amenities . '. Discover breathtaking views, gourmet dining, and a staff dedicated to making your holiday unforgettable.';

                // Create post
                $hotel_post = array(
                    'post_title'    => wp_strip_all_tags( $hotel_name ),
                    'post_content'  => $content,
                    'post_status'   => 'publish',
                    'post_type'     => 'hotel',
                    'post_author'   => 1,
                );

                $post_id = wp_insert_post( $hotel_post );

                if ( $post_id && ! is_wp_error( $post_id ) ) {
                    // Save custom metadata fields
                    update_post_meta( $post_id, '_hotel_price', $price );
                    update_post_meta( $post_id, '_hotel_location', $location );
                    update_post_meta( $post_id, '_hotel_amenities', $amenities );
                    update_post_meta( $post_id, '_hotel_contact', $contact );
                    update_post_meta( $post_id, '_hotel_available_from', $available_from );
                    update_post_meta( $post_id, '_hotel_available_to', $available_to );
                    
                    // Video URL (Uses generic youtube travel clip as placeholder)
                    update_post_meta( $post_id, '_hotel_video', 'https://www.youtube.com/watch?v=ScXs7L0fVk0' );

                    // Featured Image & Gallery Setup
                    if ( ! empty( $attachment_ids ) ) {
                        // Set featured image
                        $featured_img_index = $i % count( $attachment_ids );
                        set_post_thumbnail( $post_id, $attachment_ids[ $featured_img_index ] );

                        // Set gallery images (random 3 images from our attachment pool)
                        $gallery_ids = array();
                        for ($g = 0; $g < 3; $g++) {
                            $idx = ($i + $g) % count( $attachment_ids );
                            $gallery_ids[] = $attachment_ids[$idx];
                        }
                        update_post_meta( $post_id, '_hotel_gallery', implode( ',', $gallery_ids ) );
                    }
                }
            }



            // Save confirmation option
            update_option( 'travel_venture_seeded', true );
        }
    }
}

// Instantiate core theme hooks
Travel_Venture_Init::get_instance();

