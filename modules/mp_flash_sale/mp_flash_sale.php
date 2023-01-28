<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Mp_flash_sale extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'mp_flash_sale';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'wael zekri';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Flash Sale');
        $this->description = $this->l('Display flash sale in front office');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
		Configuration::updateValue('MP_FLASH_SALE_BANNER',null);
		Configuration::updateValue('MP_FLASH_SALE_AFFICHE',null);
		Configuration::updateValue('MP_FLASH_SALE_START',null);
		Configuration::updateValue('MP_FLASH_SALE_END',null);
		Configuration::updateValue('MP_FLASH_CAT_ID',null);
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
		Configuration::deleteByName('MP_FLASH_SALE_BANNER');
		Configuration::deleteByName('MP_FLASH_SALE_AFFICHE');
		Configuration::deleteByName('MP_FLASH_SALE_START');
		Configuration::deleteByName('MP_FLASH_SALE_END');
		Configuration::deleteByName('MP_FLASH_CAT_ID');
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitMp_flash_saleModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);


        return $this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitMp_flash_saleModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm($this->getConfigForm());
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
		$fields_form = array();
		$fields_form[]['form'] =  array(
			'legend' => array(
			'title' => $this->l('Falsh Sale Bannière'),
			),
			'input' => array(
				array(
					'type' => 'image',
					'name' => 'MP_FLASH_SALE_BANNER',
					'label' => $this->l("Affiche Bannière"),
					'value' => Configuration::get('MP_FLASH_SALE_BANNER'),
					'image' => Configuration::get('MP_FLASH_SALE_BANNER'),
				),
			),
			'submit' => array(
				'title' => $this->l('Save'),
			)
		);
		$fields_form[]['form'] =  array(
			'legend' => array(
			'title' => $this->l('Falsh Sale Affiche'),
			),
			'input' => array(
				array(
					'type' => 'image',
					'name' => 'MP_FLASH_SALE_AFFICHE',
					'label' => $this->l("Affiche produits"),
					'value' => Configuration::get('MP_FLASH_SALE_AFFICHE'),
					'image' => Configuration::get('MP_FLASH_SALE_AFFICHE'),
				),
				array(
					'type' => 'datetime',
					'desc' => $this->l('Enter la date du debut'),
					'name' => 'MP_FLASH_SALE_START',
					'label' => $this->l('Debut'),
				),
				array(
					'type' => 'datetime',
					'desc' => $this->l('Enter la date du fin'),
					'name' => 'MP_FLASH_SALE_END',
					'label' => $this->l('Fin'),
				),
				array(
                'label' => $this->l('Catégorie vente flash'),
                'type' => 'categories',
                'name' => 'MP_FLASH_CAT_ID',
                'tree' => array(
                    'id' => 'category_flash_sale',
                    'selected_categories' =>array(Configuration::get('MP_FLASH_CAT_ID')),
						'disabled_categories' => null,
						'use_checkbox' => false,
						'use_search' => true,
						'root_category' => Category::getRootCategory()->id
					),
					
				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
			),
		);
        return $fields_form;
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
		    'MP_FLASH_SALE_BANNER' => Configuration::get('MP_FLASH_SALE_BANNER'),
		    'MP_FLASH_SALE_AFFICHE' => Configuration::get('MP_FLASH_SALE_AFFICHE'),
            'MP_FLASH_SALE_START' => Configuration::get('MP_FLASH_SALE_START'),
            'MP_FLASH_SALE_END' => Configuration::get('MP_FLASH_SALE_END'),
			'MP_FLASH_CAT_ID' => Configuration::get('MP_FLASH_CAT_ID')
        );
    }


    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();
		$dir = realpath(_PS_MODULE_DIR_.$this->name.'/views/img');
        foreach (array_keys($form_values) as $key) {
			if(empty($_FILES[$key]['type'])){
				Configuration::updateValue($key, Tools::getValue($key),true);
			}else{
				$file_name = strtolower($key);
				$dest = $this->uploadFile($key,$dir,array('save_name'=>$file_name));
				Configuration::updateValue($key,$dest ,true);
			}
        }
    }

    public function uploadFile ($key,$dir, $option = array('use_salt'=>false,'save_name'=>null)){

		$ps_temp_name = @tempnam(_PS_TMP_IMG_DIR_, 'PS');
		$php_temp_name = @$_FILES[$key]['tmp_name'];
		$fileName = @$_FILES[$key]['name'];
		$salt = '';
		$type = @explode('/',@$_FILES[$key]['type'])[1];
		if(!array_key_exists('use_salt',$option)) $option['use_salt'] = false;
		if(!array_key_exists('save_name',$option)) $option['save_name'] = null;
		
		$use_salt = $option['use_salt'];
		$save_name = $option['save_name'];
		
 		if($use_salt) $salt = sha1(microtime()).'_';
		 	
		if($save_name){
			$fileName = $salt.$save_name.".".$type;
		}else{
			$fileName = $salt.$fileName;
		}
		
		$dest = $dir.'/'.$salt.$fileName;
		$url = '/modules/'.$this->name.'/views/img/'.$salt.$fileName;
		@ImageManager::validateUpload($php_temp_name,$ps_temp_name);
		move_uploaded_file($php_temp_name,$dest);
		return $url;
	}

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'views/js/front.js');
        $this->context->controller->addCSS($this->_path.'views/css/front.css');
    }

    public function hookDisplayHome()
    {	
		$link = null;
		
		try{
			$link = $this->context->link->getCategoryLink(Configuration::get('MP_FLASH_CAT_ID'));
		}catch(Exception $e){}
		
        $this->context->smarty->assign([
			'bannerSrc' => Configuration::get('MP_FLASH_SALE_BANNER'),
		    'afficheSrc' => Configuration::get('MP_FLASH_SALE_AFFICHE') ,
            'start' => Configuration::get('MP_FLASH_SALE_START'),
            'end' => Configuration::get('MP_FLASH_SALE_END'),
			'url' => $link
        ]);

        return $this->display(__FILE__, 'flashsale.tpl');

    }
}
