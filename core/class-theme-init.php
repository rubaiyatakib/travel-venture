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
            add_action( 'init', array( $this, 'seed_coxs_bazar_hotels' ), 20 );
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

            // We now seed Cox's Bazar hotels dynamically in seed_coxs_bazar_hotels()
            update_option( 'travel_venture_seeded', true );
            return;

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

        /**
         * Programmatically clean old hotels and seed 10 Cox's Bazar hotels from GoZayaan.
         */
        public function seed_coxs_bazar_hotels() {
            // Run only once
            if ( get_option( 'travel_venture_coxs_bazar_seeded_v3' ) ) {
                return;
            }

            // 1. Delete all existing hotel posts
            $existing_hotels = get_posts( array(
                'post_type'   => 'hotel',
                'numberposts' => -1,
                'post_status' => 'any',
            ) );

            if ( ! empty( $existing_hotels ) ) {
                foreach ( $existing_hotels as $hotel ) {
                    wp_delete_post( $hotel->ID, true );
                }
            }

            // 2. Define the 10 hotels data array
            $hotels_data = array(
                array(
                    'title'             => "Sea Pearl Beach Resort & Spa",
                    'price'             => '13500',
                    'location'          => "Inani Beach, Marine Drive, Cox's Bazar, Bangladesh",
                    'contact'           => '01844016001',
                    'rating_location'   => '4.8',
                    'rating_comfort'    => '4.9',
                    'rating_facilities' => '4.9',
                    'reviews_count'     => '342',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Conference Hostess, Garden, Swimming Pool, Gym, Massage, Buffet Lunch, Buffet Dinner, Air Conditioning, Couple Friendly, Water Park, Kids Club',
                    'nearby_interest'   => "0.1 km from Inani Beach\n4.5 km from Himchori Waterfall\n25.0 km from Kolatoli Beach",
                    'nearby_terminals'  => "28.0 km from Cox's Bazar Airport\n29.0 km from Cox's Bazar Railway Station",
                    'check_in'          => '14:00',
                    'check_out'         => '11:00',
                    'policy_child'      => "Children under 5 years stay free when sharing room. Children between 5-11 years stay free but require payment for breakfast/activities.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "The rate for an extra bed with breakfast is BDT 3,000 per night.",
                    'policy_house'      => "• <strong>Pool Attire:</strong> Guests must wear appropriate synthetic swimming costumes in the swimming pools.\n• <strong>Firearms:</strong> Licensed personal firearms are not permitted on resort grounds.\n• <strong>Quiet Hours:</strong> Respect other guests by keeping noise to a minimum after 10:00 PM.",
                    'content'           => "Sea Pearl Beach Resort & Spa is a premier 5-star luxury resort nestled on Inani Beach, Cox's Bazar. Spanning across 15 acres of manicured gardens, this majestic property offers 493 rooms and suites with spectacular sea and hill views. Enjoy two outdoor swimming pools, a private water park, multiple international restaurants, and a comprehensive wellness spa.",
                    'excerpt'           => "Nestled on Inani Beach, Sea Pearl offers 5-star oceanfront luxury with a private beach, water park, and infinity pools."
                ),
                array(
                    'title'             => "Ocean Paradise Hotel & Resort",
                    'price'             => '8500',
                    'location'          => "Kolatoli Road, Hotel-Motel Zone, Cox's Bazar, Bangladesh",
                    'contact'           => '09619675675',
                    'rating_location'   => '4.6',
                    'rating_comfort'    => '4.5',
                    'rating_facilities' => '4.5',
                    'reviews_count'     => '189',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Free Wi-Fi, Swimming Pool, Fitness Center, Room Service, Private Balcony, Breakfast Included, Spa & Wellness, Fine Dining, Bar/Lounge, Couple Friendly, Air Conditioning',
                    'nearby_interest'   => "0.2 km from Sugondha Beach\n0.5 km from Kolatoli Beach\n4.8 km from Radiant Fish World",
                    'nearby_terminals'  => "5.0 km from Cox's Bazar Airport\n5.8 km from Cox's Bazar Railway Station",
                    'check_in'          => '14:00',
                    'check_out'         => '12:00',
                    'policy_child'      => "Children under 6 stay free. Children 7 and above are considered adults and will require an extra bed.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed with breakfast is BDT 2,500.",
                    'policy_house'      => "• <strong>Outside Food:</strong> Outside food, beverages, and alcohol are not allowed.\n• <strong>Social Distancing:</strong> Please maintain social distancing during your stay.",
                    'content'           => "Ocean Paradise Hotel & Resort is a prominent hospitality destination in the heart of Cox's Bazar's hotel-motel zone. It features modern rooms with panoramic views of the Bay of Bengal, outdoor pools, a fully equipped gym, a therapeutic spa, and multiple dining options including a rooftop sky bar.",
                    'excerpt'           => "Located on Kolatoli Road, Ocean Paradise provides beautiful sea views, outdoor pools, and premium rooftop dining."
                ),
                array(
                    'title'             => "Sayeman Beach Resort",
                    'price'             => '12500',
                    'location'          => "Marine Drive Road, Kolatoli, Cox's Bazar, Bangladesh",
                    'contact'           => '01712345678',
                    'rating_location'   => '4.7',
                    'rating_comfort'    => '4.6',
                    'rating_facilities' => '4.6',
                    'reviews_count'     => '215',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Conference Hostess, Garden, Mobile Phone Coverage, Medical Service, Tours/Ticket Assistance, Sofa Bed, Swimming Pool, Gym, Massage, Buffet Lunch, Buffet Dinner, Air Conditioning, Couple Friendly',
                    'nearby_interest'   => "0.077 km from Kolatoli Beach, Cox's Bazar\n4.4 km from Radiant Fish World\n1.7 km from Sugondha Sea Beach\n2.8 km from Laboni Beach",
                    'nearby_terminals'  => "4.8 km from Cox's Bazar Airport\n5.6 km from Cox's Bazar Railway Station\n0.35 km from Kolatoli Bus Stand",
                    'check_in'          => '14:00',
                    'check_out'         => '12:00',
                    'policy_child'      => "Two children under the age of 4 years will enjoy a complimentary stay and breakfast. Children aged 5-9 pay BDT 650 for breakfast.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed along with breakfast is BDT 2,600.",
                    'policy_house'      => "• <strong>Date Changes:</strong> Date change requests must be made 72+ hours prior to arrival.\n• <strong>Pool Costumes:</strong> Men must wear synthetic sports shorts; Women must wear long synthetic sports leggings and synthetic sports T-shirt.",
                    'content'           => "Sayeman Beach Resort revives its famed legacy of comfort, elegance, and impeccable service first established in 1964. Located at the beachfront location of Marine Drive, Kolatoli, it features an infinity pool overlooking the ocean, private beach access, and Casablanca Restaurant.",
                    'excerpt'           => "An iconic beachfront landmark on Marine Drive, offering a gorgeous infinity pool and elegant modern design."
                ),
                array(
                    'title'             => "Hotel The Cox Today",
                    'price'             => '7500',
                    'location'          => "Kolatoli Road, Hotel-Motel Zone, Cox's Bazar, Bangladesh",
                    'contact'           => '01755598449',
                    'rating_location'   => '4.5',
                    'rating_comfort'    => '4.4',
                    'rating_facilities' => '4.4',
                    'reviews_count'     => '156',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Swimming Pool, Gym, Thai Spa, On-site Restaurant, Bar/Lounge, Free Wi-Fi, Room Service, Air Conditioning, Couple Friendly, Valet Parking',
                    'nearby_interest'   => "0.3 km from Sugondha Beach\n0.7 km from Laboni Beach\n4.5 km from Radiant Fish World",
                    'nearby_terminals'  => "4.9 km from Cox's Bazar Airport\n5.7 km from Cox's Bazar Railway Station",
                    'check_in'          => '14:00',
                    'check_out'         => '12:00',
                    'policy_child'      => "Children below 5 stay free. Ages 5-11 pay 50% breakfast cost.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed with breakfast is BDT 2,200.",
                    'policy_house'      => "• <strong>Pool Usage:</strong> Proper synthetic swimwear required.\n• <strong>Smoking:</strong> Permitted in designated outdoor areas only.",
                    'content'           => "Hotel The Cox Today is a luxury 5-star hotel in Cox's Bazar offering international standards of hospitality. With elegant rooms, a multi-cuisine restaurant, bar, spa, and a central location, it is perfect for both leisure and business travelers.",
                    'excerpt'           => "Central hotel-motel zone luxury with a large outdoor pool, spa, and comfortable multi-room layouts."
                ),
                array(
                    'title'             => "Long Beach Hotel",
                    'price'             => '9000',
                    'location'          => "Kalatali Road, Cox's Bazar, Bangladesh",
                    'contact'           => '01730338905',
                    'rating_location'   => '4.6',
                    'rating_comfort'    => '4.7',
                    'rating_facilities' => '4.6',
                    'reviews_count'     => '288',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Indoor Swimming Pool, Gym, Jacuzzi, Billiards, Cozy Restaurant, Sunset BBQ, Free Wi-Fi, Air Conditioning, Couple Friendly, Free Airport Shuttle',
                    'nearby_interest'   => "0.4 km from Sugondha Beach\n1.2 km from Laboni Beach\n3.5 km from Radiant Fish World",
                    'nearby_terminals'  => "4.5 km from Cox's Bazar Airport\n5.2 km from Cox's Bazar Railway Station",
                    'check_in'          => '13:00',
                    'check_out'         => '11:30',
                    'policy_child'      => "Children 12 and below stay free without extra bed. Kids above 12 considered adults.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed with buffet breakfast is BDT 2,500.",
                    'policy_house'      => "• <strong>Check-In Requirements:</strong> Government-issued NID or passport required for all check-ins.\n• <strong>Shuttle:</strong> Inform front desk 24 hours in advance to arrange free shuttle.",
                    'content'           => "Long Beach Hotel provides a highly rated luxury experience. Nestled in a prime location, it offers the city's only indoor swimming pool, a state-of-the-art fitness center, relaxing spa services, and fine dining restaurants serving local and continental favorites.",
                    'excerpt'           => "Highly-rated luxury hotel featuring Cox's Bazar's only indoor swimming pool, jacuzzi, and spa."
                ),
                array(
                    'title'             => "Mermaid Beach Resort",
                    'price'             => '16500',
                    'location'          => "Pechardi, Marine Drive Road, Cox's Bazar, Bangladesh",
                    'contact'           => '01841416468',
                    'rating_location'   => '4.9',
                    'rating_comfort'    => '4.8',
                    'rating_facilities' => '4.7',
                    'reviews_count'     => '195',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Private Beach Access, Swimming Pool, Organic Restaurant, Beach Cabanas, Spa, Free Wi-Fi, Air Conditioning, Couple Friendly, Kayaking',
                    'nearby_interest'   => "0.01 km from Pechardi Private Beach\n8.5 km from Himchori Waterfall\n15.0 km from Kolatoli Beach",
                    'nearby_terminals'  => "18.0 km from Cox's Bazar Airport\n19.0 km from Cox's Bazar Railway Station",
                    'check_in'          => '13:00',
                    'check_out'         => '11:00',
                    'policy_child'      => "Children under 5 enjoy a complimentary stay and breakfast. Children above 5 pay BDT 1,200 for breakfast.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed along with buffet breakfast is BDT 3,500.",
                    'policy_house'      => "• <strong>Eco-Friendly Rules:</strong> Guests are requested to maintain the ecological balance of the resort.\n• <strong>No outside visitors:</strong> Outside visitors are not permitted in rooms.",
                    'content'           => "Mermaid Beach Resort is a premium eco-friendly boutique resort offering private beach villas and bungalows. Known for its colorful designs, organic food options, and direct private beach access, it offers a peaceful haven away from crowds.",
                    'excerpt'           => "Boutique eco-resort offering exclusive private beach access, custom-themed villas, and fresh organic dining."
                ),
                array(
                    'title'             => "Windy Terrace Hotel",
                    'price'             => '5500',
                    'location'          => "Kolatoli Road, Hotel-Motel Zone, Cox's Bazar, Bangladesh",
                    'contact'           => '01730434444',
                    'rating_location'   => '4.4',
                    'rating_comfort'    => '4.3',
                    'rating_facilities' => '4.2',
                    'reviews_count'     => '98',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Infinity Pool, Chandra Dweep Restaurant, Spa, Free Wi-Fi, Air Conditioning, Room Service, Couple Friendly, Free Parking',
                    'nearby_interest'   => "0.35 km from Sugondha Beach\n0.6 km from Kolatoli Beach\n4.2 km from Radiant Fish World",
                    'nearby_terminals'  => "5.1 km from Cox's Bazar Airport\n5.9 km from Cox's Bazar Railway Station",
                    'check_in'          => '14:00',
                    'check_out'         => '12:30',
                    'policy_child'      => "Children under 6 stay free when sharing rooms with parents. Older kids pay full breakfast rates.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed is BDT 1,800 per night.",
                    'policy_house'      => "• <strong>Couples Rule:</strong> Couples may be required to show valid identification documents at check-in.\n• <strong>No alcohol:</strong> Outside alcoholic beverages are not allowed.",
                    'content'           => "Windy Terrace Hotel is a cozy boutique hotel in Cox's Bazar designed to offer a relaxing, comfortable stay. It features a rooftop infinity pool with sea and hill views, Chandra Dweep restaurant, and relaxing spa facilities.",
                    'excerpt'           => "Cozy budget-friendly boutique hotel featuring a rooftop pool and easy access to Sugondha Beach."
                ),
                array(
                    'title'             => "Neeshorgo Hotel & Resort",
                    'price'             => '6800',
                    'location'          => "Marine Drive Road, Kolatoli, Cox's Bazar, Bangladesh",
                    'contact'           => '01844057876',
                    'rating_location'   => '4.7',
                    'rating_comfort'    => '4.4',
                    'rating_facilities' => '4.4',
                    'reviews_count'     => '112',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Rooftop Infinity Pool, Seafood Restaurant, Fitness Gym, Spa & Steam, Free Wi-Fi, Air Conditioning, Room Service, Couple Friendly, Balcony',
                    'nearby_interest'   => "0.1 km from Kolatoli Beach\n2.5 km from Himchori Waterfall\n3.0 km from Laboni Beach",
                    'nearby_terminals'  => "5.5 km from Cox's Bazar Airport\n6.3 km from Cox's Bazar Railway Station",
                    'check_in'          => '14:00',
                    'check_out'         => '12:00',
                    'policy_child'      => "Children under 5 years stay free. Kids between 5-9 pay BDT 500 for breakfast.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed is BDT 2,000 per night.",
                    'policy_house'      => "• <strong>Swimwear:</strong> Appropriate synthetic costumes required for the infinity pool.\n• <strong>No soundboxes:</strong> Loud music or sound systems are not allowed in rooms.",
                    'content'           => "Neeshorgo Hotel & Resort is situated on the beautiful Marine Drive. It features a gorgeous rooftop infinity pool with stunning 360-degree views of the sea and forest, spacious balconies, a seafood restaurant, and high-quality room service.",
                    'excerpt'           => "Rooftop infinity pool resort located on Marine Drive, offering scenic hill and ocean balconies."
                ),
                array(
                    'title'             => "Seagull Hotels Ltd.",
                    'price'             => '8000',
                    'location'          => "Sugondha Road, Hotel-Motel Zone, Cox's Bazar, Bangladesh",
                    'contact'           => '01766666530',
                    'rating_location'   => '4.7',
                    'rating_comfort'    => '4.5',
                    'rating_facilities' => '4.5',
                    'reviews_count'     => '245',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Private Beach Lounge, Large Swimming Pool, Gym, Multiple Restaurants, Bar/Lounge, Free Wi-Fi, Air Conditioning, Couple Friendly, Table Tennis',
                    'nearby_interest'   => "0.05 km from Sugondha Beach\n0.5 km from Laboni Beach\n4.0 km from Radiant Fish World",
                    'nearby_terminals'  => "4.7 km from Cox's Bazar Airport\n5.4 km from Cox's Bazar Railway Station",
                    'check_in'          => '14:00',
                    'check_out'         => '12:00',
                    'policy_child'      => "Children under 5 years stay free. Kids 5-11 pay 50% buffet breakfast charge.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed is BDT 2,500.",
                    'policy_house'      => "• <strong>Swimwear:</strong> Swimming pool use requires proper synthetic costumes.\n• <strong>Loud music:</strong> Sound boxes and speakers are prohibited in rooms.",
                    'content'           => "Seagull Hotels Ltd. is one of the classic luxury hotels in Cox's Bazar. Located right on Sugondha Beach, it features a private beach lounge, a large outdoor pool, several restaurants serving multi-cuisine dishes, and well-appointed rooms with ocean or hill views.",
                    'excerpt'           => "One of the classic properties on Sugondha Beach, with a large outdoor pool, gym, and private beach beds."
                ),
                array(
                    'title'             => "Hotel Grand Pacific",
                    'price'             => '6000',
                    'location'          => "Kolatoli Road, Cox's Bazar, Bangladesh",
                    'contact'           => '01777712345',
                    'rating_location'   => '4.3',
                    'rating_comfort'    => '4.4',
                    'rating_facilities' => '4.3',
                    'reviews_count'     => '78',
                    'couple_friendly'   => 'yes',
                    'amenities'         => 'Swimming Pool, Fitness Center, Restaurant, Room Service, Free Wi-Fi, Air Conditioning, Couple Friendly, Free Parking',
                    'nearby_interest'   => "0.5 km from Sugondha Beach\n0.8 km from Kolatoli Beach\n4.5 km from Radiant Fish World",
                    'nearby_terminals'  => "5.2 km from Cox's Bazar Airport\n6.0 km from Cox's Bazar Railway Station",
                    'check_in'          => '14:00',
                    'check_out'         => '12:00',
                    'policy_child'      => "Children under 6 stay free. Older kids pay BDT 500 for breakfast.",
                    'policy_pet'        => 'Not Allowed',
                    'policy_extra'      => "Extra bed is BDT 2,000.",
                    'policy_house'      => "• <strong>Check-In ID:</strong> Each guest must present NID copy during check-in.\n• <strong>Outside Food:</strong> Outside food is not allowed in rooms.",
                    'content'           => "Hotel Grand Pacific is a comfortable, modern hotel on Kolatoli Road. Featuring spacious, air-conditioned rooms, a fitness center, pool, and a multi-cuisine restaurant, it is an excellent and affordable choice for families.",
                    'excerpt'           => "Comfortable mid-range option on Kolatoli Road with pool, gym, and multi-cuisine family dining."
                )
            );

            // 3. Loop and insert posts
            foreach ( $hotels_data as $hotel ) {
                $post_id = wp_insert_post( array(
                    'post_title'   => $hotel['title'],
                    'post_name'    => sanitize_title( $hotel['title'] ),
                    'post_content' => $hotel['content'],
                    'post_excerpt' => $hotel['excerpt'],
                    'post_status'  => 'publish',
                    'post_type'    => 'hotel',
                ) );

                if ( $post_id && ! is_wp_error( $post_id ) ) {
                    update_post_meta( $post_id, '_hotel_price', $hotel['price'] );
                    update_post_meta( $post_id, '_hotel_location', $hotel['location'] );
                    update_post_meta( $post_id, '_hotel_contact', $hotel['contact'] );
                    update_post_meta( $post_id, '_hotel_rating_location', $hotel['rating_location'] );
                    update_post_meta( $post_id, '_hotel_rating_comfort', $hotel['rating_comfort'] );
                    update_post_meta( $post_id, '_hotel_rating_facilities', $hotel['rating_facilities'] );
                    update_post_meta( $post_id, '_hotel_reviews_count', $hotel['reviews_count'] );
                    update_post_meta( $post_id, '_hotel_couple_friendly', $hotel['couple_friendly'] );
                    update_post_meta( $post_id, '_hotel_amenities', $hotel['amenities'] );
                    
                    update_post_meta( $post_id, '_hotel_nearby_interest', $hotel['nearby_interest'] );
                    update_post_meta( $post_id, '_hotel_nearby_terminals', $hotel['nearby_terminals'] );
                    
                    update_post_meta( $post_id, '_hotel_check_in', $hotel['check_in'] );
                    update_post_meta( $post_id, '_hotel_check_out', $hotel['check_out'] );
                    update_post_meta( $post_id, '_hotel_policy_child', $hotel['policy_child'] );
                    update_post_meta( $post_id, '_hotel_policy_pet', $hotel['policy_pet'] );
                    update_post_meta( $post_id, '_hotel_policy_extra', $hotel['policy_extra'] );
                    update_post_meta( $post_id, '_hotel_policy_house', $hotel['policy_house'] );

                    // Set availability dates
                    $available_from = date( 'Y-m-d' );
                    $available_to = date( 'Y-m-d', strtotime( '+2 years' ) );
                    update_post_meta( $post_id, '_hotel_available_from', $available_from );
                    update_post_meta( $post_id, '_hotel_available_to', $available_to );
                }
            }

            // Save confirmation option so it never runs again
            update_option( 'travel_venture_coxs_bazar_seeded_v3', true );
        }
    }
}

// Instantiate core theme hooks
Travel_Venture_Init::get_instance();

