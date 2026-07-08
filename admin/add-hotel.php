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

    </div>
    <?php
}

