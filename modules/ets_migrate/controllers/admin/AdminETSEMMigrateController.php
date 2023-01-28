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

class AdminETSEMMigrateController extends ModuleAdminController
{
    public function ajaxProcessSettingForm()
    {
        $this->jsonRender([
            'form' => $this->module->renderForm('speed'),
        ]);
    }

    public function ajaxProcessNewMigrate()
    {
        EMDataImport::cleanAll();
        $this->jsonRender([
            'new_migrate' => 1
        ]);
    }

    public function ajaxProcessMigrate()
    {
        $new_setting = (int)Tools::getValue('new_setting', 0);
        if ($new_setting > 0) {
            $this->module->_postConfig();
            return $this->ajaxProcessConnector();
        }
        $step = (int)Tools::getValue('current_step');
        if ($step > 0 && $step !== 3) {
            $import = EMDataImport::getInstance();
            $import->init();
            if ($import->getMigrated()) {
                $diff = array_diff($import->getDataToMigrate(), $import->getMigrated());
                if (count($diff) > 0) {
                    $task = array_shift($diff);
                    Configuration::updateGlobalValue('ETS_EM_MIGRATE_SPEED', (int)Tools::getValue('ETS_EM_MIGRATE_SPEED'));
                    $info = $import->getDataInfos($task);
                    $this->jsonRender([
                        'continue' => 1,
                        'process' => $this->module->processMigrate('process'),
                        'step' => 3,
                        'migrating' => $task,
                        'percent' => isset($info['nb_group_table']) && (int)$info['nb_group_table'] > 0 ? $import->getCount() * 100 / $info['nb_group_table'] : 0,
                    ]);
                }
            }
        }
        if ($step < 3) {
            $this->module->_postConfig();
        }
        switch ($step) {
            case '1':
                EMDataImport::cleanAll(false);
                $this->processSourceInfos();
                break;
            case '2':
                $json_data = [
                    'ok' => 1,
                ];
                if (!Tools::getValue('migrate_option')) {
                    $json_data += $this->module->processMigrate();
                }
                $this->jsonRender($json_data);
                break;
            case '3':
                $this->ajaxProcessConnector();
                break;
        }
    }

    public function ajaxProcessConnector()
    {
        // Init history:
        $import = EMDataImport::getInstance()->init();
        $import->setFieldsDefault($this->module->loadFieldsDefault());

        // Migrate data:
        if ($array_diff = array_diff($import->getDataToMigrate(), $import->getMigrated())) {
            while (count($array_diff) > 0) {
                $task = array_shift($array_diff);
                if (in_array($task, $import->getDataToMigrate()) && !in_array($task, $import->getMigrated())) {
                    // Before migrate:
                    switch (trim($task)) {
                        case 'images':
                            $this->processMigrateImage($task, $import);
                            break;
                        case 'files':
                            $this->processMigrateFile($task, $import);
                            break;
                        case 'finished':
                            $this->processFinished($task, $import);
                            break;
                        default:
                            if (trim($task) == 'minor_data'
                                && !$import->getLanguagePack()
                            ) {
                                // Import languages:
                                $this->processDownloadAndInstallLanguagePack($import);
                                $import->setLanguagePack(1);
                            }
                            if (!($migrate_tables = $import->getMigrate())) {
                                if (trim($task) === 'minor_data'
                                    && is_array(EMDataImport::$mapping_shop)
                                    && count(EMDataImport::$mapping_shop) > 1
                                    && !Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')
                                ) {
                                    // Multi-shops:
                                    $shop_target = 0;
                                    foreach (EMDataImport::$mapping_shop as $id_shop_target) {
                                        if ($id_shop_target >= 0) {
                                            $shop_target++;
                                            if ($shop_target > 1)
                                                break;
                                        }
                                    }
                                    if ($shop_target > 1) {
                                        Configuration::updateValue('PS_MULTISHOP_FEATURE_ACTIVE', 1);
                                        $tab = Tab::getInstanceFromClassName('AdminShopGroup');
                                        $tab->active = (bool)Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE');
                                        $tab->update();
                                    }
                                }
                                // Set migrate tables:
                                $resource = EMApi::getInstance()->getResources($task);
                                if (!is_array($resource['tables']) ||
                                    !count($resource['tables'])
                                ) {
                                    $import->setMigrated($task);
                                    continue 2;
                                }
                                $infos = $import->getDataInfos();
                                // Images:
                                $group_images = [];
                                if ($import->auto_migrate_image
                                    && isset($infos['images'])
                                    && (int)$infos['images'] > 0
                                    && isset($resource['images'])
                                    && count(($images = $resource['images'])) > 0
                                ) {
                                    foreach ($images as $table => $struct) {
                                        if (is_array($struct) && count($struct) > 0) {
                                            $group_images[] = $table;
                                        }
                                    }
                                }
                                // Attachments & Files:
                                $group_files = [];
                                if ($import->auto_migrate_file
                                    && isset($infos['files'])
                                    && (int)$infos['files'] > 0
                                    && isset($resource['files'])
                                    && count(($files = $resource['files'])) > 0
                                ) {
                                    foreach ($files as $table => $struct) {
                                        if (is_array($struct) && count($struct) > 0) {
                                            $group_files[] = $table;
                                        }
                                    }
                                }
                                $migrate_tables = $import
                                    ->setMigrate($resource['tables'])
                                    ->setTableImages($group_images)
                                    ->setTableFiles($group_files)
                                    ->getMigrate();
                                // Clean before migrate data:
                                if ($import->keep_all_id || $import->delete_all) {
                                    $import->cleanBeforeMigrateData($resource);
                                }
                            }
                            if ($migrate_tables) {
                                $this->processMigrateData($task, $migrate_tables, $import);
                            }
                            break;
                    }
                }
            }
        }
    }

