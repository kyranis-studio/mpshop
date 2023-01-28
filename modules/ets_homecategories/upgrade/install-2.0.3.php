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

function upgrade_module_2_0_3($object) {
    if ($object){
        $object->registerHook('displaySpecificProducts');
        if ($shops = Shop::getShops()){
            $shops[] = array('id_shop' => null);
            foreach ($shops as $shop){
                Configuration::updateValue('ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP','4',false,null,(int)$shop['id_shop']);
                Configuration::updateValue('ETS_HOMECAT_NUMBER_DISPLAY_TABLET','3',false,null,(int)$shop['id_shop']);
                Configuration::updateValue('ETS_HOMECAT_NUMBER_DISPLAY_MOBIE','1',false,null,(int)$shop['id_shop']);
            }
        }
        $object->clearCache();
    }
    return true;
}