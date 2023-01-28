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

class EMTools
{
    /**
     * @return bool
     */
    public static function setProductOutOfStock()
    {
        $id_shop_group = version_compare(_PS_VERSION_, '1.5.0.10', '>=') ? 'id_shop_group' : 'id_group_shop';
        // Set quantity:
        $query = '
            INSERT IGNORE INTO `' . _DB_PREFIX_ . 'stock_available` (
                `id_stock_available`
              , `id_product`
              , `id_product_attribute`
              , `id_shop`
              , `' . pSQL($id_shop_group) . '`
              ,`quantity`
            )
            SELECT * FROM (
                SELECT
                  NULL as `id_stock_available`
                   , `id_product`
                   , 0 as `id_product_attribute`
                   , `id_shop`
                   , `' . pSQL($id_shop_group) . '`
                   , SUM(`quantity`) as `quantity`
                FROM `' . _DB_PREFIX_ . 'stock_available`
                WHERE `id_product_attribute` > 0
                GROUP BY `id_product`, `id_shop`, `' . pSQL($id_shop_group) . '`
                UNION ALL
                SELECT NULL as `id_stock_available`
                     , p.`id_product`
                     , 0 as `id_product_attribute`
                     , shop.`id_shop`
                     , 0 as `' . pSQL($id_shop_group) . '`
                     , p.quantity
                FROM `' . _DB_PREFIX_ . 'product` p
                    INNER JOIN `' . _DB_PREFIX_ . 'product_shop` shop ON (shop.`id_product` = p.`id_product`)
                    LEFT JOIN `' . _DB_PREFIX_ . 'stock_available` stock ON (stock.`id_product` = p.`id_product` AND stock.`id_shop` = shop.`id_shop`)
                WHERE stock.`id_product` is NULL OR stock.`id_product` <= 0
                GROUP BY p.`id_product`, shop.`id_shop`
            ) st
            ON DUPLICATE KEY UPDATE `quantity` = st.`quantity`
        ';
        if ($res = Db::getInstance()->execute($query)) {

            // Set out of stock:
            $query = '
                UPDATE `' . _DB_PREFIX_ . 'stock_available` st
                    LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON p.`id_product` = st.`id_product`
                SET st.`out_of_stock` = p.`out_of_stock`
                WHERE st.`out_of_stock` is NULL OR st.`out_of_stock` <=0
            ';
            $res &= Db::getInstance()->execute($query);
        }

        return $res;
    }