    public function processDownloadAndInstallLanguagePack($import)
    {
        $time = time();
        if (!$import ||
            !$import instanceof EMDataImport
        ) {
            $import = EMDataImport::getInstance()->init();
        }
        $infos = $import->getDataInfos();
        $old_package = version_compare(_PS_VERSION_, '1.5.0.0', '<') ? 1 : 0;

        // Before import:
        if (!$import->getLanguageMigrate()
            && isset($infos['languages'])
            && is_array($infos['languages'])
            && count($infos['languages']) > 0
        ) {
            foreach ($infos['languages'] as $l) {
                if (isset($l['iso_code'])
                    && trim($l['iso_code']) !== ''
                    && ($iso_code = trim(Tools::strtolower($l['iso_code'])))
                    && (int)Language::getIdByIso($iso_code) <= 0
                ) {
                    $import->setLanguageMigrate($iso_code);
                }
            }
        }

        // Importing:
        $languages = $import->getLanguageMigrate();
        if (is_array($languages)
            && count($languages) > 0
        ) {
            $diff = array_diff($languages, $import->getMigratedLang());
            while (count($diff) > 0) {
                $iso_code = array_shift($diff);
                if (isset(EMDataImport::$iso_code_mappings[$iso_code]) && trim(EMDataImport::$iso_code_mappings[$iso_code]) !== '') {
                    $iso_code = EMDataImport::$iso_code_mappings[$iso_code];
                }
                if (!$import->getMigratedLang($iso_code)) {
                    if (!$old_package
                        && ($error = Language::downloadAndInstallLanguagePack($iso_code)) !== true
                        || $old_package
                        && !Language::checkAndAddLanguage($iso_code)
                    ) {
                        $language_name = '';
                        if (isset($infos['languages'])
                            && is_array($infos['languages'])
                            && count($infos['languages']) > 0
                        ) {
                            foreach ($infos['languages'] as $l) {
                                if ($iso_code == trim($l['iso_code'])) {
                                    $language_name = $l['name'];
                                    break;
                                }
                            }
                        }
                        if (!$old_package && !empty($error)) {
                            $this->errors[] = implode(PHP_EOL, $error) . PHP_EOL . $this->module->linkLocalizationPack(trim($iso_code), $language_name);
                        } else {
                            $this->errors[] = sprintf($this->l('Import language by iso code "%s" failed!'), trim($iso_code)) . PHP_EOL . $this->module->linkLocalizationPack(trim($iso_code), $language_name);
                        }
                    } else {
                        $process_time = time() - $time;
                        $import->setMigratedLang($iso_code);
                        $this->jsonRender([
                            'ok' => 1,
                            'migrated_lang' => $iso_code,
                            'process_time' => $process_time,
                            'migrating' => 'minor_data',
                            'percent' => (80 / count($languages)) * count($import->getMigratedLang()),
                            'task_complete' => 0,
                        ]);
                    }
                }
            }
        }
        if (is_array($this->errors)
            && count($this->errors) > 0
        ) {
            $this->jsonRender([
                'error' => Tools::nl2br(implode(PHP_EOL, $this->errors)),
            ]);
        }
    }

