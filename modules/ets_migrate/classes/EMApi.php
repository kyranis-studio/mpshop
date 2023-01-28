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

class EMApi
{
    const _API_LINK_ = '/modules/ets_migrate_connector/server.php';

    protected static $_INSTANCE;
    private $request_api;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->request_api = rtrim(Configuration::getGlobalValue('ETS_EM_DOMAIN'), '/') . self::_API_LINK_ . '?token=' . trim(Configuration::getGlobalValue('ETS_EM_ACCESS_TOKEN'));
    }

    public static function getInstance()
    {
        if (!self::$_INSTANCE) {
            self::$_INSTANCE = new EMApi();
        }
        return self::$_INSTANCE;
    }

    public function getRequestApi()
    {
        return $this->request_api;
    }

    static $_foreign_keys = [];

    public static function getForeignKey($table)
    {
        if (!self::$_foreign_keys) {
            self::$_foreign_keys = [
                'shop' => [
                    'shop_group' => 'id_shop_group',
                    'category' => 'id_category'
                ],
                'lang_shop' => [
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                ],
                'currency_shop' => [
                    'currency' => 'id_currency',
                    'shop' => 'id_shop',
                ],
                'currency_lang' => [
                    'currency' => 'id_currency',
                    'lang' => 'id_lang',
                ],
                'zone_shop' => [
                    'zone' => 'id_zone',
                    'shop' => 'id_shop',
                ],
                'country_lang' => [
                    'country' => 'id_country',
                    'lang' => 'id_lang'
                ],
                'country_shop' => [
                    'country' => 'id_country',
                    'shop' => 'id_shop'
                ],
                'profile_lang' => [
                    'profile' => 'id_profile',
                    'lang' => 'id_lang'
                ],
                'employee' => [
                    'profile' => 'id_profile',
                    'lang' => 'id_lang'
                ],
                'employee_shop' => [
                    'employee' => 'id_employee',
                    'shop' => 'id_shop'
                ],
                'group_lang' => [
                    'group' => 'id_group',
                    'lang' => 'id_lang',
                ],
                'group_shop' => [
                    'group' => 'id_group',
                    'shop' => 'id_shop',
                ],
                'category' => [
                    'category' => [
                        'id_parent' => 'id_category'
                    ],
                ],
                'category_lang' => [
                    'category' => 'id_category',
                    'lang' => 'id_lang',
                    'shop' => 'id_shop'
                ],
                'category_shop' => [
                    'category' => 'id_category',
                    'shop' => 'id_shop'
                ],
                'category_group' => [
                    'category' => 'id_category',
                    'group' => 'id_group'
                ],
                'manufacturer_lang' => [
                    'manufacturer' => 'id_manufacturer',
                    'lang' => 'id_lang'
                ],
                'manufacturer_shop' => [
                    'manufacturer' => 'id_manufacturer',
                    'shop' => 'id_shop'
                ],
                'supplier_lang' => [
                    'supplier' => 'id_supplier',
                    'lang' => 'id_lang'
                ],
                'supplier_shop' => [
                    'supplier' => 'id_supplier',
                    'shop' => 'id_shop'
                ],
                'customer' => [
                    'shop_group' => 'id_shop_group',
                    'shop' => 'id_shop',
                    'gender' => 'id_gender',
                    'lang' => 'id_lang',
                ],
                'customer_group' => [
                    'customer' => 'id_customer',
                    'group' => 'id_group',
                ],
                'address' => [
                    'country' => 'id_country',
                    'state' => 'id_state',
                    'customer' => 'id_customer',
                    'manufacturer' => 'id_manufacturer',
                    'supplier' => 'id_supplier',
                    'warehouse' => 'id_warehouse',
                ],
                'address_format' => [
                    'country' => 'id_country',
                ],
                'gender_lang' => [
                    'gender' => 'id_gender',
                    'lang' => 'id_lang',
                ],
                'carrier_lang' => [
                    'carrier' => 'id_carrier',
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                ],
                'carrier_shop' => [
                    'carrier' => 'id_carrier',
                    'shop' => 'id_shop',
                ],
                'carrier_group' => [
                    'carrier' => 'id_carrier',
                    'group' => 'id_group',
                ],
                'carrier_zone' => [
                    'carrier' => 'id_carrier',
                    'zone' => 'id_zone',
                ],
                'range_price' => [
                    'carrier' => 'id_carrier',
                ],
                'range_weight' => [
                    'carrier' => 'id_carrier',
                ],
                'delivery' => [
                    'carrier' => 'id_carrier',
                    'shop' => 'id_shop',
                    'shop_group' => 'id_shop_group',
                    'range_price' => 'id_range_price',
                    'range_weight' => 'id_range_weight',
                    'zone' => 'id_zone',
                ],
                'tag' => [
                    'lang' => 'id_lang'
                ],
                'tag_count' => [
                    'group' => 'id_group',
                    'tag' => 'id_tag',
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                ],
                'tax_lang' => [
                    'tax' => 'id_tax',
                    'lang' => 'id_lang',
                ],
                'tax_rules_group_shop' => [
                    'tax_rules_group' => 'id_tax_rules_group',
                    'shop' => 'id_shop',
                ],
                'tax_rule' => [
                    'tax_rules_group' => 'id_tax_rules_group',
                    'country' => 'id_country',
                    'state' => 'id_state',
                    'tax' => 'id_tax',
                ],
                'attachment_lang' => [
                    'attachment' => 'id_attachment',
                    'lang' => 'id_lang',
                ],
                'product' => [
                    'supplier' => 'id_supplier',
                    'manufacturer' => 'id_manufacturer',
                    'tax_rules_group' => 'id_tax_rules_group',
                    'category' => [
                        'id_category_default' => 'id_category'
                    ],
                    'shop' => 'id_shop_default',
                ],
                'product_lang' => [
                    'product' => 'id_product',
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                ],
                'product_shop' => [
                    'product' => 'id_product',
                    'shop' => 'id_shop',
                    'tax_rules_group' => 'id_tax_rules_group',
                    'category' => [
                        'id_category_default' => 'id_category'
                    ],
                ],
                'category_product' => [
                    'product' => 'id_product',
                    'category' => 'id_category',
                ],
                'accessory' => [
                    'product' => [
                        'id_product_1' => 'id_product',
                        'id_product_2' => 'id_product'
                    ],
                ],
                'product_tag' => [
                    'product' => 'id_product',
                    'tag' => 'id_tag',
                    'lang' => 'id_lang',
                ],
                'feature_lang' => [
                    'feature' => 'id_feature',
                    'lang' => 'id_lang',
                ],
                'feature_shop' => [
                    'feature' => 'id_feature',
                    'shop' => 'id_shop',
                ],
                'feature_value' => [
                    'feature' => 'id_feature',
                ],
                'feature_value_lang' => [
                    'feature_value' => 'id_feature_value',
                    'lang' => 'id_lang',
                ],
                'feature_product' => [
                    'feature' => 'id_feature',
                    'feature_value' => 'id_feature_value',
                    'product' => 'id_product',
                ],
                'attribute_group_lang' => [
                    'attribute_group' => 'id_attribute_group',
                    'lang' => 'id_lang',
                ],
                'attribute_group_shop' => [
                    'attribute_group' => 'id_attribute_group',
                    'shop' => 'id_shop',
                ],
                'attribute' => [
                    'attribute_group' => 'id_attribute_group',
                ],
                'attribute_lang' => [
                    'attribute' => 'id_attribute',
                    'lang' => 'id_lang',
                ],
                'attribute_shop' => [
                    'attribute' => 'id_attribute',
                    'shop' => 'id_shop',
                ],
                'attribute_impact' => [
                    'product' => 'id_product',
                    'attribute' => 'id_attribute',
                ],
                'product_attribute' => [
                    'product' => 'id_product',
                ],
                'product_attribute_shop' => [
                    'product_attribute' => 'id_product_attribute',
                    'product' => 'id_product',
                    'shop' => 'id_shop',
                ],
                'product_attribute_combination' => [
                    'product_attribute' => 'id_product_attribute',
                    'attribute' => 'id_attribute',
                ],
                'product_supplier' => [
                    'product_attribute' => 'id_product_attribute',
                    'product' => 'id_product',
                    'supplier' => 'id_supplier',
                    'currency' => 'id_currency',
                ],
                'pack' => [
                    'product' => [
                        'id_product_item' => 'id_product'
                    ],
                    'product_attribute' => [
                        'id_product_attribute_item' => 'id_product_attribute'
                    ],
                ],
                'product_sale' => [
                    'product' => 'id_product'
                ],
                'product_group_reduction_cache' => [
                    'product' => 'id_product',
                    'group' => 'id_group',
                ],
                'product_download' => [
                    'product' => 'id_product',
                ],
                'product_country_tax' => [
                    'product' => 'id_product',
                    'country' => 'id_country',
                    'tax' => 'id_tax',
                ],
                'product_carrier' => [
                    'product' => 'id_product',
                    'shop' => 'id_shop',
                    'carrier' => [
                        'id_carrier_reference' => 'id_carrier'
                    ],
                ],
                'product_attachment' => [
                    'product' => 'id_product',
                    'attachment' => 'id_attachment',
                ],
                'image' => [
                    'product' => 'id_product',
                ],
                'image_lang' => [
                    'image' => 'id_image',
                    'lang' => 'id_lang',
                ],
                'image_shop' => [
                    'image' => 'id_image',
                    'product' => 'id_product',
                    'shop' => 'id_shop',
                ],
                'product_attribute_image' => [
                    'product_attribute' => 'id_product_attribute',
                    'image' => 'id_image',
                ],
                'stock_available' => [
                    'product' => 'id_product',
                    'product_attribute' => 'id_product_attribute',
                    'shop' => 'id_shop',
                    'shop_group' => 'id_shop_group',
                ],
                'warehouse' => [
                    'currency' => 'id_currency',
                    'address' => 'id_address',
                    'employee' => 'id_employee',
                ],
                'warehouse_shop' => [
                    'shop' => 'id_shop',
                    'warehouse' => 'id_warehouse',
                ],
                'warehouse_carrier' => [
                    'carrier' => 'id_carrier',
                    'warehouse' => 'id_warehouse',
                ],
                'warehouse_product_location' => [
                    'product' => 'id_product',
                    'product_attribute' => 'id_product_attribute',
                    'warehouse' => 'id_warehouse',
                ],
                'stock' => [
                    'warehouse' => 'id_warehouse',
                    'product' => 'id_product',
                    'product_attribute' => 'id_product_attribute',
                ],
                'customization_field' => [
                    'product' => 'id_product',
                ],
                'customization_field_lang' => [
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                    'customization_field' => 'id_customization_field',
                ],
                'cart_rule' => [
                    'customer' => 'id_customer',
                ],
                'cart_rule_lang' => [
                    'cart_rule' => 'id_cart_rule',
                    'lang' => 'id_lang',
                ],
                'cart_rule_shop' => [
                    'cart_rule' => 'id_cart_rule',
                    'shop' => 'id_shop',
                ],
                'cart_rule_carrier' => [
                    'cart_rule' => 'id_cart_rule',
                    'carrier' => 'id_carrier',
                ],
                'cart_rule_combination' => [
                    'cart_rule' => [
                        'id_cart_rule_1' => 'id_cart_rule',
                        'id_cart_rule_2' => 'id_cart_rule',
                    ],
                ],
                'cart_rule_country' => [
                    'cart_rule' => 'id_cart_rule',
                    'country' => 'id_country',
                ],
                'cart_rule_group' => [
                    'cart_rule' => 'id_cart_rule',
                    'group' => 'id_group',
                ],
                'cart_rule_product_rule_group' => [
                    'cart_rule' => 'id_cart_rule',
                ],
                'cart_rule_product_rule' => [
                    'cart_rule_product_rule_group' => 'id_product_rule_group',
                ],
                'cart_rule_product_rule_value' => [
                    'cart_rule_product_rule' => 'id_product_rule',
                ],
                'specific_price_rule' => [
                    'shop' => 'id_shop',
                    'currency' => 'id_currency',
                    'country' => 'id_country',
                    'group' => 'id_group',
                ],
                'specific_price_rule_condition_group' => [
                    'specific_price_rule' => 'id_specific_price_rule',
                ],
                'specific_price_rule_condition' => [
                    'specific_price_rule_condition_group' => 'id_specific_price_rule_condition_group',
                ],
                'specific_price' => [
                    'specific_price_rule' => 'id_specific_price_rule',
                    'cart' => 'id_cart',
                    'product' => 'id_product',
                    'shop' => 'id_shop',
                    'shop_group' => 'id_shop_group',
                    'currency' => 'id_currency',
                    'country' => 'id_country',
                    'group' => 'id_group',
                    'customer' => 'id_customer',
                    'product_attribute' => 'id_product_attribute',
                ],
                'order_state_lang' => [
                    'order_state' => 'id_order_state',
                    'lang' => 'id_lang',
                ],
                'cart' => [
                    'shop_group' => 'id_shop_group',
                    'shop' => 'id_shop',
                    'carrier' => 'id_carrier',
                    'lang' => 'id_lang',
                    'address' => [
                        'id_address_delivery' => 'id_address',
                        'id_address_invoice' => 'id_address',
                    ],
                    'currency' => 'id_currency',
                    'customer' => 'id_customer',
                    'guest' => 'id_guest',
                ],
                'cart_product' => [
                    'cart' => 'id_cart',
                    'product' => 'id_product',
                    'address' => [
                        'id_address_delivery' => 'id_address'
                    ],
                    'shop' => 'id_shop',
                    'product_attribute' => 'id_product_attribute',
                    'customization' => 'id_customization',
                ],
                'orders' => [
                    'shop_group' => 'id_shop_group',
                    'shop' => 'id_shop',
                    'carrier' => 'id_carrier',
                    'lang' => 'id_lang',
                    'customer' => 'id_customer',
                    'cart' => 'id_cart',
                    'currency' => 'id_currency',
                    'address' => [
                        'id_address_delivery' => 'id_address',
                        'id_address_invoice' => 'id_address',
                    ],
                    'order_state' => [
                        'current_state' => 'id_order_state'
                    ]
                ],
                'order_payment' => [
                    'orders' => [
                        'order_reference' => 'reference'
                    ],
                    'currency' => 'id_currency'
                ],
                'order_invoice' => [
                    'orders' => 'id_order',
                ],
                'order_invoice_tax' => [
                    'order_invoice' => 'id_order_invoice',
                    'tax' => 'id_tax',
                ],
                'order_invoice_payment' => [
                    'order_invoice' => 'id_order_invoice',
                    'order_payment' => 'id_order_payment',
                    'orders' => 'id_order',
                ],
                'order_detail' => [
                    'orders' => 'id_order',
                    'order_invoice' => 'id_order_invoice',
                    'warehouse' => 'id_warehouse',
                    'shop' => 'id_shop',
                    'product' => [
                        'product_id' => 'id_product'
                    ],
                    'product_attribute' => [
                        'product_attribute_id' => 'id_product_attribute'
                    ],
                    'customization' => 'id_customization',
                    'tax_rules_group' => 'id_tax_rules_group',
                ],
                'order_detail_tax' => [
                    'order_detail' => 'id_order_detail',
                    'tax' => 'id_tax',
                ],
                'order_slip' => [
                    'customer' => 'id_customer',
                    'orders' => 'id_order',
                ],
                'order_slip_detail' => [
                    'order_slip' => 'id_order_slip',
                    'order_detail' => 'id_order_detail',
                ],
                'order_slip_detail_tax' => [
                    'order_slip_detail' => 'id_order_slip_detail',
                    'tax' => 'id_tax',
                ],
                'order_carrier' => [
                    'orders' => 'id_order',
                    'carrier' => 'id_carrier',
                    'order_invoice' => 'id_order_invoice',
                ],
                'order_cart_rule' => [
                    'orders' => 'id_order',
                    'cart_rule' => 'id_cart_rule',
                    'order_invoice' => 'id_order_invoice',
                ],
                'order_history' => [
                    'employee' => 'id_employee',
                    'orders' => 'id_order',
                    'order_state' => 'id_order_state',
                ],
                'order_message_lang' => [
                    'order_message' => 'id_order_message',
                    'lang' => 'id_lang',
                ],
                'order_return' => [
                    'customer' => 'id_customer',
                    'orders' => 'id_order',
                ],
                'order_return_detail' => [
                    'order_return' => 'id_order_return',
                    'order_detail' => 'id_order_detail',
                    'customization' => 'id_customization',
                ],
                'message' => [
                    'cart' => 'id_cart',
                    'customer' => 'id_customer',
                    'employee' => 'id_employee',
                    'orders' => 'id_order',
                ],
                'message_readed' => [
                    'message' => 'id_message',
                    'employee' => 'id_employee',
                ],
                'cms_category_lang' => [
                    'cms_category' => 'id_cms_category',
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                ],
                'cms_category_shop' => [
                    'cms_category' => 'id_cms_category',
                    'shop' => 'id_shop',
                ],
                'cms_lang' => [
                    'cms' => 'id_cms',
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                ],
                'cms_shop' => [
                    'cms' => 'id_cms',
                    'shop' => 'id_shop',
                ],
                'contact_lang' => [
                    'contact' => 'id_contact',
                    'lang' => 'id_lang',
                ],
                'meta_lang' => [
                    'meta' => 'id_meta',
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                ],
                'contact_shop' => [
                    'contact' => 'id_contact',
                    'shop' => 'id_shop',
                ],
                'customer_thread' => [
                    'shop' => 'id_shop',
                    'lang' => 'id_lang',
                    'contact' => 'id_contact',
                    'customer' => 'id_customer',
                    'orders' => 'id_order',
                    'product' => 'id_product',
                ],
                'customer_message' => [
                    'customer_thread' => 'id_customer_thread',
                    'employee' => 'id_employee',
                ],
                'ybc_blog_category_lang' => [
                    'ybc_blog_category' => 'id_category',
                    'lang' => 'id_lang',
                ],
                'ybc_blog_category_shop' => [
                    'ybc_blog_category' => 'id_category',
                    'shop' => 'id_shop',
                ],
                'ybc_blog_gallery_lang' => [
                    'ybc_blog_gallery' => 'id_gallery',
                    'lang' => 'id_lang',
                ],
                'ybc_blog_gallery_shop' => [
                    'ybc_blog_gallery' => 'id_gallery',
                    'shop' => 'id_shop',
                ],
                'ybc_blog_slide_lang' => [
                    'ybc_blog_slide' => 'id_slide',
                    'lang' => 'id_lang',
                ],
                'ybc_blog_slide_shop' => [
                    'ybc_blog_slide' => 'id_slide',
                    'shop' => 'id_shop',
                ],
                'ybc_blog_post' => [
                    'ybc_blog_category' => [
                        'id_category_default' => 'id_category'
                    ],
                ],
                'ybc_blog_post_lang' => [
                    'ybc_blog_post' => 'id_post',
                ],
                'ybc_blog_post_shop' => [
                    'ybc_blog_post' => 'id_post',
                    'shop' => 'id_shop',
                ],
                'ybc_blog_post_category' => [
                    'ybc_blog_post' => 'id_post',
                    'ybc_blog_category' => 'id_category',
                ],
                'ybc_blog_post_related_categories' => [
                    'ybc_blog_post' => 'id_post',
                    'ybc_blog_category' => 'id_category',
                ],
                'ybc_blog_tag' => [
                    'ybc_blog_post' => 'id_post',
                    'lang' => 'id_lang',
                ],
                'ybc_blog_polls' => [
                    'customer' => [
                        'id_user' => 'id_customer'
                    ],
                    'ybc_blog_post' => 'id_post',
                    'lang' => 'id_lang',
                ],
                'ybc_blog_comment' => [
                    'customer' => [
                        'id_user' => 'id_customer',
                        'customer_reply' => 'id_customer',
                    ],
                    'ybc_blog_post' => 'id_post',
                    'employee' => [
                        'replied_by' => 'id_employee'
                    ],
                ],
                'ybc_blog_reply' => [
                    'customer' => [
                        'id_user' => 'id_customer'
                    ],
                    'ybc_blog_comment' => 'id_comment',
                    'employee' => 'id_employee',
                ],
                'ybc_blog_log_like' => [
                    'customer' => 'id_customer',
                    'ybc_blog_post' => 'id_post',
                ],
                'ybc_blog_log_view' => [
                    'customer' => 'id_customer',
                    'ybc_blog_post' => 'id_post',
                ],
                'ybc_blog_employee' => [
                    'employee' => 'id_employee',
                ],
                'ybc_blog_employee_lang' => [
                    'ybc_blog_employee' => 'id_employee_post',
                    'lang' => 'id_lang',
                ],
                'ets_mm_menu_lang' => [
                    'ets_mm_menu' => 'id_menu',
                    'lang' => 'id_lang',
                ],
                'ets_mm_menu_shop' => [
                    'ets_mm_menu' => 'id_menu',
                    'shop' => 'id_shop',
                ],
                'ets_mm_tab' => [
                    'ets_mm_menu' => 'id_menu',
                ],
                'ets_mm_tab_lang' => [
                    'ets_mm_tab' => 'id_tab',
                    'lang' => 'id_lang',
                ],
                'ets_mm_column' => [
                    'ets_mm_menu' => 'id_menu',
                    'tab' => 'id_tab',
                ],
                'ets_mm_block' => [
                    'ets_mm_column' => 'id_column',
                    'tab' => 'id_tab',
                ],
                'ets_mm_block_lang' => [
                    'ets_mm_block' => 'id_block',
                    'lang' => 'id_lang',
                ],
                'linksmenutop' => [
                    'shop' => 'id_shop',
                ],
                'linksmenutop_lang' => [
                    'linksmenutop' => 'id_linksmenutop',
                    'lang' => 'id_lang',
                    'shop' => 'id_shop',
                ]
            ];
        }

        return $table && isset(self::$_foreign_keys[$table]) ? self::$_foreign_keys[$table] : [];
    }

    public static $resource;

    public function getResources($group = null, $sort = false)
    {
        if (!self::$resource) {
            self::$resource = array_merge(
                [
                    'minor_data' => [
                        'name' => $this->l('Minor data'),
                        'tables' => [
                            'shop_group',
                            'shop',
                            'lang',
                            'lang_shop',
                            'currency',
                            'currency_lang',
                            'currency_shop',
                            'zone',
                            'zone_shop',
                            'country',
                            'country_lang',
                            'country_shop',
                            'state',
                            'gender',
                            'gender_lang'
                        ],
                        'position' => -1,
                    ],
                    'employee' => [
                        'name' => $this->l('Employees'),
                        'tables' => [
                            'profile',
                            'profile_lang',
                            'employee',
                            'employee_shop',
                        ],
                        'position' => 4,
                    ],
                    'category' => [
                        'name' => $this->l('Product categories'),
                        'images' => [
                            'category' => [
                                [
                                    'path' => 'img/c',
                                    'ext' => '.jpg',
                                    'type' => 'categories'
                                ]
                            ]
                        ],
                        'tables' => [
                            'group',
                            'group_lang',
                            'group_shop',
                            'category',
                            'category_lang',
                            'category_shop',
                            'category_group',
                        ],
                        'position' => 2,
                    ],
                    'manufacturer' => [
                        'name' => $this->l('Manufacturers'),
                        'images' => [
                            'manufacturer' => [
                                [
                                    'path' => 'img/m',
                                    'ext' => '.jpg',
                                    'type' => 'manufacturers'
                                ]
                            ]
                        ],
                        'tables' => [
                            'manufacturer',
                            'manufacturer_lang',
                            'manufacturer_shop',
                        ],
                        'position' => 12,
                    ],
                    'supplier' => [
                        'name' => $this->l('Suppliers'),
                        'images' => [
                            'supplier' => [
                                [
                                    'path' => 'img/su',
                                    'ext' => '.jpg',
                                    'type' => 'suppliers'
                                ]
                            ]
                        ],
                        'tables' => [
                            'supplier',
                            'supplier_lang',
                            'supplier_shop',
                            'product_supplier',
                        ],
                        'position' => 11,
                    ],
                    'customer' => [
                        'name' => $this->l('Customers & addresses'),
                        'tables' => [
                            'customer',
                            'customer_group',
                            'address',
                            'address_format'
                        ],
                        'position' => 3,
                    ],
                    'carrier' => [
                        'name' => $this->l('Carriers & shipping'),
                        'images' => [
                            'carrier' => [
                                [
                                    'path' => 'img/s',
                                    'ext' => '.jpg',
                                ]
                            ]
                        ],
                        'tables' => [
                            'carrier',
                            'carrier_lang',
                            'carrier_shop',
                            'carrier_group',
                            'carrier_zone',
                            'range_price',
                            'range_weight',
                            'delivery',
                        ],
                        'position' => 6,
                    ],
                    'product' => [
                        'name' => $this->l('Products & SEO'),
                        'images' => [
                            'image' => [
                                [
                                    'path' => 'img/p',
                                    'ext' => '.jpg',
                                    'type' => 'products'
                                ]
                            ]
                        ],
                        'files' => [
                            'attachment' => [
                                [
                                    'path' => 'download',
                                    'field' => 'file',
                                ]
                            ],
                            'product_download' => [
                                [
                                    'path' => 'download',
                                    'field' => 'filename',
                                ]
                            ]
                        ],
                        'tables' => [
                            'tag',
                            'tag_count',
                            'tax',
                            'tax_lang',
                            'tax_rules_group',
                            'tax_rules_group_shop',
                            'tax_rule',
                            'attachment',
                            'attachment_lang',
                            'product',
                            'product_lang',
                            'product_shop',
                            'category_product',
                            'accessory',
                            'product_tag',
                            'feature',
                            'feature_lang',
                            'feature_shop',
                            'feature_value',
                            'feature_value_lang',
                            'feature_product',
                            'attribute_group',
                            'attribute_group_lang',
                            'attribute_group_shop',
                            'attribute',
                            'attribute_lang',
                            'attribute_shop',
                            'attribute_impact',
                            'product_attribute',
                            'product_attribute_shop',
                            'product_attribute_combination',
                            'product_supplier',
                            'pack',
                            'product_sale',
                            'product_group_reduction_cache',
                            'product_download',
                            'product_country_tax',
                            'product_carrier',
                            'product_attachment',
                            'customization_field',
                            'customization_field_lang',
                            'image',
                            'image_lang',
                            'image_shop',
                            'product_attribute_image',
                            'stock_available',
                            'warehouse',
                            'warehouse_shop',
                            'warehouse_carrier',
                            'warehouse_product_location',
                            'stock',
                        ],
                        'position' => 1,
                    ]
                ],
                EMTools::tableExist('product_comment') ? [
                    'product_comment' => [
                        'name' => $this->l('Product comments'),
                        'tables' => [
                            'product_comment_criterion',
                            'product_comment_criterion_lang',
                            'product_comment_criterion_product',
                            'product_comment_criterion_category',
                            'product_comment',
                            'product_comment_grade',
                            'product_comment_usefulness',
                            'product_comment_report',
                        ],
                        'position' => 15,
                    ],
                ] : [],
                [
                    'cart_rule' => [
                        'name' => $this->l('Cart rules'),
                        'tables' => [
                            'cart_rule',
                            'cart_rule_lang',
                            'cart_rule_shop',
                            'cart_rule_carrier',
                            'cart_rule_combination',
                            'cart_rule_country',
                            'cart_rule_group',
                            'cart_rule_product_rule_group',
                            'cart_rule_product_rule',
                            'cart_rule_product_rule_value',
                        ],
                        'position' => 7,
                    ],
                    'specific_price' => [
                        'name' => $this->l('Catalog price rules'),
                        'tables' => [
                            'specific_price_rule',
                            'specific_price_rule_condition_group',
                            'specific_price_rule_condition',
                            'specific_price',
                        ],
                        'position' => 8,
                    ],
                    'orders' => [
                        'name' => $this->l('Orders & shopping carts'),
                        'files' => [
                            'customized_data' => [
                                [
                                    'path' => 'upload',
                                    'field' => 'value'
                                ]
                            ]
                        ],
                        'tables' => [
                            'order_state',
                            'order_state_lang',
                            'cart',
                            'customization',
                            'customized_data',
                            'cart_product',
                            'orders',
                            'order_payment',
                            'order_invoice',
                            'order_invoice_tax',
                            'order_invoice_payment',
                            'order_detail',
                            'order_detail_tax',
                            'order_slip',
                            'order_slip_detail',
                            'order_slip_detail_tax',
                            'order_carrier',
                            'order_cart_rule',
                            'order_history',
                            'order_message',
                            'order_message_lang',
                            'order_return',
                            'order_return_detail',
                            'message',
                            'message_readed',
                        ],
                        'position' => 5,
                    ],
                    'cms_category' => [
                        'name' => $this->l('CMS categories'),
                        'tables' => [
                            'cms_category',
                            'cms_category_lang',
                            'cms_category_shop',
                        ],
                        'position' => 9,
                    ],
                    'cms' => [
                        'name' => $this->l('CMSs'),
                        'tables' => [
                            'cms',
                            'cms_lang',
                            'cms_shop',
                        ],
                        'position' => 10,
                    ],
                    'contact' => [
                        'name' => $this->l('Contact form messages'),
                        'tables' => [
                            'contact',
                            'contact_lang',
                            'contact_shop',
                            'customer_thread',
                            'customer_message',
                        ],
                        'position' => 13,
                    ],
                    'meta' => [
                        'name' => $this->l('Meta data & SEO'),
                        'tables' => [
                            'meta',
                            'meta_lang',
                        ],
                        'position' => 14,
                    ],
                ],
                EMTools::tableExist('ybc_blog_post') ? [
                    'ybc_blog_post' => [
                        'name' => $this->l('BLOG'),
                        'images' => [
                            'ybc_blog_gallery_lang' => [
                                [
                                    'path' => 'img/ybc_blog/gallery',
                                    'field' => 'image',
                                ],
                                [
                                    'path' => 'img/ybc_blog/gallery/thumb',
                                    'field' => 'thumb',
                                ]
                            ],
                            'ybc_blog_category_lang' => [
                                [
                                    'path' => 'img/ybc_blog/category',
                                    'field' => 'image',
                                ],
                                [
                                    'path' => 'img/ybc_blog/category/thumb',
                                    'field' => 'thumb',
                                ]
                            ],
                            'ybc_blog_post_lang' => [
                                [
                                    'path' => 'img/ybc_blog/post',
                                    'field' => 'image',
                                ],
                                [
                                    'path' => 'img/ybc_blog/post/thumb',
                                    'field' => 'thumb',
                                ]
                            ],
                            'ybc_blog_slide_lang' => [
                                [
                                    'path' => 'img/ybc_blog/slide',
                                    'field' => 'image',
                                ]
                            ],
                            'ybc_blog_employee' => [
                                [
                                    'path' => 'img/ybc_blog/avata',
                                    'field' => 'avata',
                                ]
                            ],
                        ],
                        'tables' => [
                            'ybc_blog_category',
                            'ybc_blog_category_lang',
                            'ybc_blog_category_shop',
                            'ybc_blog_gallery',
                            'ybc_blog_gallery_lang',
                            'ybc_blog_gallery_shop',
                            'ybc_blog_slide',
                            'ybc_blog_slide_lang',
                            'ybc_blog_slide_shop',
                            'ybc_blog_post',
                            'ybc_blog_post_lang',
                            'ybc_blog_post_shop',
                            'ybc_blog_post_category',
                            'ybc_blog_post_related_categories',
                            'ybc_blog_tag',
                            'ybc_blog_polls',
                            'ybc_blog_comment',
                            'ybc_blog_reply',
                            'ybc_blog_log_like',
                            'ybc_blog_log_view',
                            'ybc_blog_employee',
                            'ybc_blog_employee_lang',
                        ],
                        'position' => 16,
                    ],
                ] : [],
                (EMTools::tableExist('ets_mm_menu') || EMTools::tableExist('linksmenutop')) ? [
                    'ets_mm_menu' => [
                        'name' => $this->l('Top menus'),
                        'parent' => [
                            'ets_mm_menu',
                            'linksmenutop',
                        ],
                        'images' => [
                            'ets_mm_block' => [
                                [
                                    'path' => 'modules/ets_megamenu/views/img/upload',
                                    'field' => 'image',
                                ]
                            ],
                        ],
                        'tables' => [
                            'ets_mm_menu',
                            'ets_mm_menu_lang',
                            'ets_mm_menu_shop',
                            'ets_mm_tab',
                            'ets_mm_tab_lang',
                            'ets_mm_column',
                            'ets_mm_block',
                            'ets_mm_block_lang',
                            'linksmenutop',
                            'linksmenutop_lang',
                        ],
                        'position' => 17,
                    ]
                ] : [],
                [
                    'images' => [
                        'name' => $this->l('Images & thumbnails'),
                        'tables' => [],
                        'position' => -1,
                    ],
                    'files' => [
                        'name' => $this->l('Attachments & files'),
                        'tables' => [],
                        'position' => -1,
                    ],
                    'finished' => [
                        'name' => $this->l('Finalization'),
                        'tables' => [],
                        'position' => -1,
                    ]
                ]
            );
        }
        if ($sort) {
            self::$resource = EMTools::quickSort(self::$resource);
        }

        return $group && isset(self::$resource[$group]) ? self::$resource[$group] : self::$resource;
    }

    public function l($string)
    {
        return Translate::getModuleTranslation('ets_migrate', $string, pathinfo(__FILE__, PATHINFO_FILENAME));
    }
}