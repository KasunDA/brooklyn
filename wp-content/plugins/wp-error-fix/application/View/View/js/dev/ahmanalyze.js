/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Analyze View Object
 *
 * @var {ahmAdmin} parent
 */
function ahmAnalyze(parent) {
    /**
     * Reference to ahmAdmin
     *
     * @var {ahmAdmin}
     */
    this.parent = parent;
    //lock the Control Panel
    parent.getView('control').lockControlPanel();
    //trigger the chain
    this.analyze();
}

/**
 * Analyze the report
 *
 * Trigger the AJAX Post request chain to analyze the list of error logs
 *
 * @access public
 */
ahmAnalyze.prototype.analyze = function() {
    var _this = this;

    var params = {
        'action': 'ahm',
        'sub_action': 'analyze',
        '_ajax_nonce': ahmLocal.nonce
    };

    jQuery.ajax(ajaxurl, {
        type: 'POST',
        dataType: 'json',
        data: params,
        success: function(response) {
            if (response.stop) {
                _this.parent.getView('control').unLockControlPanel();
                _this.parent.triggerView(ahmLocal.settings.view);
            } else {
                setTimeout(function() {
                    _this.analyze();
                }, 200);
            }
        },
        error: function() {
            _this.parent.failure();
        }
    });
};