    /**
     * @param $task
     * @param $migrate_tables
     * @param null $import
     * @param array $images
     * @return void
     */
    public function processMigrateData($task, $migrate_tables, $import = null)
    {
        $time = time();
        if (!$import ||
            !$import instanceof EMDataImport
        ) {
            $import = EMDataImport::getInstance()->init();
        }
        // Migrate table:
        if (is_array($migrate_tables)
            && count($migrate_tables) > 0
        ) {
            // Before request import:
            if ($import->package_14) {
                foreach ($migrate_tables as $key => $migrate_table) {
                    if (preg_match('/^[0-9a-zA-Z\_]+\_shop$/', $migrate_table)) {
                        unset($migrate_tables[$key]);
                    }
                }
            } elseif (in_array('currency_lang', $migrate_tables) && version_compare($import->package_version, '1.7.6.0', '<')) {
                unset($migrate_tables['currency_lang']);
            }
            $params = ['multi_shops' => count(EMDataImport::$source_shops) > 0 ? implode(',', EMDataImport::$source_shops) : ''];
            if (trim($task) == 'orders'
                && in_array('cart', $migrate_tables)
            ) {
                $params['ignore_cart'] = (int)Configuration::getGlobalValue('ETS_EM_MIGRATE_EMPTY_CART') > 0 ? 0 : 1;
            }
            $response = $this->processRequestApi($migrate_tables, $params, $import->getOffset(), $import->migrate_speed, $import->getTableImages(), $import->getTableFiles());
            $connect_time = time() - $time;
            $time = time();

            // After response:
            if (is_array($response)
                && count($response) > 0
            ) {
                $migrated_tables = [];
                $records_task = (int)$import->getCount();
                $ik = 0;
                $response_total = 0;
                foreach ($response as $table => $package) {
                    ++$ik;
                    if (
                        isset($package['data'])
                        && ($data = $package['data'])
                        && is_array($data)
                        && ($count = count($data)) > 0
                    ) {
                        // Get Foreign Key
                        $foreign_keys = [];
                        if ($import->keep_all_id) {
                            $foreign_keys = EMApi::getForeignKey($table);
                            $ignore_fields = $import->getIgnoreFields();
                            $foreign_keys = is_array($foreign_keys) && count($foreign_keys) > 0 && is_array($ignore_fields) && count($ignore_fields) > 0 ? array_intersect_assoc($foreign_keys, $ignore_fields) : [];
                        } elseif (trim($table) !== 'category') {
                            $foreign_keys = EMApi::getForeignKey($table);
                        }
                        $res = $import->importData($table, $data, $foreign_keys);
                        if (isset($res['ok'])
                            && (int)$res['ok'] > 0
                        ) {
                            $response_total += $count;
                            // Import table success:
                            if (isset($package['end'])
                                && $package['end'] > 0
                            ) {
                                $this->setMigratedTable($import, $table, $migrated_tables);
                            } else {
                                $import->setOffset($import->getOffset() + $count);
                            }
                        } elseif (!is_array($res)) {
                            $this->jsonRender([
                                'error' => sprintf($this->l('Import data into table "%s" failed due to timeout error. Please check the execute row limitation in MySQL'), $table),
                            ]);
                        } else {
                            $this->jsonRender([
                                'error' => sprintf($this->l('Could not import data into table "%s"'), $table),
                            ]);
                        }
                    } elseif (
                        isset($package['end'])
                        && $package['end'] > 0
                    ) {
                        $this->setMigratedTable($import, $table, $migrated_tables);
                    }
                }
                $records_task += $response_total;
                $records_left = $import->getRecordsSource($task) - $records_task;
                $diff = array_diff($migrate_tables, $migrated_tables);
                $import
                    ->setMigrate($diff)
                    ->setCount($records_task);
                if (count($diff) <= 0) {
                    $import
                        ->setCount()
                        ->setMigrated($task)
                        ->setOffset()
                        ->setMigrateFields();
                }
                $process_time = time() - $time;
                $total_time = $process_time + $connect_time;
                $info_task = $import->getDataInfos($task);

                // Response:
                $this->jsonRender([
                    'ok' => 1,
                    'tables_migrated' => count($migrated_tables) > 0 ? implode(',', $migrated_tables) : '',
                    'tables_left' => count($diff) > 0 ? implode(',', $diff) : '',
                    'table_importing' => $import->getMigrateActive(),
                    'total_time' => $total_time,
                    'connect_time' => $connect_time,
                    'process_time' => $process_time,
                    'migrating' => $task,
                    'records_task' => $records_task,
                    'percent' => isset($info_task['nb_group_table']) && (int)$info_task['nb_group_table'] > 0 ? ($records_task / $info_task['nb_group_table']) * 100 : 0,
                    'nb_group_table' => (int)$info_task['nb_group_table'],
                    'task_complete' => in_array($task, $import->getMigrated()) ? 1 : 0,
                    'records_left' => $records_left,
                ]);
            } elseif (!is_array($response)) {
                $this->jsonRender([
                    'error' => $this->l('Source store is not online! Please check your connection.'),
                ]);
            } else {
                // Imported task:
                $import
                    ->setCount()
                    ->setMigrated($task)
                    ->setOffset()
                    ->setMigrateFields()
                    ->setMigrate();

                // Response:
                $this->jsonRender([
                    'ok' => 1,
                    'table_importing' => $import->getMigrateActive(),
                    'migrating' => $task,
                    'percent' => 100,
                    'task_complete' => in_array($task, $import->getMigrated()) ? 1 : 0,
                ]);
            }
        } else {
            $this->jsonRender([
                'error' => $this->l('Migration log not found, migration cannot continue'),
            ]);
        }
    }

