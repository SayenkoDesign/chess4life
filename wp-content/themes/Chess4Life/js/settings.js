(function($) {
	$(document).ready(function() {
		var file_frame;
		$('.select-cover-image').on('click', function(event) {
			event.preventDefault();
			var upload_button = $(this);
			
			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $(this).data( 'uploader-title' ),
				button: {
					text: $(this).data( 'uploader-button-text' ),
				},
				library: {
					type: $(this).data( 'mime-type' ),
				},
				multiple: $(this).data( 'multiple' )  // Set to true to allow multiple files to be selected
			});
			
			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				// attachment = file_frame.state().get('selection').first().toJSON();
				
				var val = [];
				attachments = file_frame.state().get('selection').toJSON();
				$(attachments).each(function() {
					val.push(this.id);
				});
				val = val.join();
	
				// Do something with attachment.id and/or attachment.url here
				$('.cover-image-id', upload_button.parent()).val(val);
	
				if($('.preview-cover-image', upload_button.parent().parent()).length) {
					$(attachments).each(function() {
						attachment = this;
						var mime_type = attachment.mime.replace('/' + attachment.subtype, '');
						var data = {
							action: 'stylish_preview_cover_image',
							id: attachment.id,
							size: upload_button.data('thumbnail'),
							mime_type: mime_type,
						}
						$.post(ajaxurl, data, function(r) {
							var preview_media = $('.preview-cover-image', upload_button.parent().parent());
							preview_media.html(r);
						});
					});
				}
				
				$('.remove-cover-image', upload_button.parent()).show();
				upload_button.hide();
			});
	
			// Finally, open the modal
			file_frame.open();
		});
		
		$('.remove-cover-image').on('click', function(event) {
			event.preventDefault();
			var remove_button = $(this);
			$('.cover-image-id', remove_button.parent()).val('');
			$('.preview-cover-image', remove_button.parent().parent()).html('');
			
			$('.select-cover-image', remove_button.parent()).show();
			remove_button.hide();
		});
		
		if( $('#page_template').length == 0 || $('#page_template').val() != 'templates/blog.php' ) {
			$('#stylish_blog_options').hide();
		}
		
		$('#page_template').change(function() {
			if( $(this).val() == 'templates/blog.php' ) {
				$('#stylish_blog_options').show();
			} else {
				$('#stylish_blog_options').hide();
			}
		});
	});
})(jQuery);