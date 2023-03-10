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

class Mp_google_map extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'mp_google_map';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'wael zekri';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Google Map');
        $this->description = $this->l('Display google map in website footer');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('MP_GOOGLE_MAP_URL','');
		Configuration::updateValue('MP_GOOGLE_MAP_TITLE','Notre Emplacement');
		Configuration::updateValue('MP_GOOGLE_MAP_HEIGHT',400);
		

        return parent::install() &&
            $this->registerHook('displayFooterAfter')&
			$this->registerHook('displayContactForm');
    }

    public function uninstall()
    {
        Configuration::deleteByName('MP_GOOGLE_MAP_URL');
		Configuration::deleteByName('MP_GOOGLE_MAP_TITLE');
		Configuration::deleteByName('MP_GOOGLE_MAP_HEIGHT');
		
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
        if (((bool)Tools::isSubmit('submitMp_google_mapModule')) == true) {
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
        $helper->submit_action = 'submitMp_google_mapModule';
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
						'type' => 'text',
						'desc' => $this->l('Titre du carte'),
						'name' => 'MP_GOOGLE_MAP_TITLE',
						'label' => $this->l('Titre'),
					),
                    array(
                        'type' => 'text',
                        'suffix' => '<a href="https://www.google.com/maps/about/mymaps/" target="_blank">Visite Google Map</a>',
                        'desc' => $this->l('Enter a map url'),
                        'name' => 'MP_GOOGLE_MAP_URL',
                        'label' => $this->l('URL'),
                    ),
					array(
                        'type' => 'text',
                        'desc' => $this->l('Enter la hauteur de la carte'),
                        'name' => 'MP_GOOGLE_MAP_HEIGHT',
                        'label' => $this->l('hauteur'),
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
            'MP_GOOGLE_MAP_URL' => Configuration::get('MP_GOOGLE_MAP_URL', true),
			'MP_GOOGLE_MAP_TITLE'=> Configuration::get('MP_GOOGLE_MAP_TITLE', true),
			'MP_GOOGLE_MAP_HEIGHT'=> Configuration::get('MP_GOOGLE_MAP_HEIGHT', true),
			
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }
  
    public function hookDisplayFooterAfter()
    {
        $this->context->smarty->assign([
			'title' => Configuration::get('MP_GOOGLE_MAP_TITLE', true),
			'mapUrl' => Configuration::get('MP_GOOGLE_MAP_URL', true),
			'height' => Configuration::get('MP_GOOGLE_MAP_HEIGHT', true),
        ]);

        return $this->display(__FILE__, 'map.tpl');
    }
	public function hookDisplayContactForm()
    {
        $this->context->smarty->assign([
			'title' => Configuration::get('MP_GOOGLE_MAP_TITLE', true),
			'mapUrl' => Configuration::get('MP_GOOGLE_MAP_URL', true),
			'height' => Configuration::get('MP_GOOGLE_MAP_HEIGHT', true)
        ]);

        return $this->display(__FILE__, 'map.tpl');
    }
	
}
