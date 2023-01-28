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
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2021 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;

Class HomeBannerCategory extends ObjectModel{
    public $ets_hc_banner_category;
    public $id_ets_hc_banner;
    public $id_category;

    public static $definition = array(
        'table' => 'ets_hc_banner_category',
        'primary' => 'id_ets_hc_banner',
        'fields' => array(
            'category_banner' => array('type' => self::TYPE_HTML, 'validate' => 'isString'),
        ),
    );

    public function __construct($id_ets_hc_banner=null) {
        parent::__construct($id_ets_hc_banner);
        if ($id_ets_hc_banner){
            $this->id_ets_hc_banner = $id_ets_hc_banner;
        }
    }

    public static function getListIdCategory($id_banner=false){
        $res = array();
        if (!$id_banner) return $res;
        $sql = 'SELECT category_banner 
               FROM `' . _DB_PREFIX_ . self::$definition['table'] . '` 
               WHERE `id_ets_hc_banner` = '.(int)$id_banner.' 
        ';
        if ($res = Db::getInstance()->executeS($sql)){
            $temp = array();
            for ($i=0,$total = count($res);$i<$total;$i++){
                if ($res[$i]['category_banner'] == 'all'){
                    continue;
                }
                if ((int)$res[$i]['category_banner'] <= 0){
                    $temp['featured'][] = $res[$i]['category_banner'];
                }else{
                    $temp['category'][] = $res[$i]['category_banner'];
                }
            }
            return $temp;
        }
        return $res;
    }
}