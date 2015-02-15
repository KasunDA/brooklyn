/**
 * ======================================================================
 * LICENSE: This file is subject to the terms and conditions defined in *
 * file 'license.txt', which is part of this source code package.       *
 * ======================================================================
 */

/**
 * Patch Control Panel View Object
 *
 * @var {ahmAdmin}
 */
function ahmPatch(parent) {
    /**
     * Reference to ahmAdmin
     *
     * @var {ahmAdmin}
     */
    this.parent = parent;

    /**
     * Row Collector
     *
     * @var {object}
     */
    this.collector = {};

    /**
     * Patch List Table
     *
     * @var {object}
     */
    this.patchList = null;

    /**
     * Patch Queue
     * 
     * @var Array
     */
    this.patchQueue = new Array();
}

/**
 * Initialize the GUI elements
 *
 * @return void
 *
 * @access public
 */
ahmPatch.prototype.init = function() {
    //reference to itself
    var _this = this;
    this.initList();
    //make Check button alive
    jQuery('#check').bind('click', function() {
        _this.lockPanel();
        _this.check();
    });
    //make alive the help button
    _this.parent.addTooltip(jQuery('.ahm-question'));
    jQuery('.ahm-question').bind('click', function() {
        _this.parent.triggerView('about');
    });
};

/**
 * Initialize the Patch List
 *
 * @return void
 *
 * @access public
 */
ahmPatch.prototype.initList = function() {
    //reference to itself
    var _this = this;
    //init available solutions
    this.patchList = jQuery('#patches').dataTable({
        sDom: "<'cpanel'ir>t<'footer'<'apply-all'>p<'clear'>>",
        bProcessing: false,
        bStateSave: true,
        bSort: false,
        sAjaxSource: ajaxurl,
        fnInitComplete: function() {
            jQuery('.apply-all').html('Apply Checked');
            jQuery('.apply-all').bind('click', function(event) {
                event.preventDefault();
                _this.apply();
            });
            jQuery('#check_all').bind('change', function() {
                if (jQuery(this).attr('checked')) {
                    jQuery('#patches tbody input[type="checkbox"]').each(function() {
                        jQuery(this).attr('checked', 'checked').trigger('change');
                    });
                } else {
                    jQuery('#patches tbody input[type="checkbox"]').each(function() {
                        jQuery(this).removeAttr('checked').trigger('change');
                    });
                }
            });
        },
        fnDrawCallback: function() {
            jQuery('#check_all').removeAttr('checked');
        },
        fnServerParams: function(aoData) {
            aoData.push({
                name: 'action',
                value: 'ahm'
            });
            aoData.push({
                name: 'sub_action',
                value: 'trigger_view'
            });
            aoData.push({
                name: '_ajax_nonce',
                value: ahmLocal.nonce
            });
            aoData.push({
                name: 'view',
                value: 'patches'
            });
        },
        fnRowCallback: function(nRow, aData) { //format data
            if (typeof _this.collector[aData[1]] === "undefined") {
                jQuery('td:eq(0)', nRow).empty();
                jQuery('td:eq(0)', nRow).append(jQuery('<div/>'));
                jQuery('td:eq(0)', nRow).append(jQuery('<input/>', {
                    'type': 'checkbox',
                    'value': aData[0],
                    'price': aData[2]
                }).bind('change', function() {
                    if (jQuery(this).attr('checked')) {
                        _this.patchList.fnUpdate(1, nRow, 3, false);
                    }
                }));

                jQuery('td:eq(1)', nRow).html(jQuery('<a/>', {
                    'href': '#',
                    'class': 'patch-id'
                }).bind('click', function(event) {
                    event.preventDefault();
                    _this.filterErrorList(aData[0]);
                }).html('#' + aData[1]));

                if (aData[2] === 'Free') {
                    var price = jQuery('<span/>', {
                        'class': 'patch-free'
                    }).html('Free');
                } else {
                    price = '$' + aData[2];
                }

                jQuery('td:eq(2)', nRow).addClass('patch-price').html(price);
                jQuery('td:eq(3)', nRow).html(jQuery('<a/>', {
                    'href': '#',
                    'class': 'patch-icon patch-' + (aData[2] === 'Free' ? 'download' : 'purchase'),
                    'title': 'Patch'
                }).bind('click', function(event) {
                    event.preventDefault();
                    _this.patchList.fnUpdate(1, nRow, 3, false);
                    _this.lockPanel();
                    _this.apply();
                }));
                _this.parent.addTooltip(jQuery('td:eq(3) > a', nRow));
                _this.collector[aData[1]] = true;
            }
        },
        aoColumnDefs: [
            {
                "bVisible": false,
                "aTargets": [3]
            }
        ]
    });
};