    /**
     * @param $task
     * @param null $import
     * @return void
     */
    public function processMigrateImage($task, $import = null)
    {
        $time = time();
        if (!$import ||
            !$import instanceof EMDataImport
        ) {
            $import = EMDataImport::getInstance()->init();
        }
        if (trim($task) !== 'images') {
            $import->setMigrated($task);
            return;
        }

        $import->beforeGenerateImage($task);
        if ($tables = $import->getMigrate()) {

            $records_task = (int)$import->getCount();
            $total = 0;
            $migrated_tables = [];

            while (count($tables) > 0 && $total < $import->migrate_image_speed) {

                $table = array_shift($tables);
                $offset = $import->getOffset();
                $limit = $import->migrate_image_speed - $total;
                $struct_images = $import->getMigrateImages($table);

                $fields = [];
                if (is_array($struct_images)
                    && count($struct_images) > 0
                ) {
                    $fields = [];
                    foreach ($struct_images as $struct) {
                        $id_entity = (isset($struct['field']) && trim($struct['field']) !== '' ? $struct['field'] : 'id_' . trim($table)) . EMDataImport::$image_field_unique;
                        if ($import->hasOldId($id_entity, $table)) {
                            $fields[] = $id_entity;
                        }
                    }
                }
                $data = count($fields) > 0 ? $import->fetch($table, 'a.*', false, $offset, $limit, $fields) : [];
                if (is_array($data)
                    && ($count = count($data)) > 0
                ) {
                    $total += $count;
                    $res = $import->importImage($table, $data);
                    if (isset($res['ok'])
                        && (int)$res['ok'] > 0
                        && $count < $limit
                    ) {
                        $import->setOffset();
                        $migrated_tables[] = $table;
                    } else
                        $import->setOffset($offset + $count);
                } else {
                    $import->setOffset();
                    $migrated_tables[] = $table;
                }
            }

            $records_task += $total;
            $diff = array_diff($import->getMigrate(), $migrated_tables);

            $import
                ->setMigrate($diff)
                ->setCount($records_task);
            if (count($diff) <= 0) {
                $import
                    ->setCount()
                    ->setMigrated($task)
                    ->setOffset();
            }
            $process_time = time() - $time;
            $info_task = $import->getDataInfos($task);
            $records_left = (int)$info_task['nb_group_table'] - $records_task;

            $this->jsonRender([
                'ok' => 1,
                'tables_migrated' => count($migrated_tables) > 0 ? implode(',', $migrated_tables) : '',
                'tables_left' => count($diff) > 0 ? implode(',', $diff) : '',
                'process_time' => $process_time,
                'migrating' => $task,
                'records_task' => $records_task,
                'percent' => isset($info_task['nb_group_table']) && (int)$info_task['nb_group_table'] > 0 ? ($records_task / $info_task['nb_group_table']) * 100 : 0,
                'nb_group_table' => (int)$info_task['nb_group_table'],
                'task_complete' => in_array($task, $import->getMigrated()) ? 1 : 0,
                'records_left' => $records_left,
            ]);
        } else {
            // Imported task:
            $import
                ->setCount()
                ->setMigrated($task)
                ->setOffset()
                ->setMigrate();
            $this->jsonRender([
                'ok' => 1,
                'migrating' => $task,
                'percent' => 100,
                'task_complete' => in_array($task, $import->getMigrated()) ? 1 : 0,
            ]);
        }
    }

