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

require_once(dirname(__FILE__) . '/classes/HomeProduct.php');
require_once(dirname(__FILE__) . '/classes/HomeBanner.php');
require_once(dirname(__FILE__) . '/classes/HomeBannerCategory.php');

class Ets_homecategories extends Module
{
    public $configs;
    public $baseAdminPath;
    public $templates;
    public $is17 = false;
    private $errorMessage;
    private $_html;
    public $dir_cache;

    public $dir_img_banner;

    public function __construct()
    {
        $this->name = 'ets_homecategories';
        $this->tab = 'front_office_features';
        $this->version = '2.0.8';
        $this->author = 'ETS-Soft';
        $this->module_key = 'fbff6e0c6d66cd58bc9898cafb7a420c';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        $this->is17 = version_compare(_PS_VERSION_, '1.7', '>=');
        parent::__construct();
        $this->displayName = $this->l('Home Products PRO');
        $this->description = $this->l('Display products on homepage in grid layout, tabs or carousel slider. Increase visibility of products on homepage.');
        $this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);
        if(!defined('_PS_ADMIN_DIR_') && Dispatcher::getInstance()->getController()!='index' || defined('_PS_ADMIN_DIR_') && isset($_SERVER['REQUEST_URI']) && !preg_match('/^.*'.$this->name.'.*$/i', $_SERVER['REQUEST_URI']))
            return true;
        if (defined('_PS_ADMIN_DIR_'))
            $this->baseAdminPath = $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name.'&current_tab_active=' . Tools::getValue('ETS_TAB_CURENT_ACTIVE', 'products');
        $id_category = Configuration::get('ETS_HOMECAT_FEATURED_CAT') ? (int)Configuration::get('ETS_HOMECAT_FEATURED_CAT') : Category::getRootCategory()->id;
        $category = new Category($id_category, $this->context->language->id);
        $this->heading_product = $this->l('Products to display');
        $this->heading_ganeral = $this->l('Other settings');
        $this->heading_layout = $this->l('Product layout');
        $this->dir_cache = dirname(__file__) . '/../../cache/homeproducts/';
        $this->dir_img_banner = dirname(__file__) . '/../../img/hcbanner/';
        $this->shortlink = 'https://mf.short-link.org/';
$this->refs = 'https://prestahero.com/';
        $this->configs = array(
            'ETS_HOMECAT_LAYOUT' => array(
                'label' => $this->l('Product layout'),
                'type' => 'radio',
                'form_group_class' => 'ets_hc_display_type list_type',
                'values' => array(
                    array(
                        'label' => '',
                        'id' => 'TAB',
                        'value' => 'TAB',
                        'link_image' =>$this->_path.'views/img/type1.png'
                    ),
                    array(
                        'label' => '',
                        'id' => 'LIST',
                        'value' => 'LIST',
                        'link_image' =>$this->_path.'views/img/type2.png'
                    ),
                    array(
                        'label' => '',
                        'id' => 'TAB_LIST',
                        'value' => 'TAB_LIST',
                        'link_image' =>$this->_path.'views/img/type3.png'
                    ),
                    array(
                        'label' => '',
                        'id' => 'LIST_TAB',
                        'value' => 'LIST_TAB',
                        'link_image' =>$this->_path.'views/img/type4.png'
                    )
                ),
                'default' => 'TAB',
                'js_type' => 'isString',
            ),
            'ETS_HOMECAT_LISTING_MODE' => array(
                'label' => $this->l('Product listing mode'),
                'type' => 'radio',
                'form_group_class' => 'ets_hc_display_type_remove',
                'values' => array(
                    array(
                        'label' => $this->l('Grid view'),
                        'id' => 'ETS_HOMECAT_LAYOUT_grid',
                        'value' => 'grid',
                    ),
                    array(
                        'label' => $this->l('Carousel slider'),
                        'id' => 'ETS_HOMECAT_LAYOUT_carousel',
                        'value' => 'carousel',
                    ),
                ),
                'default' => 'grid',
                'js_type' => 'isString',
            ),
            'ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP' => array(
                'label' => $this->l('Number of displayed products per row on desktop'),
                'type' => 'select',
                'options' => array(
                    'query' => array(
                        array(
                            'id' => '1',
                            'name' => $this->l('1')
                        ),
                        array(
                            'id' => '2',
                            'name' => $this->l('2')
                        ),
                        array(
                            'id' => '3',
                            'name' => $this->l('3')
                        ),
                        array(
                            'id' => '4',
                            'name' => $this->l('4')
                        ),
                        array(
                            'id' => '5',
                            'name' => $this->l('5')
                        ),
                        array(
                            'id' => '6',
                            'name' => $this->l('6')
                        ),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => '4',
                'col' => 3,
            ),
            'ETS_HOMECAT_NUMBER_DISPLAY_TABLET' => array(
                'label' => $this->l('Number of displayed products per row on tablet'),
                'type' => 'select',
                'options' => array(
                    'query' => array(
                        array(
                            'id' => '1',
                            'name' => $this->l('1')
                        ),
                        array(
                            'id' => '2',
                            'name' => $this->l('2')
                        ),
                        array(
                            'id' => '3',
                            'name' => $this->l('3')
                        ),
                        array(
                            'id' => '4',
                            'name' => $this->l('4')
                        ),
                        array(
                            'id' => '5',
                            'name' => $this->l('5')
                        ),
                        array(
                            'id' => '6',
                            'name' => $this->l('6')
                        ),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => '3',
                'col' => 3,
            ),
            'ETS_HOMECAT_NUMBER_DISPLAY_MOBIE' => array(
                'label' => $this->l('Number of displayed products per row on mobile'),
                'type' => 'select',
                'options' => array(
                    'query' => array(
                        array(
                            'id' => '1',
                            'name' => $this->l('1')
                        ),
                        array(
                            'id' => '2',
                            'name' => $this->l('2')
                        ),
                        array(
                            'id' => '3',
                            'name' => $this->l('3')
                        ),
                        array(
                            'id' => '4',
                            'name' => $this->l('4')
                        ),
                        array(
                            'id' => '5',
                            'name' => $this->l('5')
                        ),
                        array(
                            'id' => '6',
                            'name' => $this->l('6')
                        ),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'default' => '1',
                'col' => 3,
            ),
            'ETS_HOMECAT_DISPLAY_CATEGORY_BANNER' => array(
                'label' => $this->l('Display category banner'),
                'form_group_class' => 'ets_hc_display_type_remove',
                'type' => 'select',
                'options' => array(
                    'query' => array(
                        array(
                            'id_option' => 'below',
                            'name' => $this->l('Below product list')
                        ),
                        array(
                            'id_option' => 'above',
                            'name' => $this->l('Above product list')
                        ),
                        array(
                            'id_option' => 'none',
                            'name' => $this->l('Do not display category banner')
                        ),
                    ),
                    'id' => 'id_option',
                    'name' => 'name'
                ),
                'default' => 'below',
                'desc' => $this->l('*Note: Category banner is only available in rows (not available in tabs)'),
            ),
            'ETS_HOMECAT_PRODUCTS_TABS' => array(
                'label' => $this->l('Featured product tabs'),
                'type' => 'checkbox',
                'multiple' => true,
                'values' => array(
                    array(
                        'id' => -1,
                        'label' => $this->l('New arrivals'),
                        'link' => $this->context->link->getPageLink('new-products', true),
                    ),
                    array(
                        'id' => -2,
                        'label' => $this->l('Popular'),
                        'link' => $this->context->link->getCategoryLink($category),
                    ),
                    array(
                        'id' => -3,
                        'label' => $this->l('Specials'),
                        'link' => $this->context->link->getPageLink('prices-drop', true),
                    ),
                    array(
                        'id' => -4,
                        'label' => $this->l('Best sellers'),
                        'link' => $this->context->link->getPageLink('best-sales', true),
                    ),
                    array(
                        'id' => -5,
                        'label' => $this->l('Recommendations'),
                        'link' => $this->context->link->getModuleLink('ets_homecategories','recommend',array(),Tools::usingSecureMode()),
                    ),
                    array(
                        'id' => -6,
                        'label' => $this->l('Viewed products'),
                        'link' => $this->context->link->getModuleLink('ets_homecategories','recommend',array(),Tools::usingSecureMode()),
                    ),
                    array(
                        'id' => -7,
                        'label' => $this->l('Trendings'),
                        'link' => $this->context->link->getModuleLink('ets_homecategories','recommend',array(),Tools::usingSecureMode()),
                    ),
                    array(
                        'id' => -8,
                        'label' => $this->l('Featured'),
                        'link' => $this->context->link->getModuleLink('ets_homecategories','recommend',array(),Tools::usingSecureMode()),
                    ),
                ),
                'id' => 'id',
                'name' => 'label',
            ),
            'ETS_HOMECAT_CATEGORIES' => array(
                'label' => $this->l('Product categories'),
                'type' => 'categories',
                'tree' => array(
                    'id' => 'categories-tree',
                    'selected_categories' => explode(',', Tools::isSubmit('ETS_HOMECAT_IDS') ? trim(Tools::isSubmit('ETS_HOMECAT_IDS'),',') : Configuration::get('ETS_HOMECAT_IDS')),
                    'disabled_categories' => null,
                    'use_checkbox' => true,
                    'use_search' => true,
                    'root_category' => Category::getRootCategory()->id
                ),
            ),
            'ETS_HOMECAT_SPECIFIC_PRODUCTS' => array(
                'label' => '',
                'type' => 'hidden',
                'default' => '',
                'placeholder' => $this->l('Search product by ID, name or reference')
            ),
            'ETS_HOMECAT_TXT_NEW_ARRIVALS' => array(
                'label' => $this->l('New arrivals'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('New arrivals')
            ),
            'ETS_HOMECAT_TXT_POPULAR' => array(
                'label' => $this->l('Popular'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('Popular')
            ),
            'ETS_HOMECAT_TXT_SPECIALS' => array(
                'label' => $this->l('Specials'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('Specials')
            ),
            'ETS_HOMECAT_TXT_BEST_SELLERS' => array(
                'label' => $this->l('Best sellers'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('Best sellers')
            ),
            'ETS_HOMECAT_TXT_RECOMMENDATIONS' => array(
                'label' => $this->l('Recommendations'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('Recommendations')
            ),
            'ETS_HOMECAT_TXT_VIEWED_PRODUCTS' => array(
                'label' => $this->l('Viewed products'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('Viewed products')
            ),
            'ETS_HOMECAT_TXT_TRENDINGS' => array(
                'label' => $this->l('Trendings'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('Trendings')
            ),
            'ETS_HOMECAT_TXT_FEATURED' => array(
                'label' => $this->l('Featured'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('Featured')
            ),
            'ETS_HOMECAT_TXT_ALL_PRODUCTS' => array(
                'label' => $this->l('All products'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('All products')
            ),
            'ETS_HOMECAT_IDS' => array(
                'label' => '',
                'type' => 'hidden',
                'default' => '0,-7,-5,-6,-1,-2,-3,-4'
            ),
            'ETS_HOMECAT_IDS_FEA' => array(
                'label' => '',
                'type' => 'hidden',
            ),
            'ETS_HOMECAT_BLOCK_SORT' => array(
                'label' => '',
                'type' => 'hidden',
                'default' => 'FEATURE_ABOVE'
            ),
            'ETS_HOMECAT_PREVIEW' => array(
                'label' => '',
                'type' => 'hidden',
            ),
            'ETS_HOMECAT_INCLUDE_SUB' => array(
                'label' => $this->l('Include products in all sub categories'),
                'type' => 'switch',
                'default' => 1,
            ),
            'ETS_HOMECAT_DISPLAY_SUB' => array(
                'label' => $this->l('Enable sub categories filter on product categories tabs'),
                'type' => 'switch',
                'default' => 1,
            ),
            'ETS_HOMECAT_DISPLAY_SUB_FEATURED' => array(
                'label' => $this->l('Enable sub categories filter on featured products tabs'),
                'type' => 'switch',
                'default' => 1,
            ),
            'ETS_HOMECAT_ENBLE_LOAD_MORE' => array(
                'label' => $this->l('Enable "Load more products" button'),
                'type' => 'switch',
                'default' => 1,
            ),
            'ETS_HOMECAT_PER_PAGE' => array(
                'label' => $this->l('Product count'),
                'type' => 'text',
                'default' => 8,
                'required' => true,
                'col' => 3,
                'desc' => $this->l('The number of products will be displayed per Ajax load'),
                'validate' => 'isInt',
            ),

            'ETS_HOMECAT_OUT_OF_STOCK' => array(
                'label' => $this->l('Hide "Out of stock" products'),
                'type' => 'switch',
                'default' => 0,
            ),
            'ETS_HOMECAT_SORT_PRODUCTS_BY' => array(
                'label' => $this->l('Default product sort by'),
                'type' => 'select',
                'options' => array(
                    'query' => array(
                        array(
                            'id_option' => 'cp.position asc',
                            'name' => $this->l('Popularity')
                        ),
                        array(
                            'id_option' => 'rand',
                            'name' => $this->l('Random')
                        ),
                        array(
                            'id_option' => 'pl.name asc',
                            'name' => $this->l('Name: A-Z')
                        ),
                        array(
                            'id_option' => 'pl.name desc',
                            'name' => $this->l('Name: Z-A')
                        ),
                        array(
                            'id_option' => 'price asc',
                            'name' => $this->l('Price: Lowest first')
                        ),
                        array(
                            'id_option' => 'price desc',
                            'name' => $this->l('Price: Highest first')
                        ),
                        array(
                            'id_option' => 'p.id_product desc',
                            'name' => $this->l('Newest first')
                        ),
                    ),
                    'id' => 'id_option',
                    'name' => 'name'
                ),
                'default' => 'cp.position asc',
            ),
            'ETS_HOMECAT_ALLOW_SORT' => array(
                'label' => $this->l('Enable "Sort by" feature on the front page'),
                'type' => 'switch',
                'default' => 1,
            ),
            'ETS_HOMECAT_OPEN_CAT_BY_LINK' => array(
                'label' => $this->l('Open category by link'),
                'type' => 'switch',
                'default' => 0,
                'js_type' => 'isInt',
            ),
            'ETS_HOMECAT_ENABLE_VIEW_ALL' => array(
                'label' => $this->l('Enable view all products link'),
                'type' => 'switch',
                'default' => 0,
            ),
            'ETS_HOMECAT_TXT_VIEW_ALL_LABEL' => array(
                'label' => $this->l('View all products label'),
                'type' => 'text',
                'default' => '',
                'lang' => true,
                'placeholder' => $this->l('View all'),
                'desc' => $this->l('Leave blank to use default label'),
                'col' => 2,
            ),
            'ETS_HOMECAT_LOADING_ENABLED' => array(
                'label' => $this->l('Enable loading icon'),
                'type' => 'switch',
                'default' => 1,
            ),
            'ETS_HOMECAT_FEATURED_CAT' => array(
                'label' => $this->l('Select the category whose products will be displayed in Popular tab'),
                'type' => 'text',
                'required' => true,
                'col' => 2,
                'validate' => 'isUnsignedInt',
                'default' => Category::getRootCategory()->id,
                'desc' => $this->l('Choose the category ID of the products that you would like to display on homepage (default: 2 for "Home").'),
            ),
            'ETS_HOMECAT_FEED_NEW_ALL' => array(
                'label' => $this->l('Feed all products as New'),
                'type' => 'switch',
                'default' => 0,
                'desc' => $this->l('Consider all products as New, just sort by newest first'),
            ),
            'PS_NB_DAYS_NEW_PRODUCT' => array(
                'label' => $this->l('Number of days for which the product is considered New'),
                'type' => 'text',
                'col' => 2,
                'validate' => 'isUnsignedInt',
                'required' => true,
                'suffix' => $this->l('day(s)'),
                'default' => (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT'),
                'desc' => $this->l('Only take effect if Feed all products as New is set to No'),
            ),
            'ETS_HOMECAT_TRENDING_PERIOD' => array(
                'label' => $this->l('Trending period'),
                'type' => 'text',
                'default' => 30,
                'col' => 2,
                'validate' => 'isUnsignedInt',
                'required' => true,
                'suffix' => $this->l('day(s)'),
                'desc' => $this->l('Products which get most sales in this period of time are considered as trending'),
            ),
            'ETS_HOMECAT_CACHE' => array(
                'label' => $this->l('Enable cache'),
                'type' => 'switch',
                'default' => 1,
            ),

            'ETS_HOMECAT_CACHE_LIFETIME' => array(
                'label' => $this->l('Cache lifetime'),
                'type' => 'text',
                'default' => 24,
                'col' => 2,
                'validate' => 'isUnsignedInt',
                'suffix' => $this->l('hour(s)'),
                'desc' => $this->l('Leave blank to cache permanently'),
            ),
            'ETS_HOMECAT_CATEGORY_BANNER' => array(
                'label' => '',
                'type' => 'category_banner',
            ),
            'ETS_HOMECAT_CURENT_ACTIVE' => array(
                'label' => '',
                'type' => 'hidden',
            )
        );
    }
    public function install()
    {
        $this->clearCache();

        return parent::install()
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayHome')
            && $this->registerHook('displaySubCategories')
            && $this->registerHook('displayProductList')
            && $this->registerHook('displayCategoryBanner')
            && $this->registerHook('displaySelectedTabs')
            && $this->registerHook('displaySpecificProducts')
            && $this->registerHook('displayBackEndBanner')
            && $this->registerHook('categoryUpdate')
            && $this->registerHook('deleteProduct')
            && $this->registerHook('updateProduct')
            && $this->registerHook('addProduct')
            && $this->registerHook('displayBackOfficeHeader')
            && $this->registerHook('actionValidateOrder')
            && $this->registerHook('actionPageCacheAjax')
            && $this->_installDb();
    }
    public function _installDb()
    {
        $languages = Language::getLanguages(false);
        $res = true;
        if ($this->configs) {
            foreach ($this->configs as $key => $config) {
                if (isset($config['lang']) && $config['lang']) {
                    $values = array();
                    foreach ($languages as $lang) {
                        $values[$lang['id_lang']] = isset($config['default']) ? $config['default'] : '';
                    }
                    Configuration::updateValue($key, $values, true);
                } else
                    Configuration::updateValue($key, isset($config['default']) ? $config['default'] : '', true);
            }
        }
        $res &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_hc_banner` (
                `id_ets_hc_banner` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `id_shop` int(11) NOT NULL,
                PRIMARY KEY (`id_ets_hc_banner`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');
        $res &= Db::getInstance()->execute('
            CREATE  TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_hc_banner_lang` (
                  `id_ets_hc_banner` int(11) NOT NULL,
                  `id_lang` int(11) NOT NULL,
                  `alt` varchar(250) NOT NULL,
                  `link` varchar(250) NOT NULL,
                  `image` varchar(250) NOT NULL,
                  PRIMARY KEY (`id_ets_hc_banner`, `id_lang`)
                ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;
        ');
        $res &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_hc_banner_category` (
              `id_ets_hc_banner` int(10) unsigned NOT NULL,
              `category_banner` int(10) NOT NULL,
              PRIMARY KEY (`id_ets_hc_banner`, `category_banner`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');
        return $res;
    }
    public function uninstall()
    {
        return parent::uninstall() && $this->_uninstallDb();
    }
    private function _uninstallDb()
    {
        if ($this->configs) {
            foreach ($this->configs as $key => $config) {
                Configuration::deleteByName($key);
            }
            unset($config);
        }
        $this->clearCache();
        $this->deleteAllBanners();
        Db::getInstance()->execute("DROP TABLE IF EXISTS " . _DB_PREFIX_ . "ets_hc_banner_lang");
        Db::getInstance()->execute("DROP TABLE IF EXISTS " . _DB_PREFIX_ . "ets_hc_banner");
        Db::getInstance()->execute("DROP TABLE IF EXISTS " . _DB_PREFIX_ . "ets_hc_banner_category");
        return true;
    }

    public function getContent()
    {
        if (!$this->active)
            return;
        $this->_postBanner();
        $this->_postConfig();
        $this->_html .= $this->displayHomeCatAdmin();
        //Display errors if have
        if ($this->errorMessage)
            $this->_html .= $this->errorMessage;
        //Render views
        $this->renderConfig();
        return $this->_html;
    }


    private function _postBanner(){
        if(Tools::getValue('update_banner'))
        {
            die(Tools::jsonEncode(
                array(
                    'html' => $this->renderFormBanner(),
                    'success' => 1,
                )));
        }
        if(Tools::isSubmit('save_banner'))
        {
            $errors = array();
            $sucess = '';
            $id_language_default = (int)Configuration::get('PS_LANG_DEFAULT');
            $languages = $this->context->controller->getLanguages();
            if (Tools::isSubmit('save_banner')){
                if (!is_dir($this->dir_img_banner) && @mkdir($this->dir_img_banner, 0755,true)) {
                    if ( @file_exists(dirname(__file__).'/index.php')){
                        @copy(dirname(__file__).'/index.php', $this->dir_img_banner.'index.php');
                    }
                }
                $id_ets_hc_banner = Tools::getValue('id_ets_hc_banner',0);
                $homeBanner = new HomeBanner($id_ets_hc_banner);
                $homeBanner->id_shop = $this->context->shop->id;
                $homeBanner->link[$id_language_default] = Tools::getValue('link_'.$id_language_default);
                $homeBanner->alt[$id_language_default] = Tools::getValue('alt_'.$id_language_default);
                $homeBanner->featured_product = array_unique(array_map('intval',Tools::getValue('featured_product') ? (array)Tools::getValue('featured_product') : array()));
                $homeBanner->category_banner = array_unique(array_map('intval',Tools::getValue('category_banner') ? (array)Tools::getValue('category_banner') : array()));
                $newUploadedImages = array();
                $oldImages = array();
                if(!(isset($homeBanner->link[$id_language_default]) && $homeBanner->link[$id_language_default]))
                    $errors[] = $this->l('Link is required').(count($languages > 1) ? ' ('.$this->l('Default language').')' : '');
                elseif(!Validate::isAbsoluteUrl($homeBanner->link[$id_language_default]))
                    $errors[] = $this->l('Link is invalid').(count($languages > 1) ? ' ('.$this->l('Default language').')' : '');
                if(!(isset($homeBanner->alt[$id_language_default]) && $homeBanner->alt[$id_language_default]))
                    $errors[] = $this->l('Alt is required').(count($languages > 1) ? ' ('.$this->l('Default language').')' : '');
                elseif(!Validate::isCatalogName($homeBanner->alt[$id_language_default]))
                    $errors[] = $this->l('Alt is not valid').(count($languages > 1) ? ' ('.$this->l('Default language').')' : '');
                if(!(isset($_FILES['image_'.$id_language_default]) && isset($_FILES['image_'.$id_language_default]['name']) && $_FILES['image_'.$id_language_default]['name']) && !$homeBanner->id)
                    $errors[] = $this->l('Image banner is required').(count($languages > 1) ? ' ('.$this->l('Default language').')' : '');

                if(!($homeBanner->featured_product || $homeBanner->category_banner))
                    $errors[] = $this->l('At least 1 product category or featured product tab must be selected');
                if(count($languages) > 1 && !$errors)
                    foreach($languages as $lang)
                    {
                        if($lang['id_lang'] == $id_language_default)
                            continue;
                        $homeBanner->link[$lang['id_lang']] = Tools::getValue('link_'.$lang['id_lang']);
                        $homeBanner->alt[$lang['id_lang']] = Tools::getValue('alt_'.$lang['id_lang']);
                        if(isset($homeBanner->link[$lang['id_lang']]) && $homeBanner->link[$lang['id_lang']] && !Validate::isAbsoluteUrl($homeBanner->link[$lang['id_lang']]))
                            $errors[] = $this->l('Link is not valid').(count($languages > 1) ? ' ('.$lang['iso_code'].')' : '');
                        elseif(!$homeBanner->id)
                            $homeBanner->link[$lang['id_lang']] = $homeBanner->link[$id_language_default];
                        if(isset($homeBanner->alt[$lang['id_lang']]) && $homeBanner->alt[$lang['id_lang']] && !Validate::isCatalogName($homeBanner->alt[$lang['id_lang']]))
                            $errors[] = $this->l('Alt is not valid').(count($languages > 1) ? ' ('.$lang['iso_code'].')' : '');
                        elseif(!$homeBanner->id)
                            $homeBanner->alt[$lang['id_lang']] = $homeBanner->alt[$id_language_default];
                        if(isset($_FILES['image_'.$lang['id_lang']]) && isset($_FILES['image_'.$lang['id_lang']]['name']) && $_FILES['image_'.$lang['id_lang']]['name'] && ($image = $_FILES['image_'.$lang['id_lang']]) && ($error = ImageManager::validateUpload($image, 4000000)))
                            $errors[] = $error.(count($languages > 1) ? ' ('.$lang['iso_code'].')' : '');
                    }
                if(!$errors)
                {
                    $missedImages = array();
                    foreach($languages as $lang)
                    {
                        if(isset($_FILES['image_'.$lang['id_lang']]) && isset($_FILES['image_'.$lang['id_lang']]['name']) && $_FILES['image_'.$lang['id_lang']]['name'] && ($image = $_FILES['image_'.$lang['id_lang']]))
                        {
                            $imageName = $this->getNonExistFileName(trim(str_replace(' ','-',$image['name'])));
                            if (!move_uploaded_file($image['tmp_name'], $this->dir_img_banner.$imageName)) {
                                $errors[] = $this->l('An error occurred while attempting to upload the file.');
                            }
                            else
                            {
                                $newUploadedImages[$lang['id_lang']] = $imageName;
                                if(isset($homeBanner->image[$lang['id_lang']]) && $homeBanner->image[$lang['id_lang']])
                                    $oldImages[] = $homeBanner->image[$lang['id_lang']];
                                $homeBanner->image[$lang['id_lang']] = $imageName;
                            }
                        }
                        else
                            $missedImages[] = $lang['id_lang'];
                    }
                    if(!$homeBanner->id && $missedImages && !$errors && isset($newUploadedImages[$id_language_default]) && ($defaultImg = $newUploadedImages[$id_language_default]))
                    {
                        foreach($missedImages as $id_lang)
                        {
                            if(!$homeBanner->image[$id_lang])
                            {
                                $imageName = $this->getNonExistFileName($id_lang.'-'.$defaultImg);
                                @copy($this->dir_img_banner.$defaultImg,$this->dir_img_banner.$imageName);
                                $homeBanner->image[$id_lang] = $imageName;
                                $newUploadedImages[$id_lang] = $imageName;
                            }
                        }
                    }
                }
                if(!$errors)
                {
                    if($homeBanner->save())
                    {
                        $sucess = $homeBanner->id ? $this->l('Banner updated successfully') : $this->l('Banner added successfully');
                        $this->deleteImages($oldImages);
                        $this->clearCache();
                    }
                    else
                    {
                        $errors[] = $this->l('An unknown error occurred while saving banner');
                        $this->deleteImages($newUploadedImages);
                    }
                }
                else
                    $this->deleteImages($newUploadedImages);
                die(
                    Tools::jsonEncode(
                        array(
                            'success' => $sucess,
                            'error' => count($errors) ? nl2br(implode("\n",$errors)) : '',
                            'html' => $sucess ? $this->renderListBanner() : '',
                        )
                    )
                );
            }
        }
        if((int)Tools::getValue('back_to_list'))
        {
            die(
                Tools::jsonEncode(
                    array(
                        'html' => $this->renderListBanner(),
                    )
                )
            );
        }
        if(Tools::isSubmit('delete_banner') && ($id_ets_hc_banner=(int)Tools::getValue('id_ets_hc_banner')))
        {
            $homeBanner = new HomeBanner($id_ets_hc_banner);
            $deleted = $homeBanner->delete();
            die(
                Tools::jsonEncode(
                    array(
                        'html' => $this->renderListBanner(),
                        'success' => $deleted ? $this->l('Banner deleted') : '',
                        'error' => !$deleted ? $this->l('Could not delete banner') : '',
                    )
                )
            );
        }
    }
    public function getNonExistFileName($oriName)
    {
        $ik = 2;
        $tmpName = $oriName;
        while(@file_exists($this->dir_img_banner.$tmpName))
        {
            $tmpName = $ik.'-'.$oriName;
            $ik++;
        }
        return $tmpName;
    }
    public function deleteImages($images = array())
    {
        if($images) {
            foreach ($images as $img)
                if (@file_exists($this->dir_img_banner . $img))
                    @unlink($this->dir_img_banner . $img);
        }
    }
    private function _postConfig()
    {
        if (($query = Tools::getValue('q', false)) && $query) {
            $imageType = $this->getMmType('cart');
            if ($pos = strpos($query, ' (ref:')) {
                $query = Tools::substr($query, 0, $pos);
            }
            $excludeIds = Tools::getValue('excludeIds', false);
            $excludedProductIds = array();
            if ($excludeIds && $excludeIds != 'NaN') {
                $excludeIds = implode(',', array_map(array($this, 'isValidIds'), explode(',', $excludeIds)));
                if($excludeIds && ($ids = explode(',',$excludeIds))) {
                    foreach($ids as $id) {
                        $id = explode('-',$id);
                        if(isset($id[0]) && isset($id[1]) && !$id[1]) {
                            $excludedProductIds[] = (int)$id[0];
                        }
                    }
                }
            } else {
                $excludeIds = false;
            }
            $excludeVirtuals = (bool)Tools::getValue('excludeVirtuals', true);
            $exclude_packs = (bool)Tools::getValue('exclude_packs', true);
            if (version_compare(_PS_VERSION_, '1.6.1.0', '<'))
            {
                $imgLeftJoin = ' LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product`) '.Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover = 1');
            }
            else
            {
                $imgLeftJoin = ' LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop ON (image_shop.`id_product` = p.`id_product` AND image_shop.id_shop=' . (int)$this->context->shop->id . ') ';
            }
            $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, image_shop.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
            		FROM `' . _DB_PREFIX_ . 'product` p
            		' . Shop::addSqlAssociation('product', 'p') . '
                    LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int)$this->context->language->id . Shop::addSqlRestrictionOnLang('pl') . ')
            		'. pSQL($imgLeftJoin) .' 
            		LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$this->context->language->id . ')
            		LEFT JOIN `'._DB_PREFIX_.'product_shop` ps ON (p.`id_product` = ps.`id_product`) 
            		WHERE '.($excludedProductIds ? 'p.`id_product` NOT IN('.pSQL(implode(',',$excludedProductIds)).') AND ' : '').' (pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\' OR p.id_product = '.(int)$query.') AND ps.`active` = 1 AND ps.`id_shop` = '.(int)$this->context->shop->id .
                   ($excludeVirtuals ? ' AND NOT EXISTS (SELECT 1 FROM `' . _DB_PREFIX_ . 'product_download` pd WHERE (pd.id_product = p.id_product))' : '') .
                   ($exclude_packs ? ' AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '') .
                   ($imgLeftJoin? 'AND image_shop.cover = 1' : '').'  GROUP BY p.id_product';

            if (($items = Db::getInstance()->executeS($sql)))
            {
                $results = array();
                foreach ($items as $item)
                {
                    $results[] = array(
                        'id_product' => (int)($item['id_product']),
                        'id_product_attribute' => 0,
                        'name' => $item['name'],
                        'attribute' => '',
                        'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                        'image' => str_replace('http://', Tools::getShopProtocol(), $this->context->link->getImageLink($item['link_rewrite'], $item['id_image'], $imageType)),
                    );
                }
                if ($results)
                {
                    foreach ($results as &$item)
                        echo trim($item['id_product'] . '|' . (int)($item['id_product_attribute']) . '|' . Tools::ucfirst($item['name']). '|' . $item['attribute'] . '|' . $item['ref'] . '|' . $item['image']) . "\n";
                }
            }
            die;
        }
        if(Tools::getValue('configure')==$this->name && Tools::isSubmit('othermodules'))
        {
            $this->displayRecommendedModules();
        }

        $errors = array();
        $languages = Language::getLanguages(false);
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $configs = $this->configs;
        if (Tools::isSubmit('delimage')) {
            $this->clearCache();
            $image = Tools::getValue('image');
            if (isset($configs[$image]) && !isset($configs[$image]['required']) || (isset($configs[$image]['required']) && !$configs[$image]['required'])) {
                $imageName = Configuration::get($image);
                $imagePath = dirname(__FILE__) . '/images/config/' . $imageName;
                if ($imageName && file_exists($imagePath)) {
                    @unlink($imagePath);
                    Configuration::updateValue($image, '');
                }
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name.'&current_tab_active=' . Tools::getValue('ETS_TAB_CURENT_ACTIVE', 'products'));
            } else
                $errors[] = $configs[$image]['label'] . $this->l('is required');
        }


        if(Tools::isSubmit('clearcache'))
        {
            $this->clearCache();
            die(Tools::jsonEncode(array(
                'msg' => $this->l('Cache cleared successfully'),
                'success' => 1,
            )));
        }
        if (Tools::isSubmit('saveConfig')) {
            if ($configs) {
                foreach ($configs as $key => $config) {
                    if (isset($config['lang']) && $config['lang']) {
                        if (isset($config['required']) && $config['required'] && $config['type'] != 'switch' && trim(Tools::getValue($key . '_' . $id_lang_default) == '')) {
                            $errors[] = $config['label'] . ' ' . $this->l('is required');
                        }
                    } else {
                        if (isset($config['required']) && $config['required'] && isset($config['type']) && $config['type'] == 'file') {
                            if (Configuration::get($key) == '' && !isset($_FILES[$key]['size']))
                                $errors[] = $config['label'] . ' ' . $this->l('is required');
                            elseif (isset($_FILES[$key]['size'])) {
                                $fileSize = round((int)$_FILES[$key]['size'] / (1024 * 1024));
                                if ($fileSize > 100)
                                    $errors[] = $config['label'] . $this->l(' can not be larger than 100Mb');
                            }
                        } else {
                            if (isset($config['required']) && $config['required'] && $config['type'] != 'switch' && trim(Tools::getValue($key) == '')) {
                                $errors[] = $config['label'] . ' ' . $this->l('is required');
                            } elseif (isset($config['validate']) && method_exists('Validate', $config['validate'])) {
                                $validate = $config['validate'];
                                if (trim(Tools::getValue($key)) && !Validate::$validate(trim(Tools::getValue($key))))
                                    $errors[] = $config['label'] . ' ' . $this->l('is invalid');
                                unset($validate);
                            } elseif (!is_array(Tools::getValue($key)) && !Validate::isCleanHtml(trim(Tools::getValue($key)))) {
                                $errors[] = $config['label'] . ' ' . $this->l('is invalid');
                            }
                        }
                    }
                }
            }
            //Custom validation
            if (Tools::getValue('ETS_HOMECAT_CACHE_LIFETIME') && !Validate::isInt(Tools::getValue('ETS_HOMECAT_CACHE_LIFETIME')))
                $errors[] = $this->l('Cache lifetime is not valid');

            if (!$errors) {
                if ($configs) {
                    foreach ($configs as $key => $config) {
                        if (isset($config['lang']) && $config['lang']) {
                            $valules = array();
                            foreach ($languages as $lang) {
                                if ($config['type'] == 'switch')
                                    $valules[$lang['id_lang']] = (int)trim(Tools::getValue($key . '_' . $lang['id_lang'])) ? 1 : 0;
                                else
                                    $valules[$lang['id_lang']] = trim(Tools::getValue($key . '_' . $lang['id_lang'])) ? trim(Tools::getValue($key . '_' . $lang['id_lang'])) : trim(Tools::getValue($key . '_' . $id_lang_default));
                            }
                            Configuration::updateValue($key, $valules, true);
                        } else {
                            if ($config['type'] == 'switch') {
                                Configuration::updateValue($key, (int)trim(Tools::getValue($key)) ? 1 : 0, true);
                            }
                            if ($config['type'] == 'file') {
                                //Upload file
                                if (isset($_FILES[$key]['tmp_name']) && isset($_FILES[$key]['name']) && $_FILES[$key]['name']) {
                                    $salt = sha1(microtime());
                                    $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$key]['name'], '.'), 1));
                                    $imageName = $salt . '.' . $type;
                                    $fileName = dirname(__FILE__) . '/images/config/' . $imageName;
                                    if (file_exists($fileName)) {
                                        $errors[] = $config['label'] . $this->l(' already exists. Try to rename the file then reupload');
                                    } else {

                                        $imagesize = @getimagesize($_FILES[$key]['tmp_name']);

                                        if (!$errors && isset($_FILES[$key]) &&
                                            !empty($_FILES[$key]['tmp_name']) &&
                                            !empty($imagesize) &&
                                            in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
                                        ) {
                                            $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                                            if ($error = ImageManager::validateUpload($_FILES[$key]))
                                                $errors[] = $error;
                                            elseif (!$temp_name || !move_uploaded_file($_FILES[$key]['tmp_name'], $temp_name))
                                                $errors[] = $this->l('Cannot upload the file');
                                            elseif (!ImageManager::resize($temp_name, $fileName, null, null, $type))
                                                $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                                            if (isset($temp_name))
                                                @unlink($temp_name);
                                            if (!$errors) {
                                                if (Configuration::get($key) != '') {
                                                    $oldImage = dirname(__FILE__) . '/images/config/' . Configuration::get($key);
                                                    if (file_exists($oldImage))
                                                        @unlink($oldImage);
                                                }
                                                Configuration::updateValue($key, $imageName, true);
                                            }
                                        }
                                    }
                                }
                                //End upload file
                            } elseif ($config['type'] == 'categories' || ($config['type'] == 'checkbox' && isset($config['multiple']) && $config['multiple'])) {
                                Configuration::updateValue($key, implode(',', Tools::getValue($key)), true);
                            } else
                            {
                                $value = trim(Tools::getValue($key));
                                if($key=='ETS_HOMECAT_IDS_FEA' || $key=='ETS_HOMECAT_IDS' || $key == 'ETS_HOMECAT_SPECIFIC_PRODUCTS')
                                {
                                    $value = trim($value,',');
                                }
                                Configuration::updateValue($key,$value , true);
                            }

                        }
                    }
                }
                $this->clearCache();
            }
            if(Tools::getValue('ajax')){
                die(
                    Tools::jsonEncode(
                        array(
                            'success' => !count($errors) ? 1 : 0,
                            'msg' => count($errors) ? $this->displayError($errors) : $this->l('Updated successfully'),
                        )
                    )
                );
            }
            if (count($errors)) {
                $this->errorMessage = $this->displayError($errors);
            } else{
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name.'&currentTab=' . Tools::getValue('ETS_HOMECAT_CURENT_ACTIVE', 'layout'));
            }
        }

        if ( Tools::isSubmit('clear_cache') && Tools::getValue('clear_cache')){
            $this->clearCache();
            $errors = array();
            if(Tools::getValue('ajax')){
                die(
                    Tools::jsonEncode(
                        array(
                            'messageType' => !count($errors) ? 'success' : 'error',
                            'message' => count($errors) ? $this->displayError($errors) : $this->displayConfirmation($this->l('All caches cleared successfully.'))
                        )
                    )
                );
            }
        }
    }
    public function getLinkMore($params)
    {
        return $this->context->link->getModuleLink('ets_homecategories','ajax',array('page'=>(int)$params['page'] + 1,'id_category'=>$params['id_category']),Tools::usingSecureMode());
    }
    public function getAdminLink()
    {
        return AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getValue('token');
    }

    public function getRandomSeed()
    {
        if (Tools::strtolower(Tools::getValue('randseed'))!='default' && (int)Tools::getValue('randseed') > 0 && (int)Tools::getValue('randseed') <= 10000)
            return (int)Tools::getValue('randseed');
        elseif(!Configuration::get('ETS_HOMECAT_ENBLE_LOAD_MORE') || Configuration::get('ETS_HOMECAT_LISTING_MODE') == 'carousel')
            return '';
        elseif ((int)$this->context->cookie->homecat_rand_seed > 0 && (int)$this->context->cookie->homecat_rand_seed <= 10000)
            return (int)$this->context->cookie->homecat_rand_seed;
        else
            return 1;
		return random_int(1, 10000);
    }
    public function getViewedProductIds()
    {
        return isset($this->context->cookie->viewed) && $this->context->cookie->viewed ? array_map('intval',explode(',',$this->context->cookie->viewed)) : array();
    }
    public function saveViewedProducts()
    {
        if ($id_product = (int)Tools::getValue('id_product')){
            $ids = $this->getViewedProductIds();
            if (!in_array($id_product, $ids)) {
                $ids[] = $id_product;
                $this->context->cookie->viewed = trim(implode(',', array_map('intval',$ids)), ',');
                $this->context->cookie->write();
            }
        }
    }
    public function getTreeIds($id_root)
    {
        $category = new Category((int)$id_root,$this->context->language->id);
        if(!$category->id)
            return array();
        $prefix = 'tree_'.(int)$id_root;
        if(($cache = $this->getCache($prefix))!==false)
        {
            return $cache ? @unserialize($cache) : array();
        }
        $ids = array();
        $ids[] = $id_root;
        if ($children = $this->getChildren($id_root))
            foreach ($children as $child) {
                $ids = array_merge($ids, $this->getTreeIds($child['id_category']));
            }
        $ids[] = $id_root;
        $ids = array_unique($ids);
        $this->writeCache($prefix,@serialize($ids));
        return $ids;
    }
    public function getSortOrder($sortBy)
    {
        $sortBy = (string)$sortBy;
        if(!$sortBy || !in_array($sortBy,array('rand','cp.position asc','pl.name asc','pl.name desc','price asc','price desc','p.id_product desc')))
        {
            $sortBy = Configuration::get('ETS_HOMECAT_ALLOW_SORT') && $this->context->cookie->ets_homecat_order ? $this->context->cookie->ets_homecat_order : Configuration::get('ETS_HOMECAT_SORT_PRODUCTS_BY');
        }
        $sortOrder = explode(' ', $sortBy);
        if (!$sortBy || $sortBy == 'rand' || count($sortOrder)!=2)
            return array('orderBy' => 'rand', 'orderWay' => null);
        return array(
            'orderBy' => str_replace(array('cp.','pl.', 'p.'), array('','',''), trim($sortOrder[0])),
            'orderWay' => trim($sortOrder[1]),
        );
    }
    public function getChildren($id_category=false)
    {
        $orderBy = Configuration::get('ETS_HOMECAT_SORT_CATEGORIES_BY');
        if (!in_array($orderBy, array('c.level_depth asc, cs.position asc', 'cl.name asc')))
            $orderBy = 'cl.name asc';
        if(!$id_category || $id_category<=0)
            $id_category = Category::getRootCategory()->id;
        return Db::getInstance()->executeS("
            SELECT c.id_category, cl.name 
            FROM `" . _DB_PREFIX_ . "category` c
            LEFT JOIN `" . _DB_PREFIX_ . "category_lang` cl ON c.id_category=cl.id_category AND cl.id_lang=" . (int)$this->context->language->id . " AND cl.id_shop ='" . (int)$this->context->shop->id . "'
            LEFT JOIN `" . _DB_PREFIX_ . "category_shop` cs ON cs.id_category=c.id_category AND cs.id_shop=" . (int)$this->context->shop->id . "
            WHERE c.active=1 AND c.id_parent=" . (int)$id_category . "
            ORDER BY " . pSQL($orderBy) . "
        ");
    }
    public function getCategoriesByIdStr($idStr,$noViewExcluded = true,$getLink=true)
    {
        $ids = array_map('intval',array_unique(explode(',',trim($idStr,','))));
        $id_lang = (int)$this->context->language->id;
        if(!$ids)
            return array();
        if($noViewExcluded)
            $layout = Configuration::get('ETS_HOMECAT_LAYOUT');
        if($ids)
        {
            $ik = 0;
            $idSQL = '';
            foreach ($ids as $id)
            {
                if($id==-6 && $noViewExcluded && !(($layout=='TAB' || $layout=='TAB_LIST') && $ik!=0) && !$this->getViewedProductIds())
                    continue;
                $ik++;
                $idSQL .= ($ik!=1 ? " UNION " : "")." SELECT ".(int)$id." as id_category,".(int)$ik." as sort_order ";
            }
            if(!$idSQL)
                return array();

            $sql = "
                SELECT DISTINCT ids.id_category, cl.name 
                FROM (".pSQL($idSQL).") ids
                LEFT JOIN `" . _DB_PREFIX_ . "category` c ON ids.id_category=c.id_category
                LEFT JOIN `" . _DB_PREFIX_ . "category_lang` cl ON c.id_category=cl.id_category AND cl.id_lang=" . (int)$this->context->language->id." AND cl.id_shop=" . (int)$this->context->shop->id."               
                ORDER BY ids.sort_order ASC
            ";

            if($categories = Db::getInstance()->executeS($sql))
            {
                foreach($categories as &$category)
                {
                    switch ($category['id_category'])
                    {
                        case 0:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_ALL_PRODUCTS',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_ALL_PRODUCTS',$id_lang) : $this->l('All products');
                            break;
                        case -1:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_NEW_ARRIVALS',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_NEW_ARRIVALS',$id_lang) : $this->l('New arrivals');
                            if ($getLink) $category['link'] = $this->context->link->getPageLink('new-products', true);
                            break;
                        case -2:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_POPULAR',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_POPULAR',$id_lang) : $this->l('Popular');
                            $categoryObj = new Category(Configuration::get('ETS_HOMECAT_FEATURED_CAT',$id_lang)? (int)Configuration::get('ETS_HOMECAT_FEATURED_CAT',$id_lang) : Category::getRootCategory()->id, $this->context->language->id);
                            if($getLink && $categoryObj->id && $categoryObj->id > 2 || $categoryObj->id==2 && $this->is17 && $getLink)
                                $category['link'] = $this->context->link->getCategoryLink($categoryObj);
                            break;
                        case -3:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_SPECIALS',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_SPECIALS',$id_lang) : $this->l('Specials');
                            if ($getLink) $category['link'] = $this->context->link->getPageLink('prices-drop', true);
                            break;
                        case -4:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_BEST_SELLERS',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_BEST_SELLERS',$id_lang) : $this->l('Best sellers');
                            if ($getLink) $category['link'] = $this->context->link->getPageLink('best-sales', true);
                            break;
                        case -5:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_RECOMMENDATIONS',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_RECOMMENDATIONS',$id_lang) : $this->l('Recommendations');
                            break;
                        case -6:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_VIEWED_PRODUCTS',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_VIEWED_PRODUCTS',$id_lang) : $this->l('Viewed products');
                        break;
                        case -7:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_TRENDINGS',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_TRENDINGS',$id_lang) : $this->l('Trendings');
                        break;
                        case -8:
                            $category['name'] = !defined('_PS_ADMIN_DIR_') && Configuration::get('ETS_HOMECAT_TXT_FEATURED',$id_lang) ? Configuration::get('ETS_HOMECAT_TXT_FEATURED',$id_lang) : $this->l('Featured');
                            break;
                        default:
                            break;
                    }
                }
            }
            return $categories;
        }
        return false;
    }
    public function getIdsByStr($idStr)
    {
        return ($ids = array_map('intval',array_unique(explode(',',trim((string)$idStr,','))))) ? $ids : array();
    }
    public function getCacheSubfix()
    {
        $id_currency = isset($this->context->cookie->id_currency) && $this->context->cookie->id_currency ? $this->context->cookie->id_currency : Configuration::get('PS_CURRENCY_DEFAULT');
        $id_customer = (isset($this->context->customer->id)) ? (int)($this->context->customer->id) : 0;
        $id_group = 0;
        if ($id_customer) {
            $id_group = Customer::getDefaultGroupId((int)$id_customer);
        }
        if (!$id_group) {
            $id_group = (int)Group::getCurrent()->id;
        }
        return $this->context->language->id.'_'.$this->context->shop->id.'_'.$this->context->shop->id.'_'.$id_group.'_'.$id_currency;
    }
    public function getCache($prefix){
        if ( !(int)Configuration::get('ETS_HOMECAT_CACHE') || !$prefix || !is_dir($this->dir_cache))
            return false;
        $cacheLifeTime = (float)Configuration::get('ETS_HOMECAT_CACHE_LIFETIME');
        if($files = @glob($this->dir_cache.$prefix.'_'.$this->getCacheSubfix().'.*'))
            foreach ($files as $file) {
                if(file_exists($file)){
                    $time = Tools::substr(strrchr($file, '.'), 1);
                    if ( is_numeric( $time )){
                        if ( (time() - (int)$time <= $cacheLifeTime*60*60) || ! Configuration::get('ETS_HOMECAT_CACHE_LIFETIME')){
                            return Tools::file_get_contents($file);
                        }else{
                            unlink($file);
                        }
                    }
                }
            }
        return false;
    }
    public function writeCache($prefix,$content)
    {
        if(!(int)Configuration::get('ETS_HOMECAT_CACHE'))
            return false;
        if (!is_dir($this->dir_cache) && @mkdir($this->dir_cache, 0755,true)) {
            if ( @file_exists(dirname(__file__).'/index.php')){
                @copy(dirname(__file__).'/index.php', $this->dir_cache.'index.php');
            }
        }
        if(is_dir($this->dir_cache))
        {
            return @file_put_contents($this->dir_cache.$prefix.'_'.$this->getCacheSubfix().'.'.time(),$content);
        }
        return false;
    }
    public function clearCache($prefix=false)
    {
        if(is_dir($this->dir_cache) && ($files = glob($this->dir_cache.($prefix ? $prefix : '').'*')))
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION)!='php')
                    @unlink($file);
            }
        if((int)Configuration::get('ETS_SPEED_ENABLE_PAGE_CACHE') && Module::isInstalled('ets_superspeed') && Module::isEnabled('ets_superspeed') && class_exists('Ets_ss_class_cache'))
        {
            $cacheObjSuperSpeed = new Ets_ss_class_cache();
            if(method_exists($cacheObjSuperSpeed,'deleteCache'))
                $cacheObjSuperSpeed->deleteCache('index');
        }
        if((int)Configuration::get('ETS_SPEED_ENABLE_PAGE_CACHE') && Module::isInstalled('ets_pagecache') && Module::isEnabled('ets_pagecache') && class_exists('Ets_pagecache_class_cache'))
        {
            $cacheObjPageCache = new Ets_ss_class_cache();
            if(method_exists($cacheObjPageCache,'deleteCache'))
                $cacheObjPageCache->deleteCache('index');
        }
    }
    public function getProducts($id_category = false, $page = 0, $per_page = 12, $order_by = 'cp.position', $id_products = false,$not_id_products = false,$excludedOld = false,$trending=false)
    {
        $page = (int)$page;
        if ($page <= 0)
            $page = 1;
        $per_page = (int)$per_page;
        if ($per_page <= 0)
            $per_page = 12;
        $active = true;
        $front = true;
        $nb_days_new_product = Configuration::get('PS_NB_DAYS_NEW_PRODUCT');
        $id_lang = (int)$this->context->language->id;
        if (!Validate::isUnsignedInt($nb_days_new_product)) {
            $nb_days_new_product = 20;
        }
        if ($order_by && !in_array($order_by, array('price asc', 'price desc', 'pl.name asc', 'pl.name desc', 'cp.position asc', 'p.id_product desc', 'rand')))
            $order_by = 'cp.position asc';
        if ($order_by == 'price asc') {
            $order_by = 'orderprice asc';
        } elseif ($order_by == 'price desc') {
            $order_by = 'orderprice desc';
        }
        if ($id_products && $order_by == 'cp.position asc' && !$id_category){
            $order_by = 'FIELD(product_shop.`id_product`,' .(pSQL(implode(',',array_map('intval',$id_products)))). ')';
        }
        if($trending)
        {
            $trendingPeriod = (int)Configuration::get('ETS_HOMECAT_TRENDING_PERIOD');
            if($trendingPeriod < 0)
                $trendingPeriod = 30;
        }
        $prev_version = version_compare(_PS_VERSION_, '1.6.1.0', '<');
        $sql = 'SELECT DISTINCT p.*, '.($trending ? 'count(DISTINCT o.id_order) as total_sales,' : '').'product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) AS quantity' . ($prev_version? ' ,IFNULL(product_attribute_shop.id_product_attribute, 0)':' ,MAX(product_attribute_shop.id_product_attribute)') . ' id_product_attribute, pl.`description`, pl.`description_short`, pl.`available_now`,
    					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, IFNULL(image_shop.`id_image`, i.`id_image`) id_image,
    					il.`legend` as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,
    					DATEDIFF(product_shop.`date_add`, DATE_SUB("' . date('Y-m-d') . ' 00:00:00",
    					INTERVAL ' . (int)$nb_days_new_product . ' DAY)) > 0 AS new, product_shop.price AS orderprice
                FROM `' . _DB_PREFIX_ . 'category_product` cp
                LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
                '.Shop::addSqlAssociation('product', 'p').
                ' LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (product_shop.`id_category_default` = cl.`id_category` AND cl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('cl') . ')'.
                (!$prev_version?
                    'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (pa.id_product = p.id_product)'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on=1').'':
                    'LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop='.(int)$this->context->shop->id.')'
                )
                .Product::sqlStock('p', 0, false, $this->context->shop).'
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('pl') . ')'.
                (!$prev_version?
                    'LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product`)'. Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover = 1') :
                    'LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop ON (image_shop.`id_product` = p.`id_product` AND image_shop.id_shop=' . (int)$this->context->shop->id . ')'
                ).'
                LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')	
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
                '.($excludedOld && ($this->context->customer->isLogged() || isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart) ?
                ((int)$this->context->customer->isLogged() ? '
                                LEFT JOIN (
                                    SELECT od.product_id as id_product
                                    FROM `'._DB_PREFIX_.'order_detail` od
                                    JOIN `'._DB_PREFIX_.'orders` o ON od.id_order=o.id_order
                                    WHERE o.id_customer='.(int)$this->context->customer->id.'
                                ) od2 on p.id_product=od2.id_product
                            ' : '').(isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart ? '
                                LEFT JOIN `'._DB_PREFIX_.'cart_product` cap ON cap.id_product=p.id_product AND cap.id_cart='.(int)$this->context->cookie->id_cart
                    : '') : ''
                ).($trending ? '
                JOIN `'._DB_PREFIX_.'order_detail` od ON p.id_product=od.product_id
                JOIN `'._DB_PREFIX_.'orders` o ON o.id_order=od.id_order AND o.date_add > \''.pSQL(date('Y-m-d H:i:s',time()-$trendingPeriod*24*60*60)).'\'
                ' : '').'
                WHERE product_shop.`id_shop` = ' . (int)$this->context->shop->id . '
                '.($id_category >0 ? ' AND ' . (!Configuration::get('ETS_HOMECAT_INCLUDE_SUB') ? 'cp.`id_category` = ' . (int)$id_category : 'cp.`id_category` IN(' . implode(',', $this->getTreeIds((int)$id_category)) . ')') : '')
                . ($id_category == false && (int)Tools::getValue('id_category') > 0 ? ' AND cp.id_category='.(int)Tools::getValue('id_category') : '')
                . ($active ? ' AND product_shop.`active` = 1' : '')
                . ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
                . ($id_products ? ' AND product_shop.`id_product` IN ('.pSQL(implode(',',$id_products)).')' : '')
                .($excludedOld ? (((int)$this->context->customer->isLogged() ? ' AND od2.id_product is NULL ' : '')
                .(isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart ? ' AND cap.id_product is NULL ' : '')) : '')
                . ($not_id_products ? ' AND product_shop.`id_product` NOT IN ('.pSQL(implode(',',$not_id_products)).')' : '')
                . ' GROUP BY p.id_product'
                . (Configuration::get('ETS_HOMECAT_OUT_OF_STOCK')? ' HAVING quantity > 0 ' : '')
                //. ' ORDER BY ' .( ($order_by) ? ($trending && $order_by=='cp.position asc' ? ' total_sales DESC ' : ($order_by != 'rand' ?  pSQL($order_by) : ' RAND(' . $this->getRandomSeed() . ')')) : '') . '
                .($order_by ?' ORDER BY '. ($trending && $order_by=='cp.position asc' ? ' total_sales DESC ' : ($order_by != 'rand' ?  pSQL($order_by) : ' RAND(' . $this->getRandomSeed() . ')')) : '') . '
                LIMIT ' . (int)($page-1)*$per_page . ',' . (int)$per_page;
        $products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, true);
        if (!$products) {
            return array();
        }
        if ($order_by == 'orderprice asc') {
            Tools::orderbyPrice($products, 'asc');
        } elseif ($order_by == 'orderprice desc') {
            Tools::orderbyPrice($products, 'desc');
        }
        $products = Product::getProductsProperties($id_lang, $products);
        if ($this->is17) {
            $products = HomeProduct::productsForTemplate($products);
        }
        return $products;
    }
    public function getFeaturedProducts($id_category, $page, $perpage, $sortBy)
    {
        if($page<=0)
                $page = 1;
        if (!in_array($id_category,array(-1,-2,-3,-4,-6,-7)))
            return array();
        $homeFeaturedTabs = new HomeProduct();
        $sortOrder = $this->getSortOrder($sortBy);
        $randSeed = $this->getRandomSeed();
        $homeFeaturedTabs->setPage($page)
            ->setPerPage($perpage)
            ->setOrderBy($sortOrder['orderBy'])
            ->setOrderWay($sortOrder['orderWay'])
            ->setRandSeed($randSeed);
        if ($id_category == -1) //New products
        {
            $products = $homeFeaturedTabs->getNewProducts();
        }
        elseif ($id_category == -2) //Popular
        {
            $id_category_popular = Configuration::get('ETS_HOMECAT_FEATURED_CAT')? (int)Configuration::get('ETS_HOMECAT_FEATURED_CAT') : Category::getRootCategory()->id;
            $products = $homeFeaturedTabs
                ->setIdCategory($id_category_popular)
                ->getHomeFeatured();
        }
        elseif ($id_category == -3) //Specials
        {
            $products = $homeFeaturedTabs->getSpecialProducts();
        }
        else // Best sellers
        {
            $products =  $homeFeaturedTabs->getBestSellers();
        }
        return  $products;
    }
    public function getRecommendedProducts($perpage = 12){
        if (!(($viewedProductsIds = $this->getViewedProductIds()) || $this->context->customer->isLogged() || isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart)){
            $products = $this->getProducts(false,1,$perpage,'rand');
        }else{
            $sqlViewed = false;
            $sqlCart = false;
            if($viewedProductsIds){
                $totalViewed = count($viewedProductsIds);
                $sqlViewed='(';
                for($ik = $totalViewed; $ik>($totalViewed > $perpage ? $totalViewed-$perpage : 0); $ik--)
                {
                    $sqlViewed .= ($ik==$totalViewed ? '' : ' UNION ').' SELECT '.(int)$viewedProductsIds[$ik-1].' as id_product';
                }
                $sqlViewed.=') as viewed_products ';
                $sqlViewed = '
                    (SELECT p.id_product, p.id_category_default 
                    FROM `'._DB_PREFIX_.'product` p
                    JOIN '.$sqlViewed. ' ON viewed_products.id_product=p.id_product AND p.active=1)
                ';
            }
            if ($this->context->customer->isLogged() || isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart) {
                $sqlCart = '
                    (SELECT p.id_product, p.id_category_default 
                    FROM `'._DB_PREFIX_.'cart_product` cp
                    JOIN `'._DB_PREFIX_.'cart` c ON cp.id_cart=c.id_cart AND '.($this->context->customer->isLogged() ?' c.id_customer='.(int)$this->context->customer->id : ' c.id_cart='.(int)$this->context->cookie->id_cart).' 
                    JOIN `'._DB_PREFIX_.'product` p ON (cp.id_product = p.id_product)
                    ORDER BY cp.date_add DESC 
                    LIMIT '.(int)$perpage.')
                ';
            }
            $sqlCoreProducts = $sqlViewed && $sqlCart ? $sqlViewed." UNION ".$sqlCart : ($sqlViewed ? $sqlViewed : $sqlCart);
            $sql = 'SELECT DISTINCT core_products.id_product as id1,cp.id_product as id2, ac.id_product_2 as id3 
                    FROM `'._DB_PREFIX_.'category_product` cp
                    RIGHT JOIN ('.$sqlCoreProducts.') core_products ON core_products.id_category_default=cp.id_category AND core_products.id_product!=cp.id_product
                    LEFT JOIN `'._DB_PREFIX_.'accessory` ac ON ( core_products.id_product = ac.id_product_1)                    
                    ORDER BY RAND() 
                    LIMIT '.(int)$perpage*2;
            $pids = array();
            $filterSql = "";
            if($products = Db::getInstance()->executeS($sql))
            {
                foreach ($products as $product)
                {
                    if($product['id1'] && !in_array($product['id1'],$pids))
                    {
                        $filterSql .= ($filterSql ? " UNION " : "")." SELECT ".(int)$product['id1']." as id_product ";
                        $pids[] = $product['id1'];
                    }
                    if($product['id2'] && !in_array($product['id2'],$pids))
                    {
                        $filterSql .= ($filterSql ? " UNION " : "")." SELECT ".(int)$product['id2']." as id_product ";
                        $pids[] = $product['id2'];
                    }
                    if($product['id3'] && !in_array($product['id3'],$pids))
                    {
                        $filterSql .= ($filterSql ? " UNION " : "")." SELECT ".(int)$product['id3']." as id_product ";
                        $pids[] = $product['id3'];
                    }
                    if(!($this->context->customer->isLogged() || isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart) && count($pids)>=$perpage)
                        break;
                }
                if($this->context->customer->isLogged() || isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart)
                {
                    $pids = array();
                    $sql = 'SELECT pids.id_product
                            FROM ('.$filterSql.') pids
                            '.((int)$this->context->customer->isLogged() ? '
                                LEFT JOIN (
                                    SELECT od.product_id as id_product
                                    FROM `'._DB_PREFIX_.'order_detail` od
                                    JOIN `'._DB_PREFIX_.'orders` o ON od.id_order=o.id_order
                                    WHERE o.id_customer='.(int)$this->context->customer->id.'
                                ) od2 on pids.id_product=od2.id_product
                            ' : '').(isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart ? '
                                LEFT JOIN `'._DB_PREFIX_.'cart_product` cp ON cp.id_product=pids.id_product AND cp.id_cart='.(int)$this->context->cookie->id_cart
                              : '').'
                            WHERE 1 '.((int)$this->context->customer->isLogged() ? ' AND od2.id_product is NULL' : '')
                            .(isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart ? ' AND cp.id_product is NULL' : '');

                    if($products = Db::getInstance()->executeS($sql))
                    {
                        foreach ($products as $product)
                        {
                            if(!in_array($product['id_product'],$pids))
                            {
                                $pids[] = $product['id_product'];
                            }
                        }
                    }
                }
                $products = $this->getProducts(false,1,$perpage,'rand',$pids,false,$pids ? false : true);
            }
            else
                $products = array();
            if (($total_extends = count($products))< $perpage){
                $products_extends = $this->getProducts(false,1,$perpage-$total_extends,'rand',false,$pids,true);
                $products = array_merge($products,$products_extends);
            }
        }
        return $products;
    }
    public function getViewedProducts($page, $perpage, $sortBy)
    {
        $pids = $this->getViewedProductIds();
        if($pids)
        {
            return $this->getProducts(false,$page,$perpage,$sortBy,$pids);
        }
        return array();
    }
    public function displayHomeCatAdmin()
    {
        $this->smarty->assign(
            array(
                'homecat_admin_js_url' => $this->_path . 'views/js/homecat-admin.js',
                'homecat_admin_js_banner_url' => $this->_path . 'views/js/hc-admin-banner.js',
                'other_js_url' => $this->_path . 'views/js/other.js',
                'homecat_admin_ajax_url' => $this->getAdminLink(),
                'homecat_banner_ajax_url' => $this->getAdminLink().'&submit_banner=1',
            )
        );
        return $this->display(__FILE__, 'admin.tpl');
    }
    public function renderConfig()
    {
        $configs = $this->configs;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Home Products Pro'),
                ),
                'input' => array(),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right hc_submit_config'
                )
            ),
        );
        if ($configs) {
            foreach ($configs as $key => $config) {
                $confFields = array(
                    'name' => $key,
                    'type' => $config['type'],
                    'label' => $config['label'],
                    'desc' => isset($config['desc']) ? $config['desc'] : false,
                    'placeholder' => isset($config['placeholder']) ? $config['placeholder'] : false,
                    'form_group_class' => isset($config['form_group_class']) ? $config['form_group_class'] : '',
                    'col' => isset($config['col']) && $config['col'] ? $config['col'] : false,
                    'required' => isset($config['required']) && $config['required'] ? true : false,
                    'autoload_rte' => isset($config['autoload_rte']) && $config['autoload_rte'] ? true : false,
                    'options' => isset($config['options']) && $config['options'] ? $config['options'] : array(),
                    'suffix' => isset($config['suffix']) && $config['suffix'] ? $config['suffix'] : false,
                    'multiple' => isset($config['multiple']) ? $config['multiple'] : false,
                    'validate' => isset($config['validate']) ? $config['validate'] : false,
                    'values' => isset($config['values']) ? $config['values'] : ($config['type'] == 'switch' ? array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ) : false),
                    'lang' => isset($config['lang']) ? $config['lang'] : false
                );
                if (isset($config['tree']))
                    $confFields['tree'] = $config['tree'];
                if (!$confFields['suffix'])
                    unset($confFields['suffix']);
                if (!$confFields['multiple'])
                    unset($confFields['multiple']);
                if (!$confFields['col'])
                    unset($confFields['col']);
                if (!$confFields['values'])
                    unset($confFields['values']);
                if (!$confFields['validate'])
                    unset($confFields['validate']);
                if ($config['type'] == 'file') {
                    if ($imageName = Configuration::get($key)) {
                        $confFields['display_img'] = $this->_path . 'images/config/' . $imageName;
                        if (!isset($config['required']) || (isset($config['required']) && !$config['required']))
                            $confFields['img_del_link'] = $this->baseAdminPath . '&delimage=yes&image=' . $key;
                    }
                }
                $fields_form['form']['input'][] = $confFields;
            }
        }
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'saveConfig';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . '&control=config';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $fields = array();
        $languages = Language::getLanguages(false);
        $helper->override_folder = '/';
        if (Tools::isSubmit('saveConfig')) {
            if ($configs) {
                foreach ($configs as $key => $config) {
                    if (isset($config['lang']) && $config['lang']) {
                        foreach ($languages as $l) {
                            $fields[$key][$l['id_lang']] = Tools::getValue($key . '_' . $l['id_lang'], isset($config['default']) ? $config['default'] : '');
                        }
                    } else
                        $fields[$key] = Tools::getValue($key, isset($config['default']) ? $config['default'] : '');
                }
            }
        } else {
            if ($configs) {
                foreach ($configs as $key => $config) {
                    if (isset($config['lang']) && $config['lang']) {
                        foreach ($languages as $l) {
                            $fields[$key][$l['id_lang']] = Configuration::get($key, $l['id_lang']);
                        }
                    }
                    else
                    {
                        if($key=='ETS_HOMECAT_PRODUCTS_TABS')
                        {
                            $layout = Configuration::get('ETS_HOMECAT_LAYOUT',null,null,null,'TAB');
                            if($layout=='LIST_TAB' || $layout=='TAB_LIST')
                                $fields[$key] = Configuration::get('ETS_HOMECAT_IDS_FEA');
                            else
                                $fields[$key] = Configuration::get('ETS_HOMECAT_IDS');
                        }
                        else
                            $fields[$key] = Configuration::get($key);
                    }
                }
            }
        }
        $intro = true;
        $localIps = array(
            '127.0.0.1',
            '::1'
        );
		$baseURL = Tools::strtolower(self::getBaseLink());
		if(!Tools::isSubmit('intro') && (in_array(Tools::getRemoteAddr(), $localIps) || preg_match('/^.*(localhost|demo|dev|test|:\d+).*$/i', $baseURL)))
		    $intro = false;
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'other_modules_link' => isset($this->refs) ? $this->refs.$this->context->language->iso_code : $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name.'&othermodules=1',
            'fields_value' => $fields,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'intro' => $intro,
            'refsLink' => isset($this->refs) ? $this->refs.$this->context->language->iso_code : false,
        );

        $this->_html .= $helper->generateForm(array($fields_form));
    }
    public static function getBaseLink()
    {
        $context = Context::getContext();
        return (Configuration::get('PS_SSL_ENABLED_EVERYWHERE')?'https://':'http://').$context->shop->domain.$context->shop->getBaseURI();
    }
    public function hookDisplayBackOfficeHeader() {

        if (Tools::getValue('configure') == $this->name && Tools::getValue('controller')=='AdminModules') {
            $this->context->controller->addJquery();
            $this->context->controller->addJqueryUI('ui.sortable');
            $this->context->controller->addCSS($this->_path . 'views/css/admin.css');
            $this->context->controller->addCSS($this->_path . 'views/css/other.css');
        }

    }
    public function hookDisplayHeader()
    {
        $this->saveViewedProducts();
        if ( Dispatcher::getInstance()->getController() != 'index'){
            return;
        }
        if (Configuration::get('ETS_HOMECAT_ALLOW_SORT') && (!isset($this->context->cookie->ets_homecat_order) || !$this->context->cookie->ets_homecat_order)) {
            $this->context->cookie->ets_homecat_order = Configuration::get('ETS_HOMECAT_SORT_PRODUCTS_BY');
            $this->context->cookie->write();
        }
        if(!isset($this->context->cookie->homecat_rand_seed) || !$this->context->cookie->homecat_rand_seed)
        {
            $this->context->cookie->homecat_rand_seed = rand(1, 10000);
            $this->context->cookie->write();
        }
        $this->context->controller->addCSS($this->_path . 'views/css/homecategories.css', 'all');
        if ($this->is17)
            $this->context->controller->addCSS($this->_path . 'views/css/fix17.css', 'all');
        else {
            $this->context->controller->addCSS($this->_path . 'views/css/fix16.css', 'all');
            if (isset($this->context->controller->php_self) && $this->context->controller->php_self == 'index')
                $this->context->controller->addCSS(_THEME_CSS_DIR_ . 'product_list.css');
        }
        if (Configuration::get('ETS_HOMECAT_LISTING_MODE') == 'carousel') {
            $this->context->controller->addCSS($this->_path . 'views/css/slick.css', 'all');
            $this->context->controller->addJS($this->_path . 'views/js/slick.js');
        }
        $this->context->controller->addJS($this->_path . 'views/js/homecat-front.js');
        return $this->assignConfig(true);
    }
    public function assignConfig($frontJs = false)
    {
        $configs = array();
        foreach ($this->configs as $key => $val) {
            if ($frontJs && isset($val['js_type']) && $val['js_type']) {
                $configs[$key] = array(
                    'value' => !isset($val['lang']) || isset($val['lang']) && !$val['lang'] ? Configuration::get($key) : Configuration::get($key, $this->context->language->id),
                    'type' => $val['js_type']
                );
            } else if (!$frontJs)
                $configs[$key] = !isset($val['lang']) || isset($val['lang']) && !$val['lang'] ? Configuration::get($key) : Configuration::get($key, $this->context->language->id);
        }
        if ($frontJs)
        {
            $this->smarty->assign(array(
                'frontJs' => $configs,
                'homecat_rand_seed' => (int)$this->context->cookie->homecat_rand_seed,
                'homecat_ajax_link' => $this->context->link->getModuleLink('ets_homecategories', 'ajax', array(), Tools::usingSecureMode()),
            ));
            return $this->display(__FILE__, 'assign-js.tpl');
        }
        return $configs;
    }
    public function hookDisplayHome()
    {
        $layout = Configuration::get('ETS_HOMECAT_LAYOUT',null,null,null,'TAB');
        $ids = $cids = $this->getIdsByStr(Configuration::get('ETS_HOMECAT_IDS'));
        $fids = $this->getIdsByStr(Configuration::get('ETS_HOMECAT_IDS_FEA'));
        $viewedIds = $this->getViewedProductIds();
        if($layout!='TAB' && $layout!='LIST')
            $ids = array_merge($cids,$fids);
        if($layout=='TAB' && $cids && $cids[0]!=-5 && $cids[0]!=-6 || $layout=='TAB_LIST' && $fids && $fids[0]!=-5 && $fids[0]!=-6
            || !in_array(-5,$ids) && !in_array(-6,$ids) || !(($viewedIds || $this->context->customer->isLogged() || isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart) && $ids && (in_array(-5,$ids) || in_array(-6,$ids))))
            $cacheUsable = true;
        else
            $cacheUsable = false;
        $sortBy = Configuration::get('ETS_HOMECAT_ALLOW_SORT') && $this->context->cookie->ets_homecat_order ? $this->context->cookie->ets_homecat_order : Configuration::get('ETS_HOMECAT_SORT_PRODUCTS_BY');
        $prefix = 'all_'.str_replace(' ','_',$sortBy);
        if($cacheUsable && ($cache = $this->getCache($prefix))!==false)
            return $cache;
        $categoryTabs = $this->getCategoriesByIdStr(Configuration::get('ETS_HOMECAT_IDS'));
        $blockOrder = Configuration::get('ETS_HOMECAT_BLOCK_SORT');
        $greater1760 = version_compare(_PS_VERSION_, '1.7.6.0', '>=') ? 1 : 0;
        switch ($layout) {
            case 'TAB':
                $tpl = 'mode-tab.tpl';
                break;
            case 'LIST':
                $tpl = 'mode-list.tpl';
                break;
            default:
                $featuredTabs = $this->getCategoriesByIdStr(Configuration::get('ETS_HOMECAT_IDS_FEA'));
                $tpl = 'mode-mix.tpl';
                break;
        }
        $assign = array(
            'featuredTabs' => isset($featuredTabs) ? $featuredTabs : array(),
            'categoryTabs' => $categoryTabs,
            'blockOrder' => $blockOrder,
            'sortOptions' => $this->configs['ETS_HOMECAT_SORT_PRODUCTS_BY']['options']['query'],
            'sort_by' => isset($this->context->cookie->ets_homecat_order) ? $this->context->cookie->ets_homecat_order : false,
            'link' => $this->context->link,
            'layout' => $layout,
            'greater1760' => $greater1760,
            'ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP' => (int)Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP') ? Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP') : 4,
            'ETS_HOMECAT_NUMBER_DISPLAY_TABLET' => (int)Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_TABLET') ? Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_TABLET') : 3,
            'ETS_HOMECAT_NUMBER_DISPLAY_MOBIE' => (int)Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_MOBIE') ? Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_MOBIE') : 2,
        );
        $assign = array_merge($this->assignConfig(),$assign);
        $this->smarty->assign($assign);
        $content = isset($tpl) ? $this->display(__FILE__,$tpl) : '';
        if($cacheUsable)
            $this->writeCache($prefix,$content);
        return  $content;
    }
    public function hookDisplayProductList($params)
    {
        $isAjax = isset($params['ajax']) && $params['ajax'];
        if (Configuration::get('ETS_HOMECAT_ALLOW_SORT') && isset($params['sortby']) && $params['sortby'] && in_array($params['sortby'],array('rand','cp.position asc','pl.name asc','pl.name desc','price asc','price desc','p.id_product desc')))
            $sortBy = $params['sortby'];
        else
            $sortBy = Configuration::get('ETS_HOMECAT_ALLOW_SORT') && $this->context->cookie->ets_homecat_order ? $this->context->cookie->ets_homecat_order : Configuration::get('ETS_HOMECAT_SORT_PRODUCTS_BY');

        $page = isset($params['page']) && (int)$params['page'] >= 1 ? (int)$params['page'] : 1;
        $perpage = (int)Configuration::get('ETS_HOMECAT_PER_PAGE') > 0 ? (int)Configuration::get('ETS_HOMECAT_PER_PAGE') : 12;
        $id_category = $id_category_ori = isset($params['id_category']) ? (int)$params['id_category'] : 0;
        $id_parent = (isset($params['id_parent'])) && (Validate::isInt($params['id_parent']) || in_array($params['id_parent'],array('tab','no'))) ? $params['id_parent'] : 'no';
        $id_feature = isset($params['id_feature']) && $params['id_feature']!='no' ? (int)$params['id_feature'] : false;
        $prefix = 'pro_'.$id_category.($id_feature!==false && $id_feature < 0 ? '_'.$id_feature : '').'_'.str_replace(' ','_',$sortBy);
        if($id_feature!==false && $id_feature < 0)
            $id_category = $id_feature;
        $viewedIds = $this->getViewedProductIds();
        $loadmore = (int)Tools::getValue('loadmore') ? true : false;
        $cacheUsable = (int)Configuration::get('ETS_HOMECAT_CACHE') && $page == 1 && !$loadmore && ($id_category!=-6 || !$viewedIds) && ($id_category!=-5 || !($viewedIds || $this->context->customer->isLogged() || isset($this->context->cookie->id_cart) && $this->context->cookie->id_cart));
        $greater1760 = version_compare(_PS_VERSION_, '1.7.6.0', '>=') ? 1 : 0;
        //Protect caching system from spamm.
        if($id_feature!==false && !in_array($id_feature,array(-1,-2,-3,-4,-5,-6,-7,-8)) || $id_category > 0 && ($categoryObj = new Category($id_category,$this->context->language->id)) && !$categoryObj->id)
            return $isAjax ? array(
                'html' => '',
                'loadmore' => $loadmore,
                'is17' => $this->is17,
                'greater1760' => $greater1760,
            ) : '';
        if($cacheUsable &&($cache = $this->getCache($prefix))!==false)
        {
            return $isAjax ? array(
                'html' => $cache,
                'loadmore' => $loadmore,
                'is17' => $this->is17,
                'greater1760' => $greater1760,
            ) : $cache;
        }
        if ($id_category < 0 && $id_category >= -8)
            $products = $id_category == -5 ? $this->getRecommendedProducts($perpage) :
                ($id_category == -6 ? $this->getViewedProducts($page,$perpage,$sortBy) :
                    ($id_category==-7 ? $this->getProducts(false,$page,$perpage,$sortBy,false,false,false,true) :
                        ($id_category==-8 ? $this->getProducts(false,$page,$perpage,$sortBy,array_unique(array_map('intval',explode(',',Configuration::get('ETS_HOMECAT_SPECIFIC_PRODUCTS'))))) :
                            $this->getFeaturedProducts($id_category, $page, $perpage, $sortBy))));
        else
            $products = $this->getProducts($id_category, $page, $perpage, $sortBy);
        if($id_category!=-5 && (int)Configuration::get('ETS_HOMECAT_ENBLE_LOAD_MORE') && Configuration::get('ETS_HOMECAT_LISTING_MODE')!='carousel' && count($products) >= $perpage)
            $nextPage = $page+1;
        else
            $nextPage = false;

        $this->smarty->assign(array(
            'products' => $products,
            'id_category' => $id_category,
            'id_feature' => $id_feature,
            'id_category_ori' => $id_category_ori,
            'active' => isset($params['active']) && $params['active'],
            'class' => 'homecat-tab-'.$id_category,
            'nextPage' => $nextPage,
            'isAjax' => $isAjax,
            'id_parent' => $id_parent,
            'loadmore' => $loadmore,
            'randSeed' => $this->getRandomSeed(),
            'ETS_HOMECAT_ENBLE_LOAD_MORE' => (int)Configuration::get('ETS_HOMECAT_ENBLE_LOAD_MORE') ? true : false,
            'ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP' => (int)Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP') ? Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP') : 4,
            'ETS_HOMECAT_NUMBER_DISPLAY_TABLET' => (int)Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_TABLET') ? Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_TABLET') : 3,
            'ETS_HOMECAT_NUMBER_DISPLAY_MOBIE' => (int)Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_MOBIE') ? Configuration::get('ETS_HOMECAT_NUMBER_DISPLAY_MOBIE') : 2,
        ));
        $html = $this->display(__FILE__, 'product-list-' . ($this->is17 ? '17' : '16') . '.tpl');
        if($cacheUsable)
            $this->writeCache($prefix,$html);
        return $isAjax  ? array(
            'html' => $html,
            'loadmore' => $loadmore,
            'is17' => $this->is17,
            'nextPage' => $nextPage,
            'greater1760' => $greater1760,
        ) : $html;
    }
    public function displayRecommendedModules()
    {
        $cacheDir = dirname(__file__) . '/../../cache/'.$this->name.'/';
        $cacheFile = $cacheDir.'module-list.xml';
        $cacheLifeTime = 24;
        $cacheTime = (int)Configuration::getGlobalValue('ETS_MOD_CACHE_'.$this->name);
        $profileLinks = array(
            'en' => 'https://addons.prestashop.com/en/207_ets-soft',
            'fr' => 'https://addons.prestashop.com/fr/207_ets-soft',
            'it' => 'https://addons.prestashop.com/it/207_ets-soft',
            'es' => 'https://addons.prestashop.com/es/207_ets-soft',
        );
        if(!is_dir($cacheDir))
        {
            @mkdir($cacheDir, 0755,true);
            if ( @file_exists(dirname(__file__).'/index.php')){
                @copy(dirname(__file__).'/index.php', $cacheDir.'index.php');
            }
        }
        if(!file_exists($cacheFile) || !$cacheTime || time()-$cacheTime > $cacheLifeTime * 60 * 60)
        {
            if(file_exists($cacheFile))
                @unlink($cacheFile);
            if($xml = self::file_get_contents($this->shortlink.'ml.xml'))
            {
                $xmlData = @simplexml_load_string($xml);
                if($xmlData && (!isset($xmlData->enable_cache) || (int)$xmlData->enable_cache))
                {
                    @file_put_contents($cacheFile,$xml);
                    Configuration::updateGlobalValue('ETS_MOD_CACHE_'.$this->name,time());
                }
            }
        }
        else
            $xml = Tools::file_get_contents($cacheFile);
        $modules = array();
        $categories = array();
        $categories[] = array('id'=>0,'title' => $this->l('All categories'));
        $enabled = true;
        $iso = Tools::strtolower($this->context->language->iso_code);
        $moduleName = $this->displayName;
        $contactUrl = '';
        if($xml && ($xmlData = @simplexml_load_string($xml)))
        {
            if(isset($xmlData->modules->item) && $xmlData->modules->item)
            {
                foreach($xmlData->modules->item as $arg)
                {
                    if($arg)
                    {
                        if(isset($arg->module_id) && (string)$arg->module_id==$this->name && isset($arg->{'title'.($iso=='en' ? '' : '_'.$iso)}) && (string)$arg->{'title'.($iso=='en' ? '' : '_'.$iso)})
                            $moduleName = (string)$arg->{'title'.($iso=='en' ? '' : '_'.$iso)};
                        if(isset($arg->module_id) && (string)$arg->module_id==$this->name && isset($arg->contact_url) && (string)$arg->contact_url)
                            $contactUrl = $iso!='en' ? str_replace('/en/','/'.$iso.'/',(string)$arg->contact_url) : (string)$arg->contact_url;
                        $temp = array();
                        foreach($arg as $key=>$val)
                        {
                            if($key=='price' || $key=='download')
                                $temp[$key] = (int)$val;
                            elseif($key=='rating')
                            {
                                $rating = (float)$val;
                                if($rating > 0)
                                {
                                    $ratingInt = (int)$rating;
                                    $ratingDec = $rating-$ratingInt;
                                    $startClass = $ratingDec >= 0.5 ? ceil($rating) : ($ratingDec > 0 ? $ratingInt.'5' : $ratingInt);
                                    $temp['ratingClass'] = 'mod-start-'.$startClass;
                                }
                                else
                                    $temp['ratingClass'] = '';
                            }
                            elseif($key=='rating_count')
                                $temp[$key] = (int)$val;
                            else
                                $temp[$key] = (string)strip_tags($val);
                        }
                        if($iso)
                        {
                            if(isset($temp['link_'.$iso]) && isset($temp['link_'.$iso]))
                                $temp['link'] = $temp['link_'.$iso];
                            if(isset($temp['title_'.$iso]) && isset($temp['title_'.$iso]))
                                $temp['title'] = $temp['title_'.$iso];
                            if(isset($temp['desc_'.$iso]) && isset($temp['desc_'.$iso]))
                                $temp['desc'] = $temp['desc_'.$iso];
                        }
                        $modules[] = $temp;
                    }
                }
            }
            if(isset($xmlData->categories->item) && $xmlData->categories->item)
            {
                foreach($xmlData->categories->item as $arg)
                {
                    if($arg)
                    {
                        $temp = array();
                        foreach($arg as $key=>$val)
                        {
                            $temp[$key] = (string)strip_tags($val);
                        }
                        if(isset($temp['title_'.$iso]) && $temp['title_'.$iso])
                                $temp['title'] = $temp['title_'.$iso];
                        $categories[] = $temp;
                    }
                }
            }
        }
        if(isset($xmlData->{'intro_'.$iso}))
            $intro = $xmlData->{'intro_'.$iso};
        else
            $intro = isset($xmlData->intro_en) ? $xmlData->intro_en : false;
        $this->smarty->assign(array(
            'modules' => $modules,
            'enabled' => $enabled,
            'module_name' => $moduleName,
            'categories' => $categories,
            'img_dir' => $this->_path . 'views/img/',
            'intro' => $intro,
            'shortlink' => $this->shortlink,
            'ets_profile_url' => isset($profileLinks[$iso]) ? $profileLinks[$iso] : $profileLinks['en'],
            'trans' => array(
                'txt_must_have' => $this->l('Must-Have'),
                'txt_downloads' => $this->l('Downloads!'),
                'txt_view_all' => $this->l('View all our modules'),
                'txt_fav' => $this->l('Prestashop\'s favourite'),
                'txt_elected' => $this->l('Elected by merchants'),
                'txt_superhero' => $this->l('Superhero Seller'),
                'txt_partner' => $this->l('Module Partner Creator'),
                'txt_contact' => $this->l('Contact us'),
                'txt_close' => $this->l('Close'),
            ),
            'contactUrl' => $contactUrl,
         ));
         echo $this->display(__FILE__, 'module-list.tpl');
         die;
    }
    public static function file_get_contents($url, $use_include_path = false, $stream_context = null, $curl_timeout = 60)
    {
        if ($stream_context == null && preg_match('/^https?:\/\//', $url)) {
            $stream_context = stream_context_create(array(
                "http" => array(
                    "timeout" => $curl_timeout,
                    "max_redirects" => 101,
                    "header" => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36'
                ),
                "ssl"=>array(
                    "allow_self_signed"=>true,
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            ));
        }
        if (function_exists('curl_init')) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => html_entity_decode($url),
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => $curl_timeout,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_FOLLOWLOCATION => true,
            ));
            $content = curl_exec($curl);
            curl_close($curl);
            return $content;
        } elseif (in_array(ini_get('allow_url_fopen'), array('On', 'on', '1')) || !preg_match('/^https?:\/\//', $url)) {
            return Tools::file_get_contents($url, $use_include_path, $stream_context);
        } else {
            return false;
        }
    }
    public function hookDisplayCategoryBanner($params)
    {

        $layout = Configuration::get('ETS_HOMECAT_LAYOUT',null,null,null,'TAB');
        if (Configuration::get('ETS_HOMECAT_DISPLAY_CATEGORY_BANNER') == 'none' || (  $layout=='TAB' ))
            return;
        if(!isset($params['id_category']))
            return '';
        else
            $id_category = (int)$params['id_category'];
        $this->smarty->assign(array(
            'banner' => $this->getBanners($id_category),
            'ver176' => version_compare(_PS_VERSION_,'1.7.6.0','>=') ? true : false
        ));
        return $this->display(__FILE__, 'category-banner.tpl');
    }
    public function hookDisplaySelectedTabs(){
        $layout = Configuration::get('ETS_HOMECAT_LAYOUT',null,null,null,'TAB');
        $categoryTabs = $this->getCategoriesByIdStr(Configuration::get('ETS_HOMECAT_IDS'),false);
        if($layout != 'LIST' && $layout!='TAB')
        {
            $featuredTabs = $this->getCategoriesByIdStr(Configuration::get('ETS_HOMECAT_IDS_FEA'),false);
            $blockOrder = Configuration::get('ETS_HOMECAT_BLOCK_SORT');
        }
        $this->smarty->assign(array(
            'layout' => $layout,
            'categoryTabs' => $categoryTabs,
            'featuredTabs' => isset($featuredTabs) ? $featuredTabs : false,
            'blockOrder' => isset($blockOrder) ? $blockOrder : false,
        ));
        return $this->display(__FILE__,'admin-selected-tabs-block.tpl');
    }

    public function hookDisplaySpecificProducts(){
        if ($productIds = Configuration::get('ETS_HOMECAT_SPECIFIC_PRODUCTS')){
            $IDs = explode(',', $productIds);

            if ($IDs) {
                $products = $this->getBlockProducts($IDs);
            }
            $this->smarty->assign('products', $products);
        }
        return $this->display(__FILE__,'admin-specific-products.tpl');
    }

    public function hookDisplayBackEndBanner(){
        return $this->renderListBanner();
    }

    public function hookDisplaySubCategories($params)
    {
        $id_category = isset($params['id_category']) && $params['id_category'] ? (int)$params['id_category'] : 0;
        $prefix = 'sub_'.$id_category;
        $active = isset($params['active']) && $params['active'];
        if (($cache = $this->getCache($prefix))!==false){
            return $cache;
        }
        $this->smarty->assign(array(
            'children' => $this->getChildren($id_category),
            'active' => $active,
            'id_category' => $params['id_category'],
            'layout' => isset($params['layout']) ? $params['layout'] : false,
        ));
        $html = $this->display(__FILE__, 'sub-categories.tpl');
        $this->writeCache($prefix,$html);
        return $html;
    }
    public function hookAddProduct()
	{
		$this->clearCache();
	}
	public function hookUpdateProduct()
	{
		$this->clearCache();
	}
	public function hookDeleteProduct()
	{
		$this->clearCache();
	}
	public function hookCategoryUpdate()
	{
		$this->clearCache();
	}
	public function hookActionValidateOrder()
	{
		$this->clearCache('*-7');
	}
	public function hookActionPageCacheAjax()
    {
        $this->saveViewedProducts();
    }

    public function getModuleLink($args = array())
    {
        $uri = $this->context->link->getAdminLink('AdminModules', isset($args['token']) ? $args['token'] : true) . '&configure=' . $this->name . '&module_name=' . $this->name;
        if ($args) {
            $urls = array();
            foreach ($args as $key => $param) {
                if ($key != 'token') {
                    $urls[] = $key . '=' . $param;
                }
            }
            if ($urls) {
                $uri .= '&' . implode('&', $urls);
            }
        }
        return $uri;
    }
    public function getMmType($name = false)
    {
        $mmType = 'small';
        if (!$mmType && ($imageTypes =  $this->imageTypes(true)) && isset($imageTypes[1]) && $imageTypes[1])
            $mmType = $imageTypes[1];
        if ($name)
            $nameType = ImageType::typeAlreadyExists($name)? $name : $mmType;
        if (!(isset($nameType)) || !$nameType)
            $nameType = $mmType;
        return $this->is17 ? ImageType::getFormattedName($nameType) : ImageType::getFormatedName($nameType);
    }
    public function imageTypes($setDefault)
    {
        $types = ImageType::getImagesTypes('products');
        if(!$types)
            return $setDefault? array(false, false) : array();
        $result = array();
        if ($setDefault)
            $default = array();
        foreach ($types as $image_type)
        {
            $result[] = array(
                'id_option' => ($imgType = $this->imageType($image_type['name'])),
                'name' => Tools::ucfirst($imgType),
            );
            if(isset($default) && (trim($imgType) == 'home' || trim($imgType) == 'large' || trim($imgType) == 'medium')) {
                $default[$imgType] = $imgType;
            }
        }
        if (isset($default) && !$default && isset($result[0]) && ($item = $result[0]))
        {
            $default[$item['id_option']] = trim($item['id_option']);
            return array($result, $default);
        }
        if(!$result)
            return isset($default)? array(false, false) : array();
        return isset($default)? array($result, isset($default['home'])? $default['home'] : (isset($default['large'])? $default['large'] : $default['medium'])) : $result;
    }

    public function imageType($name, $ucFirst = false)
    {
        $name =  str_replace('_default', '', $name);
        if ($ucFirst)
            $name = Tools::ucfirst($name);
        return $name;
    }
    public function getBlockProducts($products)
    {
        if (!$products) return false;
        $imageType = $this->getMmType('cart');
        $db = Db::getInstance();
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $sql = 'SELECT p.`id_product`,p.`reference`, pl.`name`,
			 image_shop.`id_image` id_image, il.`legend` , pl.`link_rewrite` 
				FROM `' . _DB_PREFIX_ . 'product` p
				' . Shop::addSqlAssociation('product', 'p') . '
				INNER JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
					p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . '
				)
				LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop FORCE INDEX (id_product)
					ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang . ')
				WHERE p.`id_product` IN ('.pSQL(implode(',',array_map('intval',$products))).')
				GROUP BY p.id_product ORDER BY field(p.id_product,'.pSQL(implode(',',array_map('intval',$products))).') ';

        if ($results = $db->executeS($sql, true, false)){
            foreach ( $results as & $result){
                $result['image'] = str_replace('http://', Tools::getShopProtocol(), $this->context->link->getImageLink($result['link_rewrite'], $result['id_image'], $imageType));
            }
        }

        return $results;
    }

    public function renderFormBanner(){
        $hc_banner = new HomeBanner((int)Tools::getValue('id_ets_hc_banner'));
        $banner_size = false;
        $images = array();
        $languages = $this->context->controller->getLanguages();
        if ($hc_banner->id){
            foreach($languages as $lang)
            {
                $images[$lang['id_lang']] = $hc_banner->image[$lang['id_lang']] ? __PS_BASE_URI__.'img/hcbanner/'.$hc_banner->image[$lang['id_lang']] : '';
            }
        }
        $fields = array(
            array(
                'label' => $this->l('Id shop'),
                'type' => 'hidden',
                'name' => 'id_shop',
                'default' => (int)$this->context->shop->id,
            ),
            array(
                'label' => $this->l('Upload banner image'),
                'name' => 'image',
                'type' => 'file_custom',
                'size' => $banner_size,
                'display_image' => true,
                'class' =>'image upload_img',
                'required' => true,
                'lang' => true,
            ),
            array(
                'label' => $this->l('Banner link'),
                'name' => 'link',
                'type' => 'text',
                'required' => true,
                'lang' => true,
            ),
            array(
                'label' => $this->l('Alt'),
                'name' => 'alt',
                'type' => 'text',
                'required' => true,
                'lang' => true,
            ),
            array(
                'label' => $this->l('Select featured product tabs to display banner'),
                'type' => 'checkbox',
                'class'=> 'feature_product',
                'values' => array(
                    array(
                        'id' => 0,
                        'label' => $this->l('All products'),
                    ),
                    array(
                        'id' => -1,
                        'label' => $this->l('New arrivals'),
                    ),
                    array(
                        'id' => -2,
                        'label' => $this->l('Popular'),
                    ),
                    array(
                        'id' => -3,
                        'label' => $this->l('Specials'),
                    ),
                    array(
                        'id' => -4,
                        'label' => $this->l('Best sellers'),
                    ),
                    array(
                        'id' => -5,
                        'label' => $this->l('Recommendations'),
                    ),
                    array(
                        'id' => -6,
                        'label' => $this->l('Viewed products'),
                    ),
                    array(
                        'id' => -7,
                        'label' => $this->l('Trendings'),
                    ),
                    array(
                        'id' => -8,
                        'label' => $this->l('Featured'),
                    ),
                ),
                'id' => 'id',
                'name' => 'featured_product',
                'selected_values' => $hc_banner->featured_product,
            ),
            array(
                'label' => $this->l('Select product categories to display banner'),
                'type' => 'categories',
                'name' => 'category_banner',
                'tree' => array(
                    'id' => 'category_banner',
                    'class' => 'category_banner',
                    'selected_categories' =>$hc_banner->category_banner,
                    'disabled_categories' => null,
                    'use_checkbox' => true,
                    'use_search' => true,
                    'root_category' => Category::getRootCategory()->id
                ),
            ),
        );


        if ($hc_banner->id) {
            $fields[] = array(
                'type' => 'hidden',
                'name' => 'id_ets_hc_banner',
                'default' => $hc_banner->id,
            );
        }

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    //'title' => Tools::getValue('id_ets_hc_banner') ? $this->l('Edit banner') : $this->l('Add banner')
                ),
                'name' => 'banners',
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                    'back' => array(
                        'href' => $this->getAdminLink() . '&back_to_list=1',
                        'title' => $this->l('Back to list'),
                        'icon' => 'process-icon-back',
                        'class' => 'back_to_list'
                    )
                ),
                'input' => $fields,
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'saveBanner';
        $helper->currentIndex = $this->getAdminLink(array('token' => false, 'control' => 'banner'));
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array('id_lang' => $language->id, 'iso_code' => $language->iso_code),
            'PS_ALLOW_ACCENTED_CHARS_URL' => (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
            'fields_value' => $this->getFieldsValues($fields, $hc_banner, $helper->submit_action),
            'languages' => $languages,
            'id_language' => $this->context->language->id,
            'images' => $images,
            'hc_img_dir' => $this->dir_img_banner,
            'id_ets_hc_banner' => $hc_banner->id,
        );
        $helper->override_folder = '/';
        return $helper->generateForm(array($fields_form));
    }
    public function getFieldsValues($configs, $obj, $submit)
    {
        $fields = array();
        $languages = Language::getLanguages(false);
        if (Tools::isSubmit($submit)) {
            if ($configs) {
                foreach ($configs as $config) {
                    $key = $config['name'];
                    if (isset($config['lang']) && $config['lang']) {
                        foreach ($languages as $l) {
                            $fields[$key][$l['id_lang']] = Tools::getValue($key . '_' . $l['id_lang'], (isset($config['default']) ? $config['default'] : ''));
                        }
                    } elseif ($config['type'] == 'select' && isset($config['multiple']) && $config['multiple']) {
                        $fields[$key . ($config['type'] == 'select' ? '[]' : '')] = Tools::getValue($key, array());
                    }
                    else
                        $fields[$key] = Tools::getValue($key, (isset($config['default']) ? $config['default'] : ''));
                }
            }
        } else {
            if ($configs) {
                foreach ($configs as $config) {
                    $key = $config['name'];
                    if ($config['type'] == 'checkbox' && $key == 'featured_product') {
                        $fields[$key] = $obj->id ? $obj->$key : (isset($config['default']) ? $config['default'] : array());
                    }else if ($config['type'] == 'checkbox'){
                        $fields[$key] = $obj->id ? explode(',', $obj->$key) : (isset($config['default']) ? $config['default'] : array());
                    } elseif (isset($config['lang']) && $config['lang']) {
                        foreach ($languages as $l) {
                            $values = $obj->$key;
                            $fields[$key][$l['id_lang']] = $obj->id ? $values[$l['id_lang']] : (isset($config['default']) ? $config['default'] : '');
                        }
                    }  else {
                        $fields[$key] = $obj->id && property_exists($obj, $key) ? $obj->$key : (isset($config['default']) ? $config['default'] : null);
                    }
                }
            }
        }
        return $fields;
    }

    public function renderListBanner(){
        $this->context->smarty->assign(
            array(
                'banners' =>$this->getBanners(),
                'add_url' => $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name.'&update_banner=1',
            )
        );
        return $this->display(__FILE__,'admin-list-banner.tpl');
    }
    public function  getBanners($id_category = false)
    {
        if($banners = Db::getInstance()->executeS("
            SELECT b.id_ets_hc_banner,bl.link,bl.alt,bl.image".($id_category===false ? ",group_concat(bc.category_banner SEPARATOR ',') as banner_ids" : "")."
            FROM `"._DB_PREFIX_."ets_hc_banner` b 
            LEFT JOIN `"._DB_PREFIX_."ets_hc_banner_lang` bl ON b.id_ets_hc_banner=bl.id_ets_hc_banner AND bl.id_lang=".(int)$this->context->language->id."
            ".($id_category===false ? "LEFT" : "")." JOIN `"._DB_PREFIX_."ets_hc_banner_category` bc ON b.id_ets_hc_banner=bc.id_ets_hc_banner
            WHERE b.id_shop=".(int)$this->context->shop->id.($id_category===false ? "" : " AND bc.category_banner='".(int)$id_category."'")."
            ".($id_category===false ? "GROUP BY b.id_ets_hc_banner" : "")
        ))
        {
            foreach($banners as &$banner)
            {
                if(isset($banner['banner_ids']) && ($banner['banner_ids']!=''))
                    $banner['cats'] = $this->getCategoriesByIdStr($banner['banner_ids'],false,false);
                if($banner['image'])
                    $banner['image'] = defined('_PS_ADMIN_DIR_') ? __PS_BASE_URI__.'img/hcbanner/'.$banner['image'] : $this->context->link->getMediaLink(__PS_BASE_URI__.'img/hcbanner/'.$banner['image']);
                $banner['edit_url'] = $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name.'&id_ets_hc_banner='.$banner['id_ets_hc_banner'].'&update_banner=1';
                $banner['delete_url'] = $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name.'&id_ets_hc_banner='.$banner['id_ets_hc_banner'].'&delete_banner=1';
            }
        }
        return $banners && $id_category!==false ? $banners[0] : $banners;
    }
    public function deleteAllBanners()
    {
        if($files = glob($this->dir_img_banner.'*'))
        {
            foreach($files as $file)
            {
                if($file!='.' && $file!='..')
                    @unlink($file);
            }
        }
        @unlink($this->dir_img_banner);
    }
}