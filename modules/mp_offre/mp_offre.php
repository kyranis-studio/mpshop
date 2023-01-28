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

class Mp_offre extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'mp_offre';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'wael zekri';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Offre');
        $this->description = $this->l('Display offre banner in front office');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('MP_OFFRE_BANNER', '<p>Ajouter votre bannière</p>');
		Configuration::updateValue('MP_OFFRE_BG_COLOR','#6fa8e6');
        return parent::install() && $this->registerHook('displayNav1');
    }

    public function uninstall()
    {
        Configuration::deleteByName('MP_OFFRE_BANNER');
		Configuration::deleteByName('MP_OFFRE_BG_COLOR');
		
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
        if (((bool)Tools::isSubmit('submitMp_offreModule')) == true) {
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
        $helper->submit_action = 'submitMp_offreModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'image',
                        'desc' => $this->l('Ajouter votre bannière'),
                        'name' => 'MP_OFFRE_BANNER',
                        'label' => $this->l('bannière'),
						'display_image' => true,
						'value' => Configuration::get('MP_OFFRE_BANNER'),
						'image' => Configuration::get('MP_OFFRE_BANNER'),
						'lang'=> false
                    ),
					array(
                        'type' => 'text',
                        'desc' => $this->l('Ajouter URL bannière'),
                        'name' => 'MP_OFFRE_BANNER_URL',
                        'label' => $this->l('URL'),
                    ),
					array(
						'type' => 'color',
						'label' => $this->l('Couleur arrière plan'),
						'name' => 'MP_OFFRE_BG_COLOR'						
					),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'MP_OFFRE_BANNER' => Configuration::get('MP_OFFRE_BANNER',true),
			'MP_OFFRE_BG_COLOR' => Configuration::get('MP_OFFRE_BG_COLOR',true),
			'MP_OFFRE_BANNER_URL' => Configuration::get('MP_OFFRE_BANNER_URL',true)
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
		$salt = sha1(microtime());
        $form_values = $this->getConfigFormValues();
		$dir = realpath(_PS_MODULE_DIR_.$this->name.'/views/img');
		$dest = $this->uploadFile('MP_OFFRE_BANNER',$dir,array('save_name'=>'banner','use_salt'=>false));
		if(!isset($dest )){
			Configuration::updateValue('MP_OFFRE_BANNER',Tools::getValue('MP_OFFRE_BANNER'),true );
		}else{
			Configuration::updateValue('MP_OFFRE_BANNER',$dest ,true);
		}
		
        Configuration::updateValue('MP_OFFRE_BG_COLOR', Tools::getValue('MP_OFFRE_BG_COLOR'),true);
		Configuration::updateValue('MP_OFFRE_BANNER_URL', trim(Tools::getValue('MP_OFFRE_BANNER_URL')),true);
    }
	
	public function uploadFile ($key,$dir, $option = array('use_salt'=>false,'save_name'=>null)){
		if(empty($_FILES[$key]['type'])) return;	
		$ps_temp_name = @tempnam(_PS_TMP_IMG_DIR_, 'PS');
		$php_temp_name = @$_FILES[$key]['tmp_name'];
		$fileName = @$_FILES[$key]['name'];
		$salt = '';
		$type = @explode('/',@$_FILES[$key]['type'])[1];
		if(!array_key_exists('use_salt',$option)) $option['use_salt'] = true;
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
	
    public function hookDisplayNav1()
    {
		$bannerSrc = Configuration::get('MP_OFFRE_BANNER',true);
		$bgColor = Configuration::get('MP_OFFRE_BG_COLOR',true);
		
        $this->context->smarty->assign([
			'bannerSrc' => $bannerSrc,
			'bgColor' =>$bgColor,
			'url'=> Configuration::get('MP_OFFRE_BANNER_URL',true)
        ]);

        return $this->display(__FILE__, 'offre.tpl');
    }
}
