/*
 * Plugins that insert posts via Ajax, such as infinite scroll plugins, should trigger the
 * post-load evendort on document.body after posts are inserted. Other scripts that depend on
 * a JavaScript interaction after posts are loaded
 *
 * JavaScript triggering the post-load evendort after posts have been inserted via Ajax:
 */
jQuery(document).ready(function ($) {

	$('.chosen-select').chosen();
	//$('#wpb_item_list')
	$('#wpb_item_type > select').on('change', function () {

		swal('hey');

	});
	var tour = new Tour({
		steps: [
			{
				element: "#my-element",
				title: "Title of my step",
				content: "Content of my step"
			},
			{
				element: "#my-other-element",
				title: "Title of my step",
				content: "Content of my step"
			}
		]
	});

// Initialize the tour
	tour.init();

// Start the tour
	tour.start();
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

	   // We can also pass the url value separately from ajaxurl for front end AJAX implementations
	   jQuery.post(ajax_object.ajax_url, data, function(response) {

		 $('#wcb_prod_bom').html(response);
		 setTimeout(function() {
		   swal('Finished');
		 });
		 //alert('seRespon ' + response);
	   });
	 });*/
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