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

	//$('.chosen-select').chosen();

	console.log('ajax_object');


	alert("bitch");
	$('select').on('change', function (event, params) {

		$('select > span.selection').innerHTML;
		//console.log(params['selected']);
		console.log(this);
	});
//$('#wpb_item_list')
	$('#wpb_item_type').click('click', function (event, params) {

		console.log(this);

	});

	$('#wpb_item_type > select').on('change', function () {

		swal('hey');

	});
	$('#wpb_admin_ajax').click(function (e) {
		swal('hey');

		console.log(e);
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
//jQuery(document.body).trigger('post-load');

/*
 *JavaScript listening to the post-load evendort:
 */
jQuery(document.body).trigger('post-load');
jQuery(document.body).on('post-load', function () {
	// New posts have been added to the page.
	console.log('posts');
});