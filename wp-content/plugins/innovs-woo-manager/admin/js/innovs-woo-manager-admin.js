(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


		// Keeping tab same page when reload
		$(document).ready(function(){
			$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
				localStorage.setItem('activeTab', $(e.target).attr('href'));
			});
			var activeTab = localStorage.getItem('activeTab');
			if(activeTab){
				$('#myTab a[href="' + activeTab + '"]').tab('show');
			}
		});
		
		
		
		
		
		// Add class on variable product button
		$(document).ready(function() {
			$(".product_type_variable").addClass("innovs_variable_button");
		});
		
		// Add class on woocommerce product title
		$(document).ready(function() {
			$(".woocommerce-loop-product__title").addClass("innovs_woo_product_title");
		});
		
		// Add class on woocommerce product price
		$(document).ready(function() {
			$(".woocommerce-Price-amount").addClass("innovs_woo_product_price");
		});
		
		// Add class on woocommerce product onsale
		$(document).ready(function() {
			$(".onsale").addClass("innovs_woo_onsale");
		});
		
		// Add class on woocommerce single product title
		$(document).ready(function() {
			$(".product_title").addClass("innovs_woo_single_product_title");
		});
		
		// Add class on woocommerce single product cart buttion
		$(document).ready(function() {
			$(".single_add_to_cart_button").addClass("innovs_woo_single_product_cart_button");
		});
		
		
		//innovs woo Checkout page
		
		
		
		
		// $( function() {
		// 	$( "#sortable" ).sortable();
		// 	$( "#sortable" ).disableSelection();
		// 	// $( "#sortable" ).sortable({ 
		// 	// 	placeholder: "ui-state-highlight",
		// 	// 	// update: function( event, ui ) {
		// 	// 	// 	var sorted = $( "#sortable" ).sortable( "serialize", { key: "sort" } );
		// 	// 	// 	console.log(sorted);
		// 	// 	// 	$.post( "form/order.php",{ 'choices[]': sorted});
		// 	// 	// }
		// 	// 	update: function () {
		// 	// 		var strItems = "";
	
		// 	// 		$("#sortable").children().each(function (i) {
		// 	// 			var li = $(this);
		// 	// 			strItems += li.attr("id") + ':' + i + ',';
		// 	// 			console.log(strItems);
		// 	// 		});
	
		// 	// });
		// });

		// $( function(){
		// 	('ul#sortable').sortable({
		// 		axis: 'y',
		// 		stop: function (event, ui) {
		// 			var data = $(this).sortable('serialize');
		// 			$('span.data').text(data);
		// 			/*$.ajax({
		// 					data: oData,
		// 				type: 'POST',
		// 				url: '/your/url/here'
		// 			});*/
		// 	}
		// 	});
		// })

		
				
		

		$(document).ready(function($){
			$('.innovs-color-picker').each(function(){
				$(this).wpColorPicker();
			});
		});

	

})( jQuery );
