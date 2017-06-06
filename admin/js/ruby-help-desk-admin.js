(function( $ ) {
	'use strict';
	$(function() {
		$('.post-type-support_ticket #title-prompt-text').html('Ticket Subject');
		$('.ticket-status-color-field').wpColorPicker();


		//The WC+EDD Products sync logic
		$('#sync_wc_products').click(function(){

			$('#sync_wc_products').attr('disabled', 'disabled');
			$('#sync_wc_products_spinner').css('display', 'inline-block');
			$('#sync_wc_products_spinner_result').css('display', 'none');

			var data = {
						'action': 'sync_wc_products',
						'_wpnonce': rhd.wc_sync_nonce
			};

			$.post(ajaxurl, data, function(response) {
				$('#sync_wc_products_spinner_result').html(response +' '+ rhd.text_processed_products);
				$('#sync_wc_products_spinner_result').css('display', 'inline-block');
				$('#sync_wc_products').removeAttr('disabled');
				$('#sync_wc_products_spinner').css('display', 'none');
			});
		});



		$('#sync_edd_products').click(function(){

			$('#sync_edd_products').attr('disabled', 'disabled');
			$('#sync_edd_products_spinner').css('display', 'inline-block');
			$('#sync_edd_products_spinner_result').css('display', 'none');

			var data = {
						'action': 'sync_edd_products',
						'_wpnonce': rhd.edd_sync_nonce
			};

			$.post(ajaxurl, data, function(response) {
				$('#sync_edd_products_spinner_result').html(response +' '+ rhd.text_processed_products);
				$('#sync_edd_products_spinner_result').css('display', 'inline-block');
				$('#sync_edd_products').removeAttr('disabled');
				$('#sync_edd_products_spinner').css('display', 'none');
			});
		});


  });



})( jQuery );