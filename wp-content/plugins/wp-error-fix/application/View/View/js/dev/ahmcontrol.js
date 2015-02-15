/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Control Panel View Object
 *
 * @var {ahmAdmin}
 */
function ahmControl(parent) {
    /**
     * Reference to ahmAdmin
     *
     * @var {ahmAdmin}
     */
    this.parent = parent;
}

/**
 * Initialize the GUI elements
 *
 * @return void
 *
 * @access public
 */
ahmControl.prototype.init = function() {
    //reference to itself
    var _this = this;

    jQuery('#current_view > div').each(function() {
        //add Tooltip
        _this.parent.addTooltip(jQuery(this));
        //bind and event
        if (jQuery(this).attr('view')){
            jQuery(this).bind('click', function() {
                    _this.parent.triggerView(jQuery(this).attr('view'));
            });
        }
    });
    
    jQuery('#support').bind('click', function(){
        jQuery('#purchase_support').show();
    });

    //Init Register button
    jQuery('#register').bind('click', function() {
        _this.parent.triggerView('register');
    });

    jQuery('#delete').bind('click', function() {
        jQuery('#clear').show();
    });

    jQuery('.minor-table a').each(function() {
        _this.parent.addTooltip(this);
    });

    jQuery('#clear_no').bind('click', function(event) {
        event.preventDefault();
        jQuery('#clear').hide();
    });
    jQuery('#clear_yes').bind('click', function(event) {
        event.preventDefault();

        var params = {
            'action': 'ahm',
            'sub_action': 'clean',
            '_ajax_nonce': ahmLocal.nonce
        };

        jQuery.ajax(ajaxurl, {
            type: 'POST',
            dataType: 'json',
            data: params,
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    _this.unLockControlPanel();
                    jQuery('#clear').hide();
                }
            },
            error: function() {
                _this.parent.failure();
            }
        });
    });

    jQuery('#reload_page').bind('click', function(event) {
        event.preventDefault();
        location.reload();
    });

    //Trigger the proper view. If system is not registered then register it
    if (ahmLocal.settings.registered !== 'undefined'
            && ahmLocal.settings.registered) {
        this.parent.triggerView('analyze');
    } else {
        //show registration form only once. If consumer is not registered show
        //the Register button instead of Report
        this.parent.triggerView('register');
    }

    jQuery('#info').bind('click', function() {
        _this.parent.triggerView('about');
    });

    jQuery('#support_cancel').bind('click', function(event) {
        event.preventDefault();
        jQuery('#purchase_support').hide();
    });

    jQuery('#open_preferences').bind('click', function(event) {
        event.preventDefault();
        jQuery('#preferences_form').show();
    });
    jQuery('#update_preferences').bind('click', function(event) {
        event.preventDefault();
        jQuery('#preferences_form').hide();

        var data = {
            'action': 'ahm',
            'sub_action': 'preference',
            '_ajax_nonce': ahmLocal.nonce,
            'preference[email]': jQuery('#preference_email').val()
        };
        if (jQuery('#preference_notify_error').attr('checked')) {
            data['preference[notify][error]'] = 'on';
        }
        if (jQuery('#preference_notify_solution').attr('checked')) {
            data['preference[notify][solution]'] = 'on';
        }

        jQuery.ajax(ajaxurl, {
            type: 'POST',
            dataType: 'json',
            data: data,
            complete: function() {
                _this.unLockControlPanel();
            }
        });
    });
    jQuery('#cancel_preferences').bind('click', function(event) {
        event.preventDefault();
        jQuery('#preferences_form').hide();
    });
};

/**
 * Lock the Control Panel
 *
 * @return void
 *
 * @access public
 */
ahmControl.prototype.lockControlPanel = function() {
    jQuery('#submitdiv').append(jQuery('<div/>', {
        'class': 'disabler'
    }));
};

/**
 * Unlock the Control Panel
 *
 * @return void
 *
 * @access public
 */
ahmControl.prototype.unLockControlPanel = function() {
    jQuery('#submitdiv .disabler').remove();
};