    public static function regenerateEntire()
    {
        if ($res = Db::getInstance()->execute('
                UPDATE `' . _DB_PREFIX_ . 'category` 
                SET 
                    `id_parent` = ' . (int)Configuration::get('PS_HOME_CATEGORY') . ' 
                WHERE `is_root_category` != 1 
                    AND `id_parent` = ' . (int)Configuration::get('PS_ROOT_CATEGORY')
        )) {
            $res &= Db::getInstance()->execute('
                UPDATE `' . _DB_PREFIX_ . 'category` c
                    JOIN `' . _DB_PREFIX_ . 'category` lc ON c.`id_parent` = lc.`id_category_ets_old`
                SET 
                    c.`id_parent` = lc.`id_category`
                WHERE c.`id_parent` != 0 AND c.is_root_category != 1
            ');
        }

        return $res;
    }

    public static function resetRootCategory()
    {
        static $configs = [
            'PS_HOME_CATEGORY' => [
                'field' => 'is_root_category',
                'value' => 1,
            ],
            'PS_ROOT_CATEGORY' => [
                'field' => 'id_parent',
                'value' => 0,
            ]
        ];
        foreach ($configs as $key => $config) {
            if (($id_category = (int)Db::getInstance()->getValue('SELECT `id_category` FROM `' . _DB_PREFIX_ . 'category` WHERE `' . pSQL($config['field']) . '`=' . (int)$config['value']))
                && $id_category != (int)Configuration::get($key)
            ) {
                Db::getInstance()->update(
                    'configuration'
                    , ['value' => (int)$id_category]
                    , 'name=\'' . pSQL($key) . '\''
                );
            }
        }
    }

    public static function updateShopCategory()
    {
        $shops = Db::getInstance()->executeS('SELECT `id_shop`, `id_category` FROM `' . _DB_PREFIX_ . 'shop`');
        if (is_array($shops)
            && count($shops) > 0
        ) {
            foreach ($shops as $shop) {
                if (isset($shop['id_category'])
                    && $shop['id_category'] > 0
                    && isset($shop['id_shop'])
                    && $shop['id_shop'] > 0
                ) {
                    $id_category = (int)Db::getInstance()->getValue('SELECT `id_category` FROM `' . _DB_PREFIX_ . 'category` WHERE `id_category_ets_old`=' . (int)$shop['id_category']);
                    if ($id_category <= 0) {
                        $id_category = (int)Configuration::get('PS_HOME_CATEGORY');
                    }
                    if ($id_category != $shop['id_category']) {
                        Db::getInstance()->update(
                            'shop'
                            , ['id_category' => (int)$id_category]
                            , 'id_shop=' . (int)$shop['id_shop']
                        );
                    }
                }
            }
        }
    }

    public static function setProductSuppliers()
    {
        $ps_currency_default = Db::getInstance()->getValue('SELECT `value` FROM `' . _DB_PREFIX_ . 'configuration` WHERE name="PS_CURRENCY_DEFAULT"');

        //Get all products with positive quantity
        $resource = Db::getInstance()->query('
            SELECT id_supplier, id_product, supplier_reference, wholesale_price
            FROM `' . _DB_PREFIX_ . 'product`
            WHERE `id_supplier` > 0
        ');

        while ($row = Db::getInstance()->nextRow($resource)) {
            //Set default supplier for product
            Db::getInstance()->execute('
                INSERT IGNORE INTO `' . _DB_PREFIX_ . 'product_supplier`
                (`id_product`, `id_product_attribute`, `id_supplier`,
                    `product_supplier_reference`, `product_supplier_price_te`,
                    `id_currency`)
                VALUES
                ("' . (int)$row['id_product'] . '", "0", "' . (int)$row['id_supplier'] . '",
                "' . pSQL($row['supplier_reference']) . '", "' . (int)$row['wholesale_price'] . '",
                    "' . (int)$ps_currency_default . '")
            ');
            //Try to get product attribues
            $attributes = Db::getInstance()->executeS('
                SELECT id_product_attribute, supplier_reference, wholesale_price
                FROM `' . _DB_PREFIX_ . 'product_attribute`
                WHERE `id_product` = ' . (int)$row['id_product']
            );
            //Add each attribute to stock_available
            foreach ($attributes as $attribute) {
                // set supplier for attribute
                Db::getInstance()->execute('
                    INSERT IGNORE INTO `' . _DB_PREFIX_ . 'product_supplier`
                    (`id_product`, `id_product_attribute`,
                    `id_supplier`, `product_supplier_reference`,
                    `product_supplier_price_te`, `id_currency`)
                    VALUES
                    ("' . (int)$row['id_product'] . '", "' . (int)$attribute['id_product_attribute'] . '",
                    "' . (int)$row['id_supplier'] . '", "' . pSQL($attribute['supplier_reference']) . '",
                    "' . (int)$attribute['wholesale_price'] . '", "' . (int)$ps_currency_default . '")
                ');
            }
        }
    }

    public static function fetch($table, $nb = true, $select = null, $offset = 0, $limit = 0, $operators = [], $get_first = false)
    {
        $dq = new DbQuery();
        $dq->from($table);

        // Select:
        if ($nb) {
            $dq->select('COUNT(*)');
        } elseif (trim($select) !== '') {
            $dq->select($select);
        } else {
            $dq->select('*');
        }

        // Conditions:
        if (is_array($operators)
            && count($operators) > 0
        ) {
            foreach ($operators as $operator) {
                $dq->where($operator);
            }
        }
        // Get first:
        if ($nb ||
            $get_first
        ) {
            return (int)Db::getInstance()->getValue($dq);
        }

        if ($limit) {
            $dq->limit($limit, $offset);
        }
        return Db::getInstance()->executeS($dq);
    }

    public static function tableExist($table)
    {
        return Db::getInstance()->executeS('SHOW TABLES LIKE \'' . _DB_PREFIX_ . bqSQL($table) . '\'');
    }

    public static function quickSort($list, $field = 'position', $ignore_value = -1)
    {
        $left = $right = array();
        if (count($list) <= 1) {
            return $list;
        }
        $pivot_key = key($list);
        $pivot = array_shift($list);
        // partial:
        foreach ($list as $key => $val) {
            if ($val[$field] <= $pivot[$field]) {
                $left[$key] = $val;
            } elseif ($val[$field] > $pivot[$field]) {
                $right[$key] = $val;
            }
        }
        // recursive:
        return array_merge(self::quickSort($left, $field, $ignore_value), array($pivot_key => $pivot), self::quickSort($right, $field, $ignore_value));
    }

    public static function getDuplicateLanguages()
    {
        $dq = new DbQuery();
        $dq
            ->select('GROUP_CONCAT(`id_lang` SEPARATOR \',\')')
            ->from('lang')
            ->where('id_lang_ets_old is NULL');

        $res = Db::getInstance()->getValue($dq);
        return $res ? explode(',', $res) : [];
    }

    public static function setCurrentState()
    {
        return Db::getInstance()->execute('
            UPDATE `' . _DB_PREFIX_ . 'orders` o
            SET o.`current_state` = IFNULL((
                SELECT oh.`id_order_state`
                FROM `' . _DB_PREFIX_ . 'order_history` oh
                WHERE oh.`id_order` = o.`id_order`
                ORDER BY oh.`date_add` DESC
                LIMIT 1
            ), 0);
        ');
    }

    public static function updateSpecificPrice()
    {
        return Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'specific_price` SET `price` = -1 WHERE `price` = 0');
    }

    public static function updateCarrierReference()
    {
        return Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'carrier` SET `id_reference` = `id_carrier`');
    }
}