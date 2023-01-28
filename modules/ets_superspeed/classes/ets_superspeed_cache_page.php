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
class Ets_superspeed_cache_page extends ObjectModel
{
    public $page;
    public $id_object;
    public $id_product_attribute;
    public $ip;
	public $file_cache;
    public $request_uri;
	public $id_shop;
    public $id_lang;
    public $id_currency;
    public $id_country;
    public $file_size;
    public $user_agent;
    public $has_customer;
    public $has_cart;
    public $date_add;
    public $_dir;
    public static $definition = array(
		'table' => 'ets_superspeed_cache_page',
		'primary' => 'id_cache_page',
		'multilang' => false,
		'fields' => array(
			'page' => array('type' => self::TYPE_STRING),
            'id_object' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'id_product_attribute' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'ip' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),  
            'file_cache' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),            
            'request_uri' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),
            'id_shop'  => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'), 
            'id_lang'  => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'), 
            'id_currency'  => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'), 
            'id_country'  => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'), 
            'has_customer'  => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'), 
            'has_cart'  => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'), 
            'file_size' => array('type' =>   self::TYPE_FLOAT),   
            'user_agent' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),
            'date_add' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'), 
        )
	);
    public	function __construct($id_item = null, $id_lang = null, $id_shop = null)
	{
		parent::__construct($id_item, $id_lang, $id_shop);
        $this->_dir = _ETS_SPEED_CACHE_DIR_.(int)$this->id_shop.'/'.Image::getImgFolderStatic($this->id);
	}
    public function add($auto_date = true,$null_value=false)
    {
        if(parent::add($auto_date,$null_value))
        {
            $this->_dir = _ETS_SPEED_CACHE_DIR_.(int)$this->id_shop.'/'.Image::getImgFolderStatic($this->id);
            return true;
        }
    }
    public function setFileCache($value)
    {
        if(!$this->id)
            return false;
        if(!is_dir($this->_dir))
            @mkdir($this->_dir,0777,true);
        if(Configuration::get('ETS_SPEED_COMPRESS_CACHE_FIIE') && class_exists('ZipArchive'))
        {
            $cache_file = $this->_dir.$this->id.'.zip';
            $zip = new ZipArchive();
            if(!file_exists($cache_file))
            {
                if($zip->open($cache_file, ZipArchive::CREATE | ZipArchive::CHECKCONS)===true)
                {
                    $zip->addFromString($this->id, $value);
                }
            }
            else
            {
                if($zip->open($cache_file))
                {
                    $zip->addFromString($this->id, $value);
                }
            }
            $zip->close();
        }
        else
        {
            $cache_file = $this->_dir.$this->id.'.html';
            file_put_contents($cache_file, $value);
        }
        return Tools::ps_round(@filesize($cache_file)/1024,2);
    }
    public static function getCacheContent($pageCache)
    {
        $dir = _ETS_SPEED_CACHE_DIR_.(int)$pageCache['id_shop'].'/'.Image::getImgFolderStatic($pageCache['id_cache_page']);
        if(Configuration::get('ETS_SPEED_COMPRESS_CACHE_FIIE') && class_exists('ZipArchive'))
        {
            $cache_file = $dir.$pageCache['id_cache_page'].'.zip';
            $zip = new ZipArchive();
            if(file_exists($cache_file) && $zip->open($cache_file))
            {
                return $zip->getFromName($pageCache['id_cache_page']);
            }
        }
        else
        {
            $cache_file = $dir.$pageCache['id_cache_page'].'.html';
            if(file_exists($cache_file))
                return  Tools::file_get_contents($cache_file);
        }
        return false;
    }
    public function delete()
    {
        if(parent::delete())
        {
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_superspeed_cache_page_hook` WHERE id_cache_page = '.(int)$this->id);
            if(file_exists($this->_dir.$this->id.'.zip'))
                @unlink($this->_dir.$this->id.'.zip');
            if(file_exists($this->_dir.$this->id.'.html'))
                @unlink($this->_dir.$this->id.'.html');
            self::deleteForder($this->id,$this->id_shop);
            return true;
        }
    }
    public static function deleteById($id,$id_shop)
    {
        $dir = _ETS_SPEED_CACHE_DIR_.(int)$id_shop.'/'.Image::getImgFolderStatic($id);
        Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_superspeed_cache_page_hook` WHERE id_cache_page = '.(int)$id);
        Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_superspeed_cache_page` WHERE id_cache_page = '.(int)$id);
        if(file_exists($dir.$id.'.zip'))
            @unlink($dir.$id.'.zip');
        if(file_exists($dir.$id.'.html'))
            @unlink($dir.$id.'.html');
        self::deleteForder($id,$id_shop);
        return true;
    }
    public static function deleteForder($id,$id_shop)
    {
        $dir = _ETS_SPEED_CACHE_DIR_.(int)$id_shop.'/'.Image::getImgFolderStatic($id);
        if (is_dir($dir)) {
            $deleteFolder = true;
            foreach (scandir($dir, SCANDIR_SORT_NONE) as $file) {
                if (($file != '.' && $file != '..')) {
                    $deleteFolder = false;
                    break;
                }
            }
        }
        if (isset($deleteFolder) && $deleteFolder && @rmdir($dir) && $id >=10) {
            $parentId = (int)$id/10;
            if((int)$parentId)
            {
                self::deleteForder($parentId,$id_shop);
            }
        }
    }
}