<?php
/**
 * Custom metabox fields form layout
 *
 * @package Travel_Venture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register Hotel Meta Box
 */
function travel_venture_add_hotel_metaboxes() {
    add_meta_box(
        'travel_venture_hotel_details',
        __( 'TripAzai - Hotel Options', 'tripazai' ),
        'travel_venture_hotel_details_callback',
        'hotel',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'travel_venture_add_hotel_metaboxes' );

/**
 * Render Meta Box Fields Form HTML
 */
function travel_venture_hotel_details_callback( $post ) {
    // Add nonce for verification
    wp_nonce_field( 'travel_venture_save_hotel_data', 'travel_venture_hotel_nonce' );

    // Retrieve existing values
    $price          = get_post_meta( $post->ID, '_hotel_price', true );
    $location       = get_post_meta( $post->ID, '_hotel_location', true );
    $amenities      = get_post_meta( $post->ID, '_hotel_amenities', true );
    $contact        = get_post_meta( $post->ID, '_hotel_contact', true );
    $available_from = get_post_meta( $post->ID, '_hotel_available_from', true );
    $available_to   = get_post_meta( $post->ID, '_hotel_available_to', true );
    $gallery        = get_post_meta( $post->ID, '_hotel_gallery', true );
    $video          = get_post_meta( $post->ID, '_hotel_video', true );
    ?>
    <div class="hotel-meta-form-wrapper">
        
        <div class="hotel-meta-field-row row-half">
            <label for="hotel_price"><?php esc_html_e( 'Price Range ($ per night)', 'tripazai' ); ?></label>
            <input type="number" id="hotel_price" name="hotel_price" value="<?php echo esc_attr( $price ); ?>" min="0" placeholder="e.g. 199" />
        </div>

        <div class="hotel-meta-field-row row-half">
            <label for="hotel_location"><?php esc_html_e( 'Location City / Country', 'tripazai' ); ?></label>
            <input type="text" id="hotel_location" name="hotel_location" value="<?php echo esc_attr( $location ); ?>" placeholder="e.g. Kyoto, Japan" />
        </div>

        <div class="hotel-meta-field-row">
            <label for="hotel_amenities"><?php esc_html_e( 'Amenities (Comma-separated list)', 'tripazai' ); ?></label>
            <textarea id="hotel_amenities" name="hotel_amenities" rows="2" placeholder="e.g. Free Wi-Fi, Infinite Pool, Room Service, Spa"><?php echo esc_textarea( $amenities ); ?></textarea>
        </div>

        <div class="hotel-meta-field-row">
            <label for="hotel_contact"><?php esc_html_e( 'Contact / Reservation Phone Number', 'tripazai' ); ?></label>
            <input type="text" id="hotel_contact" name="hotel_contact" value="<?php echo esc_attr( $contact ); ?>" placeholder="e.g. +1 (800) 555-0199" />
        </div>

        <div class="hotel-meta-field-row row-half">
            <label for="hotel_available_from"><?php esc_html_e( 'Availability Start Date', 'tripazai' ); ?></label>
            <input type="date" id="hotel_available_from" name="hotel_available_from" value="<?php echo esc_attr( $available_from ); ?>" />
        </div>

        <div class="hotel-meta-field-row row-half">
            <label for="hotel_available_to"><?php esc_html_e( 'Availability End Date', 'tripazai' ); ?></label>
            <input type="date" id="hotel_available_to" name="hotel_available_to" value="<?php echo esc_attr( $available_to ); ?>" />
        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;" />

        <!-- Gallery Upload Container -->
        <div class="hotel-meta-field-row">
            <label><?php esc_html_e( 'Hotel Multi-Image Gallery', 'tripazai' ); ?></label>
            <div>
                <button type="button" class="button media-upload-action-btn" id="travel_venture_select_gallery_btn">
                    <span class="dashicons dashicons-images-alt2" style="margin-top: 3px; margin-right: 5px;"></span>
                    <?php esc_html_e( 'Select/Upload Gallery Images', 'tripazai' ); ?>
                </button>
            </div>
            
            <input type="hidden" id="hotel_gallery_input" name="hotel_gallery" value="<?php echo esc_attr( $gallery ); ?>" />
            
            <div class="gallery-preview-container" id="hotel_gallery_preview_container">
                <?php
                if ( ! empty( $gallery ) ) {
                    $attachment_ids = explode( ',', $gallery );
                    foreach ( $attachment_ids as $attachment_id ) {
                        $img_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );
                        if ( $img_url ) {
                            ?>
                            <div class="gallery-preview-item" data-id="<?php echo esc_attr( $attachment_id ); ?>">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="" />
                                <button type="button" class="remove-preview-img">&times;</button>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;" />

        <!-- Video Upload Container -->
        <div class="hotel-meta-field-row">
            <label for="hotel_video"><?php esc_html_e( 'Hotel Video Uploader (MP4 file or YouTube/Vimeo Link)', 'tripazai' ); ?></label>
            <div style="display: flex; gap: 10px;">
                <input type="text" id="hotel_video" name="hotel_video" value="<?php echo esc_attr( $video ); ?>" placeholder="Paste YouTube link or click upload to select MP4 file..." style="flex: 1;" />
                <button type="button" class="button media-upload-action-btn" id="travel_venture_select_video_btn">
                    <span class="dashicons dashicons-video-alt3" style="margin-top: 3px; margin-right: 5px;"></span>
                    <?php esc_html_e( 'Upload MP4 Video', 'tripazai' ); ?>
                </button>
            </div>
            
            <div class="video-preview-container" id="hotel_video_preview_container" style="<?php echo empty($video) ? 'display:none;' : ''; ?>">
                <?php if ( ! empty( $video ) && preg_match( '/\.(mp4|webm|ogg)$/i', $video ) ) : ?>
                    <video controls src="<?php echo esc_url( $video ); ?>"></video>
                <?php elseif ( ! empty( $video ) ) : ?>
                    <p class="description" style="margin-top: 10px; color: #0284c7;"><i class="dashicons dashicons-external" style="font-size:16px; margin-right:5px; vertical-align:middle;"></i> Dynamic oEmbed link recognized.</p>
                <?php endif; ?>
            </div>
        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;" />

        <!-- Scorecards, Badges & Ratings -->
        <h3><?php esc_html_e( 'Ratings & Badge Options', 'tripazai' ); ?></h3>
        
        <?php
        $rating_location   = get_post_meta( $post->ID, '_hotel_rating_location', true );
        $rating_comfort    = get_post_meta( $post->ID, '_hotel_rating_comfort', true );
        $rating_facilities = get_post_meta( $post->ID, '_hotel_rating_facilities', true );
        $reviews_count     = get_post_meta( $post->ID, '_hotel_reviews_count', true );
        $couple_friendly   = get_post_meta( $post->ID, '_hotel_couple_friendly', true );
        ?>

        <div class="hotel-meta-field-row row-half" style="display:inline-block; width: 48%; margin-right: 2%;">
            <label for="hotel_rating_location"><?php esc_html_e( 'Location Rating Score (1 to 5)', 'tripazai' ); ?></label>
            <input type="text" id="hotel_rating_location" name="hotel_rating_location" value="<?php echo esc_attr( $rating_location ); ?>" placeholder="e.g. 4.6" />
        </div>

        <div class="hotel-meta-field-row row-half" style="display:inline-block; width: 48%;">
            <label for="hotel_rating_comfort"><?php esc_html_e( 'Comfort Rating Score (1 to 5)', 'tripazai' ); ?></label>
            <input type="text" id="hotel_rating_comfort" name="hotel_rating_comfort" value="<?php echo esc_attr( $rating_comfort ); ?>" placeholder="e.g. 4.5" />
        </div>

        <div class="hotel-meta-field-row row-half" style="display:inline-block; width: 48%; margin-right: 2%; margin-top: 15px;">
            <label for="hotel_rating_facilities"><?php esc_html_e( 'Facilities Rating Score (1 to 5)', 'tripazai' ); ?></label>
            <input type="text" id="hotel_rating_facilities" name="hotel_rating_facilities" value="<?php echo esc_attr( $rating_facilities ); ?>" placeholder="e.g. 4.5" />
        </div>

        <div class="hotel-meta-field-row row-half" style="display:inline-block; width: 48%; margin-top: 15px;">
            <label for="hotel_reviews_count"><?php esc_html_e( 'Total Reviews Count', 'tripazai' ); ?></label>
            <input type="number" id="hotel_reviews_count" name="hotel_reviews_count" value="<?php echo esc_attr( $reviews_count ); ?>" placeholder="e.g. 127" />
        </div>

        <div class="hotel-meta-field-row" style="margin-top: 15px;">
            <label>
                <input type="checkbox" name="hotel_couple_friendly" value="yes" <?php checked( $couple_friendly, 'yes' ); ?> />
                <strong><?php esc_html_e( 'Enable "Couple Friendly" Badge', 'tripazai' ); ?></strong>
            </label>
        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;" />

        <!-- What's Nearby Points -->
        <h3><?php esc_html_e( 'Attractions & Terminals (What\'s Nearby)', 'tripazai' ); ?></h3>
        
        <?php
        $nearby_interest  = get_post_meta( $post->ID, '_hotel_nearby_interest', true );
        $nearby_terminals = get_post_meta( $post->ID, '_hotel_nearby_terminals', true );
        ?>

        <div class="hotel-meta-field-row">
            <label for="hotel_nearby_interest"><?php esc_html_e( 'Points of Interest (One per line)', 'tripazai' ); ?></label>
            <textarea id="hotel_nearby_interest" name="hotel_nearby_interest" rows="4" placeholder="e.g. 0.077 km from Kolatoli Beach, Cox's Bazar&#10;4.4 km from Radiant Fish World"><?php echo esc_textarea( $nearby_interest ); ?></textarea>
        </div>

        <div class="hotel-meta-field-row" style="margin-top: 15px;">
            <label for="hotel_nearby_terminals"><?php esc_html_e( 'Nearby Terminals (One per line)', 'tripazai' ); ?></label>
            <textarea id="hotel_nearby_terminals" name="hotel_nearby_terminals" rows="3" placeholder="e.g. 4.8 km from Cox's Bazar Airport&#10;5.6 km from Cox's Bazar Railway Station"><?php echo esc_textarea( $nearby_terminals ); ?></textarea>
        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #e2e8f0;" />

        <!-- Policies & Rules -->
        <h3><?php esc_html_e( 'Hotel Policies & Rules', 'tripazai' ); ?></h3>

        <?php
        $check_in     = get_post_meta( $post->ID, '_hotel_check_in', true );
        $check_out    = get_post_meta( $post->ID, '_hotel_check_out', true );
        $policy_child = get_post_meta( $post->ID, '_hotel_policy_child', true );
        $policy_pet   = get_post_meta( $post->ID, '_hotel_policy_pet', true );
        $policy_extra = get_post_meta( $post->ID, '_hotel_policy_extra', true );
        $policy_house = get_post_meta( $post->ID, '_hotel_policy_house', true );
        ?>

        <div class="hotel-meta-field-row row-half" style="display:inline-block; width: 48%; margin-right: 2%;">
            <label for="hotel_check_in"><?php esc_html_e( 'Check In Time (e.g. 14:00)', 'tripazai' ); ?></label>
            <input type="text" id="hotel_check_in" name="hotel_check_in" value="<?php echo esc_attr( $check_in ); ?>" placeholder="14:00" />
        </div>

        <div class="hotel-meta-field-row row-half" style="display:inline-block; width: 48%;">
            <label for="hotel_check_out"><?php esc_html_e( 'Check Out Time (e.g. 12:00)', 'tripazai' ); ?></label>
            <input type="text" id="hotel_check_out" name="hotel_check_out" value="<?php echo esc_attr( $check_out ); ?>" placeholder="12:00" />
        </div>

        <div class="hotel-meta-field-row" style="margin-top: 15px;">
            <label for="hotel_policy_child"><?php esc_html_e( 'Child Policy', 'tripazai' ); ?></label>
            <textarea id="hotel_policy_child" name="hotel_policy_child" rows="3"><?php echo esc_textarea( $policy_child ); ?></textarea>
        </div>

        <div class="hotel-meta-field-row" style="margin-top: 15px;">
            <label for="hotel_policy_pet"><?php esc_html_e( 'Pet Policy', 'tripazai' ); ?></label>
            <input type="text" id="hotel_policy_pet" name="hotel_policy_pet" value="<?php echo esc_attr( $policy_pet ); ?>" placeholder="Not Allowed" />
        </div>

        <div class="hotel-meta-field-row" style="margin-top: 15px;">
            <label for="hotel_policy_extra"><?php esc_html_e( 'Extra Bed & Breakfast Policy', 'tripazai' ); ?></label>
            <textarea id="hotel_policy_extra" name="hotel_policy_extra" rows="3"><?php echo esc_textarea( $policy_extra ); ?></textarea>
        </div>

        <div class="hotel-meta-field-row" style="margin-top: 15px;">
            <label for="hotel_policy_house"><?php esc_html_e( 'House Rules & Special Guidelines (HTML/text supported)', 'tripazai' ); ?></label>
            <textarea id="hotel_policy_house" name="hotel_policy_house" rows="6"><?php echo esc_textarea( $policy_house ); ?></textarea>
        </div>

    </div>
    <?php
}
