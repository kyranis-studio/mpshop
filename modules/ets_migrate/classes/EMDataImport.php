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

if (version_compare(_PS_VERSION_, '1.5.0.1', '<')) {
    require_once dirname(__FILE__) . '/DbQuery.php';
}

class EMDataImport
{
    // Cache init:
    static $_initialized = false;
    static $_INSTANCE;
    static $image_field_unique = '_img_exist';
    static $file_field_unique = '_file_exist';
    static $prefix = 'ETS_EM_';

    // Cache shop mapping:
    static $mapping_shop = [];
    static $source_shops = [];
    static $target_shops = [];
    static $domain_url;

    // Copied languages:
    static $languages = [];
    static $default_language;

    // Cache history and data info import:
    public $data_migrated = [];
    public $group_tables = [];
    public $data_to_migrate = [];
    public $data_infos = [];

    // Cache struct table import:
    public $migrate_fields = [];
    public $migrate_primary = [];
    public $migrate_schema = [];
    public $migrate_unique = [];

    // Option import:
    public $supplier_default = 0;
    public $manufacturer_default = 0;
    public $delete_all = 0;
    public $keep_all_id = 1;
    public $migrate_speed = 200;
    public $migrate_image_speed = 5;
    public $migrate_file_speed = 5;
    public $package_version = _PS_VERSION_;
    public $keep_passwd = 0;
    public $count = 0;
    public $time_execution = 0;
    public $package_14 = 0;
    public $auto_migrate_image = 0;
    public $auto_migrate_file = 0;
    public $auto_product_thumb = 0;

    private $old_id_exist = array();
    private $offset = 0;
    private $all_shop = 0;
    private $fields_default = [];
    private $migrate_active = 0;
    private $migrate_images = [];
    private $table_images = [];
    private $migrated_lang = [];
    private $language_pack = 0;
    private $language_migrate = [];

    /**
     * @param $language
     * @return array|string
     */
    public function getLanguageMigrate($language = null)
    {
        if (!$this->language_migrate) {
            $this->language_migrate = (trim(($res = Configuration::getGlobalValue(self::$prefix . 'LANGUAGE_MIGRATE'))) !== '' ? explode(',', $res) : []);
        }
        return trim($language) !== '' ? (isset($this->language_migrate[$language]) && trim($this->language_migrate[$language]) !== '' ? $this->language_migrate[$language] : '') : $this->language_migrate;
    }

    /**
     * @param array|string $language
     * @return EMDataImport
     */
    public function setLanguageMigrate($language = null)
    {
        if (trim($language) == '') {
            $this->language_migrate = [];
        } elseif (is_array($language)) {
            $this->language_migrate = $language;
        } else {
            $this->language_migrate[] = trim($language);
        }
        Configuration::updateGlobalValue(self::$prefix . 'LANGUAGE_MIGRATE', count($this->language_migrate) > 0 ? implode(',', $this->language_migrate) : '', true);

        return $this;
    }

    protected static $keep_passwd_tables = [
        'employee' => 'passwd',
        'customer' => 'passwd',
    ];
    protected static $ignore_fields = [];
    public static $ignore_tables = [
        'zone' => [
            'field' => 'name',
            'pri' => 'id_zone',
        ],
        'currency' => [
            'field' => 'iso_code',
            'pri' => 'id_currency',
        ],
        'lang' => [
            'field' => 'iso_code',
            'pri' => 'id_lang',
        ],
        'employee' => [
            'field' => 'email',
            'pri' => 'id_employee',
        ],
        'country' => [
            'field' => 'iso_code',
            'pri' => 'id_country',
        ],
        'customer' => [
            'field' => 'email',
            'pri' => 'id_customer',
            'delete' => true,
        ],
        'profile' => [
            'field' => 'id_profile',
            'pri' => 'id_profile',
        ],
    ];
    protected static $table_legacy = [
        'category',
        'category_lang',
        'category_shop',
        'cms_category',
        'cms_category_lang',
        'cms_category_shop',
    ];
    protected static $ignore_keep_id = [
        'lang',
        'shop'
    ];
    protected static $new_struct_img;

    public function __construct()
    {
    }

    public function init()
    {
        if (!self::$_initialized) {
            // Static:
            self::$domain_url = rtrim(Configuration::getGlobalValue(self::$prefix . 'DOMAIN'), '/') . '/';
            self::$new_struct_img = version_compare(_PS_VERSION_, '1.4.3.0', '>=') ? 1 : 0;

            $this->loadMappingShops();
            $this->supplier_default = (int)Configuration::getGlobalValue(self::$prefix . 'SUPPLIER_DEFAULT');
            $this->manufacturer_default = (int)Configuration::getGlobalValue(self::$prefix . 'MANUFACTURER_DEFAULT');
            $this->keep_all_id = (int)Configuration::getGlobalValue(self::$prefix . 'KEEP_ALL_ID') ? 1 : 0;
            $this->delete_all = $this->keep_all_id || (int)Configuration::getGlobalValue(self::$prefix . 'DELETE_ALL') ? 1 : 0;
            $this->migrate_speed = (int)Configuration::getGlobalValue(self::$prefix . 'MIGRATE_SPEED');
            $this->package_version = trim(Configuration::getGlobalValue(self::$prefix . 'MIGRATE_VERSION'));
            $this->keep_passwd = 1;
            $this->all_shop = !empty(self::$target_shops) && count(self::$target_shops) != count(Shop::getShops()) ? 0 : 1;
            $this->package_14 = version_compare($this->package_version, '1.5.0.0', '<') ? 1 : 0;
            $this->migrate_image_speed = (int)Configuration::getGlobalValue(self::$prefix . 'MIGRATE_IMAGE_SPEED');
            $this->migrate_file_speed = (int)Configuration::getGlobalValue(self::$prefix . 'ATTACHMENTS_FILES_SPEED');
            $this->auto_migrate_image = !$this->keep_all_id || trim(Configuration::get(self::$prefix . 'MIGRATE_IMAGES')) == 'auto' ? 1 : 0;
            $this->auto_migrate_file = trim(Configuration::get(self::$prefix . 'ATTACHMENTS_FILES')) == 'auto' ? 1 : 0;
            $this->auto_product_thumb = !$this->auto_migrate_image || trim(Configuration::get(self::$prefix . 'GENE_PRODUCT_THUMBNAIL')) == 'auto' ? 1 : 0;
            $this->getIgnoreFields();
            $this->getLanguages();
            $this->getDefaultLanguage();

            self::$_initialized = true;
        }

        return $this;
    }

    public static function getInstance()
    {
        if (!self::$_INSTANCE) {
            self::$_INSTANCE = new EMDataImport();
        }
        return self::$_INSTANCE;
    }

    public function getIgnoreFields()
    {
        if (!self::$ignore_fields) {
            if (is_array(self::$ignore_tables) && count(self::$ignore_tables) > 0) {
                foreach (self::$ignore_tables as $table => $field) {
                    if (isset($field['pri']) && trim($field['pri']) !== '') {
                        self::$ignore_fields[$table] = trim($field['pri']);
                    }
                }
            }
        }
        return self::$ignore_fields;
    }

