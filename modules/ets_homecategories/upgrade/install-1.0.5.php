<?php
/**
 * 2007-2021 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2021 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;

function upgrade_module_1_0_5($object)
{
    return Configuration::updateValue('ETS_HOMECAT_LISTING_MODE', 'grid')
        && Configuration::updateValue('ETS_HOMECAT_PER_ROW_DESKTOP' ,4)
        && Configuration::updateValue('ETS_HOMECAT_PER_ROW_TABLET', 2)
        && Configuration::updateValue('ETS_HOMECAT_PER_ROW_MOBILE', 1)
        && Configuration::updateValue('ETS_HOMECAT_LAZY_LOAD', 1)
        && Configuration::updateValue('ETS_HOMECAT_PRODUCTS_TABS', 'new_arrivals,popular,specials,best_sellers')
        && Configuration::updateValue('ETS_HOMECAT_FEATURED_CAT', Category::getRootCategory()->id)
        && Configuration::updateValue('ETS_HOMECAT_PRODUCTS_TABS_POSITION', 'before')
        && (Configuration::get('ETS_HOMECAT_SORT_PRODUCTS_BY') == 'orderprice asc'? Configuration::updateValue('ETS_HOMECAT_FEATURED_PRODUCT_TAB', 'price asc') : (Configuration::get('ETS_HOMECAT_SORT_PRODUCTS_BY') == 'orderprice desc'? Configuration::updateValue('ETS_HOMECAT_FEATURED_PRODUCT_TAB', 'price desc') : true))
        && Configuration::deleteByName('ETS_HOMECAT_ENBLE_CAROUSEL')
        && $object->registerHook('displayFeaturedProductTabs');
}
