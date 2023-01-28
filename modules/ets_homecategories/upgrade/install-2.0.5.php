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

function upgrade_module_2_0_5($object)
{
    Db::getInstance()->execute("
        CREATE  TABLE IF NOT EXISTS `"._DB_PREFIX_."ets_hc_banner_lang` (
              `id_ets_hc_banner` int(11) NOT NULL,
              `id_lang` int(11) NOT NULL,
              `alt` varchar(250) NOT NULL,
              `link` varchar(250) NOT NULL,
              `image` varchar(250) NOT NULL,
              PRIMARY KEY (`id_ets_hc_banner`, `id_lang`)
            ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;
    ");
    Db::getInstance()->execute("
        ALTER TABLE `"._DB_PREFIX_."ets_hc_banner_category`
        MODIFY `category_banner` int(10) NOT NULL
    ");
    Db::getInstance()->execute("
        ALTER TABLE `"._DB_PREFIX_."ets_hc_banner_category`
        ADD PRIMARY KEY (`id_ets_hc_banner`,`category_banner`)
    ");
    $languages = Context::getContext()->controller->getLanguages();
    if($banners = Db::getInstance()->executeS("SELECT * FROM `"._DB_PREFIX_."ets_hc_banner`"))
    {
        foreach($banners as $banner)
        {
            if($languages)
            {
                foreach($languages as $lang)
                {
                    $imageName = $banner['image_name'];
                    $tmpName = $object->getNonExistFileName($lang['id_lang'].'-'.$imageName);
                    @copy($object->dir_img_banner.$imageName,$object->dir_img_banner.$tmpName);
                    Db::getInstance()->execute("
                        INSERT INTO "._DB_PREFIX_."ets_hc_banner_lang(id_ets_hc_banner,id_lang,alt,link,image)
                        VALUES(".(int)$banner['id_ets_hc_banner'].",".(int)$lang['id_lang'].",'".$banner['image_alt']."','#','".$tmpName."')
                    ");
                }
            }
        }
    }
    Db::getInstance()->execute("ALTER TABLE `"._DB_PREFIX_."ets_hc_banner` DROP COLUMN image_name");
    Db::getInstance()->execute("ALTER TABLE `"._DB_PREFIX_."ets_hc_banner` DROP COLUMN image_alt");
    $object->clearCache();
    return true;
}


