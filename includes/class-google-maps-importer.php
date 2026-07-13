<?php
/**
 * Google Maps / Places API Hotel Importer Integration
 *
 * @package Travel_Venture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Travel_Venture_Google_Maps_Importer {

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
        // Add Admin Menu Subpage under Hotels CPT
        add_action( 'admin_menu', array( $this, 'register_importer_admin_page' ) );

        // Register REST API Route for AJAX synchronization
        add_action( 'rest_api_init', array( $this, 'register_rest_route' ) );
    }

    /**
     * Register the admin subpage
     */
    public function register_importer_admin_page() {
        add_submenu_page(
            'edit.php?post_type=hotel',
            __( 'Google Maps Sync', 'tripazai' ),
            __( 'Google Maps Sync', 'tripazai' ),
            'manage_options',
            'google-maps-sync',
            array( $this, 'render_admin_page' )
        );
    }

    /**
     * Register REST API endpoint
     */
    public function register_rest_route() {
        register_rest_route( 'travel-venture/v1', '/sync-hotels', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handle_sync_request' ),
            'permission_callback' => function() {
                return current_user_can( 'manage_options' );
            }
        ) );
    }

    /**
     * Handle REST API Request to Sync Hotels
     */
    public function handle_sync_request( WP_REST_Request $request ) {
        $api_key = sanitize_text_field( $request->get_param( 'api_key' ) );
        $query   = sanitize_text_field( $request->get_param( 'query' ) );

        if ( empty( $api_key ) ) {
            return new WP_Error( 'missing_api_key', __( 'Google Maps API Key is required.', 'tripazai' ), array( 'status' => 400 ) );
        }

        if ( empty( $query ) ) {
            $query = "Hotels in Kolatoli, Cox's Bazar";
        }

        // Save settings to options database for persistence
        update_option( 'travel_venture_google_maps_api_key', $api_key );
        update_option( 'travel_venture_google_maps_query', $query );

        // Initialize sync logging
        $logs = array();
        $logs[] = sprintf( __( 'Starting Google Maps synchronization for query: "%s"...', 'tripazai' ), $query );

        // 1. Text Search request to find Place IDs
        $search_url = add_query_arg( array(
            'query' => urlencode( $query ),
            'key'   => $api_key
        ), 'https://maps.googleapis.com/maps/api/place/textsearch/json' );

        $search_response = wp_remote_get( $search_url );
        if ( is_wp_error( $search_response ) ) {
            return new WP_Error( 'api_error', $search_response->get_error_message(), array( 'status' => 500 ) );
        }

        $search_body = wp_remote_retrieve_body( $search_response );
        $search_data = json_decode( $search_body, true );

        if ( empty( $search_data ) || ! isset( $search_data['status'] ) ) {
            return new WP_Error( 'api_error', __( 'Failed to parse search response.', 'tripazai' ), array( 'status' => 500 ) );
        }

        if ( 'OK' !== $search_data['status'] ) {
            $err_msg = isset( $search_data['error_message'] ) ? $search_data['error_message'] : $search_data['status'];
            return new WP_Error( 'api_error', sprintf( __( 'Google Places API Error: %s', 'tripazai' ), $err_msg ), array( 'status' => 500 ) );
        }

        $results = $search_data['results'];
        $logs[]  = sprintf( __( 'Found %d hotel listings on Google Maps. Processing details...', 'tripazai' ), count( $results ) );

        // Load media functions for sideloading images
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $synced_count = 0;
        $created_count = 0;
        $updated_count = 0;

        foreach ( $results as $place ) {
            $place_id = $place['place_id'];
            $hotel_name = sanitize_text_field( $place['name'] );

            $logs[] = sprintf( __( 'Processing: "%s" (Place ID: %s)...', 'tripazai' ), $hotel_name, $place_id );

            // 2. Place Details request for complete details
            $details_url = add_query_arg( array(
                'place_id' => $place_id,
                'fields'   => 'name,formatted_address,formatted_phone_number,editorial_summary,photos,rating,reviews,website',
                'key'      => $api_key
            ), 'https://maps.googleapis.com/maps/api/place/details/json' );

            $details_response = wp_remote_get( $details_url );
            if ( is_wp_error( $details_response ) ) {
                $logs[] = sprintf( __( 'Error fetching details for "%s": %s', 'tripazai' ), $hotel_name, $details_response->get_error_message() );
                continue;
            }

            $details_body = wp_remote_retrieve_body( $details_response );
            $details_data = json_decode( $details_body, true );

            if ( empty( $details_data ) || ! isset( $details_data['result'] ) ) {
                $logs[] = sprintf( __( 'Failed to parse details for "%s".', 'tripazai' ), $hotel_name );
                continue;
            }

            $details = $details_data['result'];

            // Extract fields
            $address = isset( $details['formatted_address'] ) ? sanitize_text_field( $details['formatted_address'] ) : '';
            $phone   = isset( $details['formatted_phone_number'] ) ? sanitize_text_field( $details['formatted_phone_number'] ) : '';
            $rating  = isset( $details['rating'] ) ? sanitize_text_field( $details['rating'] ) : '4.5';
            
            $reviews_count = '120'; // Fallback reviews count
            if ( isset( $place['user_ratings_total'] ) ) {
                $reviews_count = sanitize_text_field( $place['user_ratings_total'] );
            }

            $description = '';
            if ( isset( $details['editorial_summary']['overview'] ) ) {
                $description = sanitize_textarea_field( $details['editorial_summary']['overview'] );
            }
            if ( empty( $description ) ) {
                $description = sprintf( __( 'Experience a premium stay at %1$s, located conveniently at %2$s. This beautiful property is highly rated by travelers for its excellent service and comfortable rooms.', 'tripazai' ), $hotel_name, $address );
            }

            $excerpt = sprintf( __( 'Discover comfort and premium services at %s. Book your luxury room today.', 'tripazai' ), $hotel_name );

            // Check if hotel already exists in our database
            $existing_hotels = get_posts( array(
                'post_type'   => 'hotel',
                'meta_key'    => '_google_place_id',
                'meta_value'  => $place_id,
                'post_status' => 'any',
                'numberposts' => 1
            ) );

            $post_id = 0;
            $is_update = false;

            if ( ! empty( $existing_hotels ) ) {
                // Update existing
                $post_id = $existing_hotels[0]->ID;
                $is_update = true;
                wp_update_post( array(
                    'ID'           => $post_id,
                    'post_title'   => $hotel_name,
                    'post_content' => $description,
                    'post_excerpt' => $excerpt
                ) );
                $updated_count++;
                $logs[] = sprintf( __( 'Updated existing listing (Post ID: %d).', 'tripazai' ), $post_id );
            } else {
                // Insert new
                $post_id = wp_insert_post( array(
                    'post_title'   => $hotel_name,
                    'post_name'    => sanitize_title( $hotel_name ),
                    'post_content' => $description,
                    'post_excerpt' => $excerpt,
                    'post_status'  => 'publish',
                    'post_type'    => 'hotel'
                ) );
                $created_count++;
                $logs[] = sprintf( __( 'Created new listing (Post ID: %d).', 'tripazai' ), $post_id );
            }

            if ( $post_id && ! is_wp_error( $post_id ) ) {
                // 3. Update standard hotel custom meta fields
                update_post_meta( $post_id, '_google_place_id', $place_id );
                update_post_meta( $post_id, '_hotel_location', $address );
                update_post_meta( $post_id, '_hotel_contact', $phone );
                update_post_meta( $post_id, '_hotel_rating_location', $rating );
                update_post_meta( $post_id, '_hotel_rating_comfort', '4.5' );
                update_post_meta( $post_id, '_hotel_rating_facilities', '4.4' );
                update_post_meta( $post_id, '_hotel_reviews_count', $reviews_count );
                update_post_meta( $post_id, '_hotel_couple_friendly', 'yes' );

                // Set random realistic price (Google Places doesn't provide nightly room rates directly)
                $random_price = rand( 45, 145 ) * 100; // Generates prices like 4500, 5200, 11000 etc.
                if ( ! $is_update || ! get_post_meta( $post_id, '_hotel_price', true ) ) {
                    update_post_meta( $post_id, '_hotel_price', $random_price );
                }

                // Default dummy dates and fields
                update_post_meta( $post_id, '_hotel_available_from', date( 'Y-m-d' ) );
                update_post_meta( $post_id, '_hotel_available_to', date( 'Y-m-d', strtotime( '+2 years' ) ) );
                update_post_meta( $post_id, '_hotel_check_in', '14:00' );
                update_post_meta( $post_id, '_hotel_check_out', '12:00' );
                update_post_meta( $post_id, '_hotel_policy_pet', 'Not Allowed' );
                update_post_meta( $post_id, '_hotel_policy_child', 'Children under 6 stay free when sharing rooms with parents.' );
                update_post_meta( $post_id, '_hotel_policy_extra', 'Extra bed is BDT 2,500 per night.' );
                update_post_meta( $post_id, '_hotel_policy_house', '• Present valid NID copy upon check-in.' );
                update_post_meta( $post_id, '_hotel_amenities', 'Free Wi-Fi, Swimming Pool, Fitness Center, Room Service, Couple Friendly, Air Conditioning' );
                update_post_meta( $post_id, '_hotel_nearby_interest', "0.2 km from Kolatoli Sea Beach\n3.5 km from Radiant Fish World" );
                update_post_meta( $post_id, '_hotel_nearby_terminals', "5.0 km from Cox's Bazar Airport\n5.5 km from Cox's Bazar Railway Station" );

                // 4. Download and map images (Sideload to WP Media Library)
                if ( ! empty( $details['photos'] ) ) {
                    $attachment_ids = array();
                    $image_urls = array();
                    $photos = array_slice( $details['photos'], 0, 5 ); // Sync up to 5 photos

                    $logs[] = sprintf( __( 'Downloading %d images for "%s"...', 'tripazai' ), count( $photos ), $hotel_name );

                    foreach ( $photos as $index => $photo ) {
                        $photo_ref = $photo['photo_reference'];
                        $photo_url = add_query_arg( array(
                            'maxwidth'        => 1200,
                            'photo_reference' => $photo_ref,
                            'key'             => $api_key
                        ), 'https://maps.googleapis.com/maps/api/place/photo' );

                        $image_urls[] = $photo_url;

                        // Sideload image
                        $desc = sprintf( __( '%1$s - Photo %2$d', 'tripazai' ), $hotel_name, $index + 1 );
                        $img_id = media_sideload_image( $photo_url, $post_id, $desc, 'id' );

                        if ( ! is_wp_error( $img_id ) && is_numeric( $img_id ) ) {
                            $attachment_ids[] = (int) $img_id;
                        } else {
                            $logs[] = sprintf( __( 'Warning: Failed to download image %d: %s', 'tripazai' ), $index + 1, $img_id->get_error_message() );
                        }
                    }

                    // Update gallery and featured image
                    if ( ! empty( $attachment_ids ) ) {
                        // Set featured image
                        set_post_thumbnail( $post_id, $attachment_ids[0] );
                        $logs[] = sprintf( __( 'Featured image set (Attachment ID: %d).', 'tripazai' ), $attachment_ids[0] );

                        // Set gallery metadata (comma-separated list of IDs)
                        if ( count( $attachment_ids ) > 1 ) {
                            $gallery_ids = array_slice( $attachment_ids, 1 );
                            update_post_meta( $post_id, '_hotel_gallery', implode( ',', $gallery_ids ) );
                            $logs[] = sprintf( __( 'Gallery images mapped: %s.', 'tripazai' ), implode( ',', $gallery_ids ) );
                        }
                    }

                    // Save direct Google Photo fallback URLs
                    if ( ! empty( $image_urls ) ) {
                        update_post_meta( $post_id, '_hotel_image_featured_url', $image_urls[0] );
                        if ( count( $image_urls ) > 1 ) {
                            $gallery_urls = array_slice( $image_urls, 1 );
                            update_post_meta( $post_id, '_hotel_image_gallery_urls', implode( ',', $gallery_urls ) );
                        }
                    }
                }

                $synced_count++;
            }
        }

        $logs[] = sprintf( __( 'Synchronization completed. Total Synced: %d | Created: %d | Updated: %d.', 'tripazai' ), $synced_count, $created_count, $updated_count );

        return rest_ensure_response( array(
            'success' => true,
            'summary' => sprintf( __( 'Successfully synchronized %d hotels.', 'tripazai' ), $synced_count ),
            'created' => $created_count,
            'updated' => $updated_count,
            'logs'    => $logs
        ) );
    }

    /**
     * Render the admin subpage UI
     */
    public function render_admin_page() {
        // Fetch saved settings
        $api_key = get_option( 'travel_venture_google_maps_api_key', '' );
        $query   = get_option( 'travel_venture_google_maps_query', "Hotels in Kolatoli, Cox's Bazar" );
        ?>
        <div class="wrap" style="max-width: 900px; margin: 30px auto 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
            
            <h1 style="font-size: 26px; font-weight: 700; color: #0f172a; margin-bottom: 5px; display: flex; align-items: center; gap: 10px;">
                <span class="dashicons dashicons-admin-site" style="font-size: 28px; width: 28px; height: 28px; color: #0284c7;"></span>
                <?php esc_html_e( 'Google Maps to WordPress Hotel Auto-Sync', 'tripazai' ); ?>
            </h1>
            <p style="color: #64748b; font-size: 14px; margin-top: 0; margin-bottom: 25px;">
                <?php esc_html_e( 'Fetch hotels from Google Places API directly and publish them as custom posts into your WordPress site.', 'tripazai' ); ?>
            </p>

            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 25px;" />

            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- Google Maps API Key -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="tv_api_key" style="font-weight: 600; font-size: 13px; color: #334155; text-transform: uppercase; tracking-wider: 0.05em;">
                        <?php esc_html_e( 'Google Maps/Places API Key', 'tripazai' ); ?>
                        <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="password" id="tv_api_key" value="<?php echo esc_attr( $api_key ); ?>" placeholder="<?php esc_attr_e( 'Paste your Google Places API Key here...', 'tripazai' ); ?>" style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; width: 100%; box-sizing: border-box; background: #f8fafc;" />
                    <p style="margin: 3px 0 0 0; font-size: 12px; color: #64748b;">
                        <?php esc_html_e( 'Places API and Photo API must be enabled on your Google Cloud Console project.', 'tripazai' ); ?>
                    </p>
                </div>

                <!-- Google Maps Search Query -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="tv_query" style="font-weight: 600; font-size: 13px; color: #334155; text-transform: uppercase; tracking-wider: 0.05em;">
                        <?php esc_html_e( 'Location / Search Query', 'tripazai' ); ?>
                    </label>
                    <input type="text" id="tv_query" value="<?php echo esc_attr( $query ); ?>" placeholder="<?php esc_attr_e( 'e.g. Hotels in Kolatoli, Cox\'s Bazar', 'tripazai' ); ?>" style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; width: 100%; box-sizing: border-box; background: #f8fafc;" />
                </div>

                <!-- Action Button -->
                <div>
                    <button type="button" id="tv_start_sync_btn" style="background: #0284c7; color: #fff; border: 0; padding: 12px 24px; font-size: 14px; font-weight: 600; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s ease;">
                        <span class="dashicons dashicons-update" style="font-size: 18px; width: 18px; height: 18px;"></span>
                        <?php esc_html_e( 'Start Automation Sync', 'tripazai' ); ?>
                    </button>
                </div>

                <!-- Log Panel -->
                <div id="tv_sync_log_wrapper" style="display: none; flex-direction: column; gap: 6px;">
                    <label style="font-weight: 600; font-size: 13px; color: #334155; text-transform: uppercase; tracking-wider: 0.05em;">
                        <?php esc_html_e( 'Live Synchronization Log', 'tripazai' ); ?>
                    </label>
                    <div id="tv_sync_log_console" style="background: #0f172a; color: #38bdf8; font-family: 'Courier New', Courier, monospace; font-size: 12px; padding: 15px; border-radius: 8px; height: 250px; overflow-y: auto; line-height: 1.6; border: 1px solid #1e293b;">
                        <!-- Logs will populate here -->
                    </div>
                </div>

            </div>

            <!-- Custom Script for AJAX Execution -->
            <script>
                jQuery(document).ready(function($) {
                    $('#tv_start_sync_btn').on('click', function(e) {
                        e.preventDefault();
                        
                        var apiKey = $('#tv_api_key').val();
                        var query = $('#tv_query').val();

                        if (!apiKey) {
                            alert('Please enter your Google Maps API Key.');
                            return;
                        }

                        // Update button state
                        var $btn = $(this);
                        $btn.prop('disabled', true).css('background', '#64748b').html('<span class="dashicons dashicons-update" style="animation: spin 2s linear infinite; font-size: 18px; width: 18px; height: 18px;"></span> Syncing...');

                        // Show logs panel
                        var $logConsole = $('#tv_sync_log_console');
                        $('#tv_sync_log_wrapper').show();
                        $logConsole.html('<div style="color: #64748b;">Initializing connection to REST API...</div>');

                        // Execute API Sync Request
                        $.ajax({
                            url: wpApiSettings.root + 'travel-venture/v1/sync-hotels',
                            method: 'POST',
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                            },
                            data: {
                                api_key: apiKey,
                                query: query
                            },
                            success: function(response) {
                                $logConsole.html('');
                                if (response.logs && response.logs.length) {
                                    $.each(response.logs, function(index, log) {
                                        var color = log.includes('Error') ? '#f87171' : (log.includes('Created') || log.includes('Updated') ? '#4ade80' : '#38bdf8');
                                        $logConsole.append('<div style="color: ' + color + '; margin-bottom: 5px;">[' + new Date().toLocaleTimeString() + '] ' + log + '</div>');
                                    });
                                }
                                $logConsole.scrollTop($logConsole[0].scrollHeight);
                            },
                            error: function(xhr) {
                                var errMsg = 'An unknown connection error occurred.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errMsg = xhr.responseJSON.message;
                                }
                                $logConsole.append('<div style="color: #f87171; margin-top: 10px;">[ERROR] ' + errMsg + '</div>');
                            },
                            complete: function() {
                                // Restore button
                                $btn.prop('disabled', false).css('background', '#0284c7').html('<span class="dashicons dashicons-update" style="font-size: 18px; width: 18px; height: 18px;"></span> Start Automation Sync');
                            }
                        });
                    });
                });
            </script>
            <style>
                @keyframes spin {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }
            </style>
        </div>
        <?php
    }
}

// Instantiate the Google Maps Importer
Travel_Venture_Google_Maps_Importer::get_instance();