    public function importData($table, $data, $foreign_keys = array())
    {
        if (trim($table) === '' ||
            !is_array($data) ||
            count($data) <= 0 ||
            !EMTools::tableExist($table)
        ) {
            return [
                'ok' => 1,
                'table' => $table
            ];
        }
        // Cache struct:
        if (trim($this->getMigrateActive($table)) !== trim($table)) {
            // Get schema:
            $migrate_schema = $this->getSchema($table);
            $this->setMigrateSchema($table, $migrate_schema);
            // Cache struct table:
            $primary_keys = [];
            $fields = [];
            if (is_array($migrate_schema)
                && count($migrate_schema) > 0
            ) {
                foreach ($migrate_schema as $schema) {
                    $field = trim($schema['Field']);
                    if (!in_array($field, $fields)) {
                        $fields[] = $field;
                    }
                    if (isset($schema['Key']) && $schema['Key'] == 'PRI') {
                        if (!in_array($field, $primary_keys)) {
                            $primary_keys[] = $field;
                        }
                        if (isset($schema['Extra'])
                            && trim($schema['Extra']) == 'auto_increment'
                            && !in_array($field . '_ets_old', $fields)
                        ) {
                            $this
                                ->modifyTable($table, [$field . '_ets_old' => $schema['Type'] . ' DEFAULT NULL'], !$this->keep_all_id ? [$field . '_ets_old'] : [])
                                ->setOldIdExist($table, $field . '_ets_old');

                            if (!in_array($field . '_ets_old', $fields)) {
                                $fields[] = $field . '_ets_old';
                            }
                        }
                    }
                    if ($this->keep_passwd
                        && isset(self::$keep_passwd_tables[$table])
                        && $field == trim(self::$keep_passwd_tables[$table])
                    ) {
                        $this->modifyTable($table, [$field . '_old_wp' => $schema['Type'] . ' DEFAULT NULL']);

                        if (!in_array($field . '_old_wp', $fields)) {
                            $fields[] = $field . '_old_wp';
                        }
                    }
                }
                // Images:
                if (($struct_images = $this->getMigrateImages($table))
                    && is_array($struct_images)
                    && count($struct_images) > 0
                ) {
                    foreach ($struct_images as $struct) {
                        $field = isset($struct['field']) && trim($struct['field']) !== '' ? trim($struct['field']) : 'id_' . trim($table);
                        if (!in_array($field . self::$image_field_unique, $fields)) {
                            $this
                                ->modifyTable($table, [$field . self::$image_field_unique => 'tinyint(1) unsigned DEFAULT NULL'])
                                ->setOldIdExist($table, $field . self::$image_field_unique);
                            $fields[] = $field . self::$image_field_unique;
                        }
                    }
                }

                // Attachments & Files:
                if (($struct_files = $this->getMigrateFiles($table))
                    && is_array($struct_files)
                    && count($struct_files) > 0
                ) {
                    foreach ($struct_files as $struct) {
                        $field = isset($struct['field']) && trim($struct['field']) !== '' ? trim($struct['field']) : 'id_' . trim($table);
                        if (!in_array($field . self::$file_field_unique, $fields)) {
                            $this
                                ->modifyTable($table, [$field . self::$file_field_unique => 'tinyint(1) unsigned DEFAULT NULL'])
                                ->setOldIdExist($table, $field . self::$file_field_unique);
                            $fields[] = $field . self::$file_field_unique;
                        }
                    }
                }
            }

            // Write struct:
            $this
                ->setMigrateFields($table, $fields)
                ->setMigratePrimary($table, $primary_keys)
                ->hasUnique($table)
                ->setMigrateActive($table);
        }

        // State:
        $res = true;

        // Process:
        if ($query = $this->generateSQL($table, $data, $foreign_keys)) {
            // All query:
            $res = Db::getInstance()->execute($query);
            // Current Language:
            if ($res
                && trim($table) == 'currency'
                && version_compare(_PS_VERSION_, '1.7.6.0', '>=')
                && version_compare($this->package_version, '1.7.6.0', '<')
            ) {
                $query = 'INSERT IGNORE INTO `' . _DB_PREFIX_ . $table . '_lang`(`id_currency`, `id_lang`, `name`, `symbol`) VALUES';
                $subQuery = '';
                if ($languages = Language::getLanguages(false)) {
                    foreach ($languages as $l) {
                        foreach ($data as $item) {
                            $fields_value = [
                                'id_currency' => $this->getNewIdByOldId('currency', 'id_currency', (int)$item['id_currency']),
                                'id_lang' => (int)$l['id_lang'] ?: Configuration::get('PS_LANG_DEFAULT'),
                                'name' => '"' . pSQL($item['name']) . '"',
                                'symbol' => '"' . (isset($item['sign']) ? pSQL($item['sign']) : '') . '"'
                            ];
                            $queryTmp = '(' . implode(',', $fields_value) . ')';
                            if ($this->keep_all_id) {
                                $queryTmp .= ' ON DUPLICATE KEY UPDATE ';
                                foreach ($fields_value as $key => $value) {
                                    $queryTmp .= '`' . $key . '`=' . $value . ',';
                                }
                            }
                            $subQuery .= $query . rtrim($queryTmp, ',') . ';';
                        }
                    }
                }
                if ($subQuery)
                    $res &= Db::getInstance()->execute($subQuery);
            } // Shop:
            elseif ($res
                && trim($table) == 'shop'
                && count(self::$mapping_shop) > 0
                && $this->hasOldId('id_shop_ets_old', $table)
            ) {
                $dq = new DbQuery();
                $dq
                    ->select('id_shop, id_shop_ets_old')
                    ->from('shop')
                    ->where('id_shop_ets_old is NOT NULL');
                if ($shops = Db::getInstance()->executeS($dq)) {
                    foreach ($shops as $shop) {
                        if (isset(self::$mapping_shop[(int)$shop['id_shop_ets_old']])) {
                            self::$mapping_shop[(int)$shop['id_shop_ets_old']] = (int)$shop['id_shop'];
                        }
                    }
                    EMDataImport::mappingShops(self::$mapping_shop);
                }
            } // Package version 14 to prestashop > 1.4:
            elseif ($res
                && $this->package_14
                && version_compare(_PS_VERSION_, '1.5', '>=')
            ) {
                $tables_import = [];
                if (trim($table) == 'product_attribute'
                    && version_compare(_PS_VERSION_, '1.5.0.2', '>=')
                    && version_compare($this->package_version, '1.5.0.2', '<')
                ) {
                    $tables_import[] = 'stock_available';
                }
                if (!preg_match('/^[0-9a-zA-Z\_]+\_shop$/', trim($table))) {
                    $tables_import[] = trim($table) . '_shop';
                }
                if (count($tables_import) > 0) {
                    foreach ($tables_import as $table_import) {
                        if (trim($table_import) !== '' && EMTools::tableExist($table_import)) {
                            $foreign_keys = [];
                            if ($this->keep_all_id) {

                                $foreign_keys2 = EMApi::getForeignKey($table_import);
                                $ignore_fields = $this->getIgnoreFields();

                                if (is_array($foreign_keys2) && count($foreign_keys2) > 0 && is_array($ignore_fields) && count($ignore_fields) > 0) {
                                    $foreign_keys = array_intersect_assoc($foreign_keys2, $ignore_fields);
                                }
                            } elseif (trim($table_import) !== 'category') {
                                $foreign_keys = EMApi::getForeignKey($table_import);
                            }
                            $this->importData($table_import, $data, $foreign_keys);
                        }
                    }
                }
            }
        }

        return [
            'ok' => (int)$res,
            'table' => $table,
        ];
    }

    /** @var int access rights of created folders (octal) */
    protected static $access_rights = 0775;

    public function importImage($entity, $data)
    {
        if (trim($entity) === '' ||
            !is_array($data) ||
            count($data) <= 0
        ) {
            return false;
        }
        if ($image = $this->getMigrateImages($entity)) {
            $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));
            foreach ($data as $item) {
                if (is_array($image) && count($image) > 0) {
                    foreach ($image as $struct) {
                        if (isset($struct['field']) && trim($struct['field']) !== '') {
                            $id_entity = $id_entity_old = trim($struct['field']);
                        } else {
                            $id_entity = 'id_' . trim($entity);
                            $id_entity_old = $id_entity . '_ets_old';
                        }
                        $images_types = isset($struct['type']) && trim($struct['type']) !== '' && (trim($entity) !== 'image' || !$this->keep_all_id || trim(Configuration::getGlobalValue(self::$prefix . 'GENE_PRODUCT_THUMBNAIL')) === 'auto') ? ImageType::getImagesTypes(trim($struct['type'])) : [];
                        $regenerate = count($images_types) > 0 ? 1 : 0;
                        $extension = isset($struct['ext']) && trim($struct['ext']) !== '' ? trim($struct['ext']) : '';

                        $dest_path = _PS_ROOT_DIR_ . '/' . trim($struct['path'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
                        $src_link = self::$domain_url . trim($struct['path'], '/') . '/';

                        if (isset($item[$id_entity_old])
                            && trim($item[$id_entity_old]) !== ''
                            && isset($item[$id_entity])
                            && trim($item[$id_entity]) !== ''
                            && isset($item[$id_entity . self::$image_field_unique])
                            && trim($item[$id_entity . self::$image_field_unique]) !== ''
                        ) {
                            //@file_put_contents(dirname(__FILE__) . '/log.txt', $entity . '|old:' . $item[$id_entity_old] . '|new:' . $item[$id_entity] . '|exist:' . $item[$id_entity . self::$image_field_unique] . PHP_EOL, FILE_APPEND);
                            // source;
                            if (trim($entity) !== 'image') {
                                $sources = [
                                    $item[$id_entity] => [
                                        'path_creator' => '',
                                        'src' => $item[$id_entity_old]
                                    ]
                                ];
                            } else {
                                $path_creator = self::$new_struct_img ? Image::getImgFolderStatic($item[$id_entity]) : $item['id_product'] . '-';
                                $sources = [
                                    $path_creator . $item[$id_entity] => [
                                        'path_creator' => self::$new_struct_img ? $path_creator : '',
                                        'src' => ((int)$item[$id_entity . self::$image_field_unique] > 0 ? Image::getImgFolderStatic($item[$id_entity_old]) : $item['id_product_ets_old'] . '-') . $item[$id_entity_old]
                                    ]
                                ];
                            }
                            if (is_array($sources) && count($sources) > 0) {
                                $type = Tools::strtolower(Tools::substr(strrchr(trim($item[$id_entity]), '.'), 1));
                                foreach ($sources as $dest => $source) {
                                    if (is_array($source) && count($source) > 0) {
                                        // Create directory image:
                                        if (isset($source['path_creator'])
                                            && !is_dir($dest_path . $source['path_creator'])
                                        ) {
                                            $success = @mkdir($dest_path . $source['path_creator'], self::$access_rights, true);
                                            $chmod = @chmod($dest_path . $source['path_creator'], self::$access_rights);
                                            if (($success || $chmod)
                                                && !file_exists($dest_path . $source['path_creator'] . 'index.php')
                                                && file_exists($dest_path . 'index.php')
                                            ) {
                                                @copy($dest_path . 'index.php', $dest_path . $source['path_creator'] . 'index.php');
                                            }
                                        }
                                        // Source download:
                                        $source = isset($source['src']) && trim($source['src']) !== '' ? trim($source['src']) : '';
                                    }
                                    $tmp_file = tempnam(_PS_TMP_IMG_DIR_, uniqid('ets_migrate', true));
                                    if (trim($source) !== '' && self::copy($src_link . $source . $extension, $tmp_file)) {
                                        //Evaluate the memory required to resize the image: if it's too much, you can't resize it.
                                        if (!ImageManager::checkImageMemoryLimit($tmp_file)) {
                                            @unlink($tmp_file);
                                        } else {
                                            // Generate origin:
                                            $tgt_width = $tgt_height = 0;
                                            $src_width = $src_height = 0;
                                            $error = 0;
                                            ImageManager::resize($tmp_file,
                                                $dest_path . $dest . $extension,
                                                null,
                                                null,
                                                (trim($extension) !== '' ? trim($extension, '.') : $type),
                                                false,
                                                $error,
                                                $tgt_width,
                                                $tgt_height,
                                                5,
                                                $src_width,
                                                $src_height
                                            );
                                            // Generate thumbnail:
                                            if ($regenerate) {
                                                $path_infos = array();
                                                $path_infos[] = array($tgt_width, $tgt_height, $dest_path . $dest . $extension);
                                                foreach ($images_types as $image_type) {
                                                    $best_path = self::get_best_path($image_type['width'], $image_type['height'], $path_infos);
                                                    if (ImageManager::resize(
                                                        $best_path,
                                                        $dest_path . $dest . '-' . Tools::stripslashes($image_type['name']) . $extension,
                                                        $image_type['width'],
                                                        $image_type['height'],
                                                        (trim($extension) !== '' ? trim($extension, '.') : $type),
                                                        false,
                                                        $error,
                                                        $tgt_width,
                                                        $tgt_height,
                                                        5,
                                                        $src_width,
                                                        $src_height
                                                    )) {
                                                        // the last image should not be added in the candidate list if it's bigger than the original image
                                                        if ($tgt_width <= $src_width && $tgt_height <= $src_height) {
                                                            $path_infos[] = array($tgt_width, $tgt_height, $dest_path . $dest . '-' . Tools::stripslashes($image_type['name']) . $extension);
                                                        }
                                                        if (trim($entity) == 'image') {
                                                            if (is_file(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int)$item[$id_entity] . $extension)) {
                                                                unlink(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int)$item[$id_entity] . $extension);
                                                            }
                                                            if (self::$target_shops) {
                                                                foreach (self::$target_shops as $id_shop) {
                                                                    if (is_file(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int)$item[$id_entity] . '_' . (int)$id_shop . $extension)) {
                                                                        unlink(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int)$item[$id_entity] . '_' . (int)$id_shop . $extension);
                                                                    }
                                                                }
                                                            } elseif (is_file(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int)$item[$id_entity] . '_' . (int)Context::getContext()->shop->id . $extension)) {
                                                                unlink(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int)$item[$id_entity] . '_' . (int)Context::getContext()->shop->id . $extension);
                                                            }
                                                        }
                                                    }
                                                    if (trim($entity) == 'image' && in_array($image_type['id_image_type'], $watermark_types)) {
                                                        Hook::exec('actionWatermark', array('id_image' => $item[$id_entity], 'id_product' => $item['id_product']));
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    @unlink($tmp_file);
                                }
                            }
                        }
                    }
                }
            }

            return [
                'ok' => 1,
                'table' => $entity,
            ];
        }

