<?php
/**
 * 2007-2020 ETS-Soft
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
function upgrade_module_1_3_2($object)
{
    if(!$object->checkCreatedColumn('ets_superspeed_cache_page','id_lang'))
    {
        Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'ets_superspeed_cache_page` ADD `id_lang` INT(11) NOT NULL AFTER `id_shop`, ADD INDEX (`id_lang`)');
    }
    if(!$object->checkCreatedColumn('ets_superspeed_cache_page','id_currency'))
    {
        Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'ets_superspeed_cache_page` ADD `id_currency` INT(11) NOT NULL AFTER `id_lang`, ADD INDEX (`id_currency`)');
    }
    if(!$object->checkCreatedColumn('ets_superspeed_cache_page','id_country'))
    {
        Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'ets_superspeed_cache_page` ADD `id_country` INT(11) NOT NULL AFTER `id_lang`, ADD INDEX (`id_country`)');
    }
    $object->unInstallOverrides();
    $object->installOverrides();
    return true;
}