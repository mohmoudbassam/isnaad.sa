/*
 * Adapted from: http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
 * Further modified from PippinsPlugins https://gist.github.com/pippinsplugins/29bebb740e09e395dc06
 */
jQuery(document).ready(function($){
// Uploading files
var file_frame;
 
  jQuery('.mh_author_pc_wpmu_button').on('click', function( event ){
 
    event.preventDefault();
 
    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
 
      // Do something with attachment.id and/or attachment.url here
      // write the selected image url to the value of the #mh_author_pc_meta text field
      jQuery('#mh_author_pc_meta').val('');
      jQuery('#mh_author_pc_upload_meta').val(attachment.url);
      jQuery('#mh_author_pc_upload_edit_meta').val('/wp-admin/post.php?post='+attachment.id+'&action=edit&image-editor');
      jQuery('.mhauthorpc-current-img').attr('src', attachment.url).removeClass('placeholder');
    });
 
    // Finally, open the modal
    file_frame.open();
  });

// Toggle Image Type
  jQuery('input[name=img_option]').on('click', function( event ){
    var imgOption = jQuery(this).val();

    if (imgOption == 'external'){
      jQuery('#mh_author_pc_upload').hide();
      jQuery('#mh_author_pc_external').show();
    } else if (imgOption == 'upload'){
      jQuery('#mh_author_pc_external').hide();
      jQuery('#mh_author_pc_upload').show();
    }

  });
  
  if ( '' !== jQuery('#mh_author_pc_meta').val() ) {
    jQuery('#external_option').attr('checked', 'checked');
    jQuery('#mh_author_pc_external').show();
    jQuery('#mh_author_pc_upload').hide();
  } else {
    jQuery('#upload_option').attr('checked', 'checked');
  }

  // Update hidden field meta when external option url is entered
  jQuery('#mh_author_pc_meta').blur(function(event) {
    if( '' !== $(this).val() ) {
      jQuery('#mh_author_pc_upload_meta').val('');
      jQuery('.mhauthorpc-current-img').attr('src', $(this).val()).removeClass('placeholder');
    }
  });

// Remove Image Function
  jQuery('.edit_options').hover(function(){
    jQuery(this).stop(true, true).animate({opacity: 1}, 100);
  }, function(){
    jQuery(this).stop(true, true).animate({opacity: 0}, 100);
  });

  jQuery('.remove_img').on('click', function( event ){
    var placeholder = jQuery('#mh_author_pc_placeholder_meta').val();

    jQuery(this).parent().fadeOut('fast', function(){
      jQuery(this).remove();
      jQuery('.mhauthorpc-current-img').addClass('placeholder').attr('src', placeholder);
    });
    jQuery('#mh_author_pc_upload_meta, #mh_author_pc_upload_edit_meta, #mh_author_pc_meta').val('');
  });

});