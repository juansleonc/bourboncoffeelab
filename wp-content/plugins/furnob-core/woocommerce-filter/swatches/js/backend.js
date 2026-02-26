(
    function($) {
        'use strict';
        $(document).ready(function() {
            $('.product_attribute_color').wpColorPicker();
            // Only show the "remove image" button when needed
            if ('' === jQuery('#product_attribute_image').val()) {
                jQuery('#product_attribute_remove_image').hide();
            }
            // Uploading files
            var file_frame_tm;
            jQuery(document).on('click', '#product_attribute_upload_image', function(event) {
                event.preventDefault();
                // If the media frame already exists, reopen it.
                if (file_frame_tm) {
                    file_frame_tm.open();
                    return;
                }
                // Create the media frame.
                file_frame_tm = wp.media.frames.downloadable_file = wp.media({
                    title: 'Choose an image',
                    button: {
                        text: 'Use image',
                    },
                    multiple: false,
                });
                // When an image is selected, run a callback.
                file_frame_tm.on('select', function() {
                    var attachment = file_frame_tm.state().
                    get('selection').
                    first().
                    toJSON();
                    jQuery('#product_attribute_image').val(attachment.id);
                    jQuery('#product_attribute_image_thumbnail').
                    find('img').
                    attr('src', attachment.sizes.thumbnail.url);
                    jQuery('#product_attribute_remove_image').show();
                });
                // Finally, open the modal.
                file_frame_tm.open();
            });
            jQuery(document).on('click', '#product_attribute_remove_image', function() {
                jQuery('#product_attribute_image_thumbnail').
                find('img').
                attr('src', product_attribute_vars.placeholder_img);
                jQuery('#product_attribute_image').val('');
                jQuery('#product_attribute_remove_image').hide();
                return false;
            });
        });
    }
)(jQuery);
