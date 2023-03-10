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

function upgrade_module_2_0_4($object) {
    if ($object){
        $object->registerHook('displayBackEndBanner');

        Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_hc_banner` (
                `id_ets_hc_banner` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `id_shop` int(11) NOT NULL,
                `image_name` varchar(255) CHARACTER SET utf8 NOT NULL,
                `image_alt` varchar(255) CHARACTER SET utf8 NOT NULL,
                PRIMARY KEY (`id_ets_hc_banner`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');

        Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_hc_banner_category` (
              `id_ets_hc_banner` int(10) unsigned NOT NULL,
              `category_banner` varchar(255) CHARACTER SET utf8 NOT NULL
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');

        $object->clearCache();
    }
    return true;
}