        return false;
    }

    public function importFiles($entity, $data)
    {
        if (trim($entity) === '' ||
            !is_array($data) ||
            count($data) <= 0
        ) {
            return false;
        }
        $file = $this->getMigrateFiles($entity);
        if (is_array($file)
            && count($file) > 0
        ) {
            foreach ($file as $struct) {
                if (isset($struct['path']) &&
                    trim($struct['path']) !== ''
                ) {
                    $field = isset($struct['field']) && trim($struct['field']) !== '' ? trim($struct['field']) : 'id_' . trim($entity);
                    $dest_file = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . trim($struct['path'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
                    foreach ($data as $item) {
                        if (isset($item[$field]) &&
                            trim($item[$field]) !== '' &&
                            isset($item[$field . self::$file_field_unique]) &&
                            $item[$field . self::$file_field_unique] !== ''
                        ) {
                            $this->downloadFile($dest_file . $item[$field], ['filename' => trim($item[$field]), 'field' => trim($field), 'entity' => trim($entity)]);
                            if (trim($entity) == 'customized_data') {
                                $this->downloadFile($dest_file . $item[$field] . '_small', ['filename' => trim($item[$field]) . '_small', 'field' => trim($field), 'entity' => trim($entity)]);
                            }
                        }
                    }
                }
            }
            return [
                'ok' => 1,
                'table' => $entity,
            ];
        }

        return false;
    }

    protected static function get_best_path($tgt_width, $tgt_height, $path_infos)
    {
        $path_infos = array_reverse($path_infos);
        $path = '';
        foreach ($path_infos as $path_info) {
            list($width, $height, $path) = $path_info;
            if ($width >= $tgt_width && $height >= $tgt_height) {
                return $path;
            }
        }

        return $path;
    }

    public static function copy($source, $destination, $stream_context = null)
    {
        if (null === $stream_context && !preg_match('/^https?:\/\//', $source)) {
            return @copy($source, $destination);
        }
        $content = self::file_get_contents($source, false, $stream_context);
        if ($content) {
            return strpos($content, 'head') !== false ? false : @file_put_contents($destination, $content);
        }

        return false;
    }

    public function downloadFile($destination, $params)
    {
        $http_build_query = ['download' => 1];
        if ($params) {
            foreach ($params as $key => $param) {
                if (trim($param) !== '') {
                    $http_build_query[$key] = $param;
                }
            }
        }
        $content_file = self::file_get_contents(EMApi::getInstance()->getRequestApi() . '&' . http_build_query($http_build_query));
        if ($content_file) {
            return strpos($content_file, '**(error)**') !== false ? false : @file_put_contents($destination, $content_file);
        }

        return false;
    }

    public function hasUnique($table = null)
    {
        if ($table === null) {
            $this->migrate_unique = [];
        } else {
            if (is_array($this->migrate_unique) && count($this->migrate_unique) > 1) {
                $this->migrate_unique = [];
            }
            $indexes = Db::getInstance()->executeS('SHOW INDEXES FROM ' . _DB_PREFIX_ . $table);
            $uniques = [];
            foreach ($indexes as $index) {
                if (!$index['Non_unique'] && $index['Key_name'] != 'PRIMARY') {
                    $uniques[$index['Key_name']][] = $index['Column_name'];
                }
            }
            $this->migrate_unique[$table] = $uniques;
        }
        Configuration::updateGlobalValue(self::$prefix . 'MIGRATE_UNIQUE', json_encode($this->migrate_unique), true);

        return $this;
    }

    public function getUnique($table = null)
    {
        if ($table === null) {
            return [];
        }
        if (!$this->migrate_unique ||
            !isset($this->migrate_unique[$table])
        ) {
            $this->migrate_unique = json_decode(trim(Configuration::getGlobalValue(self::$prefix . 'MIGRATE_UNIQUE')), true);
        }

        return isset($this->migrate_unique[$table]) && is_array($this->migrate_unique[$table]) && count($this->migrate_unique[$table]) > 0 ? $this->migrate_unique[$table] : [];
    }

    public function cleanUnique()
    {
        if ($this->migrate_unique) {
            $this->migrate_unique = [];
        }
        Configuration::updateGlobalValue(self::$prefix . 'MIGRATE_UNIQUE', json_encode($this->migrate_unique), true);

        return $this;
    }

    /**
     * @param $table
     * @return bool
     */
    public function ignoreTable($table)
    {
        if (isset(self::$ignore_tables[$table])) {
            if (isset(self::$ignore_tables[$table]['delete']) && self::$ignore_tables[$table]['delete']) {
                return false;
            }

            return true;
        } elseif (preg_match('/^([a-z0-9A-Z\_]+)\_(shop|lang)$/', $table, $m) && isset($m[1]) && trim($m[1]) !== '') {
            return $this->ignoreTable(trim($m[1]));
        }

        return false;
    }


    /**
     * @param array $resource
     * @return bool
     */
    public function cleanBeforeMigrateData($resource)
    {
        if (!is_array($resource) ||
            !count($resource) ||
            !isset($resource['tables']) ||
            !count($resource['tables'])
        ) {
            return false;
        }
        if ($tables = $resource['tables']) {

            // Clean Images:
            $images = isset($resource['images']) ? $resource['images'] : [];
            if (is_array($images) &&
                count($images) > 0
            ) {
                foreach ($images as $table => $image) {
                    if (is_array($image)
                        && count($image) > 0
                        && EMTools::tableExist($table)
                    ) {
                        foreach ($image as $struct) {
                            if (!isset($struct['path']) || trim($struct['path']) == '') {
                                continue;
                            }

                            $path = _PS_ROOT_DIR_ . '/' . trim($struct['path'], '/') . '/';
                            $id_entity = isset($struct['field']) && trim($struct['field']) !== '' ? trim($struct['field']) : 'id_' . $table;
                            $image_types = isset($struct['type']) && trim($struct['type']) !== '' ? ImageType::getImagesTypes(trim($struct['type'])) : [];
                            $extension = isset($struct['ext']) && trim($struct['ext']) !== '' ? trim($struct['ext']) : '';

                            $dq = new DbQuery();
                            $dq
                                ->select($id_entity)
                                ->from($table);
                            if ($table == 'category') {
                                $dq
                                    ->where('id_parent!=0')
                                    ->where('is_root_category!=1');
                            }
                            if ($res = Db::getInstance()->executeS($dq)) {
                                foreach ($res as $item) {
                                    if (isset($item[$id_entity]) && trim($item[$id_entity]) !== '') {
                                        $path_create = [
                                            $path . $item[$id_entity]
                                        ];
                                        if (trim($table) === 'image') {
                                            $path_create[] = $path . Image::getImgFolderStatic($item[$id_entity]) . $item[$id_entity];
                                        }
                                        $has_image_type = count($image_types) > 0 ? 1 : 0;
                                        foreach ($path_create as $path_item) {
                                            $files = [
                                                $path_item,
                                                _PS_TMP_IMG_DIR_ . ($table !== 'image' ? $table : 'product') . '_mini_' . (int)$item[$id_entity],
                                            ];
                                            if (trim($table) === 'category') {
                                                $files[] = $path_item . (int)$item[$id_entity] . '_thumb';
                                            }
                                            if ($has_image_type) {
                                                foreach ($image_types as $type) {
                                                    if (isset($type['name']) && trim($type['name']) !== '') {
                                                        $files[] = $path_item . '-' . $type['name'];
                                                    }
                                                }
                                            }
                                            if ($files) {
                                                foreach ($files as $file) {
                                                    if (is_file($file . $extension)) {
                                                        unlink($file . $extension);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // Clean Attachments & Files:
            $files = isset($resource['files']) ? $resource['files'] : [];
            if (is_array($files) && count($files) > 0) {
                foreach ($files as $table => $file) {
                    if (is_array($file)
                        && count($file) > 0
                        && EMTools::tableExist($table)
                    ) {
                        foreach ($file as $struct) {
                            if (!isset($struct['path']) || trim($struct['path']) == '') {
                                continue;
                            }
                            $path = _PS_ROOT_DIR_ . '/' . trim($struct['path'], '/') . '/';
                            $field = isset($struct['field']) && trim($struct['field']) !== '' ? trim($struct['field']) : 'id_' . $table;
                            $extension = isset($struct['ext']) && trim($struct['ext']) !== '' ? trim($struct['ext']) : '';
                            $dq = new DbQuery();
                            $dq
                                ->select($field)
                                ->from($table);
                            if ($res = Db::getInstance()->executeS($dq)) {
                                foreach ($res as $item) {
                                    if (isset($item[$field]) && trim($item[$field]) !== '') {
                                        if (@file_exists($path . $item[$field] . $extension)) {
                                            @unlink($path . $item[$field] . $extension);
                                        }
                                        if (trim($table) == 'customized_data') {
                                            if (@file_exists($path . $item[$field] . '_small' . $extension)) {
                                                @unlink($path . $item[$field] . '_small' . $extension);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // Clean table:
            $queries = [];
            $auto_increment = [];
            foreach ($tables as $table) {
                if (!preg_match('/^shop([0-9a-zA-Z\_]+)?$/', $table)
                    && EMTools::tableExist($table)
                ) {
                    if (!$this->ignoreTable($table)) {
                        if (!$this->package_14
                            || !in_array(trim($table), self::$table_legacy)
                        ) {
                            $queries[] = 'TRUNCATE TABLE ' . _DB_PREFIX_ . $table;
                        } else {
                            $dq = new DbQuery();
                            $dq
                                //->type('DELETE')
                                ->from($table, 'a');
                            if (preg_match('/^([0-9a-zA-Z\_]+?)_(lang|shop)$/', $table, $m)) {
                                $dq
                                    ->leftJoin($m[1], 'b', 'a.id_' . $m[1] . '=b.id_' . $m[1])
                                    ->where('b.id_' . $m[1] . ' is NULL OR b.id_' . $m[1] . '<=0');
                            }

                            $parent = is_array($m) && count($m) > 0 && isset($m[1]) && trim($m[1]) !== '' ? $m[1] : $table;
                            $has_parent = trim($parent) !== trim($table) ? 1 : 0;
                            $alias = $has_parent ? 'b' : 'a';

                            switch (trim($parent)) {
                                case 'category':
                                    $dq
                                        ->where(pSQL($alias) . '.id_parent!=0 AND ' . pSQL($alias) . '.is_root_category!=1');
                                    break;
                                case 'cms_category':
                                    $dq
                                        ->where(pSQL($alias) . '.id_parent!=0');
                                    break;
                            }
                            $queries[] = preg_replace('/DELETE|SELECT\s+\*/i', 'DELETE a', $dq->build());
                            if ($has_parent <= 0) {
                                $auto_increment[] = $table;
                            }
                        }
                    } elseif (preg_match('/^([0-9a-zA-Z\_]+?)_(lang|shop)$/', $table, $m)) {
                        $dq = new DbQuery();
                        $dq
                            //->type('DELETE')
                            ->from($table, 'a');
                        if (isset($m[2]) && trim($m[2]) !== '') {
                            $dq
                                ->leftJoin($m[2], 'b', 'a.id_' . $m[2] . ' = b.id_' . $m[2])
                                ->where('b.id_' . $m[2] . ' is NULL OR b.id_' . $m[2] . ' <= 0');
                        }
                        $queries[] = preg_replace('/DELETE|SELECT\s+\*/i', 'DELETE a', $dq->build());
                    }
                }
            }
            if (count($queries) > 0
                && Db::getInstance()->execute(implode(';', $queries))
                && count($auto_increment) > 0
            ) {
                $auto_queries = [];
                foreach ($auto_increment as $table) {
                    $max = (int)Db::getInstance()->getValue('SELECT MAX(id_' . pSQL($table) . ') FROM ' . _DB_PREFIX_ . pSQL($table));
                    $max = $max + 1;
                    $auto_queries[] = 'ALTER TABLE ' . _DB_PREFIX_ . pSQL($table) . ' AUTO_INCREMENT = ' . (int)$max;
                }
                if (count($auto_queries)) {
                    Db::getInstance()->execute('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";SET time_zone = "+00:00";' . implode(';', $auto_queries));
                }
            }
        }
    }

    static $ignore_table_package_14 = [
        'specific_price',
        'stock_available',
    ];

    static $ignore_null_field_1770 = [
        'address',
        'orders',
        'order_detail',
        'order_payment',
        'order_slip',
        'order_slip_detail',
        'supply_order',
        'supply_order_detail',
    ];

    // Prestashop 1.4, 1.5 to 1.6, 1.7:
    static $iso_code_mappings = [
        'sl' => 'si'
    ];

    public function generateSQL($table, $data, $foreign_keys = array())
    {
        $this->time_execution = time();
        $query = '';
        if ($data) {
            // Fix migrate null any table (prestashop version 1.7.7.0 or more than)
            $migrate_ps_1770 = version_compare(_PS_VERSION_, '1.7.7.0', '>=') && in_array(trim($table), self::$ignore_null_field_1770) ? 1 : 0;
            // Fix migrate id_group_shop to id_shop_group
            $migrate_ps_15010 = version_compare($this->package_version, '1.5.0.10', '<') && version_compare(_PS_VERSION_, '1.5.0.10', '>') ? 1 : 0;
            // Fix category"
            $migrate_ps_1504 = version_compare($this->package_version, '1.5.0.4', '>=') ? 1 : 0;
            // Fix ignore table:
            $keep_id_ignore_table = isset(self::$ignore_tables[$table]) && (!isset(self::$ignore_tables[$table]['delete']) || !self::$ignore_tables[$table]['delete']) ? 1 : 0;

            foreach ($data as $item) {

                // Table employee:
                if (trim($table) == 'employee'
                    && isset($item['id_profile'])
                    && $item['id_profile'] > 0
                    && (int)$item['id_profile'] == _PS_ADMIN_PROFILE_
                    && isset($item['id_employee'])
                    && (int)$item['id_employee'] > 0
                    && (int)EMTools::fetch(trim($table)
                        , false
                        , 'id_employee'
                        , 0
                        , 0
                        , ['id_employee=' . (int)$item['id_employee']]
                        , true
                    ) > 0
                ) {
                    continue;
                } // Table shops:
                elseif (trim($table) == 'shop'
                    && isset($item['id_shop']) && $item['id_shop'] > 0
                    && (isset(self::$mapping_shop[$item['id_shop']]) && (int)self::$mapping_shop[$item['id_shop']] > 0 || !isset(self::$mapping_shop[$item['id_shop']]))
                ) {
                    continue;
                } // Table category:
                elseif (trim($table) == 'category'
                    && ($this->package_14 || !$this->keep_all_id)
                    && isset($item['id_category'])
                    && (int)$item['id_category'] > 0
                    && (isset($item['id_parent']) && (int)$item['id_parent'] <= 0 ||
                        $migrate_ps_1504 && isset($item['is_root_category']) && (int)$item['is_root_category'] > 0 ||
                        !$migrate_ps_1504 && (int)$item['id_category'] == ($id_root_category = (int)EMTools::fetch(trim($table), false, 'id_category', 0, 0, ['is_root_category=1'], true))
                    )
                ) {
                    if (isset($item['id_parent']) && (int)$item['id_parent'] <= 0) {
                        $id_category = (int)EMTools::fetch(trim($table), false, 'id_category', 0, 0, ['id_parent=0'], true);
                    } else {
                        if (!isset($id_root_category)) {
                            $id_root_category = (int)EMTools::fetch(trim($table), false, 'id_category', 0, 0, ['is_root_category=1'], true);
                        }
                        $id_category = !$this->package_14 || $id_root_category == (int)$item['id_category'] ? $id_root_category : 0;
                    }
                    if ($id_category <= 0 && !$this->package_14) {
                        Db::getInstance()->update(
                            'configuration'
                            , ['value' => (int)$item['id_category']]
                            , 'name=\'' . (isset($id_root_category) ? 'PS_ROOT_CATEGORY' : 'PS_HOME_CATEGORY') . '\''
                        );
                    } elseif ($id_category > 0) {
                        Db::getInstance()->update(
                            $table
                            , ['id_category_ets_old' => (int)$item['id_category']]
                            , 'id_category=' . (int)$id_category
                        );
                        continue;
                    }
                }
                // Table ignore:
                if (isset(self::$ignore_tables[$table])
                    && ($field = self::$ignore_tables[$table])
                    && isset($item[$field['field']])
                    && trim($item[$field['field']])
                    && (int)Db::getInstance()->getValue(
                        (new DbQuery())
                            ->select($field['pri'])
                            ->from($table)
                            ->where($field['field'] . '=\'' . pSQL(($item_field_value = (trim($table) !== 'lang' || !isset(self::$iso_code_mappings[$item[$field['field']]]) || !Validate::isLangIsoCode(self::$iso_code_mappings[$item[$field['field']]]) ? trim($item[$field['field']]) : trim(self::$iso_code_mappings[$item[$field['field']]])))) . '\'')
                    )
                ) {
                    Db::getInstance()->update($table, [$field['pri'] . '_ets_old' => (int)$item[$field['pri']]], $field['field'] . '=\'' . pSQL($item_field_value) . '\'');
                    // All table:
                } elseif (
                    ($migrate_schema = $this->getMigrateSchema($table))
                    && is_array($migrate_schema)
                    && count($migrate_schema) > 0
                ) {
                    // Get cache struct:
                    $migrate_primary = $this->getMigratePrimary($table);
                    $migrate_fields = $this->getMigrateFields($table);
                    $migrate_unique = $this->getUnique($table);

                    // Set value:
                    $fields_value = array();
                    foreach ($migrate_schema as $schema) {
                        $field = trim($schema['Field']);
                        // Binding fields:
                        if (in_array($field, $migrate_primary) && isset($schema['Extra']) && trim($schema['Extra']) == 'auto_increment') {
                            if ($this->keep_all_id && !$keep_id_ignore_table)
                                $fields_value[$field] = !in_array(trim($table), self::$ignore_keep_id) && isset($item[$field]) && (int)$item[$field] > 0 ? (int)$item[$field] : (isset($schema['Null']) && Tools::strtoupper(trim($schema['Null'])) !== 'YES' || $migrate_ps_1770 ? '\'\'' : 'NULL');
                            $fields_value[$field . '_ets_old'] = isset($item[$field]) ? $item[$field] : 'NULL';
                            if (isset($fields_value[$field]) && trim($fields_value[$field]) === '\'\'') {
                                unset($fields_value[$field]);
                            }
                        } elseif (!preg_match('/^(id_[0-9a-zA-Z\_]+_ets_old|[0-9a-zA-Z\_]+_old_wp)$/i', $field) && in_array($field, $migrate_fields)) {
                            if (trim($table) == 'shop' && $field == 'theme_name') {
                                // Theme:
                                $fields_value[$field] = '\'' . pSQL(_THEME_NAME_) . '\'';
                            } elseif (preg_match('/(?:int|tinyint|mediumint)\((\d+)\)/i', $schema['Type'])) {
                                // Type int|tinyint:
                                $fields_value[$field] = isset($item[$field]) && trim($item[$field]) != '' && Validate::isInt($item[$field]) ? (int)$item[$field] : (isset($schema['Default']) && trim($schema['Default']) !== '' ? (int)$schema['Default'] : (isset($schema['Null']) && Tools::strtoupper(trim($schema['Null'])) === 'YES' && !$migrate_ps_1770 ? 'NULL' : 0));
                            } elseif (preg_match('/(?:char|varchar)\((\d+)\)|text|mediumtext|longtext/i', $schema['Type'])) {
                                // Type char|varchar:
                                $fields_value[$field] = (isset($item[$field]) && trim($item[$field]) !== '' ? '\'' . pSQL($item[$field], true) . '\'' : (isset($schema['Default']) && trim($schema['Default']) !== '' ? '\'' . pSQL($schema['Default'], true) . '\'' : (isset($schema['Null']) && Tools::strtoupper(trim($schema['Null'])) === 'YES' && !$migrate_ps_1770 ? 'NULL' : '\'\'')));
                            } elseif (preg_match('/decimal\((\d+,\s*\d+)\)|float(\((\d+,\s*\d+)\))?/i', $schema['Type'])) {
                                // Type decimal|float:
                                $fields_value[$field] = isset($item[$field]) && trim($item[$field]) !== '' && Validate::isFloat($item[$field]) ? (float)$item[$field] : (isset($schema['Default']) && trim($schema['Default']) !== '' ? (float)$schema['Default'] : (isset($schema['Null']) && Tools::strtoupper(trim($schema['Null'])) === 'YES' && !$migrate_ps_1770 ? 'NULL' : 0));
                            } elseif (preg_match('/date|datetime/i', $schema['Type'])) {
                                // Type date or datetime:
                                if (isset($item[$field]) && Validate::isDate(trim($item[$field])) && (strtotime($item[$field]) > 0 || Tools::strtoupper(trim($schema['Null'])) !== 'YES' && (trim($item[$field]) == '0000-00-00' || trim($item[$field]) == '0000-00-00 00:00:00'))) {
                                    $fields_value[$field] = '\'' . pSQL($item[$field]) . '\'';
                                } elseif (isset($schema['Default']) && Validate::isDate($schema['Default']) && strtotime($schema['Default']) > 0) {
                                    $fields_value[$field] = '\'' . pSQL($schema['Default']) . '\'';
                                } else {
                                    $fields_value[$field] = isset($schema['Null']) && Tools::strtoupper(trim($schema['Null'])) === 'NO' ? '\'' . (trim($schema['Type']) !== 'datetime' ? '0000-00-00' : '0000-00-00 00:00:00') . '\'' : 'NULL';
                                }
                            } else {
                                // Type other:
                                $fields_value[$field] = (isset($item[$field]) && trim($item[$field]) != '' ? '\'' . pSQL($item[$field]) . '\'' : (isset($schema['Default']) && trim($schema['Default']) !== '' ? '\'' . pSQL($schema['Default']) . '\'' : (isset($schema['Null']) && Tools::strtoupper(trim($schema['Null'])) === 'YES' && !$migrate_ps_1770 ? 'NULL' : '\'\'')));
                            }
                        }
                        // Keep passwd
                        if ($this->keep_passwd
                            && isset(self::$keep_passwd_tables[$table])
                            && $field == trim(self::$keep_passwd_tables[$table])
                        ) {
                            $fields_value[$field . '_old_wp'] = '\'' . pSQL($item[$field]) . '\'';
                        }
                        // Convert id_group_shop to id_shop_group:
                        if (trim($field) == 'id_shop_group'
                            && $migrate_ps_15010
                            && isset($item['id_group_shop'])
                        ) {
                            $fields_value[$field] = $item['id_group_shop'];
                        }
                        // Mapping shops:
                        if (trim($table) !== 'shop'
                            && preg_match('/^id_shop([0-9a-zA-Z\_]+)?$/', $field)
                            && isset($fields_value[$field])
                        ) {
                            if (
                                isset($item[$field])
                                && (int)$item[$field] > 0
                                && (int)$fields_value[$field] > 0
                                && isset(self::$mapping_shop[$item[$field]])
                                && self::$mapping_shop[$item[$field]] > 0
                            ) {
                                $fields_value[$field] = self::$mapping_shop[$item[$field]];
                            } elseif (
                                isset($item[$field])
                                && (int)$item[$field] == 0
                                && (int)$fields_value[$field] == 0
                            ) {
                                $fields_value[$field] = 0;
                            } elseif (
                                isset($item[$field])
                                && (int)$item[$field] > 0 ||
                                $this->package_14
                                && (!in_array(trim($table), self::$ignore_table_package_14) || trim($field) !== 'id_shop_group')
                            ) {
                                $fields_value[$field] = isset($schema['Null']) && Tools::strtoupper(trim($schema['Null'])) !== 'YES' ? (isset(Context::getContext()->shop->$field) ? (int)Context::getContext()->shop->$field : (int)Context::getContext()->shop->id) : 'NULL';
                            }
                        }
                        // Unique:
                        if ($this->fieldInUnique($field, $migrate_unique)
                            && isset($fields_value[$field])
                            && (trim($fields_value[$field]) == '' || preg_match('/(?:int|tinyint)\((\d+)\)/i', $schema['Type']) && $fields_value[$field] <= 0)
                            && isset($schema['Null'])
                            && Tools::strtoupper(trim($schema['Null'])) === 'YES'
                        ) {
                            $fields_value[$field] = 'NULL';
                        }
                    }
                    // Foreign keys:
                    if (is_array($foreign_keys) && count($foreign_keys) > 0) {
                        foreach ($foreign_keys as $foreign_table => $foreign_key) {
                            if (trim($foreign_table) !== 'shop') {
                                if (is_array($foreign_key) && $foreign_key) {
                                    foreach ($foreign_key as $id_source => $id_target) {
                                        if (isset($fields_value[$id_source])
                                            && isset($item[$id_source])
                                            && $item[$id_source]
                                        ) {
                                            $fields_value[$id_source] = $this->getNewIdByOldId($foreign_table, $id_target, $item[$id_source]);
                                        }
                                    }
                                } elseif (isset($fields_value[$foreign_key])
                                    && isset($item[$foreign_key])
                                    && $item[$foreign_key]
                                ) {
                                    $fields_value[$foreign_key] = $this->getNewIdByOldId($foreign_table, $foreign_key, $item[$foreign_key]);
                                }
                            }
                        }
                    }
                    // Images:
                    if (($struct_images = $this->getMigrateImages($table))
                        && is_array($struct_images)
                        && count($struct_images) > 0
                    ) {
                        foreach ($struct_images as $struct) {
                            if (is_array($struct)
                                && count($struct) > 0
                            ) {
                                $field = isset($struct['field']) && trim($struct['field']) !== '' ? trim($struct['field']) : 'id_' . trim($table);
                                if (in_array($field . self::$image_field_unique, $migrate_fields)) {
                                    $fields_value[$field . self::$image_field_unique] = isset($item[$field . self::$image_field_unique]) && trim($item[$field . self::$image_field_unique]) !== '' ? (int)$item[$field . self::$image_field_unique] : 'NULL';
                                }
                            }
                        }
                    }
                    // Attachments & Files:
                    if (($struct_files = $this->getMigrateFiles($table))
                        && is_array($struct_files)
                        && count($struct_files) > 0
                    ) {
                        foreach ($struct_files as $struct) {
                            if (is_array($struct)
                                && count($struct) > 0
                            ) {
                                $field = isset($struct['field']) && trim($struct['field']) !== '' ? trim($struct['field']) : 'id_' . trim($table);
                                if (in_array($field . self::$file_field_unique, $migrate_fields)) {
                                    $fields_value[$field . self::$file_field_unique] = isset($item[$field . self::$file_field_unique]) && trim($item[$field . self::$file_field_unique]) != '' ? (int)$item[$field . self::$file_field_unique] : 'NULL';
                                }
                            }
                        }
                    }
                    // General:
                    if ($fields_value) {
                        // Fix version:
                        if (trim($table) == 'currency'
                            && version_compare($this->package_version, '1.7.0.0', '<')
                            && version_compare(_PS_VERSION_, '1.7.6.0', '>=')
                        ) {
                            $fields_value['numeric_iso_code'] = isset($item['iso_code_num']) ? trim($item['iso_code_num']) : 0;
                            $fields_value['precision'] = isset($item['format']) ? trim($item['format']) : 0;
                        }
                        if (
                            version_compare($this->package_version, '1.6.1.0', '<')
                            && version_compare(_PS_VERSION_, '1.6.1.0', '>=')
                            && (!$this->package_14 || !preg_match('/^[0-9a-zA-Z\_]+_shop$/', $table))
                        ) {
                            switch (trim($table)) {
                                case 'image_shop':
                                    $fields_value['id_product'] = isset($fields_value['id_image']) && trim($fields_value['id_image']) !== '' ? (int)EMTools::fetch('image', false, 'id_product', 0, 0, ['id_image=' . (int)$fields_value['id_image']], true) : 0;
                                    break;
                                case 'product_attribute_shop':
                                    $fields_value['id_product'] = isset($fields_value['id_product_attribute']) && trim($fields_value['id_product_attribute']) !== '' ? (int)EMTools::fetch('product_attribute', false, 'id_product', 0, 0, ['id_product_attribute=' . (int)$fields_value['id_product_attribute']], true) : 0;
                                    break;
                            }
                        }
                        if (version_compare($this->package_version, '1.7.6.0', '<') && version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
                            switch (trim($table)) {
                                case 'product_supplier':
                                    if (isset($fields_value['id_currency']) && $fields_value['id_currency'] <= 0) {
                                        $fields_value['id_currency'] = (int)Configuration::get('PS_CURRENCY_DEFAULT');
                                    }
                                    break;
                            }
                        }
                        if ((trim($table) == 'product' || trim($table) == 'product_shop') && isset($fields_value['minimal_quantity']) && $fields_value['minimal_quantity'] < 1) {
                            $fields_value['minimal_quantity'] = 1;
                        }
                        // Queries item;

                        if ($geneQuery = $this->buildSQL($table, $migrate_fields, $fields_value, $migrate_unique)) {
                            $query .= $geneQuery;
                            if (preg_match('/^[a-zA-Z0-9]+_lang$/', $table)
                                && is_array(self::$languages)
                                && count(self::$languages) > 0
                                && isset($fields_value['id_lang'])
                                && (int)$fields_value['id_lang'] > 0
                                && (int)self::$default_language == (int)$fields_value['id_lang']
                            ) {
                                foreach (self::$languages as $id_lang) {
                                    $fields_value['id_lang'] = $id_lang;
                                    if ($geneQuery = $this->buildSQL($table, $migrate_fields, $fields_value, $migrate_unique)) {
                                        $query .= $geneQuery;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->time_execution = time() - $this->time_execution;
        return $query;
    }

    public function buildSQL($table, $migrate_fields, $fields_value, $migrate_unique)
    {
        $fields = $values = [];
        if ($migrate_fields) {
            foreach ($migrate_fields as $field) {
                if (isset($fields_value[$field])) {
                    $fields[] = $field;
                    $values[] = $fields_value[$field];
                }
            }
        }
        if ($fields && $values) {
            $query = 'INSERT IGNORE INTO `' . _DB_PREFIX_ . $table . '` (' . implode(',', $this->toFieldsSQL($fields)) . ') VALUES(' . implode(',', $values) . ')';
            if ($this->keep_all_id && !in_array(trim($table), self::$ignore_keep_id)) {
                $query .= ' ON DUPLICATE KEY UPDATE ';
                foreach ($fields_value as $key => $value) {
                    if (!$this->fieldInUnique($key, $migrate_unique)) {
                        $query .= '`' . $key . '`=' . $value . ',';
                    }
                }
            }

            return rtrim($query, ',') . ';';
        }

        return false;
    }

    public function fieldInUnique($field, $migrate_unique)
    {
        if (is_array($migrate_unique) && count($migrate_unique) > 0) {
            foreach ($migrate_unique as $unique) {
                if (in_array($field, $unique)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function toFieldsSQL($fields)
    {
        if (!is_array($fields))
            $fields = is_array($fields);
        if ($fields) {
            foreach ($fields as &$field) {
                $field = '`' . $field . '`';
            }
        }
        return $fields;
    }

    public function getNewIdByOldId($table, $id, $value)
    {
        if (trim($table) == '') {
            return 0;
        }
        $dq = new DbQuery();
        $dq
            ->select($id)
            ->from($table);
        if ($this->hasOldId($id . '_ets_old', $table)) {
            $dq
                ->where($id . '_ets_old=' . (int)$value);
        } else {
            $dq
                ->where($id . '=' . (int)$value);
        }
        $res = (int)Db::getInstance()->getValue($dq);
        if ($res <= 0
            && ($default = $this->getFieldsDefault($id)) !== null
        ) {
            return $default;
        }

        return $res;
    }

    public function getSchema($table)
    {
        return Db::getInstance()->executeS('DESCRIBE `' . _DB_PREFIX_ . bqSQL($table) . '`');
    }

    public function modifyTable($table, $fields, $indexes = [])
    {
        if (!is_array($fields)) {
            $fields = array($fields);
        }
        $query = '';

        // Add column:
        if ($fields) {
            foreach ($fields as $key => $val) {
                if (!Db::getInstance()->getValue('SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = "' . _DB_NAME_ . '" AND TABLE_NAME = "' . _DB_PREFIX_ . bqSQL($table) . '" AND COLUMN_NAME = "' . pSQL($key) . '"')) {
                    $query .= 'ALTER TABLE `' . _DB_PREFIX_ . bqSQL($table) . '` ADD COLUMN `' . bqSQL($key) . '` ' . bqSQL($val) . ';';
                }
            }
        }

        // Indexes:
        if ($indexes) {
            foreach ($indexes as $index) {
                if (!Db::getInstance()->getValue('SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA = "' . _DB_NAME_ . '" AND TABLE_NAME = "' . _DB_PREFIX_ . bqSQL($table) . '" AND INDEX_NAME = "' . pSQL($index) . '"')) {
                    $query .= 'ALTER TABLE `' . _DB_PREFIX_ . bqSQL($table) . '` ADD INDEX (`' . bqSQL($index) . '`);';
                }
            }
        }
        // Try execute:
        if (trim($query) !== '') {
            Db::getInstance()->execute('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";SET time_zone = "+00:00";' . $query);
        }

        return $this;
    }

    public static function mappingShops($mapping)
    {
        if (!is_array($mapping)) {
            $mapping = array($mapping);
        }
        if ($mapping) {
            Db::getInstance()->execute('TRUNCATE TABLE `' . _DB_PREFIX_ . 'ets_em_shop_mapping`');
            $query = 'INSERT INTO `' . _DB_PREFIX_ . 'ets_em_shop_mapping`(id_shop_source, id_shop_target) VALUES';
            foreach ($mapping as $id_shop1 => $id_shop2) {
                $query .= '(' . (int)$id_shop1 . ', ' . (int)$id_shop2 . '),';
            }
            Db::getInstance()->execute(rtrim($query, ','));
        }
    }

    public function loadMappingShops()
    {
        if (!self::$mapping_shop) {
            $qd = new DbQuery();
            $qd
                ->select('*')
                ->from('ets_em_shop_mapping');
            if ($mapping = Db::getInstance()->executeS($qd)) {
                foreach ($mapping as $item) {
                    if (isset($item['id_shop_source']) && (int)$item['id_shop_source']) {
                        self::$mapping_shop[(int)$item['id_shop_source']] = (int)$item['id_shop_target'];
                        if ((int)$item['id_shop_source'])
                            self::$source_shops[] = (int)$item['id_shop_source'];
                        if ((int)$item['id_shop_target'])
                            self::$target_shops[] = (int)$item['id_shop_target'];
                    }
                }
            }
        }
        return self::$mapping_shop;
    }

    public static function file_get_contents($url, $use_include_path = false, $stream_context = null, $curl_timeout = 60, $opts = [])
    {
        $post = is_array($opts) && count($opts) > 0 ? 1 : 0;
        if ($post) {
            $opts = http_build_query($opts);
        }
        if ($stream_context == null && preg_match('/^https?:\/\//', $url)) {
            $stream_context = stream_context_create(array(
                "http" => array(
                    'method' => $post ? "POST" : "GET",
                    "timeout" => $curl_timeout,
                    "max_redirects" => 101,
                    "header" => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                    'content' => $opts
                ),
                "ssl" => array(
                    "allow_self_signed" => true,
                    "verify_peer" => false,
                    "verify_peer_name" => false,
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
                CURLOPT_POST => $post,
                CURLOPT_POSTFIELDS => $opts
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

    public function getRecordsSource($migrating = '')
    {
        $infos = $this->getDataInfos();
        if ($infos && isset($infos['nb']) && is_array($infos['nb']) && count($infos['nb']) > 0) {
            $total_record = 0;
            if ($migrating) {
                $diff = array_diff($this->getDataToMigrate(), $this->getMigrated());
                if (count($diff) > 0) {
                    foreach ($diff as $resource) {
                        if (isset($infos['nb'][$resource]) && count($infos['nb'][$resource]) > 0 && isset($infos['nb'][$resource]['nb_group_table']) && $infos['nb'][$resource]['nb_group_table'] > 0) {
                            $total_record += (int)$infos['nb'][$resource]['nb_group_table'];
                        }
                    }
                }
                return $total_record;
            } else {
                foreach ($infos['nb'] as $resource => $info) {
                    if (isset($info['nb_group_table']) && $info['nb_group_table'] > 0) {
                        $total_record += (int)$info['nb_group_table'];
                    }
                }
                return $total_record;
            }
        }

        return 0;
    }

    /**
     * @param string $task
     * @return array
     */
    public function getDataInfos($task = null)
    {
        if (!$this->data_infos) {
            $this->data_infos = json_decode(Configuration::getGlobalValue(self::$prefix . 'DATA_INFO_SOURCE'), true);
        }
        if (trim($task) !== '') {
            return isset($this->data_infos['nb'][$task]) ? $this->data_infos['nb'][$task] : [];
        }
        return $this->data_infos;
    }

    /**
     * @param array $data_infos
     * @param null $task
     * @return EMDataImport
     */
    public function setDataInfos($data_infos, $task = null)
    {
        if (trim($task) !== '') {
            $this->data_infos['nb'][$task] = $data_infos;
        } else
            $this->data_infos = $data_infos;
        Configuration::updateGlobalValue(self::$prefix . 'DATA_INFO_SOURCE', $this->data_infos ? json_encode($this->data_infos) : '', true);

        return $this;
    }

    public function setMigrated($task)
    {
        if (!in_array($task, $this->data_migrated)) {
            $this->data_migrated[] = $task;
            Configuration::updateGlobalValue(self::$prefix . 'DATA_MIGRATED', $this->data_migrated ? implode(',', $this->data_migrated) : '', true);
        }

        return $this;
    }

    public function getMigrated($task = null)
    {
        if (!$this->data_migrated) {
            $this->data_migrated = ($tasks = trim(Configuration::getGlobalValue(self::$prefix . 'DATA_MIGRATED'))) ? explode(',', $tasks) : [];
        }
        return trim($task) !== '' ? in_array($task, $this->data_migrated) : $this->data_migrated;
    }

    public function cleanMigrated()
    {
        $this->data_migrated = [];
        Configuration::updateGlobalValue(self::$prefix . 'DATA_MIGRATED', '');

        return $this;
    }

    public function setMigrate($tables = array())
    {
        $this->group_tables = $tables;
        Configuration::updateGlobalValue(self::$prefix . 'GROUP_TABLES', $tables ? implode(',', $tables) : '', true);

        return $this;
    }

    public function getMigrate()
    {
        if (!$this->group_tables) {
            $this->group_tables = ($tables = trim(Configuration::getGlobalValue(self::$prefix . 'GROUP_TABLES'))) ? explode(',', $tables) : [];
        }
        return $this->group_tables;
    }

    public function setOffset($offset = 0)
    {
        $this->offset = $offset;
        Configuration::updateGlobalValue(self::$prefix . 'MIGRATE_OFFSET', $this->offset, true);

        return $this;
    }

    public function getOffset()
    {
        if (!$this->offset) {
            $this->offset = (int)Configuration::getGlobalValue(self::$prefix . 'MIGRATE_OFFSET');
        }
        return $this->offset;
    }

    public function setMigrateActive($table = null)
    {
        if ($table === null) {
            $this->migrate_active = [];
        } else {
            if (is_array($this->migrate_active) && count($this->migrate_active) > 1) {
                $this->migrate_active = [];
            }
            $this->migrate_active[$table] = $table;
        }
        Configuration::updateGlobalValue(self::$prefix . 'MIGRATE_ACTIVE', json_encode($this->migrate_active), true);

        return $this;
    }

    public function getMigrateActive($table = null)
    {
        if (!$this->migrate_active ||
            $table !== null && !isset($this->migrate_active[$table])
        ) {
            $this->migrate_active = json_decode(Configuration::getGlobalValue(self::$prefix . 'MIGRATE_ACTIVE'), true);
        }
        return $table !== null && isset($this->migrate_active[$table]) && trim($this->migrate_active[$table]) !== '' ? $this->migrate_active[$table] : array_shift($this->migrate_active);
    }

    public function getMigrateFields($table = null)
    {
        if ($table === null) {
            return [];
        }
        if (!$this->migrate_fields ||
            !isset($this->migrate_fields[$table])
        ) {
            $this->migrate_fields = json_decode(Configuration::getGlobalValue(self::$prefix . 'MIGRATE_FIELDS'), true);
        }
        return isset($this->migrate_fields[$table]) && is_array($this->migrate_fields[$table]) && count($this->migrate_fields[$table]) > 0 ? $this->migrate_fields[$table] : [];
    }

    public function setMigrateFields($table = null, $fields = array())
    {
        if ($table === null) {
            $this->migrate_fields = [];
        } else {
            if (is_array($this->migrate_fields) && count($this->migrate_fields) > 1) {
                $this->migrate_fields = [];
            }
            $this->migrate_fields[$table] = $fields;
        }
        Configuration::updateGlobalValue(self::$prefix . 'MIGRATE_FIELDS', json_encode($this->migrate_fields), true);

        return $this;
    }

    public function getMigratePrimary($table = null)
    {
        if ($table === null) {
            return [];
        }
        if (!$this->migrate_primary ||
            !isset($this->migrate_primary[$table])
        ) {
            $this->migrate_primary = json_decode(Configuration::getGlobalValue(self::$prefix . 'MIGRATE_PRIMARY'), true);
        }
        return isset($this->migrate_primary[$table]) && is_array($this->migrate_primary[$table]) && count($this->migrate_primary[$table]) > 0 ? $this->migrate_primary[$table] : [];
    }

    public function setMigratePrimary($table = null, $primary = array())
    {
        if ($table === null) {
            $this->migrate_primary = [];
        } else {
            if (is_array($this->migrate_primary) && count($this->migrate_primary) > 1) {
                $this->migrate_primary = [];
            }
            $this->migrate_primary[$table] = $primary;
        }
        Configuration::updateGlobalValue(self::$prefix . 'MIGRATE_PRIMARY', json_encode($this->migrate_primary), true);

        return $this;
    }

    public function getMigrateSchema($table = null)
    {
        if ($table === null) {
            return [];
        }
        if (!$this->migrate_schema ||
            !isset($this->migrate_schema[$table])
        ) {
            $this->migrate_schema = json_decode(Configuration::getGlobalValue(self::$prefix . 'MIGRATE_SCHEMA'), true);
        }
        return isset($this->migrate_schema[$table]) && is_array($this->migrate_schema[$table]) && count($this->migrate_schema[$table]) > 0 ? $this->migrate_schema[$table] : [];
    }

    public function setMigrateSchema($table = null, $schema = array())
    {
        if ($table === null) {
            $this->migrate_schema = [];
        } else {
            if (is_array($this->migrate_schema) && count($this->migrate_schema) > 1) {
                $this->migrate_schema = [];
            }
            $this->migrate_schema[$table] = $schema;
        }
        Configuration::updateGlobalValue(self::$prefix . 'MIGRATE_SCHEMA', json_encode($this->migrate_schema), true);

        return $this;
    }

    public function hasOldId($id, $table = null)
    {
        if (!$this->old_id_exist)
            $this->getOldIdExist();
        $ids = isset($this->old_id_exist[$table]) && is_array($this->old_id_exist[$table]) && count($this->old_id_exist[$table]) > 0 ? $this->old_id_exist[$table] : [];
        if ($ids) {
            foreach ($ids as $id_old) {
                if (trim($id_old) === trim($id)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getOldIdExist()
    {
        if (!$this->old_id_exist) {
            $this->old_id_exist = json_decode(trim(Configuration::getGlobalValue(self::$prefix . 'OLD_ID_EXIST')), true);
        }
        return $this->old_id_exist;
    }

    public function setOldIdExist($table, $id)
    {
        if (!$this->hasOldId($id, $table)) {
            if (isset($this->old_id_exist[$table])) {
                $this->old_id_exist[$table][] = $id;
            } else {
                $this->old_id_exist[$table] = [$id];
            }
            Configuration::updateGlobalValue(self::$prefix . 'OLD_ID_EXIST', json_encode($this->old_id_exist), true);
        }

        return $this;
    }

    public function cleanOldId()
    {
        $this->old_id_exist = [];
        Configuration::updateGlobalValue(self::$prefix . 'OLD_ID_EXIST', '');

        return $this;
    }

    /**
     * @return $this
     */
    public function cleanDb()
    {
        $query = '
            SELECT TABLE_NAME, COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE (COLUMN_NAME REGEXP \'^id_[a-zA-Z0-9\_]+_ets_old$\' 
                OR COLUMN_NAME REGEXP \'^[a-zA-Z0-9\_]+' . pSQL(self::$image_field_unique) . '$\' 
                OR COLUMN_NAME REGEXP \'^[a-zA-Z0-9\_]+' . pSQL(self::$file_field_unique) . '$\') 
                AND TABLE_SCHEMA=\'' . _DB_NAME_ . '\';
        ';
        if ($collections = Db::getInstance()->executeS($query)) {
            $drop_query = '';
            foreach ($collections as $schema) {
                $drop_query .= 'ALTER TABLE ' . pSQL($schema['TABLE_NAME']) . ' DROP COLUMN ' . $schema['COLUMN_NAME'] . ';';
            }
            if ($drop_query)
                Db::getInstance()->execute('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";SET time_zone = "+00:00";' . $drop_query);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public static function cleanShopsMapping()
    {
        return Db::getInstance()->execute('TRUNCATE TABLE ' . _DB_PREFIX_ . 'ets_em_shop_mapping');
    }

    /**
     * @return array
     */
    public function getDataToMigrate()
    {
        if (!$this->data_to_migrate) {
            $this->data_to_migrate = explode(',', trim(Configuration::getGlobalValue(self::$prefix . 'DATA_TO_MIGRATE')));
        }
        return $this->data_to_migrate;
    }

    /**
     * @param array|string $data
     * @return EMDataImport
     */
    public function setDataToMigrate($data)
    {
        if (is_array($data)) {
            $this->data_to_migrate = $data;
        } elseif (!in_array($data, $this->data_to_migrate)) {
            $this->data_to_migrate[] = trim($data);
        }
        Configuration::updateGlobalValue(self::$prefix . 'DATA_TO_MIGRATE', $this->data_to_migrate ? implode(',', $this->data_to_migrate) : '');

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        if (!$this->count) {
            $this->count = (int)Configuration::getGlobalValue(self::$prefix . 'RESOURCE_COUNT');
        }
        return (int)$this->count;
    }

    public function setCount($count = 0)
    {
        $this->count = (int)$count;
        Configuration::updateGlobalValue(self::$prefix . 'RESOURCE_COUNT', (int)$this->count);

        return $this;
    }

    /**
     * @param string $field
     * @return array
     */
    public function getFieldsDefault($field = '')
    {
        if (trim($field) !== '') {
            return isset($this->fields_default[$field]) ? $this->fields_default[$field] : null;
        }
        return $this->fields_default;
    }

    /**
     * @param $fields
     * @return EMDataImport
     */
    public function setFieldsDefault($fields)
    {
        $this->fields_default = $fields;

        return $this;
    }

    /**
     * @param null $table
     * @return array
     */
    public function getMigrateImages($table = null)
    {
        if (!$this->migrate_images) {
            $this->migrate_images = json_decode(Configuration::getGlobalValue(self::$prefix . 'RESOURCE_IMAGES'), true);
        }
        return $table ? (isset($this->migrate_images[$table]) && is_array($this->migrate_images[$table]) && count($this->migrate_images[$table]) > 0 ? $this->migrate_images[$table] : []) : $this->migrate_images;
    }

    /**
     * @param array $migrate_images
     * @return EMDataImport
     */
    public function setMigrateImages($migrate_images = [])
    {
        $this->migrate_images = $migrate_images;
        Configuration::updateGlobalValue(self::$prefix . 'RESOURCE_IMAGES', json_encode($this->migrate_images));

        return $this;
    }

    public function getTableImages()
    {
        if (!$this->table_images) {
            $this->table_images = json_decode(Configuration::getGlobalValue(self::$prefix . 'TABLE_IMAGES'), true);
        }
        return $this->table_images;
    }

    /**
     * @param array $table_images
     * @return EMDataImport
     */
    public function setTableImages($table_images = [])
    {
        $this->table_images = $table_images;
        Configuration::updateGlobalValue(self::$prefix . 'TABLE_IMAGES', json_encode($this->table_images));

        return $this;
    }

    private $migrate_files = [];

    /**
     * @param null $table
     * @return array
     */
    public function getMigrateFiles($table = null)
    {
        if (!$this->migrate_files) {
            $this->migrate_files = json_decode(Configuration::getGlobalValue(self::$prefix . 'RESOURCE_FILES'), true);
        }
        return $table ? (isset($this->migrate_files[$table]) && is_array($this->migrate_files[$table]) && count($this->migrate_files[$table]) > 0 ? $this->migrate_files[$table] : []) : $this->migrate_files;
    }

    /**
     * @param array $migrate_files
     * @return EMDataImport
     */
    public function setMigrateFiles($migrate_files = [])
    {
        $this->migrate_files = $migrate_files;
        Configuration::updateGlobalValue(self::$prefix . 'RESOURCE_FILES', json_encode($this->migrate_files));

        return $this;
    }

    private $table_files = [];

    public function getTableFiles()
    {
        if (!$this->table_files) {
            $this->table_files = json_decode(Configuration::getGlobalValue(self::$prefix . 'TABLE_FILES'), true);
        }
        return $this->table_files;
    }

    /**
     * @param array $table_files
     * @return EMDataImport
     */
    public function setTableFiles($table_files = [])
    {
        $this->table_files = $table_files;
        Configuration::updateGlobalValue(self::$prefix . 'TABLE_FILES', json_encode($this->table_files));

        return $this;
    }


    /**
     * @return array
     */
    public function getLanguages()
    {
        if (!self::$languages) {
            self::$languages = explode(',', trim(Configuration::getGlobalValue(self::$prefix . 'LANGUAGES')));
        }
        return self::$languages;
    }

    /**
     * @param array $languages
     * @return EMDataImport
     */
    public function setLanguages($languages = [])
    {
        self::$languages = $languages;
        Configuration::updateGlobalValue(self::$prefix . 'LANGUAGES', count(self::$languages) > 0 ? implode(',', self::$languages) : '');

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultLanguage()
    {
        if (!self::$default_language) {
            self::$default_language = (int)Configuration::getGlobalValue(self::$prefix . 'LANG_DEFAULT');
        }
        return self::$default_language;
    }

    /**
     * @param mixed $default_language
     * @return EMDataImport
     */
    public function setDefaultLanguage($default_language = 0)
    {
        self::$default_language = (int)$default_language;
        Configuration::updateGlobalValue(self::$prefix . 'LANG_DEFAULT', self::$default_language > 0 ? self::$default_language : '');


        return $this;
    }

    /**
     * @param $iso_code
     * @return array|bool
     */
    public function getMigratedLang($iso_code = null)
    {
        $iso_code = trim(Tools::strtolower($iso_code));
        if (!$this->migrated_lang) {
            $this->migrated_lang = ($res = trim(Configuration::getGlobalValue(self::$prefix . 'MIGRATED_LANG'))) !== '' ? explode(',', $res) : [];
        }
        return $iso_code !== '' ? (in_array($iso_code, $this->migrated_lang) ? $iso_code : false) : $this->migrated_lang;
    }

    /**
     * @param $iso_code
     * @return EMDataImport
     */
    public function setMigratedLang($iso_code = null)
    {
        if (trim($iso_code) == '') {
            $this->migrated_lang = [];
        } elseif (!in_array($iso_code, $this->migrated_lang)) {
            $this->migrated_lang[] = $iso_code;
        }
        Configuration::updateGlobalValue(self::$prefix . 'MIGRATED_LANG', count($this->migrated_lang) > 0 ? implode(',', $this->migrated_lang) : '');

        return $this;
    }

    /**
     * @return int
     */
    public function getLanguagePack()
    {
        if (!$this->language_pack) {
            $this->language_pack = (int)Configuration::getGlobalValue(self::$prefix . 'LANGUAGE_PACK') ? 1 : 0;
        }

        return $this->language_pack;
    }

    /**
     * @param int $language_pack
     * @return EMDataImport
     */
    public function setLanguagePack($language_pack = 0)
    {
        $this->language_pack = $language_pack;
        Configuration::updateGlobalValue(self::$prefix . 'LANGUAGE_PACK', $this->language_pack > 0 ? 1 : 0);

        return $this;
    }

    public static function cleanAll($cleanDb = true)
    {
        $import = self::getInstance();
        $import
            ->cleanMigrated()
            ->setOffset()
            ->setCount()
            ->setMigrate()
            ->setMigrateFields()
            ->setMigratePrimary()
            ->cleanOldId()
            ->setMigrateActive()
            ->setMigrateSchema()
            ->setMigrateImages()
            ->setTableImages()
            ->setMigrateFiles()
            ->setTableFiles()
            ->setDefaultLanguage()
            ->setLanguages()
            ->setMigratedLang()
            ->setLanguagePack()
            ->setLanguageMigrate()
            ->cleanUnique();
        if ($cleanDb) {
            $import->cleanDb();
        }
    }

    public function beforeGenerateImage($task)
    {
        $infos = $this->getDataInfos($task);
        $images = $this->getMigrateImages();

        if (is_array($images)
            && count($images) > 0
            && !isset($infos['nb_group_table'])
        ) {
            $infos['nb_group_table'] = 0;
            $tables = [];
            foreach ($images as $table => $struct_image) {
                $fields = [];
                foreach ($struct_image as $st) {
                    $id_entity = (isset($st['field']) && trim($st['field']) !== '' ? $st['field'] : 'id_' . $table) . self::$image_field_unique;
                    if ($this->hasOldId($id_entity, $table)) {
                        $fields[] = $id_entity;
                    }
                }
                if (count($fields) > 0) {
                    $infos['nb_group_table'] += $this->fetch($table, '*', true, 0, 0, $fields);
                    $tables[] = $table;
                }
            }
            $this
                ->setDataInfos($infos, $task)
                ->setMigrate($tables)
                ->setOffset();
        }
        return $this;
    }

    public function beforeGenerateFile($task)
    {
        $infos = $this->getDataInfos($task);
        $files = $this->getMigrateFiles();

        if (is_array($files)
            && count($files) > 0
            && !isset($infos['nb_group_table'])
        ) {
            $infos['nb_group_table'] = 0;
            $tables = [];
            foreach ($files as $entity => $struct_file) {
                $fields = [];
                foreach ($struct_file as $st) {
                    $id_entity = (isset($st['field']) && trim($st['field']) !== '' ? $st['field'] : 'id_' . trim($entity)) . self::$file_field_unique;
                    if ($this->hasOldId($id_entity, $entity)) {
                        $fields[] = $id_entity;
                    }
                }
                if (count($fields) > 0) {
                    $infos['nb_group_table'] += $this->fetch($entity, '*', true, 0, 0, $fields);
                    $tables[] = $entity;
                }
            }
            $this
                ->setDataInfos($infos, $task)
                ->setMigrate($tables)
                ->setOffset();
        }
        return $this;
    }

    public function fetch($table, $select = '*', $number_of_record = false, $offset = 0, $limit = 0, $fields = [])
    {
        if (EMTools::tableExist($table)) {
            $dq = new DbQuery();
            $select = (trim($select) !== '*' ? pSQL($select) : '*');
            if ($number_of_record) {
                $dq->select('COUNT(' . $select . ')');
            } else {
                $dq
                    ->select($select);
                if (trim($table) == 'image') {
                    $dq
                        ->select('p.`id_product_ets_old`')
                        ->leftJoin('product', 'p', 'a.`id_product` = p.`id_product`')
                        ->orderBy('id_image');
                }
            }
            $dq
                ->from($table, 'a');
            if (is_array($fields)
                && count($fields) > 0
            ) {
                $queries = [];
                foreach ($fields as $field) {
                    $queries[] = 'a.`' . trim($field) . '` is NOT NULL';
                }
                $dq
                    ->where(implode(' OR ', $queries));
            }
            if ($number_of_record) {
                return (int)Db::getInstance()->getValue($dq);
            }
            if ($limit) {
                $dq->limit($limit, $offset);
            }
            return Db::getInstance()->executeS($dq);
        }

        return $number_of_record ? 0 : [];
    }
}