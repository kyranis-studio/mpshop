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

class Mp_shift_clock extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'mp_shift_clock';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'wael zekri';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Shift Clock');
        $this->description = $this->l('A module to display shift time in front office');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
		Configuration::updateValue('MP_SHIFT_CLOCK_DOUBLE_SHIFT', true);
        Configuration::updateValue('MP_SHIFT_CLOCK_FIRST','09:00-14:00');
        Configuration::updateValue('MP_SHIFT_CLOCK_SECOND','15:00-18:00');
		Configuration::updateValue('MP_SHIFT_CLOCK_SATURDAY','09:00-15:00');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayFooter');
    }

    public function uninstall()
    {
        Configuration::deleteByName('MP_SHIFT_CLOCK_DOUBLE_SHIFT');
		Configuration::deleteByName('MP_SHIFT_CLOCK_FIRST');
		Configuration::deleteByName('MP_SHIFT_CLOCK_SECOND');
		Configuration::deleteByName('MP_SHIFT_CLOCK_SATURDAY');

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
        if (((bool)Tools::isSubmit('submitMp_shift_clockModule')) == true) {
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
        $helper->submit_action = 'submitMp_shift_clockModule';
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
		$form_fields = array();
		$form_fields[]['form'] = array(
                'legend' => array(
                'title' => $this->l('Lundi Vendredi'),
                'icon' => 'icon-time',
                ),
                'input' => array(
                    array(
						'id'=>'shift-toggle',
                        'type' => 'switch',
                        'label' => $this->l('Séance'),
                        'name' => 'MP_SHIFT_CLOCK_DOUBLE_SHIFT',
                        'is_bool' => true,
                        'desc' => $this->l('Séance'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Double séance')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Séance unique')
                            )
                        ),
                    ),
                    array(
						'id'=>'morning',
                        'type' => 'time',
                        'name' => 'MP_SHIFT_CLOCK_FIRST',
                        'label' => $this->l('Matain'),
                    ),
                    array(
						'id'=>'afternoon',
                        'type' => 'time',
                        'name' => 'MP_SHIFT_CLOCK_SECOND',
                        'label' => $this->l('Soir'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            );
			$form_fields[]['form'] = array(
                'legend' => array(
                'title' => $this->l('Samedi'),
                'icon' => 'icon-time',
                ),
                'input' => array(
                    array(
						'id'=>'saturday',
                        'type' => 'time',
                        'name' => 'MP_SHIFT_CLOCK_SATURDAY',
                        'label' => $this->l('Matain'),
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            );
			$firstShift = Configuration::get('MP_SHIFT_CLOCK_FIRST');
			$firstShift = explode("-", $firstShift);
			$secondShift = Configuration::get('MP_SHIFT_CLOCK_SECOND');
			$secondShift = $secondShift = explode("-", $secondShift);
			$saturdayShift = Configuration::get('MP_SHIFT_CLOCK_SATURDAY');
			$saturdayShift = explode("-", $saturdayShift);
			$this->context->smarty->assign([
				'doubleSeance'=>Configuration::get('MP_SHIFT_CLOCK_DOUBLE_SHIFT'),
				'starMorning' => $firstShift[0],
				'endMorning' => $firstShift[1],
				'starAfternoon' => $secondShift[0],
				'endAfternoon' => $secondShift[1] ,
				'starSaturday' => $saturdayShift[0],
				'endSaturday' => $saturdayShift[1],
			]);
        return $form_fields;
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'MP_SHIFT_CLOCK_DOUBLE_SHIFT' => Configuration::get('MP_SHIFT_CLOCK_DOUBLE_SHIFT', true),
            'MP_SHIFT_CLOCK_FIRST' => Configuration::get('MP_SHIFT_CLOCK_FIRST'),
            'MP_SHIFT_CLOCK_SECOND' => Configuration::get('MP_SHIFT_CLOCK_SECOND'),
			'MP_SHIFT_CLOCK_SATURDAY'=> Configuration::get('MP_SHIFT_CLOCK_SATURDAY')
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
		Tools::clearSmartyCache('clock.tpl');
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
  
		
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
		$this->context->controller->addCSS($this->_path.'/views/css/fontello-embedded.css');
    }

    public function hookDisplayFooter()
    {
        /* Place your code here. */
		$firstShift = Configuration::get('MP_SHIFT_CLOCK_FIRST');
		$firstShift = explode("-", $firstShift);
		$secondShift = Configuration::get('MP_SHIFT_CLOCK_SECOND');
		$secondShift = $secondShift = explode("-", $secondShift);
		$pause = $firstShift[1].'-'.$secondShift[0];
		$doubleShift = Configuration::get('MP_SHIFT_CLOCK_DOUBLE_SHIFT', true);
		$fsStartDeg = $this->calculateDeg($firstShift[0]) . 'deg';
		$pauseStartDeg = $this->calculateDeg($firstShift[1]) . 'deg';
		$ssStartDeg = $this->calculateDeg($secondShift[0]) . 'deg';
		$pauseStartProg = $this->shiftDuration($firstShift) ;
		$pauseEndProg = $pauseStartProg + $this->shiftDuration(array($firstShift[1],$secondShift[0]));
		$ssEndShiftProg = $pauseEndProg + $this->shiftDuration($secondShift);
		if(date("l") == 'Saturday'){
			$firstShift = Configuration::get('MP_SHIFT_CLOCK_SATURDAY');
			$pauseStartProg = $this->shiftDuration(explode("-", $firstShift));
		}else{
			$firstShift = Configuration::get('MP_SHIFT_CLOCK_FIRST');
		}
		$this->context->smarty->assign([
			'doubleShift' => Configuration::get('MP_SHIFT_CLOCK_DOUBLE_SHIFT', true),
            'firstShift' => $firstShift,
			'pause' => $pause,
            'secondShift' => Configuration::get('MP_SHIFT_CLOCK_SECOND'),
			'saturdayShift'=> Configuration::get('MP_SHIFT_CLOCK_SATURDAY'),
			'fsStartDeg'=>$fsStartDeg ,
			'pauseStartDeg'=>$pauseStartDeg ,
			'ssStartDeg'=>$ssStartDeg ,
			'pauseStartProg'=>$pauseStartProg / 12,
			'pauseEndProg'=>$pauseEndProg / 12,
			'ssEndShiftProg'=>$ssEndShiftProg / 12,
			'saturday'=> date("l") == 'Saturday',
			'sunday'=> date("l") == 'Sunday',
		]);
		return $this->display(__FILE__, 'clock.tpl');
    }
	
	public function calculateDeg($shift){
		$shiftArray = explode(":",$shift);
		$h = intval($shiftArray[0]);
		$deg = 0;
		if($h < 12){
			$deg = ((12 - $h) / -12 * 360);
		}else{
			$deg = ($h/12 * 360);
		}
		if($deg > 360){
			return fmod($deg , 360) ;
		}
		return $deg;
	}
	
	public function shiftDuration($shift){
		$start = intval($shift[0]);
		$end = intval($shift[1]);
		if($start < 12){
			$duration = 12 - $start + $end - 12;
		}else{
			$duration = $end - $start;
		}
		return $duration;
	}
}
