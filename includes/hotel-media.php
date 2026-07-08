<?php
/**
 * Media processing scripts and admin page assets integrations
 *
 * @package Travel_Venture
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Enqueue native WP media uploader elements and custom JS/styles for hotels CPT
 */
function travel_venture_admin_media_scripts( $hook ) {
    global $post_type;
    
    // Only load on hotel post editing screens
    if ( ( 'post.php' === $hook || 'post-new.php' === $hook ) && 'hotel' === $post_type ) {
        
        // Enqueue WP Media library files
        wp_enqueue_media();

        // Enqueue custom uploader orchestrator
        wp_enqueue_script(
            'tripazai-media-upload',
            get_template_directory_uri() . '/assets/js/media-upload.js',
            array( 'jquery' ),
            '1.0.0',
            true
        );

        // Inject high-end admin meta styles to align grids and form inputs
        wp_add_inline_style( 'wp-admin', '
            .hotel-meta-form-wrapper { padding: 10px 0; }
            .hotel-meta-field-row { margin-bottom: 18px; display: flex; flex-flow: column nowrap; }
            .hotel-meta-field-row.row-half { display: inline-flex; width: 48%; margin-right: 2%; }
            .hotel-meta-field-row label { font-weight: 600; margin-bottom: 6px; color: #1e293b; font-size: 13px; }
            .hotel-meta-field-row input[type="text"], 
            .hotel-meta-field-row input[type="number"], 
            .hotel-meta-field-row input[type="date"], 
            .hotel-meta-field-row select,
            .hotel-meta-field-row textarea { 
                padding: 8px 12px; 
                border: 1px solid #cbd5e1; 
                border-radius: 6px; 
                background-color: #f8fafc;
                font-size: 14px;
                color: #334155;
                box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
                transition: all 0.2s ease;
            }
            .hotel-meta-field-row input:focus, .hotel-meta-field-row select:focus, .hotel-meta-field-row textarea:focus {
                border-color: #3b82f6;
                outline: none;
                box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
            }
            .media-upload-action-btn {
                background: #2563eb !important;
                border-color: #2563eb !important;
                color: white !important;
                padding: 5px 15px !important;
                height: auto !important;
                line-height: 1.5 !important;
                border-radius: 6px !important;
                font-weight: 500 !important;
                cursor: pointer;
                transition: background 0.2s ease;
            }
            .media-upload-action-btn:hover {
                background: #1d4ed8 !important;
            }
            .gallery-preview-container { 
                display: grid; 
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); 
                gap: 10px; 
                margin-top: 12px; 
            }
            .gallery-preview-item { 
                position: relative; 
                aspect-ratio: 1/1; 
                border: 1px solid #e2e8f0; 
                border-radius: 6px; 
                overflow: hidden; 
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .gallery-preview-item img { 
                width: 100%; 
                height: 100%; 
                object-fit: cover; 
            }
            .gallery-preview-item .remove-preview-img { 
                position: absolute; 
                top: 4px; 
                right: 4px; 
                background: rgba(239, 68, 68, 0.9); 
                color: #fff; 
                border: none; 
                border-radius: 50%; 
                width: 20px; 
                height: 20px; 
                font-size: 11px; 
                cursor: pointer; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            }
            .gallery-preview-item .remove-preview-img:hover {
                background: #ef4444;
            }
            .video-preview-container { 
                margin-top: 12px; 
                max-width: 320px; 
                border-radius: 6px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                border: 1px solid #e2e8f0;
            }
            .video-preview-container video { 
                width: 100%; 
                display: block;
            }
        ' );
    }
}
add_action( 'admin_enqueue_scripts', 'travel_venture_admin_media_scripts' );

