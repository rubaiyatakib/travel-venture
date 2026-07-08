/**
 * WordPress Native Media Uploader integration script
 * Matches dashboard elements with media uploader interfaces.
 *
 * @package Travel_Venture
 */

jQuery(document).ready(function($) {
    
    // ==========================================
    // MULTI-IMAGE GALLERY UPLOADER LOGIC
    // ==========================================
    var gallery_frame;
    
    $('#travel_venture_select_gallery_btn').on('click', function(e) {
        e.preventDefault();
        
        // If the media frame already exists, reopen it.
        if (gallery_frame) {
            gallery_frame.open();
            return;
        }
        
        // Create the media frame.
        gallery_frame = wp.media({
            title: 'Select or Upload Hotel Gallery Images',
            button: {
                text: 'Add to Gallery'
            },
            multiple: true  // Set to true to allow multiple files to be selected
        });
        
        // When an image is selected, run a callback.
        gallery_frame.on('select', function() {
            var selection = gallery_frame.state().get('selection');
            var attachment_ids = [];
            
            // Get current IDs from hidden input
            var current_val = $('#hotel_gallery_input').val();
            if (current_val) {
                attachment_ids = current_val.split(',').map(function(item) {
                    return item.trim();
                }).filter(Boolean);
            }
            
            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                if (attachment.id && attachment_ids.indexOf(attachment.id.toString()) === -1) {
                    attachment_ids.push(attachment.id.toString());
                    
                    // Get thumbnail URL
                    var img_url = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                    
                    // Append preview image html
                    $('#hotel_gallery_preview_container').append(
                        '<div class="gallery-preview-item" data-id="' + attachment.id + '">' +
                            '<img src="' + img_url + '" alt="" />' +
                            '<button type="button" class="remove-preview-img">&times;</button>' +
                        '</div>'
                    );
                }
            });
            
            // Update hidden input val
            $('#hotel_gallery_input').val(attachment_ids.join(','));
        });
        
        // Open the modal.
        gallery_frame.open();
    });
    
    // Remove individual images from gallery preview
    $('#hotel_gallery_preview_container').on('click', '.remove-preview-img', function(e) {
        e.preventDefault();
        var item = $(this).closest('.gallery-preview-item');
        var id_to_remove = item.attr('data-id').toString();
        
        var current_val = $('#hotel_gallery_input').val();
        if (current_val) {
            var attachment_ids = current_val.split(',').map(function(i) { return i.trim(); });
            var index = attachment_ids.indexOf(id_to_remove);
            
            if (index > -1) {
                attachment_ids.splice(index, 1);
            }
            
            // Update input
            $('#hotel_gallery_input').val(attachment_ids.join(','));
        }
        
        // Remove element from DOM
        item.remove();
    });

    // ==========================================
    // VIDEO UPLOADER LOGIC
    // ==========================================
    var video_frame;
    
    $('#travel_venture_select_video_btn').on('click', function(e) {
        e.preventDefault();
        
        if (video_frame) {
            video_frame.open();
            return;
        }
        
        video_frame = wp.media({
            title: 'Select or Upload Hotel Video (.MP4)',
            button: {
                text: 'Use this Video'
            },
            library: {
                type: 'video'
            },
            multiple: false
        });
        
        video_frame.on('select', function() {
            var attachment = video_frame.state().get('selection').first().toJSON();
            
            // Update Text input with file URL
            $('#hotel_video').val(attachment.url);
            
            // Generate dynamic video preview
            var preview_container = $('#hotel_video_preview_container');
            preview_container.empty().show();
            
            if (attachment.url.match(/\.(mp4|webm|ogg)$/i)) {
                preview_container.html('<video controls src="' + attachment.url + '"></video>');
            } else {
                preview_container.html('<p class="description" style="margin-top: 10px; color: #0284c7;"><i class="dashicons dashicons-external"></i> File URL loaded: ' + attachment.url + '</p>');
            }
        });
        
        video_frame.open();
    });

    // Detect manual entry changes in Video text field to toggle display previews
    $('#hotel_video').on('change keyup input', function() {
        var val = $(this).val();
        var preview_container = $('#hotel_video_preview_container');
        
        if (val === '') {
            preview_container.hide().empty();
        } else {
            preview_container.show();
            if (val.match(/\.(mp4|webm|ogg)$/i)) {
                preview_container.html('<video controls src="' + val + '"></video>');
            } else {
                // If it is YouTube or Vimeo, show notice
                preview_container.html('<p class="description" style="margin-top: 10px; color: #0284c7;"><i class="dashicons dashicons-external" style="font-size:16px; margin-right:5px; vertical-align:middle;"></i> Dynamic oEmbed link recognized.</p>');
            }
        }
    });

});

