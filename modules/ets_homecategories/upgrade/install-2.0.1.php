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

function upgrade_module_2_0_1($object)
{
    $convertedKeys = array(
        'new_arrivals' => -1,
        'popular' => -2,
        'specials' => -3,
        'best_sellers' => -4,
    );
    if ($object)
    {
        $object->registerHook('displayBackOfficeHeader');
        $object->registerHook('displaySelectedTabs');
        $object->registerHook('actionValidateOrder');
        $object->registerHook('actionPageCacheAjax');
        if ($shops = Shop::getShops()){
            $shops[] = array('id_shop' => null);
            foreach ($shops as $shop){
                Configuration::updateValue('ETS_HOMECAT_LAYOUT',(int)Configuration::get('ETS_HOMECAT_TABS_GROUPED',null,null,$shop['id_shop']) ? 'TAB' : 'LIST',false,null,$shop['id_shop']);
                Configuration::updateValue('ETS_HOMECAT_CACHE',1,false,null,$shop['id_shop']);
                Configuration::updateValue('ETS_HOMECAT_CACHE_LIFETIME',240,false,null,$shop['id_shop']);
                Configuration::updateValue('ETS_HOMECAT_TRENDING_PERIOD',30,false,null,$shop['id_shop']);
                $newTabs = array();
                if($oldFeaturedTabs = explode(',',trim(Configuration::get('ETS_HOMECAT_PRODUCTS_TABS',null,null,$shop['id_shop']),',')))
                {
                    foreach($oldFeaturedTabs as $tab)
                    {
                        $tab = trim($tab);
                        if($tab && isset($convertedKeys[$tab]))
                            $newTabs[] = $convertedKeys[$tab];
                    }
                }
                $newTabStr = $newTabs ? implode(',',array_unique($newTabs)) : '';
                if (Configuration::get('ETS_HOMECAT_PRODUCTS_TABS_POSITION',null,null,$shop['id_shop'])=='before'){
                    $tabStr = $newTabStr.','.trim(Configuration::get('ETS_HOMECAT_CATEGORIES',null,null,$shop['id_shop']),',');
                }else{
                    $tabStr = trim(Configuration::get('ETS_HOMECAT_CATEGORIES',null,null,$shop['id_shop']),',').','.$newTabStr;
                }
                $tabStr = trim($tabStr,',');
                if (Configuration::get('ETS_HOMECAT_ENBLE_ALL_PRODUCT_TAB',false,null,$shop['id_shop']))
                    $tabStr = '0,'.$tabStr;
                $tabStr = trim($tabStr,',');
                Configuration::updateValue('ETS_HOMECAT_IDS',$tabStr,false,null,$shop['id_shop']);
                Configuration::updateValue('ETS_HOMECAT_LISTING_MODE',Configuration::get('ETS_HOMECAT_PRODUCTS_LAYOUT',null,null,$shop['id_shop']),false,null,$shop['id_shop']);
            }
        }

        $object->clearCache();
    }
    return true;
}


