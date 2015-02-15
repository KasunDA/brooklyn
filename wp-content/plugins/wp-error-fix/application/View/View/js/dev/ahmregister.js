/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Registration View Object
 *
 * @var {ahmAdmin}
 */
function ahmRegister(parent) {
    //activate register button
    jQuery('#register').removeClass('minor-table-action-register');
    jQuery('#register').addClass('minor-table-action-register-active');

    jQuery('#registration_more').bind('click', function() {
        jQuery('.register .hide').removeClass('hide');
    });
    parent.getView('control').lockControlPanel();

    var params = {
        'action': 'ahm',
        'sub_action': 'register',
        '_ajax_nonce': ahmLocal.nonce
    };

    jQuery.ajax(ajaxurl, {
        type: 'POST',
        dataType: 'json',
        data: params,
        success: function(response) {
            if (response.status === 'success') {
                jQuery('.register .progress').addClass('progress-success').html('Success');
            } else {
                jQuery('.register .progress').addClass('progress-failed').html('Failed');
            }
            parent.getView('control').unLockControlPanel();
            jQuery('#reload').show();
        },
        error: function() {
            _this.parent.failure();
        }
    });
}