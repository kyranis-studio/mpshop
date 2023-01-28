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
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
class Mp_new_product extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'mp_new_product';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'wael zekri';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('New Products');
        $this->description = $this->l('Dispaly new products in front office');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('MP_NEW_PRODUCT_DISPALY_COUNT', 12);
		Configuration::updateValue('MP_NEW_PRODUCT_BANNER', '<p>Ajouter votre bannière</p>');
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        Configuration::deleteByName('MP_NEW_PRODUCT_DISPALY_COUNT');
		Configuration::deleteByName('MP_NEW_PRODUCT_BANNER');
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
		 if (((bool)Tools::isSubmit('submitMp_new_productModule')) == true) {
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
        $helper->submit_action = 'submitMp_new_productModule';
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
                ),'input' => array(
					array(
                        'type' => 'textarea',
                        'desc' => $this->l('Ajouter votre bannière'),
                        'name' => 'MP_NEW_PRODUCT_BANNER',
                        'label' => $this->l('bannière'),
						'class' =>  'rte',
						'autoload_rte' =>  true,
						'row' => 10,
                    ),
                    array(
                        'type' => 'text',
                        'desc' => $this->l('Nombre produits'),
                        'name' => 'MP_NEW_PRODUCT_DISPALY_COUNT',
                        'label' => $this->l('Nombre de produits a afficher'),
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
            'MP_NEW_PRODUCT_DISPALY_COUNT' => Configuration::get('MP_NEW_PRODUCT_DISPALY_COUNT',true),
			'MP_NEW_PRODUCT_BANNER' => Configuration::get('MP_NEW_PRODUCT_BANNER',true)
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key),true);
        }
    }


    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayFooter()
    {
        /* Place your code here. */
    }
	protected function getViewedProducts($productIds)
    {

        if (!empty($productIds)) {
            $assembler = new ProductAssembler($this->context);

            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(
                new ImageRetriever(
                    $this->context->link
                ),
                $this->context->link,
                new PriceFormatter(),
                new ProductColorsRetriever(),
                $this->context->getTranslator()
            );

            $products_for_template = array();

            if (is_array($productIds)) {
                foreach ($productIds as $productId) {
					$products_for_template[] = $presenter->present(
						$presentationSettings,
						$assembler->assembleProduct(array('id_product' => $productId)),
						$this->context->language
					);
                }
            }

            return $products_for_template;
        }

        return false;
    }
    public function hookDisplayHome()
    {
		global $cookie;
		$ids_array = array();
		$id_lang=(int)Context::getContext()->language->id;
		$limit = Configuration::get('MP_NEW_PRODUCT_DISPALY_COUNT',true);
		$order_by='id_product';
		$order_way='DESC';
		$all_products = Product::getProducts($id_lang, 0, $limit, $order_by, $order_way, $id_category = false, $only_active = true ,$context = null);
        /* Place your code here. */
		foreach ($all_products as $product) {
			array_push($ids_array, $product['id_product']);
		}
		try{
			$doc = new DOMDocument();
			$doc->loadHTML(Configuration::get('MP_NEW_PRODUCT_BANNER'));
			$bannerSrc =  $doc->getElementsByTagName('img')[0]->getAttribute('src');
		}catch(Exception $e){}
		$this->context->smarty->assign([
			'products'=>$this->getViewedProducts($ids_array),
			'bannerSrc' => $bannerSrc
		]);
		return $this->display(__FILE__, 'newproduct.tpl');
    }
}
