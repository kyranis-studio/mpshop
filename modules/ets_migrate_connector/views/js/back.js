/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2020 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */

var ets_mc_func = {
    getE: function (name) {
        if (document.getElementById)
            var elem = document.getElementById(name);
        else if (document.all)
            var elem = document.all[name];
        else if (document.layers)
            var elem = document.layers[name];
        return elem;
    },
    gencode: function (name, size) {
        getE(name).value = '';
        /* There are no O/0 in the codes in order to avoid confusion */
        var chars = "123456789abcdefghijklmnpqrstuvwxyz";
        for (var i = 1; i <= size; ++i)
            getE(name).value += chars.charAt(Math.floor(Math.random() * chars.length));
    },
    copyToClipboard(ele) {
        ele.select();
        ele.parent().addClass('parents_copied').find('.data_copied').addClass('copied');
        document.execCommand("copy");
        setTimeout(function () {
            $('.data_copied').removeClass('copied').parent().removeClass('parents_copied');
        }, 1500);
    }
};

jQuery(document).ready(function () {
    const $ = jQuery;
    $('#ets_mc_gencode').click(function (e) {
        e.preventDefault();
        ets_mc_func.gencode('ETS_MC_ACCESS_TOKEN', 10);
    });
    $('.ets_mc_copied').click(function (e) {
        ets_mc_func.copyToClipboard($(this));
    });
});

