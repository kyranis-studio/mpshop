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
function upgrade_module_1_2_3($object)
{
    if(!Tab::getIdFromClassName('AdminSuperSpeedAjax'))
    {
        $tab = new Tab();
        $tab->class_name = 'AdminSuperSpeedAjax';
        $tab->module = $object->name;
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminSuperSpeed');
        $tab->active=0;
        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[$lang['id_lang']] = $object->getTextLang('Ajax speed', $lang, 'upgrade-1.2.3') ?: $object->l('Ajax speed','upgrade-1.2.3');
        }
        $tab->save();
    }
    return true;
}