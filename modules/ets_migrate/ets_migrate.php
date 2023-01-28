<?php
/**
 * 2007-2021 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 web site only.
 * If you want to use this file on more web sites (or projects), you need to purchase additional licenses.
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
 * @license    Valid for 1 web site (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
if (!class_exists('EMApi')) {
    require_once dirname(__FILE__) . '/classes/EMApi.php';
}
if (!class_exists('EMTools')) {
    require_once dirname(__FILE__) . '/classes/EMTools.php';
}
if (!class_exists('EMDataImport')) {
    require_once dirname(__FILE__) . '/classes/EMDataImport.php';
}

class Ets_migrate extends Module
{
    // static:
    static $currentIndex;
    static $_configs;
    static $ignore_configs = [
        'ETS_EM_PROCESS_MIGRATION',
        'ETS_EM_MIGRATION_DONE'
    ];

    // private:
    private $prestashop_15;
    private $content;

    public function __construct()
    {
        $this->name = 'ets_migrate';
        $this->tab = 'front_office_features';
        $this->version = '4.1.8';
        $this->author = 'ETS-Soft';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->module_key = '44fa773de0e2ee30ecce1925be276a02';
        parent::__construct();

        $this->displayName = $this->l('Migration 4.0');
        $this->description = $this->l('Best module to migrate or upgrade PrestaShop 1.3, 1.4, 1.5, 1.6 to PrestaShop 1.7 or migrate data between PrestaShop websites (any version) within seconds!');
        $this->ps_versions_compliancy = array('min' => '1.5.0.0', 'max' => '1.7.99.9999');
        $this->prestashop_15 = version_compare(_PS_VERSION_, '1.5.0.0', '>=') && version_compare(_PS_VERSION_, '1.6.0.0', '<') ? 1 : 0;
    }

    const _INSTALL_SQL_FILE = 'install.sql';

    public function _initTabs($uninstall = false)
    {
        $prefix = 'AdminETSEM';
        $tabs = [
            [
                'class_name' => 'Migrate',
                'origin' => 'Ajax - Migrate controller',
                'name' => $this->l('Ajax - Migrate controller'),
                'active' => 0
            ],
            [
                'class_name' => 'Download',
                'origin' => 'Ajax - Download controller',
                'name' => $this->l('Ajax - Download controller'),
                'active' => 0
            ],
        ];
        if (count($tabs) > 0) {
            $languages = Language::getLanguages(false);
            foreach ($tabs as $t) {
                if (!isset($t['class_name']) ||
                    trim($t['class_name']) == ''
                ) {
                    continue;
                }
                $tab = Tab::getInstanceFromClassName($t['class_name']);
                if (!$uninstall && $tab->id <= 0) {
                    $tab = new Tab();
                    $tab->active = 1;
                    $tab->class_name = $prefix . $t['class_name'];
                    $tab->name = array();
                    if (is_array($languages) && count($languages) > 0) {
                        foreach ($languages as $l) {
                            $tab->name[$l['id_lang']] = $this->getTrans($t['origin'], $l['iso_code']);
                        }
                    }
                    $tab->id_parent = 0;
                    $tab->active = $t['active'];
                    $tab->module = $this->name;
                    if (!$tab->add())
                        return false;
                } elseif ($uninstall && $tab->id > 0 && !$tab->delete())
                    return false;
            }
        }

        return true;
    }

    public function install()
    {
        if (!$this->executeSQL(self::_INSTALL_SQL_FILE))
            return false;
        // Prepare tab
        return
            parent::install()
            && $this->_initHooks()
            && $this->_initTabs()
            && $this->_initConfigs();
    }

    const _UNINSTALL_SQL_FILE = 'uninstall.sql';

    public function uninstall()
    {
        if (!$this->executeSQL(self::_UNINSTALL_SQL_FILE))
            return false;
        return
            $this->_initTabs(true)
            && parent::uninstall()
            && $this->_initHooks(true)
            && $this->_initConfigs(true);
    }

    static $HOOKs = [
        'header',
        'backOfficeHeader',
        'displayBackOfficeHeader',
        'displayHeader'
    ];

    public function _initHooks($unregister = false)
    {
        if (self::$HOOKs) {
            foreach (self::$HOOKs as $hook) {
                if (!$unregister && !$this->registerHook($hook) || $unregister && !$this->unregisterHook($hook)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function executeSQL($sql_file)
    {
        if (!file_exists(($dest = dirname(__FILE__) . '/sql/' . $sql_file))) {
            return false;
        } elseif (!$sql = Tools::file_get_contents($dest)) {
            return false;
        }
        $sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
        if ($sql) {
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }
        }

        return true;
    }

    public function _initConfigs($uninstall = false)
    {
        if ($configs = $this->getConfigs()) {
            $languages = [];
            foreach ($configs as $key => $config) {
                if ($uninstall) {
                    if (!Configuration::deleteByName($key)) {
                        return false;
                    }
                } else {
                    if (!count($languages)) {
                        $languages = Language::getLanguages(false);
                    }
                    $global = isset($config['global']) && $config['global'] ? 1 : 0;
                    if (isset($config['lang']) && $config['lang']) {
                        $values = array();
                        foreach ($languages as $l) {
                            $values[$l['id_lang']] = isset($config['default']) ? $config['default'] : '';
                        }
                        $this->setFields($key, $global, $values, true);
                    } else {
                        $this->setFields($key, $global, isset($config['default']) ? $config['default'] : '', true);
                    }
                }
            }
        }

        return true;
    }

    public function getConfigs($partial = null)
    {
        if (!self::$_configs) {
            $values = array(
                array(
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Enabled'),
                ),
                array(
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->l('Disabled'),
                ),
            );
            $suppliers_array = [
                [
                    'id_supplier' => 0,
                    'name' => $this->l('None')
                ]
            ];
            if ($suppliers = Supplier::getSuppliers()) {
                foreach ($suppliers as $supplier) {
                    $suppliers_array[] = [
                        'id_supplier' => (int)$supplier['id_supplier'],
                        'name' => trim($supplier['name'])
                    ];
                }
            }
            $manufacturers_array = [
                [
                    'id_manufacturer' => 0,
                    'name' => $this->l('None')
                ]
            ];
            if ($manufacturers = Manufacturer::getManufacturers()) {
                foreach ($manufacturers as $manu) {
                    $manufacturers_array[] = [
                        'id_manufacturer' => (int)$manu['id_manufacturer'],
                        'name' => trim($manu['name'])
                    ];
                }
            }
            $domain = Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE') ? Tools::getShopDomainSsl() : Tools::getShopDomain();
            self::$_configs = array(
                'ETS_EM_DOMAIN' => array(
                    'type' => 'text',
                    'label' => $this->l('Source store URL'),
                    'name' => 'ETS_EM_DOMAIN',
                    'hint' => $this->l('Enter source store URL (home page URL of the source store) including http:// or https://'),
                    'required' => true,
                    'global' => true,
                    'step' => '1',
                    'regex' => [
                        [
                            'pattern' => '/^(http(?:|s)):\/\/.+?$/',
                            'bool' => true,
                            'error' => $this->l('Please enter complete url with http://  or https://'),
                        ],
                        [
                            'pattern' => '/^(http(?:|s)):\/\/' . str_replace('/', '\/', $domain . rtrim(__PS_BASE_URI__, '/')) . '\/?$/',
                            'bool' => false,
                            'error' => $this->l('Source store and target store could not be the same!'),
                        ]
                    ],
                    'placeholder' => $this->l('https://your-store.com/'),
                ),
                'ETS_EM_ACCESS_TOKEN' => array(
                    'type' => 'text',
                    'label' => $this->l('Access token'),
                    'required' => true,
                    'name' => 'ETS_EM_ACCESS_TOKEN',
                    'hint' => $this->l('Copy Access token from "PrestaShop Connector" installed on the source store'),
                    'global' => true,
                    'step' => '1',
                    'placeholder' => $this->l('See on "PrestaShop Connector" module'),
                ),
                'ETS_EM_DATA_TO_MIGRATE' => array(
                    'type' => 'checkboxes',
                    'label' => $this->l('Data to migrate'),
                    'name' => 'ETS_EM_DATA_TO_MIGRATE',
                    'global' => true,
                    'group_title' => $this->l('Migration options'),
                    'step' => '2',
                ),
                'ETS_EM_KEEP_ALL_ID' => array(
                    'type' => $this->prestashop_15 ? 'radio' : 'switch',
                    'is_bool' => true,
                    'label' => $this->l('Keep IDs'),
                    'name' => 'ETS_EM_KEEP_ALL_ID',
                    'values' => $values,
                    'default' => 1,
                    'desc' => $this->l('Keep ID of data entities such as product IDs, customer, IDs, etc.'),
                    'global' => true,
                    'group' => 'option',
                    'form_group_class' => 'ets_em_keep_all_id ets_migrate_option',
                    'group_title' => $this->l('Migration options'),
                    'step' => '2',
                ),
                'ETS_EM_DELETE_ALL' => array(
                    'type' => $this->prestashop_15 ? 'radio' : 'switch',
                    'is_bool' => true,
                    'label' => $this->l('Delete data before migration'),
                    'name' => 'ETS_EM_DELETE_ALL',
                    'values' => $values,
                    'default' => 0,
                    'desc' => $this->l('Delete selected data entities on target store before migration'),
                    'global' => true,
                    'form_group_class' => 'ets_em_delete_all ets_migrate_option',
                    'group' => 'option',
                    'step' => '2',
                ),
                'ETS_EM_MIGRATE_IMAGES' => array(
                    'type' => 'radio',
                    //'is_bool' => true,
                    'label' => $this->l('How to migrate images?'),
                    'name' => 'ETS_EM_MIGRATE_IMAGES',
                    'form_group_class' => 'group-images ets_em_migrate_images ets_migrate_option',
                    'global' => true,
                    'group' => 'option',
                    'values' => array(
                        array(
                            'id' => 'migrate_images_auto',
                            'value' => 'auto',
                            'label' => $this->l('Automatically migrate images (will take more time)'),
                        ),
                        array(
                            'id' => 'migrate_images_manual',
                            'value' => 'manual',
                            'label' => $this->l('Manually copy images to target site when database migration completed'),
                        ),
                    ),
                    'default' => 'auto',
                    'step' => '2',
                    'image' => true,
                ),
                'ETS_EM_GENE_PRODUCT_THUMBNAIL' => array(
                    'type' => 'radio',
                    //'is_bool' => true,
                    'label' => $this->l('How to generate product thumbnail images?'),
                    'name' => 'ETS_EM_GENE_PRODUCT_THUMBNAIL',
                    'form_group_class' => 'group-images ets_em_gene_product_thumbnail ets_migrate_option',
                    'global' => true,
                    'group' => 'option',
                    'values' => array(
                        array(
                            'id' => 'product_thumbnail_auto',
                            'value' => 'auto',
                            'label' => $this->l('Automatically generate thumbnail images (will take more time)'),
                        ),
                        array(
                            'id' => 'product_thumbnail_manual',
                            'value' => 'manual',
                            'label' => $this->l('Manually generate thumbnail images when migration completed'),
                        ),
                    ),
                    'default' => 'auto',
                    'step' => '2',
                    'image' => true,
                ),
                'ETS_EM_MIGRATE_IMAGE_SPEED' => array(
                    'type' => 'text',
                    'label' => $this->l('Images migrated per request'),
                    'name' => 'ETS_EM_MIGRATE_IMAGE_SPEED',
                    'validate' => 'isUnsignedInt',
                    'form_group_class' => 'group-images ets_em_migrate_image_speed ets_migrate_option',
                    'col' => 4,
                    'default' => 5,
                    'group' => 'option',
                    'global' => true,
                    'suffix' => $this->l('Item(s)'),
                    'step' => '2',
                    'image' => true,
                    'partial' => 'speed',
                ),
                'ETS_EM_ATTACHMENTS_FILES' => array(
                    'type' => 'radio',
                    //'is_bool' => true,
                    'label' => $this->l('How to migrate attachments & files?'),
                    'name' => 'ETS_EM_ATTACHMENTS_FILES',
                    'form_group_class' => 'group-files ets_em_attachments_files ets_migrate_option',
                    'global' => true,
                    'group' => 'option',
                    'values' => array(
                        array(
                            'id' => 'attachments_files_auto',
                            'value' => 'auto',
                            'label' => $this->l('Automatically migrate attachments & files (will take more time)'),
                        ),
                        array(
                            'id' => 'attachments_files_manual',
                            'value' => 'manual',
                            'label' => $this->l('Manually copy attachments & files to target site when database migration completed'),
                        ),
                    ),
                    'default' => 'auto',
                    'step' => '2',
                    'file' => true,
                ),
                'ETS_EM_ATTACHMENTS_FILES_SPEED' => array(
                    'type' => 'text',
                    'label' => $this->l('Attachments & files migrated per request'),
                    'name' => 'ETS_EM_ATTACHMENTS_FILES_SPEED',
                    'validate' => 'isUnsignedInt',
                    'form_group_class' => 'group-files ets_em_attachments_files_speed ets_migrate_option',
                    'col' => 4,
                    'default' => 5,
                    'group' => 'option',
                    'global' => true,
                    'suffix' => $this->l('Item(s)'),
                    'step' => '2',
                    'file' => true,
                    'partial' => 'speed',
                ),
                'ETS_EM_MIGRATE_EMPTY_CART' => array(
                    'type' => $this->prestashop_15 ? 'radio' : 'switch',
                    'is_bool' => true,
                    'label' => $this->l('Migrate empty shopping carts?'),
                    'name' => 'ETS_EM_MIGRATE_EMPTY_CART',
                    'form_group_class' => 'ets_em_migrate_empty_cart ets_migrate_option',
                    'values' => $values,
                    'default' => 1,
                    'group' => 'option',
                    'global' => true,
                    'step' => '2',
                ),
                'ETS_EM_SUPPLIER_DEFAULT' => array(
                    'type' => 'select',
                    'label' => $this->l('Default Supplier'),
                    'name' => 'ETS_EM_SUPPLIER_DEFAULT',
                    'options' => array(
                        'query' => $suppliers_array,
                        'id' => 'id_supplier',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'ets_migrate_option ets_em_supplier_default',
                    'global' => true,
                    'step' => '2',
                    'field' => 'id_supplier',
                ),
                'ETS_EM_MANUFACTURER_DEFAULT' => array(
                    'type' => 'select',
                    'label' => $this->l('Default Manufacturer'),
                    'name' => 'ETS_EM_MANUFACTURER_DEFAULT',
                    'options' => array(
                        'query' => $manufacturers_array,
                        'id' => 'id_manufacturer',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'ets_migrate_option ets_em_manufacturer_default',
                    'global' => true,
                    'step' => '2',
                    'field' => 'id_manufacturer',
                ),
                'ETS_EM_MIGRATE_SPEED' => array(
                    'type' => 'range',
                    'label' => $this->l('Items migrated per request'),
                    'name' => 'ETS_EM_MIGRATE_SPEED',
                    'validate' => 'isUnsignedInt',
                    'default' => 5000,
                    'min' => 100,
                    'max' => 9900,
                    'col' => 7,
                    'form_group_class' => 'ets_range_speed ets_migrate_option',
                    'group_title' => $this->l('Migration speed'),
                    'global' => true,
                    'step' => '2',
                    'partial' => 'speed',
                ),
                'ETS_NEW_COOKIE_KEY' => array(
                    'type' => 'hidden',
                    'label' => $this->l('Migration cookie key'),
                    'form_group_class' => 'ets_migrate_option',
                    'name' => 'ETS_NEW_COOKIE_KEY',
                    'global' => true,
                    'step' => '2',
                ),
                'ETS_EM_MIGRATE_VERSION' => array(
                    'type' => 'hidden',
                    'label' => $this->l('Migration version'),
                    'form_group_class' => 'ets_migrate_option',
                    'name' => 'ETS_EM_MIGRATE_VERSION',
                    'global' => true,
                    'step' => '2',
                ),
                'ETS_EM_PROCESS_MIGRATION' => array(
                    'type' => 'html',
                    'label' => $this->l('Process migration'),
                    'name' => 'ETS_EM_PROCESS_MIGRATION',
                    'step' => '3',
                ),
                'ETS_EM_MIGRATION_DONE' => array(
                    'type' => 'html',
                    'label' => $this->l('Done!!!'),
                    'name' => 'ETS_EM_MIGRATION_DONE',
                    'step' => '4',
                ),
            );
        }
        if (trim($partial) !== '') {
            $fields_set = [];
            foreach (self::$_configs as $key => $config) {
                if (isset($config['partial']) && trim($config['partial']) === trim($partial)) {
                    $fields_set[$key] = $config;
                }
            }
            return $fields_set;
        }

        return self::$_configs;
    }

    public function loadFieldsDefault()
    {
        $fields = [];
        if ($configs = $this->getConfigs()) {
            foreach ($configs as $key => $config) {
                if (isset($config['field']) && trim($config['field']) !== '') {
                    $fields[$config['field']] = Configuration::getGlobalValue($key);
                }
            }
        }
        return $fields;
    }

    public function getContent()
    {
        self::$currentIndex = $this->getAdminLink('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $this->setDisplayHeader();
        $this->renderForm();

        return $this->content;
    }

    public function getAdminLink($controller, $token = null)
    {
        return version_compare(_PS_VERSION_, '1.5.0.0', '<') ? 'index.php?tab=' . $controller . '&token=' . (trim($token) !== '' ? $token : trim(Tools::getValue('token'))) : $this->context->link->getAdminLink($controller);
    }

    static $youtube_links = [
        'en' => 'https://youtu.be/O4dhYrsKDVw',
        'es' => 'https://youtu.be/MXjw5qVrjqE',
        'fr' => 'https://youtu.be/9s0KIc6q7RA',
        'it' => 'https://youtu.be/4fJ4zxGQHi0',
    ];

    public function renderForm($partial = null)
    {
        if ($configs = $this->getConfigs($partial)) {
            $fields_form_1 = array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Migrate'),
                        'icon' => 'icon-AdminAdmin',
                    ),
                    'input' => $configs,
                ),
            );
            $helper = new HelperForm();
            $helper->show_toolbar = false;
            $helper->table = $this->table;
            $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper->default_form_language = $lang->id;
            $helper->module = $this;
            $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
            $helper->identifier = $this->identifier;
            $helper->submit_action = 'submitConfig';
            $helper->currentIndex = self::$currentIndex;
            $helper->token = $this->context->controller->token;
            $helper->tpl_vars = array(
                'fields_value' => $this->getFieldsValues($helper->submit_action, $partial),
                'languages' => $this->context->controller->getLanguages(),
                'id_language' => $this->context->language->id,
                'img_path' => $this->_path . 'views/img/',
                'steps' => [
                    'step1' => $this->l('Source'),
                    'step2' => $this->l('Migration options'),
                    'step3' => $this->l('Process migration'),
                    'step4' => $this->l('Done!!! Enjoy your new site'),
                ],
                'current_step' => (int)Tools::getValue('current_step', 1),
                'resources' => EMApi::getInstance()->getResources(null, true),
                'PS_ROOT_DIR' => _PS_ROOT_DIR_,
                'download_plugin_link' => $this->getAdminLink('AdminETSEMDownload', Tools::getAdminTokenLite('AdminETSEMDownload')),
                'page_index' => $this->context->link->getPageLink('index'),
                'support_link' => isset($this->refs) && $this->refs && preg_match('/^https?:\/\/.+$/', $this->refs) ? rtrim($this->refs, '/') . '/en/support/contact-us' : 'https://addons.prestashop.com/en/contact-us?id_product=32298',
                'document_file' => 'readme_' . (@file_exists(dirname(__FILE__) . '/docs/readme_' . ($iso_code = Tools::strtolower($this->context->language->iso_code)) . '.pdf') ? $iso_code : 'en') . '.pdf',
                'partial' => $partial,
                'product_thumb_link' => $this->getAdminLink('AdminImages', Tools::getAdminTokenLite('AdminImages')),
                'prestashop_15' => $this->prestashop_15,
                'youtube_link' => isset(self::$youtube_links[$iso_code]) ? self::$youtube_links[$iso_code] : self::$youtube_links['en'],
            );
            $import = EMDataImport::getInstance()->init();
            if ($import->getMigrated()) {
                $infos = $import->getDataInfos();
                $infos['confirm'] = 1;
                $infos['migrate'] = $this->processMigrate('migrate');
                $helper->tpl_vars['current_step'] = 2;
                $helper->tpl_vars['infos'] = $infos;
            }
            $html = $helper->generateForm(array($fields_form_1));
            if ($partial) {
                return $html;
            }
            $this->content .= $html;
        }
    }

    public function getFieldsValues($submit_action = '', $partial = null)
    {
        $fields = array();
        if ($configs = $this->getConfigs($partial)) {
            $languages = Language::getLanguages(false);
            if (trim($submit_action) !== '' && Tools::isSubmit($submit_action)) {
                foreach ($configs as $config) {
                    $key = $config['name'];
                    if (isset($config['lang']) && $config['lang']) {
                        foreach ($languages as $l) {
                            $fields[$key][$l['id_lang']] = Tools::getValue($key . '_' . $l['id_lang'], isset($config['default']) ? $config['default'] : '');
                        }
                    } elseif ($config['type'] == 'select' && isset($config['multiple']) && $config['multiple']) {
                        $fields[$key . ($config['type'] == 'select' ? '[]' : '')] = Tools::getValue($key, array());
                    } elseif ($config['type'] == 'group' || $config['type'] == 'checkboxes') {
                        $fields[$key] = Tools::getValue($key, array());
                    } else
                        $fields[$key] = Tools::getValue($key, isset($config['default']) ? $config['default'] : '');
                }
            } else {
                foreach ($configs as $config) {
                    $key = $config['name'];
                    $global = !empty($config['global']) ? 1 : 0;
                    if (isset($config['lang']) && $config['lang']) {
                        foreach ($languages as $l) {
                            $fields[$key][$l['id_lang']] = $this->getFields($key, $global, $l['id_lang'], isset($config['default']) ? $config['default'] : '');
                        }
                    } elseif ($config['type'] == 'select' && isset($config['multiple']) && $config['multiple']) {
                        $fields[$key . ($config['type'] == 'select' ? '[]' : '')] = ($result = $this->getFields($key, $global)) != '' ? explode(',', $result) : array();
                    } elseif ($config['type'] == 'group' || $config['type'] == 'checkboxes') {
                        $fields[$key] = ($result = $this->getFields($key, $global)) != '' ? explode(',', $result) : array();
                    } else
                        $fields[$key] = $this->getFields($key, $global, null, isset($config['default']) ? $config['default'] : '');
                }
            }
        }

        return $fields;
    }

    public function getFields($key, $global = false, $idLang = null, $default = '')
    {
        return Configuration::hasKey($key, $idLang, $global ? null : $this->context->shop->id_shop_group, $global ? null : $this->context->shop->id) ? ($global ? Configuration::getGlobalValue($key, $idLang) : Configuration::get($key, $idLang)) : $default;
    }

    public function _postConfig()
    {
        $partial = trim(Tools::getValue('partial'));

        if ($configs = $this->getConfigs($partial)) {
            $languages = Language::getLanguages(false);
            $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
            foreach ($configs as $key => $config) {
                if (in_array($key, self::$ignore_configs))
                    continue;
                if (isset($config['lang']) && $config['lang']) {
                    if (isset($config['required'])
                        && $config['required']
                        && $config['type'] != 'switch'
                        && trim(Tools::getValue($key . '_' . $id_lang_default) == '')
                    ) {
                        $this->_errors[] = $config['label'] . ' ' . $this->l('is required');
                    }
                } else {
                    if (isset($config['required'])
                        && $config['required']
                        && $config['type'] != 'switch'
                        && trim(Tools::getValue($key) == '')
                    ) {
                        $this->_errors[] = $config['label'] . ' ' . $this->l('is required');
                    } elseif (isset($config['regex'])
                        && is_array($config['regex'])
                        && count($config['regex']) > 0
                    ) {
                        foreach ($config['regex'] as $regex) {
                            if (isset($regex['bool'])
                                && isset($regex['pattern'])
                                && trim($regex['pattern']) !== ''
                            ) {
                                if ($regex['bool'] && !preg_match($regex['pattern'], trim(Tools::getValue($key))) || !$regex['bool'] && preg_match($regex['pattern'], trim(Tools::getValue($key)))) {
                                    $this->_errors[] = $config['label'] . ' ' . (isset($regex['error']) ? $regex['error'] : $this->l('invalid'));
                                }
                            }
                        }
                    } elseif (isset($config['validate'])
                        && method_exists('Validate', $config['validate'])
                    ) {
                        $validate = $config['validate'];
                        if (!Validate::$validate(trim(Tools::getValue($key))))
                            $this->_errors[] = $config['label'] . ' ' . $this->l('is invalid');
                        unset($validate);
                    } elseif ($config['type'] !== 'checkboxes'
                        && !Validate::isCleanHtml(trim(Tools::getValue($key)))
                    ) {
                        $this->_errors[] = $config['label'] . ' ' . $this->l('is invalid');
                    }
                }
            }
            if (!$this->_errors) {
                foreach ($configs as $key => $config) {
                    if (in_array($key, self::$ignore_configs))
                        continue;
                    $global = isset($config['global']) && $config['global'] ? 1 : 0;
                    if (isset($config['lang']) && $config['lang']) {
                        $values = array();
                        foreach ($languages as $lang) {
                            if ($config['type'] == 'switch')
                                $values[$lang['id_lang']] = (int)trim(Tools::getValue($key . '_' . $lang['id_lang'])) ? 1 : 0;
                            else
                                $values[$lang['id_lang']] = trim(Tools::getValue($key . '_' . $lang['id_lang'])) ? trim(Tools::getValue($key . '_' . $lang['id_lang'])) : trim(Tools::getValue($key . '_' . $id_lang_default));
                        }
                        $this->setFields($key, $global, $values, true);
                    } else {
                        if ($config['type'] == 'switch') {
                            $this->setFields($key, $global, (int)trim(Tools::getValue($key)) ? 1 : 0, true);
                        } elseif ($config['type'] == 'checkboxes' || $config['type'] == 'select' && isset($config['multiple']) && $config['multiple']) {
                            $this->setFields($key, $global, implode(',', Tools::getValue($key, array())), true);
                        } else {
                            $this->setFields($key, $global, trim(Tools::getValue($key)), true);
                        }
                    }
                }

                if (trim($partial) === '') {
                    $import = EMDataImport::getInstance();
                    $migrate_data = $import->getDataToMigrate();

                    // Sort:
                    if (is_array($migrate_data)
                        && count($migrate_data) > 0
                        && ($resources = EMApi::getInstance()->getResources())
                        && is_array($resources)
                        && count($resources) > 0
                    ) {
                        $data_sort = [];
                        foreach ($resources as $task => $resource) {
                            if (is_array($resource)
                                && in_array($task, $migrate_data)
                            ) {
                                $data_sort[] = $task;
                            }
                        }
                        $import->setDataToMigrate($data_sort);
                    }

                    // Mapping shops if import multi shops:
                    if ($shops = trim(Tools::getValue('ETS_EM_SHOPS_MAPPING'))) {
                        $shops = explode(',', $shops);
                        if ($shops) {
                            $shops_mapping = [];
                            foreach ($shops as $shop) {
                                $id_target_shop = Tools::getValue('id_shop_target_' . $shop);
                                if (trim($id_target_shop) !== '' && $id_target_shop >= 0) {
                                    $shops_mapping[(int)Tools::getValue('id_shop_source_' . $shop)] = $id_target_shop;
                                }
                            }
                            EMDataImport::mappingShops($shops_mapping);
                        }
                    } else {
                        EMDataImport::cleanShopsMapping();
                    }

                    // Migrate Images & Files:
                    $migrate_data = $import->getDataToMigrate();
                    $infos = $import->getDataInfos();
                    $images = [];
                    $files = [];
                    if (is_array($migrate_data)
                        && count($migrate_data) > 0
                    ) {
                        foreach ($migrate_data as $data) {
                            $res = EMApi::getInstance()->getResources($data);
                            // Images:
                            if (isset($res['images']) &&
                                count($res['images']) > 0
                            ) {
                                $images += $res['images'];
                            }
                            // Attachments & Files:
                            if (isset($res['files']) &&
                                count($res['files']) > 0
                            ) {
                                $files += $res['files'];
                            }
                        }
                    }
                    $import
                        ->setMigrateImages($images)
                        ->setMigrateFiles($files);

                    // Images:
                    if (count($images) > 0
                        && isset($infos['images'])
                        && (int)$infos['images'] > 0
                        && ((int)Configuration::getGlobalValue('ETS_EM_KEEP_ALL_ID') <= 0 || trim(Configuration::getGlobalValue('ETS_EM_MIGRATE_IMAGES')) === 'auto')
                    ) {
                        $import->setDataToMigrate('images');
                    }

                    // Attachments & Files:
                    if (count($files) > 0
                        && isset($infos['files'])
                        && (int)$infos['files'] > 0
                        && trim(Configuration::getGlobalValue('ETS_EM_ATTACHMENTS_FILES')) === 'auto'
                    ) {
                        $import->setDataToMigrate('files');
                    }

                    // Finished:
                    $info_name = 'finished';
                    $info = $import->getDataInfos($info_name);
                    $info['nb'] = $info['nb_group_table'] = (int)EMTools::fetch('product');
                    $import
                        ->setDataToMigrate($info_name)
                        ->setDataInfos($info, $info_name);
                }
            }

            if (count($this->_errors)) {
                die(json_encode([
                    'errors' => Tools::nl2br(implode(PHP_EOL, $this->_errors)),
                ]));
            }
        }
    }

    public function setFields($key, $global, $values, $html = false)
    {
        return $global ? Configuration::updateGlobalValue($key, $values, $html) : Configuration::updateValue($key, $values, $html);
    }

    public function processMigrate($type = 'all')
    {
        $data = EMDataImport::getInstance();
        $tpl_vars = [
            'info' => $data->getDataInfos(),
            'configs' => $this->getConfigs(),
            'resources' => EMApi::getInstance()->getResources(null, true),
            'configs_value' => $this->getFieldsValues(),
        ];
        $this->smarty->assign($tpl_vars);
        $ret = [];
        $type = trim($type);
        if ($type === 'all' || $type === 'migrate') {
            $ETS_EM_SUPPLIER_DEFAULT = (int)Configuration::getGlobalValue('ETS_EM_SUPPLIER_DEFAULT');
            $ETS_EM_MANUFACTURER_DEFAULT = (int)Configuration::getGlobalValue('ETS_EM_MANUFACTURER_DEFAULT');
            $this->smarty->assign([
                'ETS_EM_SUPPLIER_DEFAULT' => $ETS_EM_SUPPLIER_DEFAULT > 0 ? Supplier::getNameById($ETS_EM_SUPPLIER_DEFAULT) : $this->l('None'),
                'ETS_EM_MANUFACTURER_DEFAULT' => $ETS_EM_MANUFACTURER_DEFAULT > 0 ? Manufacturer::getNameById($ETS_EM_MANUFACTURER_DEFAULT) : $this->l('None'),
            ]);
            $ret['migrate'] = $this->display(__FILE__, 'bo-migrate.tpl');
        }
        if ($type === 'all' || $type === 'process') {
            $data_to_import = $data->getDataToMigrate();
            $migrated_table = $data->getMigrated();
            $diff = array_diff($data_to_import, $migrated_table);
            $this->smarty->assign([
                'migrated_tables' => $migrated_table,
                'img_path' => $this->_path . 'views/img/',
                'count' => (int)$data->getCount(),
                'migrating' => is_array($diff) && count($diff) ? array_shift($diff) : '',
            ]);
            $ret['process'] = $this->display(__FILE__, 'bo-process-migrate.tpl');
        }
        return $type !== 'all' ? array_shift($ret) : $ret;
    }

    public function setDisplayHeader()
    {
        $js_files = [];
        if ($this->prestashop_15) {
            $js_files[] = $this->_path . 'views/js/jquery.growl.js';
        }
        $this->smarty->assign([
            'js_files' => array_merge(
                $js_files,
                [
                    $this->_path . 'views/js/back.js',
                    $this->_path . 'views/js/easytimer.min.js',
                ]
            ),
            'request_url' => $this->getAdminLink('AdminETSEMMigrate'),
        ]);
        $this->content .= $this->display(__FILE__, 'bo-header.tpl');
    }

    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            if ($this->prestashop_15) {
                $this->context->controller->addCSS($this->_path . 'views/css/jquery.growl.css');
                $this->context->controller->addCSS($this->_path . 'views/css/back_15.css');
            }
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        }
    }

    public function hookDisplayBackOfficeHeader()
    {
        $this->hookBackOfficeHeader();
    }

    public function getTrans($origin, $lang, $specific = null)
    {
        if (is_array($lang))
            $iso_code = $lang['iso_code'];
        elseif (is_object($lang))
            $iso_code = $lang->iso_code;
        else {
            $language = new Language($lang);
            $iso_code = $language->iso_code;
        }

        $files_by_priority = _PS_MODULE_DIR_ . $this->name . '/translations/' . $iso_code . '.' . 'php';

        if (!@file_exists($files_by_priority)) {
            return Tools::stripslashes($origin);
        }

        $string = preg_replace("/\\\*'/", "\'", $origin);
        $key = md5($string);
        $new_key = Tools::strtolower('<{' . $this->name . '}prestashop>' . ($specific ?: $this->name)) . '_' . $key;

        preg_match('/(\$_MODULE\[\'' . preg_quote($new_key) . '\'\]\s*=\s*\')(.*)(\';)/', Tools::file_get_contents($files_by_priority), $matches);

        if ($matches && isset($matches[2])) {
            return Tools::stripslashes($matches[2]);
        }

        return Tools::stripslashes($origin);
    }

    public function linkLocalizationPack($iso_code, $language_name)
    {
        $this->smarty->assign([
            'iso_code' => $iso_code,
            'language_name' => $language_name,
            'link' => $this->context->link->getAdminLink('AdminLocalization', true, ['route' => 'admin_localization_index'])
        ]);

        return $this->display(__FILE__, 'bo-localization-pack.tpl');
    }
}
