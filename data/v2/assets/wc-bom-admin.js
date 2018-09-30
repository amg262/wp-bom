/*
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

/**
 * Created by andy on 2/24/17.
 */
/**
 * Created by andy on 2/9/17.
 */

var product = null;
var data = null;
var val = null;
var id = null;
var inventory, vendor, bom_post, related_text, copy_product_data,
    copy_part_data;
var copy_assembly_data;
var prod_bom = 0;

jQuery(document).ready(function($) {

  $('.chosen-select').chosen();

  prod_bom = $('#prod_bom').val();
  if (($('#custom_category').prop('checked') == true)) {
    $('.wcb_custom_cat').css('visibility', 'visible');

  } else {
    $('.wcb_custom_cat').css('visibility', 'hidden');

  }
  if (($('#custom_tags').prop('checked') == true)) {
    $('.wcb_custom_tag').css('visibility', 'visible');

  } else {
    $('.wcb_custom_tag').css('visibility', 'hidden');

  }
  $('.wcb_cb').on('change', function(event, params) {

    var a = $(this).prop('checked');
    console.log(this['id']);

    console.log(this['checked']);
    var id = this['id'];
    var ch = this['checked'];
    var cl = this['css'];

    console.log(this);
    if ((id == 'custom_category') && (ch == true)) {
      $('.wcb_custom_cat').css('visibility', 'visible');

    } else if ((id == 'custom_category') && (ch == false)) {
      $('.wcb_custom_cat').css('visibility', 'hidden');

    } else if ((id == 'custom_tags') && (ch == true)) {
      $('.wcb_custom_tag').css('visibility', 'visible');

    } else if ((id == 'custom_tags') && (ch == false)) {
      $('.wcb_custom_tag').css('visibility', 'hidden');

    }
    //}
    //swal(a);
    /*console.log(evendort);
    console.log(params);

    // $('#prod_bom').attr('value', params['selected']);
    //$('#wcb_prod_bom').attr('value', params['selected']);

    //prod_bom = params['selected'];
//

    console.log(params);

    console.log(this);*/
    // alert(this);
  });

  $('select.wc_bom_select.chosen-select').
      on('change', function(evendort, params) {

        console.log(evendort);
        console.log(params);

        $('#prod_bom').attr('value', params['selected']);
        $('#wcb_prod_bom').attr('value', params['selected']);

        prod_bom = params['selected'];
        // swal(prod_bom);

      });
  $('#part_button_hit').click(function(e) {
    console.log(e);
    inventory = $('#inventory').prop('checked');
    vendor = $('#vendordor').prop('checked');
    bom = $('#bom').prop('checked');
    related_text = $('#related_text').val();
    copy_part_data = $('#copy_part_data').val();
    copy_assembly_data = $('#copy_assembly_data').val();
    copy_product_data = $('#copy_product_data').val();
    prod_bom = $('#prod_bom').val();

    //console.log($('#vendortory').isChecked());

    var arr = {
      'inventory': inventory,
      'vendordor': vendor,
      'bom': bom,
      'related_text': related_text,
      'copy_product_data': copy_product_data,
      'copy_part_data': copy_part_data,
      'copy_assembly_data': copy_assembly_data,
      'prod_bom': prod_bom,
    };
    var data = {
      'url': ajax_object.ajax_url,
      'action': 'save_part_dv',
      'security': ajax_object.nonce,
      'data': ajax_object.ajax_data,
      'product': prod_bom,
      'part': copy_part_data,
      'settings': ajax_object.settings,
      'options': ajax_object.options,
      'input': arr,

    };

    sweetAlert({
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
    });

  });
  $('#button_hit').click(function(e) {

    // swal(prod_bom);

    console.log(e);
    inventory = $('#inventory').prop('checked');
    vendor = $('#vendordor').prop('checked');
    bom = $('#bom').prop('checked');
    related_text = $('#related_text').val();
    copy_part_data = $('#copy_part_data').val();
    copy_assembly_data = $('#copy_assembly_data').val();
    copy_product_data = $('#copy_product_data').val();
    prod_bom = $('#prod_bom').val();

    //console.log($('#vendortory').isChecked());

    var arr = {
      'inventory': inventory,
      'vendordor': vendor,
      'bom': bom,
      'related_text': related_text,
      'copy_product_data': copy_product_data,
      'copy_part_data': copy_part_data,
      'copy_assembly_data': copy_assembly_data,
      'prod_bom': prod_bom,
    };

    var data = {
      'url': ajax_object.ajax_url,
      'action': 'wco_ajax',
      'security': ajax_object.nonce,
      'data': ajax_object.ajax_data,
      'product': prod_bom,
      'part': copy_part_data,
      'settings': ajax_object.settings,
      'options': ajax_object.options,
      'input': arr,

    };

    console.log(data);

    sweetAlert({
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
    });

  });
});

jQuery(function($) {
  $('#wcrp-nav-all').click(function() {
    //alert('hi');
    $('#wcrp-related').css('display', 'block');
    $('#wcrp-options').css('display', 'block');
    $('#wcrp-settings').css('display', 'block');

    $(this).attr('class', 'nav-tab nav-tab-active', 'nav-tab nav-tab-active');
    $('#wcrp-nav-related').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-options').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-settings').attr('class', 'nav-tab', 'nav-tab');
  });
  $('#wcrp-nav-related').click(function() {
    //alert('hi');
    $('#wcrp-related').css('display', 'block');
    $('#wcrp-options').css('display', 'none');
    $('#wcrp-settings').css('display', 'none');

    $(this).attr('class', 'nav-tab nav-tab-active', 'nav-tab nav-tab-active');
    $('#wcrp-nav-related').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-options').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-settings').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-all').attr('class', 'nav-tab', 'nav-tab');

  });

  $('#wcrp-nav-options').click(function() {
    //alert('hi');
    $('#wcrp-related').css('display', 'none');
    $('#wcrp-options').css('display', 'block');
    $('#wcrp-settings').css('display', 'none');

    $(this).attr('class', 'nav-tab nav-tab-active', 'nav-tab nav-tab-active');
    $('#wcrp-nav-related').attr('class', 'nav-tab', 'nav-tab');
    //$('#wcrp-nav-options').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-settings').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-all').attr('class', 'nav-tab', 'nav-tab');

  });

  $('#wcrp-nav-settings').click(function() {
    //alert('hi');
    $('#wcrp-related').css('display', 'none');
    $('#wcrp-options').css('display', 'none');
    $('#wcrp-settings').css('display', 'block');

    $(this).attr('class', 'nav-tab nav-tab-active', 'nav-tab nav-tab-active');
    $('#wcrp-nav-related').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-options').attr('class', 'nav-tab', 'nav-tab');
    //$('#wcrp-nav-settings').attr('class', 'nav-tab', 'nav-tab');
    $('#wcrp-nav-all').attr('class', 'nav-tab', 'nav-tab');

    //$('#wcrp-nav-settings').attr('class', 'nav-tab', 'nav-tab');
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
jQuery(document.body).on('post-load', function() {
  // New posts have been added to the page.
  console.log('posts');
});