    /**
     * @param $task
     * @param null $import
     * @return void
     */
    public function processMigrateFile($task, $import = null)
    {
        $time = time();
        if (!$import ||
            !$import instanceof EMDataImport
        ) {
            $import = EMDataImport::getInstance()->init();
        }
        if (trim($task) !== 'files') {
            $import->setMigrated($task);
            return;
        }

        $import->beforeGenerateFile($task);

        if ($tables = $import->getMigrate()) {

            $records_task = (int)$import->getCount();
            $total = 0;
            $migrated_tables = [];

            while (count($tables) > 0 && $total < $import->migrate_file_speed) {

                $table = array_shift($tables);
                $offset = $import->getOffset();
                $limit = $import->migrate_file_speed - $total;
                $struct_files = $import->getMigrateFiles($table);

                $fields = [];
                if (is_array($struct_files)
                    && count($struct_files) > 0
                ) {
                    $fields = [];
                    foreach ($struct_files as $struct) {
                        $id_entity = (isset($struct['field']) && trim($struct['field']) !== '' ? $struct['field'] : 'id_' . trim($table)) . EMDataImport::$file_field_unique;
                        if ($import->hasOldId($id_entity, $table)) {
                            $fields[] = $id_entity;
                        }
                    }
                }

                $data = count($fields) > 0 ? $import->fetch($table, 'a.*', false, $offset, $limit, $fields) : [];

                if (is_array($data) && ($count = count($data)) > 0) {
                    $total += $count;
                    $res = $import->importFiles($table, $data);
                    $import->setOffset($offset + $count);
                    if (isset($res['ok']) && (int)$res['ok'] > 0 && $count < $limit || $res === false) {
                        $import->setOffset();
                        $migrated_tables[] = $table;
                    }
                } else {
                    $import->setOffset();
                    $migrated_tables[] = $table;
                }
            }

            $records_task += $total;
            $diff = array_diff($import->getMigrate(), $migrated_tables);

            $import
                ->setMigrate($diff)
                ->setCount($records_task);

            if (count($diff) <= 0) {
                $import
                    ->setCount()
                    ->setMigrated($task)
                    ->setOffset();
            }
            $process_time = time() - $time;
            $info_task = $import->getDataInfos($task);
            $records_left = (int)$info_task['nb_group_table'] - $records_task;

            $this->jsonRender([
                'ok' => 1,
                'tables_migrated' => count($migrated_tables) > 0 ? implode(',', $migrated_tables) : '',
                'tables_left' => count($diff) > 0 ? implode(',', $diff) : '',
                'process_time' => $process_time,
                'migrating' => $task,
                'records_task' => $records_task,
                'percent' => isset($info_task['nb_group_table']) && (int)$info_task['nb_group_table'] > 0 ? ($records_task / $info_task['nb_group_table']) * 100 : 0,
                'nb_group_table' => (int)$info_task['nb_group_table'],
                'task_complete' => in_array($task, $import->getMigrated()) ? 1 : 0,
                'records_left' => $records_left,
                'offset' => $import->getOffset()
            ]);
        } else {
            // Imported task:
            $import
                ->setCount()
                ->setMigrated($task)
                ->setOffset()
                ->setMigrate();
            $this->jsonRender([
                'ok' => 1,
                'migrating' => $task,
                'percent' => 100,
                'task_complete' => in_array($task, $import->getMigrated()) ? 1 : 0,
            ]);
        }
    }

