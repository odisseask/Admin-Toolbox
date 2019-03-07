/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function () {
    jQuery("#google_analytics").on('click', function () {
        var data = jQuery('#google_analytics_sdata').val();
        var type = jQuery("input[name='google_ana']:checked").val();
        jQuery.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: {
                request:'google_ana',
                data:data,
                type:type,
                'action': 'save_data'
            },
            success: function (response) {
                console.log(response);
            },
        })
    });
    jQuery("#google_analytics_button").on('click', function () {
        var data = jQuery('#facebook_analytics').val();
        var type = jQuery("input[name='facebook_ana']:checked").val();

        console.log(data);
        console.log(type);
        jQuery.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: {
                request:'facebook_ana',
                data:data,
                type:type,
               'action': 'save_data'
            },
            success: function (response) {
                console.log(response);
            },
        })
    });
    jQuery("#google_google_pixels_button").on('click', function () {
        var data = jQuery('#google_google_pixels').val();
        var type = jQuery("input[name='google_pixel']:checked").val();

        console.log(data);
        console.log(type);
        jQuery.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: {
                request:'google_pixel',
                data:data,
                type:type,
               'action': 'save_data'
            },
            success: function (response) {
                console.log(response);
            },
        })
    });
    jQuery("#facebook_pixel_script_button").on('click', function () {
        var data = jQuery('#facebook_pixel_script').val();
        var type = jQuery("input[name='facebook_pixel']:checked").val();

        console.log(data);
        console.log(type);
        jQuery.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: {
                request:'facebook_pixel',
                data:data,
                type:type,
               'action': 'save_data'
            },
            success: function (response) {
                console.log(response);
            },
        })
    });
    jQuery("#extra_css_button").on('click', function () {
        var data = jQuery('#extra_css').val();
        var type = jQuery("input[name='css_set']:checked").val();

        console.log(data);
        console.log(type);
        jQuery.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: {
                request:'css_set',
                data:data,
                type:type,
               'action': 'save_data'
            },
            success: function (response) {
                console.log(response);
            },
        })
    });
    jQuery("#google_tag_manager_button").on('click', function () {
        var data = jQuery('#google_tag_mng').val();
        var type = jQuery("input[name='tag_mng']:checked").val();

        console.log(data);
        console.log(type);
        jQuery.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: {
                request:'tag_mng',
                data:data,
                type:type,
               'action': 'save_data'
            },
            success: function (response) {
                console.log(response);
            },
        })
    });

});