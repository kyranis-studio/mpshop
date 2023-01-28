<?php
/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

ob_start();
require_once(dirname(__FILE__) . '/../../config/config.inc.php');
@ini_set('display_errors', 'off');

$mod = Module::getInstanceByName('ets_migrate_connector');
$display_error = array();
if (!$mod->id) {
    $display_error[] = $mod->l('PrestaShop Connector module has not been installed on source store');
} elseif (!$mod->active) {
    $display_error[] = $mod->l('PrestaShop Connector module is disabled.');
} else {
    if (!(int)$mod->getFields('ETS_MC_ENABLED', true)) {
        $display_error[] = $mod->l('PrestaShop Connector has been turned off');
    } elseif (trim(Tools::getValue('token')) !== trim($mod->getFields('ETS_MC_ACCESS_TOKEN', true))) {
        $display_error[] = $mod->l('Access token is not correct. Connection is denied!');
    }
}
if (count($display_error) > 0) {
    die(json_encode(array(
        'error' => implode(PHP_EOL, $display_error),
    )));
}
// Execute request:
if ($mod->ps14 || $mod->ps13) {
    require_once _PS_MODULE_DIR_ . 'ets_migrate_connector/backward_compatibility/backward.php';
}
require_once(_PS_MODULE_DIR_ . 'ets_migrate_connector/classes/MCDb.php');

$export = MCDb::getInstance();
$table = Tools::getValue('table');
if (trim(($ignore_cart = Tools::getValue('ignore_cart', ''))) !== '' && Validate::isUnsignedInt($ignore_cart)) {
    $export->setIgnoreCart($ignore_cart);
}
if ((int)Tools::getValue('infos')) {
    $export->getInfos(json_decode($table, true));
} elseif (Tools::isSubmit('download')) {
    $export->downloadFile(Tools::getValue('filename'), Tools::getValue('field'), Tools::getValue('entity'));
} else {
    $tables = explode(',', $table);
    // Multi-shop:
    $multi_shops = Tools::getValue('multi_shops');
    if (trim($multi_shops) !== '') {
        $multi_shops_build = explode(',', $multi_shops);
        if (count($multi_shops_build) > 0) {
            $shops = array();
            foreach ($multi_shops_build as $id_shop) {
                if (Validate::isUnsignedInt($id_shop)) {
                    $shops[] = $id_shop;
                }
            }
            $export->setMultiShops($shops);
        }
    }
    // Images:
    $images = Tools::getValue('images');
    if (trim($images) !== '') {
        $images_build = explode(',', $images);
        if (count($images_build) > 0) {
            $migrate_images = array();
            foreach ($images_build as $image) {
                if (preg_match('/^[0-9a-zA-Z\_]+$/', $image)) {
                    $migrate_images[] = $image;
                }
            }
            $export->setImages($migrate_images);
        }
    }
    $offset = (int)Tools::getValue('offset');
    $limit = (int)Tools::getValue('limit');
    // Attachments & Files
    $files = Tools::getValue('files');
    if (trim($files) !== '') {
        $files_build = explode(',', $files);
        if (count($files_build) > 0) {
            $migrate_files = array();
            foreach ($files_build as $file) {
                if (preg_match('/^[0-9a-zA-Z\_]+$/', $file)) {
                    $migrate_files[] = $file;
                }
            }
            $export->setFiles($migrate_files);
        }
    }
    // ps_version:
    $ps_version = trim(Tools::getValue('ps_version'));
    if ($ps_version !== '') {
        $export->setPsVersion($ps_version);
    }

    $export->fetchGroups($tables, $offset, $limit);
}

ob_end_flush();