    /**
     * @param $task
     * @param null $import
     */
    public function processFinished($task, $import = null)
    {
        $time = time();
        if (!$import ||
            !$import instanceof EMDataImport
        ) {
            $import = EMDataImport::getInstance()->init();
        }

        // Re-build search products:
        if ($import->getMigrated('product') || $import->getMigrated('category')) {
            ini_set('max_execution_time', 7200);
            Tools::generateHtaccess();
            // Only import product:
            if ($import->getMigrated('product')) {
                Search::indexation(true);
            }
        }
        $manual_images = $manual_files = false;

        // Images:
        $infos = $import->getDataInfos();
        if (
            !$import->auto_migrate_image
            && !$import->getMigrated('images')
            && isset($infos['images'])
            && (int)$infos['images'] > 0
            && ($groups_images = $import->getMigrateImages())
            && is_array($groups_images)
            && count($groups_images) > 0
        ) {
            $manual_images = $groups_images;
        }

        // Attachments & Files:
        if (
            !$import->auto_migrate_file
            && !$import->getMigrated('files')
            && isset($infos['files'])
            && (int)$infos['files'] > 0
            && ($groups_files = $import->getMigrateFiles())
            && is_array($groups_files)
            && count($groups_files) > 0
        ) {
            $manual_files = $groups_files;
        }

        // Manual product thumbnail
        $manual_products_thumbnail = !$import->auto_product_thumb && $import->getMigrated('product') ? true : false;

        // Keep password:
        $keep_pwd = ($import->getMigrated('employee') || $import->getMigrated('customer')) && !Module::isInstalled('ets_passwordkeeper') ? true : false;

        // Clean all history:
        EMDataImport::cleanAll();

        $process_time = time() - $time;
        $this->jsonRender([
            'end' => 1,
            'process_time' => $process_time,
            'migrating' => $task,
            'percent' => 100,
            'task_complete' => 1,
            'images' => $manual_images,
            'files' => $manual_files,
            'ps_root_dir' => isset($infos['ps_root_dir']) ? trim($infos['ps_root_dir']) : _PS_ROOT_DIR_,
            'products_thumb' => $manual_products_thumbnail,
            'keep_pwd' => $keep_pwd,
            'msg' => $this->l('Import successfully!'),
        ]);
    }

    /**
     * @param $import
     * @param $table
     * @param array $migrated_tables
     */
    public function setMigratedTable($import, $table, &$migrated_tables)
    {
        if ($import instanceof EMDataImport && trim($table) !== '') {
            $migrated_tables[] = $table;
            $import
                ->setOffset()
                ->setMigrateFields($table);
            switch (trim($table)) {
                case 'category':
                    if ($import->package_14 || !$import->keep_all_id) {
                        EMTools::regenerateEntire();
                    } else {
                        EMTools::resetRootCategory();
                    }
                    EMTools::updateShopCategory();
                    Category::regenerateEntireNtree();
                    break;
                case 'stock_available':
                    if (version_compare($import->package_version, '1.5.0.2', '<') && version_compare(_PS_VERSION_, '1.5.0.2', '>=')) {
                        EMTools::setProductOutOfStock();
                    }
                    break;
                case 'product_supplier':
                    if (version_compare($import->package_version, '1.5.0.2', '<') && version_compare(_PS_VERSION_, '1.5.0.2', '>=')) {
                        EMTools::setProductSuppliers();
                    }
                    break;
                case 'lang':
                    $languages = EMTools::getDuplicateLanguages();
                    if (is_array($languages)
                        && count($languages) > 0
                    ) {
                        $import->setLanguages($languages);
                        if (!in_array((int)Configuration::get('PS_LANG_DEFAULT'), $languages)) {
                            $import->setDefaultLanguage((int)Configuration::get('PS_LANG_DEFAULT'));
                        } else {
                            $infos = $import->getDataInfos();
                            $import->setDefaultLanguage(isset($infos['lang_default']) && (int)$infos['lang_default'] > 0 ? $import->getNewIdByOldId('lang', 'id_lang', $infos['lang_default']) : 0);
                        }
                    }
                    break;
                case 'order_detail':
                    if (version_compare($import->package_version, '1.5.0.2', '<') && version_compare(_PS_VERSION_, '1.5.0.2', '>=')) {
                        if (!function_exists('migrate_orders')) {
                            require dirname(__FILE__) . '/../../classes/upgrade/migrate_orders.php';
                        }
                        $res = migrate_orders();
                        if (isset($res['error']) && $res['error'] > 0) {
                            $this->jsonRender([
                                'error' => isset($res['msg']) ? $res['msg'] : $this->l('Migrate order error!'),
                            ]);
                        }
                    }
                    break;
                case 'group_shop':
                    if (version_compare($import->package_version, '1.5.0.1', '<') && version_compare(_PS_VERSION_, '1.5.0.1', '>=')) {
                        if (!function_exists('upgrade_groups')) {
                            require dirname(__FILE__) . '/../../classes/upgrade/add_new_groups.php';
                        }
                        upgrade_groups();
                    } elseif (version_compare($import->package_version, '1.5.0.1', '>=')) {
                        $infos = $import->getDataInfos();
                        // Customer:
                        if (isset($infos['ps_customer_group']) && (int)$infos['ps_customer_group'] > 0) {
                            Configuration::updateValue('PS_CUSTOMER_GROUP', (int)$infos['ps_customer_group']);
                        }
                        // Visiter:
                        if (isset($infos['ps_unidentified_group']) && (int)$infos['ps_unidentified_group'] > 0) {
                            Configuration::updateValue('PS_UNIDENTIFIED_GROUP', (int)$infos['ps_unidentified_group']);
                        }
                        // Guest:
                        if (isset($infos['ps_guest_group']) && (int)$infos['ps_guest_group'] > 0) {
                            Configuration::updateValue('PS_GUEST_GROUP', (int)$infos['ps_guest_group']);
                        }
                    }
                    break;
                case 'order_history':
                    if (version_compare($import->package_version, '1.5.0.6', '<') && version_compare(_PS_VERSION_, '1.5.0.6', '>=')) {
                        EMTools::setCurrentState();
                    }
                    break;
                case 'specific_price':
                    if (version_compare($import->package_version, '1.5.0.12', '<') && version_compare(_PS_VERSION_, '1.5.0.12', '>=')) {
                        EMTools::updateSpecificPrice();
                    }
                    break;
                case 'carrier':
                    if (version_compare($import->package_version, '1.5.0.1', '<') && version_compare(_PS_VERSION_, '1.5.0.1', '>=')) {
                        EMTools::updateCarrierReference();
                    }
                    break;
            }
        }
    }

