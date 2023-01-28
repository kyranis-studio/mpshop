<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
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
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

function upgrade_groups()
{
    $id_group = (int)Db::getInstance()->getValue('SELECT id_group FROM `' . _DB_PREFIX_ . 'group` ORDER BY id_group ASC');
    if ($id_group <= 0) {
        $id_group = 1;
    }
    $res = Db::getInstance()->update('configuration', array('value' => $id_group, 'date_upd' => date('Y-m-d H:i:s')), 'name = "PS_CUSTOMER_GROUP"');
    if ($res) {
        $res &= add_new_groups('Visiteur', 'Visitor');
        $res &= add_new_groups('Invité', 'Guest');
    }

    return $res;
}

function add_new_groups($french, $standard)
{
    $res = Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'group` (`id_group`, `date_add`, `date_upd`) VALUES (NULL, NOW(), NOW())');
    $last_id = Db::getInstance()->Insert_ID();

    $languages = Db::getInstance()->executeS('SELECT id_lang, iso_code FROM `' . _DB_PREFIX_ . 'lang`');

    $sql = '';
    foreach ($languages as $lang) {
        if (Tools::strtolower($lang['iso_code']) == 'fr') {
            $sql .= '(' . (int)$last_id . ', ' . (int)$lang['id_lang'] . ', "' . pSQL($french) . '"),';
        } else {
            $sql .= '(' . (int)$last_id . ', ' . (int)$lang['id_lang'] . ', "' . pSQL($standard) . '"),';
        }
    }
    $sql = Tools::substr($sql, 0, Tools::strlen($sql) - 1);
    $res &= Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'group_lang` (`id_group`, `id_lang`, `name`) VALUES ' . $sql);
    // we add the different id_group in the configuration
    if (Tools::strtolower($standard) == 'visitor') {
        $res &= Db::getInstance()->update('configuration', array('value' => (int)$last_id, 'date_upd' => date('Y-m-d H:i:s')), 'name = "PS_UNIDENTIFIED_GROUP"');
    } elseif (Tools::strtolower($standard) == 'guest') {
        $res &= Db::getInstance()->update('configuration', array('value' => (int)$last_id, 'date_upd' => date('Y-m-d H:i:s')), 'name = "PS_GUEST_GROUP"');
    }

    // Add shop association
    $res &= Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'group_shop` (`id_group`, `id_shop`) (SELECT ' . (int)$last_id . ', `value` FROM `' . _DB_PREFIX_ . 'configuration` WHERE `name` = \'PS_SHOP_DEFAULT\')');

    // Copy categories associations from the group of id 1 (default group for both visitors and customers in version 1.4) to the new group
    $res &= Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'category_group` (`id_category`, `id_group`) (SELECT `id_category`, ' . (int)$last_id . ' FROM `' . _DB_PREFIX_ . 'category_group` WHERE `id_group` = 1)');

    return $res;
}