/**
 * Filter Error List based on checked patch
 *
 * @param {Integer} patchID
 *
 * @retur void
 *
 * @access public
 */
ahmPatch.prototype.filterErrorList = function(patchID) {
    //load List View first in case we are on different one & trigger filter
    this.parent.loadView('list').triggerFilter('patch', patchID, false);
    //now show the List Screen in case we are on some other
    this.parent.triggerView('list');
};

/**
 * Refresh the Patch List
 *
 * @return void
 *
 * @access public
 */
ahmPatch.prototype.refreshList = function() {
    this.patchList.fnDestroy();
    this.collector = {};
    this.initList();
};

/**
 * Lock the Patch Control Panel
 *
 * @return void
 *
 * @access public
 */
ahmPatch.prototype.lockPanel = function() {
    jQuery('#patchdiv').append(jQuery('<div/>', {
        'class': 'disabler'
    }));
};

/**
 * Unlock the Patch Control Panel
 *
 * @return void
 *
 * @access public
 */
ahmPatch.prototype.unlockPanel = function() {
    jQuery('#patchdiv .disabler').remove();
};

/**
 * Check for available solution chain
 *
 * @return void
 *
 * @access public
 */
ahmPatch.prototype.check = function() {
    var _this = this;
    var params = {
        'action': 'ahm',
        'sub_action': 'check',
        '_ajax_nonce': ahmLocal.nonce
    };

    jQuery.ajax(ajaxurl, {
        type: 'POST',
        dataType: 'json',
        data: params,
        success: function(response) {
            if (response.stop) {
                _this.unlockPanel();
                _this.refreshList();
                //refresh also the error list
                _this.parent.getView('list').refreshList();
            } else {
                setTimeout(function() {
                    _this.check();
                }, 200);
            }
        },
        error: function() {
            _this.parent.failure();
        }
    });
};

/**
 * Apply selected patch
 *
 * @return void
 *
 * @access public
 */
ahmPatch.prototype.apply = function() {
    var data = this.patchList.fnGetData();
    this.patchQueue = new Array();

    for (var i in data) {
        if (parseInt(data[i][3]) === 1) {
            this.patchQueue.push(data[i][0]);
        }
    }
    if (this.patchQueue.length > 0) {
        this.run();
    } else {
        this.unlockPanel();
    }
};

/**
 * Apply selected patch
 *
 * @return void
 *
 * @access public
 */
ahmPatch.prototype.run = function() {
    var _this = this;
    var patchID = this.patchQueue.shift();
    //decorate the table row
    var nRow = jQuery('#patch_' + patchID);
    //hide the checkbox
    jQuery('td:eq(0) > input', nRow).hide();
    //show progress bar
    jQuery('td:eq(0) > div', nRow).addClass('apply-loader');
    //hide the Apply button
    jQuery('.patch-apply', nRow).hide();

    var params = {
        'action': 'ahm',
        'sub_action': 'apply',
        '_ajax_nonce': ahmLocal.nonce,
        'patch[]': patchID //Array is important to keep it as Queue
    };

    jQuery.ajax(ajaxurl, {
        type: 'POST',
        dataType: 'json',
        data: params,
        success: function(response) {
            var force_stop = false;
            //decorate the table row first
            jQuery('td:eq(0) > div', nRow).removeClass('apply-loader');
            if (response.status === 'success') {
                jQuery('td:eq(0) > div', nRow).addClass('patch-tick');
            } else {
                jQuery('td:eq(0) > div', nRow).addClass('patch-warning');
                jQuery('td:eq(0) > div', nRow).attr('title', response.reason);
                _this.parent.addTooltip(jQuery('td:eq(0) > div', nRow));
                if (typeof response.code !== 'undefined'
                        && (parseInt(response.code) === 7)) {
                    force_stop = true;
                    jQuery('#low_balance').show();

                }
            }
            if (_this.patchQueue.length && !force_stop) {
                setTimeout(function() {
                    _this.run();
                }, 200);
            } else {
                _this.unlockPanel();
            }
        },
        error: function() {
            _this.parent.failure();
        }
    });
};