    public function processSourceInfos()
    {
        $import = EMDataImport::getInstance();
        $tables = EMApi::getInstance()->getResources(null, true);
        $response = $this->processRequestApi(json_encode($tables), ['infos' => 1]);
        if (!isset($response['error']) || trim($response['error']) == '') {
            if ($response) {
                $import->setDataInfos($response);
            }
            $response['target_shops'] = Shop::getShops();
            if (!$response || !isset($response['ps_version']) || !$response['ps_version']) {
                $this->errors[] = $this->l('Server is not connected');
            }
            if (count($this->errors) > 0) {
                $response['error'] = Tools::nl2br(implode(PHP_EOL, $this->errors));
            }
        }
        $this->jsonRender($response);
    }

    public function processRequestApi($table, $params = array(), $offset = 0, $speed = 0, $images = [], $files = [])
    {
        if (is_array($table)
            && !isset($params['infos'])
        ) {
            $table = implode(',', $table);
        }
        $http_build_query = [
            'table' => $table,
            'limit' => $speed,
            'offset' => $offset,
            'ps_version' => _PS_VERSION_,
        ];
        if (is_array($images) &&
            count($images) > 0
        ) {
            $http_build_query['images'] = implode(',', $images);
        }
        if (is_array($files) &&
            count($files) > 0
        ) {
            $http_build_query['files'] = implode(',', $files);
        }
        if ($params) {
            foreach ($params as $key => $param) {
                if (trim($param) !== '') {
                    $http_build_query[$key] = $param;
                }
            }
        }
        $response = EMDataImport::file_get_contents(EMApi::getInstance()->getRequestApi(), false, null, 60, $http_build_query);
        $response = json_decode($response, true);
        if (isset($response['json_error_utf8']) && $response['json_error_utf8'] > 0) {
            $response = $this->decodeUtf8ize($response);
        }

        return $response;
    }

    public function decodeUtf8ize($mixed)
    {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->decodeUtf8ize($value);
            }
        } else if (is_string($mixed)) {
            return utf8_decode($mixed);
        }
        return $mixed;
    }

    public function jsonRender($jsonData)
    {
        die(json_encode($jsonData));
    }
}
