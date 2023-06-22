(function($) {
    'use strict';


    /**
     * Billing field
     */

    $(document).on('click', '.billing', function(e) {
        e.preventDefault();
        var id = $(this).attr("data-id");

        var data = {
            'action': 'delete_biling_field',
            'id': id

        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $('#delete_biling_field_modal').modal('show');
            $('.modal-body.delete-field-data-modal-billing').html(response);

        })

    });



    /**
     * Checkout billing field sortable
     */
    $(function() {
        $("tbody.short").sortable({
            update: function(event, ui) {
                $(this).children().each(function(index) {
                    if ($(this).attr('data-position') != (index + 1)) {
                        $(this).attr('data-position', (index + 1)).addClass("updated");
                    }
                });

                saveNewPosition();
            }

        });
    });

    function saveNewPosition() {
        var positions = [];
        $('.updated').each(function() {
            positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
            $(this).removeClass('updated');
        });

        var data = {
            'action': 'update_biling_field_postion',
            'update_position': 1,
            'positions': positions

        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            // $('#delete_biling_field_modal').modal('show');
            // $('.modal-body.delete-field-data-modal').html(response);

        })
    }

    /**
     * Checkout billing field sortable End
     */



    /**
     * Shipping field
     */
    $(document).on('click', '.shipping', function(e) {
        e.preventDefault();
        var id = $(this).attr("data-id");

        var data = {
            'action': 'delete_shipping_field',
            'id': id

        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $('#delete_shipping_field_modal').modal('show');
            $('.modal-body.delete-field-data-modal-shipping').html(response);

        })

    });

    /**
     * Checkout shipping field sortable
     */
    $(function() {
        $("tbody.short-shipping").sortable({
            update: function(event, ui) {
                $(this).children().each(function(index) {
                    if ($(this).attr('data-position') != (index + 1)) {
                        $(this).attr('data-position', (index + 1)).addClass("updated-shipping");
                    }
                });

                saveNewPositionShipping();
            }

        });
    });

    function saveNewPositionShipping() {
        var positions = [];
        $('.updated-shipping').each(function() {
            positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
            $(this).removeClass('updated-shipping');
        });

        var data = {
            'action': 'update_shipping_field_postion',
            'update_position': 1,
            'positions': positions

        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            // $('#delete_biling_field_modal').modal('show');
            // $('.modal-body.delete-field-data-modal').html(response);

        })
    }

    /**
     * Review System ajax
     */
    $(document).on('click', '#iwmreviewAlreadyDid, #iwmneverShowAgain', function(e) {
        e.preventDefault();
        var id = 'iwm_install_time';

        var data = {
            'action': 'review_already_did',
            'id': id
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $('.iwm-review').fadeOut(1000);
        })

    });

    $(document).on('click', '#iwmmaybeLater', function(e) {
        e.preventDefault();
        var id = 'iwm_install_time';

        var data = {
            'action': 'maybe_later_will_review',
            'id': id
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $('.iwm-review').fadeOut(1000);
        })
    });
    
    $(document).on('click', '#wooProNotice button', function(e) {
        e.preventDefault();
        var id = 'woo_pro_notice';

        var data = {
            'action': 'woo_pro_notice',
            'id': id
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $('#wooProNotice').fadeOut(1000);
        })
    });  
    
    $(document).on('click', '#wooestimateNotice button', function(e) {
        e.preventDefault();
        var id = 'woo_estimate_notice';

        var data = {
            'action': 'woo_estimate_notice',
            'id': id
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $('#wooestimateNotice').fadeOut(1000);
        })
    });


})(jQuery);