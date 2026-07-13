<?php
/**
 * TripAzai functions and definitions
 *
 * @package Travel_Venture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Load Core OOP Architecture & Seeding Logic
require_once get_template_directory() . '/core/class-theme-init.php';

// Load Media Processing Scripts
require_once get_template_directory() . '/includes/hotel-media.php';

// Load Admin Write Panels (Custom Dashboard Form Handling)
require_once get_template_directory() . '/admin/add-hotel.php';
require_once get_template_directory() . '/admin/save-hotel.php';

// Load Google Maps Importer Integration
require_once get_template_directory() . '/includes/class-google-maps-importer.php';




/**
 * Filter redirect logic to load templates/page-*.php from templates subdirectory
 */
function travel_venture_template_hierarchy( $template ) {
    if ( is_page() ) {
        $slug = get_post_field( 'post_name', get_queried_object_id() );
        
        // Match specific templates
        if ( 'home' === $slug || is_front_page() ) {
            $new_template = locate_template( array( 'templates/page-home.php' ) );
            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }
        
        if ( 'about' === $slug || 'about-us' === $slug ) {
            $new_template = locate_template( array( 'templates/page-about.php' ) );
            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }

        // General page template in templates directory
        $new_template = locate_template( array( 'templates/page-' . $slug . '.php' ) );
        if ( ! empty( $new_template ) ) {
            return $new_template;
        }
    }
    return $template;
}
add_filter( 'template_include', 'travel_venture_template_hierarchy' );

