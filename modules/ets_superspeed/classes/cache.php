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

class Ets_ss_class_cache
{
    public $user_agent = '';
    protected static $instance;
    public $is_cache_enabled;
	public	function __construct()
	{
        $this->context = Context::getContext();
        if(Configuration::get('ETS_SPEED_CHECK_USER_AGENT'))
        {
            $this->user_agent .= str_replace(array('/','(',')','.','\\','_',';'),'_',isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] :'' );
        }
        $this->is_cache_enabled = (defined('_PS_CACHE_ENABLED_')) ? _PS_CACHE_ENABLED_ : false;
	}
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Ets_ss_class_cache();
        }
        return self::$instance;
    }
    public function getFileCacheByUrl()
    {
        if(!isset($_SERVER['SERVER_PORT']))
            return '';
        if($_SERVER['SERVER_PORT']!="80")
        {
            $url =$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        }
        else
            $url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
            $url ='https://'.$url;
        }
        else
            $url ='http://'.$url;
        if (strpos($url, '#') !== FALSE) {
            $url = Tools::substr($url, 0, strpos($url, '#'));
        }
        $this->context = Context::getContext();
        $query_string = parse_url( $url, PHP_URL_QUERY );
        $params = '&ets_currency='.($this->context->cookie->id_currency ? $this->context->cookie->id_currency : Configuration::get('PS_CURRENCY_DEFAULT'));
        $id_customer = (isset($this->context->customer->id)) ? (int)($this->context->customer->id) : 0;
        $id_group = null;
        if ($id_customer) {
            $id_group = Customer::getDefaultGroupId((int)$id_customer);
        }
        if (!$id_group) {
            $id_group = (int)Group::getCurrent()->id;
        } 
        $params .= '&ets_group='.(int)$id_group; 
        $id_country =isset($this->context->cookie->iso_code_country) && $this->context->cookie->iso_code_country && Validate::isLanguageIsoCode($this->context->cookie->iso_code_country) ?
                    (int) Country::getByIso(Tools::strtoupper($this->context->cookie->iso_code_country)) : (int) Tools::getCountry();
        $params .='&ets_country='.($id_country ? $id_country : (int)$this->context->country->id);
        if(isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart)
            $params .='&hascart=1';
        $params .='&user_agent='.$this->user_agent;
        if ($query_string == '') {
            $query_string .= Tools::substr($params, 1);
        }
        else {
            $query_string .= $params;
        }
        $uri = http_build_url($url, array("query" => $query_string));
        return md5(_COOKIE_KEY_.$uri);
    }
    public function getCache($check_connect=false)
    {
        $context = Context::getContext();
        if(defined('_PS_ADMIN_DIR_') && isset($context->employee) && isset($context->employee->id) && $context->employee->id)
            return ;
        if((isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST') || !Configuration::get('ETS_SPEED_ENABLE_PAGE_CACHE') || !Configuration::get('PS_SHOP_ENABLE') )
            return false;
        $file_name=$this->getFileCacheByUrl();
        $cache_key = 'ss_cache_' .(int)$this->context->shop->id . '_'.$file_name;
        if(!$this->is_cache_enabled || !Cache::getInstance()->exists($cache_key))
        {
            $pageCache = Ets_ss_class_cache::getPageCacheByFile($file_name);
            if($pageCache && $this->is_cache_enabled)
                Cache::getInstance()->set($cache_key, $pageCache);
        }
        else    
        {
            $pageCache = Cache::getInstance()->get($cache_key);
        }
        if($pageCache)
        {
            if($this->checkLifeTime($pageCache))
            {
                if(($cache_content = Ets_superspeed_cache_page::getCacheContent($pageCache))!==false)
                {
                    if(!Ets_ss_class_cache::isCheckSpeed() && $check_connect && (int)Configuration::get('ETS_RECORD_PAGE_CLICK'))
                    {
                        Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'ets_superspeed_cache_page` SET click = click+1 WHERE file_cache="'.pSQL($file_name).'" AND id_shop="'.(int)Context::getContext()->shop->id.'"');
                    }
                    
                    if (!defined('_PS_ADMIN_DIR_') && ($context =Context::getContext()) && isset($context->ss_start_time) && ($start_time =  (float)$context->ss_start_time))
                    {
                        header('X-SS: cached at ' .Tools::displayDate($pageCache['date_add'],null,true). ', '.(Tools::ps_round((microtime(true)-$start_time),3)*1000).'ms'.(isset($context->ss_total_sql) ? '/'.$context->ss_total_sql:'') );
                    }
                    return $cache_content;
                }
            }
        }
        if($this->is_cache_enabled && Cache::getInstance()->exists($cache_key))
            Cache::getInstance()->delete($cache_key);
        return false;
    }
    public static function getPageCacheByFile($file_cache)
    {
       return Db::getInstance()->getRow('SELECT id_cache_page,page,date_add,file_cache,id_shop FROM `'._DB_PREFIX_.'ets_superspeed_cache_page` WHERE file_cache="'.pSQL($file_cache).'" AND id_shop="'.(int)Context::getContext()->shop->id.'"',false);
    }
    public function checkLifeTime($pageCache)
    {
        if(($lifetime = (int)Configuration::get('ETS_SPEED_TIME_CACHE_'.Tools::strtoupper($pageCache['page'])))!=31)
        {
            if(strtotime($pageCache['date_add']) > strtotime('-'.($lifetime ? $lifetime : 1).' DAY'))
                return true;
            else
                return false;
        }
        return true;
    }
    public function setCache($value)
    {
        if($_SERVER['REQUEST_METHOD']=='POST' || !Configuration::get('ETS_SPEED_ENABLE_PAGE_CACHE') || !Configuration::get('PS_SHOP_ENABLE') )
            return false;
        $controller = Tools::getValue('controller');
        if(!Validate::isControllerName($controller))
            return false;
        $id_object = (int)Tools::getValue('id_'.$controller);
        $fc = Tools::getValue('fc');
        $module = Tools::getValue('module');
        if($module=='ybc_blog' && Module::isInstalled('ybc_blog') && Module::isEnabled('ybc_blog') && $fc=='module' && in_array($controller,array('blog','category','gallery','author')))
        {
            if($controller=='blog')
            {
                $id_post = (int)Tools::getValue('id_post');
                $post_url_alias = Tools::getValue('post_url_alias');
                if(!$id_post && $post_url_alias && Validate::isCleanHtml($post_url_alias))
                {
                    $id_post = (int)Db::getInstance()->getValue('SELECT ps.id_post FROM `'._DB_PREFIX_.'ybc_blog_post_lang` pl ,`'._DB_PREFIX_.'ybc_blog_post_shop` ps  WHERE ps.id_shop="'.(int)$this->context->shop->id.'" AND ps.id_post=pl.id_post AND pl.url_alias ="'.pSQL($post_url_alias).'"');
                }
                if($id_post)
                    $id_object=$id_post;
                else
                {
                    $id_category = (int)trim(Tools::getValue('id_category'));
                    $category_url_alias = Tools::getValue('category_url_alias');
                    if(!$id_category && $category_url_alias && Validate::isCleanHtml($category_url_alias))
                    {
                        $id_category = (int)Db::getInstance()->getValue('SELECT cs.id_category FROM `'._DB_PREFIX_.'ybc_blog_category_lang` cl,`'._DB_PREFIX_.'ybc_blog_category_shop` cs WHERE cs.id_category=cl.id_category AND cs.id_shop="'.(int)$this->context->shop->id.'" AND cl.url_alias ="'.pSQL($category_url_alias).'"');    
                    }
                    if($id_category)
                        $id_object=$id_category;
                    elseif($id_author = (int)Tools::getValue('id_author'))
                        $id_object=$id_author;
                }
                
            }
            $controller = 'blog';
        }
        $id_currency = ($this->context->cookie->id_currency ? $this->context->cookie->id_currency : Configuration::get('PS_CURRENCY_DEFAULT'));
        $id_lang = $this->context->language->id;
        $id_country =isset($this->context->cookie->iso_code_country) && $this->context->cookie->iso_code_country && Validate::isLanguageIsoCode($this->context->cookie->iso_code_country) ?
                    (int) Country::getByIso(Tools::strtoupper($this->context->cookie->iso_code_country)) : (int) Tools::getCountry();
        if(!$id_country)
            $id_country = $this->context->country->id;
        $id_shop= $this->context->shop->id;
        if(Db::getInstance()->getValue('
            SELECT id_cache_page FROM `'._DB_PREFIX_.'ets_superspeed_cache_page`
            WHERE page="'.pSQL($controller).'" 
            AND id_lang="'.(int)$id_lang.'"
            AND id_country = "'.(int)$id_country.'"
            AND id_currency = "'.(int)$id_currency.'"
            AND id_shop="'.(int)$id_shop.'"
            AND date_add > "'.pSQL(date('Y-m-d H:i:s', strtotime('-'.($controller=='blog' ? '1':'15').' minutes'))).'"'
            .((int)$id_object ? 'AND id_object="'.(int)$id_object.'"':'')
            .($this->context->customer->id ? ' AND has_customer=1':' AND has_customer=0')
            .($this->context->cart->id ? ' AND has_cart=1':' AND has_cart=0')
        ))
            return false;
        if($pages_exception = trim(Configuration::get('ETS_SPEED_PAGES_EXCEPTION')))
        {
            if($pages_exception = explode("\n",$pages_exception))
                foreach($pages_exception as $page_exception)
                {
                    $page_exception = trim($page_exception);
                    if($page_exception && Tools::strpos($_SERVER['REQUEST_URI'],$page_exception)!==false)
                        return false;
                }
        }
        if(!is_dir(_ETS_SPEED_CACHE_DIR_))
            @mkdir(_ETS_SPEED_CACHE_DIR_,0777,true);
        if(!is_dir(_ETS_SPEED_CACHE_DIR_.$id_shop))
            @mkdir(_ETS_SPEED_CACHE_DIR_.$id_shop,0777,true);
        $file_name=$this->getFileCacheByUrl();
        if($id_page_cache = Db::getInstance()->getValue('SELECT id_cache_page FROM `'._DB_PREFIX_.'ets_superspeed_cache_page` WHERE file_cache = "'.pSQL($file_name).'" AND id_shop="'.(int)Context::getContext()->shop->id.'"'))
        {
            $page_cache = new Ets_superspeed_cache_page($id_page_cache);
        }
        else
        {
            $page_cache= new Ets_superspeed_cache_page();
        }
        $page_cache->page= $controller;
        $page_cache->id_object = (int)$id_object;
        $page_cache->id_country = (int)$id_country;
        $page_cache->id_lang = (int)$id_lang;
        $page_cache->id_currency = (int)$id_currency;
        $page_cache->ip = !self::isCheckSpeed() ? Tools::getRemoteAddr():'';
        $page_cache->id_product_attribute = (int)Tools::getValue('id_product_attribute');
        $page_cache->id_shop = Context::getContext()->shop->id;
        $page_cache->file_cache= $file_name;
        $page_cache->has_customer = $this->context->customer->id ? 1 : 0;
        $page_cache->has_cart = $this->context->cart->id ? 1 : 0;
        $page_cache->request_uri = $_SERVER['REQUEST_URI'];
        $page_cache->user_agent = $this->user_agent;
        $page_cache->date_add = date('Y-m-d H:i:s');
        if($page_cache->id)
        {
            $page_cache->file_size = $page_cache->setFileCache($value);
            $page_cache->update();
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_superspeed_cache_page_hook` WHERE id_cache_page="'.(int)$id_page_cache.'"');
        }
        elseif($page_cache->add())
        {
            $page_cache->file_size = $page_cache->setFileCache($value);
            $page_cache->update();
            $id_page_cache = $page_cache->id;
        }
        //Flush object cache
        $cache_key = 'ss_cache_' .(int)$this->context->shop->id . '_'.$file_name;
        if($this->is_cache_enabled && Cache::getInstance()->exists($cache_key))
            Cache::getInstance()->delete($cache_key);
        if(Hook::$executed_hooks && $id_page_cache)
        {
            foreach(Hook::$executed_hooks as $hook_name)
                Db::getInstance()->execute('INSERT IGNORE INTO `'._DB_PREFIX_.'ets_superspeed_cache_page_hook` set id_cache_page="'.(int)$id_page_cache.'", hook_name="'.pSQL($hook_name).'"');
        }
    }
    public function deleteCache($page='',$id_object=0,$hook_name='')
    {
        if(Db::getInstance()->executeS('SHOW TABLES LIKE "'._DB_PREFIX_.'ets_superspeed_cache_page"'))
        {
            if(!$page && !$id_object && !$hook_name)
            {
                Db::getInstance()->execute('TRUNCATE TABLE `'._DB_PREFIX_.'ets_superspeed_cache_page`');
                Db::getInstance()->execute('TRUNCATE TABLE `'._DB_PREFIX_.'ets_superspeed_cache_page_hook`');
                if($this->is_cache_enabled)
                    Cache::getInstance()->flush();
                $this->rmDir(_ETS_SPEED_CACHE_DIR_);
            }
            else
            {
               $pageCaches = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'ets_superspeed_cache_page`
                    WHERE 1 '.($page ? ' AND page="'.pSQL($page).'"':'').($id_object ? ' AND id_object="'.(int)$id_object.'"':'').($hook_name ? ' AND id_cache_page IN (SELECT id_cache_page FROM `'._DB_PREFIX_.'ets_superspeed_cache_page_hook` WHERE hook_name="'.pSQL($hook_name).'")':''));
               if($pageCaches)
               {
                    foreach($pageCaches as $pageCache)
                    {
                        $pageCacheObj = new Ets_superspeed_cache_page($pageCache['id_cache_page']);
                        $pageCacheObj->delete();
                    }
                    if($this->is_cache_enabled)
                        Cache::getInstance()->flush();
               }
            }
        }
        return true;
    }
    public function rmDir($directory)
    {
       
        if(is_dir($directory))
        {
            
            $dir = @opendir(trim($directory));
            while (false !== ($file = @readdir($dir))) {
                 
                if (($file != '.') && ($file != '..') &&$file!=='') {
                    if (is_file($directory . $file)) {
                        if (file_exists($directory  . $file)) {
                            @unlink($directory . $file);
                        }
                    } else {
                        $this->rmDir($directory . $file.'/');
                    }
                }
            }
            @closedir($dir);
            @rmdir($directory); 
        }
        return true;
    }
    public static function getallheaders()
    {
        $headers = [];
        if($_SERVER)
        {
            foreach ($_SERVER as $name => $value)
            {
                if (Tools::substr($name, 0, 5) == 'HTTP_')
                {
                    $headers[str_replace(' ', '-', ucwords(Tools::strtolower(str_replace('_', ' ', Tools::substr($name, 5)))))] = $value;
                }
            }
        }
        return $headers;
    }
    public static function isCheckSpeed()
    {
        $headers = self::getallheaders();
        if($headers && ((isset($headers['XTestSS']) && $headers['XTestSS']=='click') || (isset($headers['Xtestss']) && $headers['Xtestss']=='click') || (isset($headers['xtestss']) && $headers['xtestss']=='click') ))
            return true;
        else
            return false;
    }
}