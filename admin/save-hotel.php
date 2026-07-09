<?php
/**
 * Custom metabox fields saving logic
 *
 * @package Travel_Venture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Handle custom post type meta save actions
 */
function travel_venture_save_hotel_meta( $post_id ) {
    // Check if nonce is set
    if ( ! isset( $_POST['travel_venture_hotel_nonce'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['travel_venture_hotel_nonce'], 'travel_venture_save_hotel_data' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions
    if ( isset( $_POST['post_type'] ) && 'hotel' === $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it is safe to save data now. */

    // Save Price
    if ( isset( $_POST['hotel_price'] ) ) {
        $price = sanitize_text_field( $_POST['hotel_price'] );
        update_post_meta( $post_id, '_hotel_price', $price );
    }

    // Save Location
    if ( isset( $_POST['hotel_location'] ) ) {
        $location = sanitize_text_field( $_POST['hotel_location'] );
        update_post_meta( $post_id, '_hotel_location', $location );
    }

    // Save Amenities
    if ( isset( $_POST['hotel_amenities'] ) ) {
        $amenities = sanitize_textarea_field( $_POST['hotel_amenities'] );
        update_post_meta( $post_id, '_hotel_amenities', $amenities );
    }

    // Save Contact Number
    if ( isset( $_POST['hotel_contact'] ) ) {
        $contact = sanitize_text_field( $_POST['hotel_contact'] );
        update_post_meta( $post_id, '_hotel_contact', $contact );
    }

    // Save Availability Dates
    if ( isset( $_POST['hotel_available_from'] ) ) {
        $available_from = sanitize_text_field( $_POST['hotel_available_from'] );
        update_post_meta( $post_id, '_hotel_available_from', $available_from );
    }
    if ( isset( $_POST['hotel_available_to'] ) ) {
        $available_to = sanitize_text_field( $_POST['hotel_available_to'] );
        update_post_meta( $post_id, '_hotel_available_to', $available_to );
    }

    // Save Gallery Attachment IDs (Comma-separated)
    if ( isset( $_POST['hotel_gallery'] ) ) {
        $gallery = sanitize_text_field( $_POST['hotel_gallery'] );
        update_post_meta( $post_id, '_hotel_gallery', $gallery );
    }

    // Save Video link / file URL
    if ( isset( $_POST['hotel_video'] ) ) {
        $video = esc_url_raw( $_POST['hotel_video'] );
        update_post_meta( $post_id, '_hotel_video', $video );
    }

    // Save Ratings & Scorecard
    if ( isset( $_POST['hotel_rating_location'] ) ) {
        update_post_meta( $post_id, '_hotel_rating_location', sanitize_text_field( $_POST['hotel_rating_location'] ) );
    }
    if ( isset( $_POST['hotel_rating_comfort'] ) ) {
        update_post_meta( $post_id, '_hotel_rating_comfort', sanitize_text_field( $_POST['hotel_rating_comfort'] ) );
    }
    if ( isset( $_POST['hotel_rating_facilities'] ) ) {
        update_post_meta( $post_id, '_hotel_rating_facilities', sanitize_text_field( $_POST['hotel_rating_facilities'] ) );
    }
    if ( isset( $_POST['hotel_reviews_count'] ) ) {
        update_post_meta( $post_id, '_hotel_reviews_count', sanitize_text_field( $_POST['hotel_reviews_count'] ) );
    }
    
    // Save Couple Friendly Badge
    $couple_friendly = isset( $_POST['hotel_couple_friendly'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_hotel_couple_friendly', $couple_friendly );

    // Save Attractions (What's Nearby)
    if ( isset( $_POST['hotel_nearby_interest'] ) ) {
        update_post_meta( $post_id, '_hotel_nearby_interest', sanitize_textarea_field( $_POST['hotel_nearby_interest'] ) );
    }
    if ( isset( $_POST['hotel_nearby_terminals'] ) ) {
        update_post_meta( $post_id, '_hotel_nearby_terminals', sanitize_textarea_field( $_POST['hotel_nearby_terminals'] ) );
    }

    // Save Policies & Timing
    if ( isset( $_POST['hotel_check_in'] ) ) {
        update_post_meta( $post_id, '_hotel_check_in', sanitize_text_field( $_POST['hotel_check_in'] ) );
    }
    if ( isset( $_POST['hotel_check_out'] ) ) {
        update_post_meta( $post_id, '_hotel_check_out', sanitize_text_field( $_POST['hotel_check_out'] ) );
    }
    if ( isset( $_POST['hotel_policy_child'] ) ) {
        update_post_meta( $post_id, '_hotel_policy_child', sanitize_textarea_field( $_POST['hotel_policy_child'] ) );
    }
    if ( isset( $_POST['hotel_policy_pet'] ) ) {
        update_post_meta( $post_id, '_hotel_policy_pet', sanitize_text_field( $_POST['hotel_policy_pet'] ) );
    }
    if ( isset( $_POST['hotel_policy_extra'] ) ) {
        update_post_meta( $post_id, '_hotel_policy_extra', sanitize_textarea_field( $_POST['hotel_policy_extra'] ) );
    }
    if ( isset( $_POST['hotel_policy_house'] ) ) {
        update_post_meta( $post_id, '_hotel_policy_house', wp_kses_post( $_POST['hotel_policy_house'] ) );
    }
}
add_action( 'save_post_hotel', 'travel_venture_save_hotel_meta' );

