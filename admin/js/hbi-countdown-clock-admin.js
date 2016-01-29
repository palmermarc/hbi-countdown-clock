(function( $ ) {
	'use strict';
	
	$(function() {
		
		var file_frame;
		
		$('#add_another_row').on( 'click touch', function() {
			var total_sizes = $('#countdown_sizes tbody tr').length + 1;
			var t = document.querySelector('#countdown_clock_size_template');
			
			var clone = document.importNode(t.content, true);
            $(clone).contents().find('.size_name').attr('name', 'hbi_countdown_clock_sizes[sizes]['+total_sizes+'][name]');
            $(clone).contents().find('.size_width').attr('name', 'hbi_countdown_clock_sizes[sizes]['+total_sizes+'][width]');
            $(clone).contents().find('.size_height').attr('name', 'hbi_countdown_clock_sizes[sizes]['+total_sizes+'][height]');
            $(clone).appendTo('#countdown_sizes tbody');
		});
		
		$(document).on('click touch', '.remove_image_size', function() {
			$(this).parent('tr').remove();
		});
		
		$('#countdown_use_link').change( function() {
			if($(this).val() == 1) {
				$('#countdown_link_location').addClass('active');
			} else {
				$('#countdown_link_location').removeClass('active');
			}
			
		});
		
		$('.upload_item_button').live('click', function( event ){
			
			var attach_to_div = $(this).data('attachment_div');
			
			event.preventDefault();
 
    		// Create the media frame.
    		file_frame = wp.media.frames.file_frame = wp.media({
      			title: jQuery( this ).data( 'uploader_title' ),
      			button: {
        			text: jQuery( this ).data( 'uploader_button_text' ),
      			},
      			multiple: true  // Set to true to allow multiple files to be selected
			});
 
    		// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
			 
				var selection = file_frame.state().get('selection');
			 
			    selection.map( function( attachment ) {
			 
					attachment = attachment.toJSON();
					console.log(attachment);
			 		// Do something with attachment.id and/or attachment.url here
		 			$(attach_to_div).val(attachment.url);
				});
				
			});
 
    		// Finally, open the modal
    		file_frame.open();
  		});
		
	});

})( jQuery );