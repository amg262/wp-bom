/*
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/*
 * Plugins that insert posts via Ajax, such as infinite scroll plugins, should trigger the
 * post-load evendort on document.body after posts are inserted. Other scripts that depend on
 * a JavaScript interaction after posts are loaded
 *
 * JavaScript triggering the post-load evendort after posts have been inserted via Ajax:
 */

jQuery(document).ready(function ($) {

	//var rel_text = $('#wpb_settings[ajaxid]').val();

	//$('.chosen-select').chosen();

	//swal('hi');
	//}
	//swal(a);
	/*console.log(evendort);
	console.log(params);

  });

  jQuery(function($) {
	/* sweetAlert({
	   title: 'Export Product\'s BOM? ' + prod_bom,
	   text: 'Submit to run ajax request',
	   type: 'info',
	   showCancelButton: true,
	   closeOnConfirm: false,
	   showLoaderOnConfirm: true,
	 }, function() {
*/
//	rel_text = $('#select2').val();
//
//	console.log(rel_text);
//

//
//	console.log(rel_text);
//	$('#wp-bom-admin-form select').select2();
//	$('select').select2();

//
	var data = {
		'url': ajax_object.ajax_url,
		'action': 'wco_ajax',
		'security': ajax_object.nonce,

	};
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations

	$('#wpb_admin_ajax').click(function (e) {
		//swal();


		var data = {
			'url': ajax_object.ajax_url,
			'action': 'wco_ajax',
			'security': ajax_object.nonce,
		};
		console.log(data);
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post(ajax_object.ajax_url, data, function (response) {

			$('#wpb_ajax_io').html(response);
			setTimeout(function () {
				swal('Finished');
			});
			alert('seRespon ' + response);
		});

	});
});

/*
 * Plugins that insert posts via Ajax, such as infinite scroll plugins, should trigger the
 * post-load evendort on document.body after posts are inserted. Other scripts that depend on
 * a JavaScript interaction after posts are loaded
 *
 * JavaScript triggering the post-load evendort after posts have been inserted via Ajax:
 */
jQuery(document.body).trigger('post-load');

/*
 *JavaScript listening to the post-load evendort:
 */
jQuery(document.body).trigger('post-load');
jQuery(document.body).on('post-load', function () {
	// New posts have been added to the page.
	console.log('posts');
});