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

Class HomeBanner extends ObjectModel{
    public $id_ets_hc_banner;
    public $image;
    public $link;
    public $alt;
    public $featured_product;
    public $category_banner;
    public $id_shop;
    public $dir_img_banner;
    public static $definition = array(
        'table' => 'ets_hc_banner',
        'primary' => 'id_ets_hc_banner',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'image' => array('type' => self::TYPE_HTML, 'validate' => 'isString','lang'=>true),
            'alt' => array('type' => self::TYPE_HTML, 'validate' => 'isString','lang'=>true),
            'link' => array('type' => self::TYPE_HTML, 'validate' => 'isString','lang'=>undefined),
        ),
    );

    public function __construct($id_ets_hc_banner = null)
    {
        $this->dir_img_banner = dirname(__file__) . '/../../../img/hcbanner/';
        parent::__construct($id_ets_hc_banner);
        if ($id_ets_hc_banner){
            $this->id_ets_hc_banner = $id_ets_hc_banner;
            $this->featured_product = $this->getBannerCategory('featured');
            $this->category_banner = $this->getBannerCategory('category');
        }
    }
    public function getBannerCategory($type)
    {
        if(!$this->id)
            return array();
        $ids = array();
        if($rows = Db::getInstance()->executeS("
            SELECT category_banner 
            FROM `"._DB_PREFIX_."ets_hc_banner_category` 
            WHERE id_ets_hc_banner=".(int)$this->id." AND category_banner".($type=='featured' ? "<=0" : ">0")))
        {
            foreach($rows as $row)
                $ids[] = $row['category_banner'];
        }
        return $ids;
    }
    public function save($null_values = false, $auto_date = true)
    {
        $res = true;
        $ids = array_merge($this->featured_product,$this->category_banner);
        if ($res &= parent::save($null_values, $auto_date))
        {
            $res &= DB::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'ets_hc_banner_category` WHERE `id_ets_hc_banner` = ' . (int)$this->id);
            $sql = '';
            if ($ids) {
                foreach ($ids as $id) {
                    $sql .= '(' . (int)$this->id . ', ' . (int)$id . '),';
                }
                $res &= ($sql ? DB::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'ets_hc_banner_category` (`id_ets_hc_banner`,`category_banner`) VALUES ' . trim($sql, ',')) : true);
            }
        }
        return $res;
    }

    public function delete() {
        if(!$this->id)
            return false;
        if($images = Db::getInstance()->executeS("SELECT image FROM `"._DB_PREFIX_."ets_hc_banner_lang` WHERE id_ets_hc_banner=".(int)$this->id))
        {
            foreach($images as $img)
                if(@file_exists($this->dir_img_banner.$img['image']))
                    @unlink($this->dir_img_banner.$img['image']);
        }
        if(parent::delete())
        {
            DB::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'ets_hc_banner_category` WHERE `id_ets_hc_banner` = ' . (int)$this->id);
            return true;
        }
        return false;
    }
}