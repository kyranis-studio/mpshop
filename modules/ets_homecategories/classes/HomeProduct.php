<?php
/**
 * 2007-2021 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2021 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

class HomeProduct
{
    private $is17 = false;
    private $nProducts = 1;
    private $id_category = 2;
    private $Page = 1;
    private $orderBy = null;
    private $orderWay = 'ASC';
    private $randSeed = 1;

    public function __construct($id_category = 2, $nProducts = 1, $Page = 1 , $orderBy = null, $orderWay = 'ASC')
    {
        $this->is17 = version_compare(_PS_VERSION_, '1.7', '>=');
        $this->id_category = $id_category;
        $this->nProducts = $nProducts;
        $this->Page = $Page;
        $this->orderBy = $orderBy;
        $this->orderWay = $orderWay;
        $this->orderWay = $orderWay;
    }

    public function setRandSeed($randSeed)
    {
		
        $this->randSeed = $randSeed;
        return $this;
    }

    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;
        return $this;
    }

    public function setPage($Page)
    {
        $this->Page = $Page;
        return $this;
    }

    public function setPerPage($nProducts)
    {
        $this->nProducts = $nProducts;
        return $this;
    }

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setOrderWay($orderWay)
    {
        $this->orderWay = $orderWay;
        return $this;
    }

    public function getPages($methods)
    {
        if (!$methods)
            return 1;
        $nbTotal = (int)$this->{$methods}(true);
        return ceil($nbTotal/$this->nProducts);
    }

    public function getBestSellers($count = false)
    {
        $context = Context::getContext();
        if ($count)
            return self::getNbSales();
        if (($results = $this->_getBestSales((int)$context->language->id, $this->Page, $this->nProducts, $this->orderBy, $this->orderWay)))
        {
            if (!$this->is17){
                $currency = new Currency((int)$context->currency->id);
                $usetax = (Product::getTaxCalculationMethod((int)$context->customer->id) != PS_TAX_EXC);
                foreach ($results as &$product){
                    $product['price'] = Tools::displayPrice(Product::getPriceStatic((int)$product['id_product'], $usetax), $currency);
                }
            }
        }
        return !$this->is17 ? $results : $this->productsForTemplate($results, $context);
    }
    public static function getNbSales()
    {
        $sql = 'SELECT COUNT(DISTINCT ps.`id_product`) AS nb
				FROM `'._DB_PREFIX_.'product_sale` ps
				LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = ps.`id_product`
				'.Shop::addSqlAssociation('product', 'p', false).'
                LEFT JOIN `'._DB_PREFIX_.'category_product` cp on (cp.id_product=p.id_product)
				WHERE product_shop.`active` = 1'.((int)Tools::getValue('id_category') >0 ? ' AND cp.id_category='.(int)Tools::getValue('id_category'): '');

        return (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
    }
    public function getHomeFeatured()
    {
        if (!$this->id_category)
            return array();
        $context = Context::getContext();
        $category = new Category((int)$this->id_category, (int)$context->language->id);
        if (!$category->active)
            return false;
        $products = $this->getProductsByIdCategory($category->id,$this->Page, $this->nProducts, $this->orderBy, $this->orderWay);
        return !$this->is17 ? $products : $this->productsForTemplate($products, $context);
    }
    public function getNewProducts($count = false)
    {
        $context = Context::getContext();
        if ($count)
            return $this->_getNewProducts((int)$context->language->id, 0, 0, true);
        $newProducts = false;
        if (Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) {
            $newProducts = $this->_getNewProducts((int)$context->language->id, $this->Page, $this->nProducts, false, $this->orderBy, $this->orderWay);
        }
        return $this->is17 ? $this->productsForTemplate($newProducts, $context) : $newProducts;
    }
    public function getSpecialProducts($count = false)
    {
        $context = Context::getContext();
        if ($count)
            return $this->_getPricesDrop((int)$context->language->id, 0, 0, true);
        $products = $this->_getPricesDrop((int)$context->language->id, $this->Page, $this->nProducts, false, $this->orderBy, $this->orderWay);
        return $this->is17? $this->productsForTemplate($products, $context) : $products;
    }

    public static function productsForTemplate($products, Context $context = null)
    {
        if (!$products || !is_array($products))
            return array();
        if (!$context)
            $context = Context::getContext();
        $assembler = new ProductAssembler($context);
        $presenterFactory = new ProductPresenterFactory($context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new PrestaShop\PrestaShop\Core\Product\ProductListingPresenter(
            new PrestaShop\PrestaShop\Adapter\Image\ImageRetriever(
                $context->link
            ),
            $context->link,
            new PrestaShop\PrestaShop\Adapter\Product\PriceFormatter(),
            new PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever(),
            $context->getTranslator()
        );

        $products_for_template = array();

        foreach ($products as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $context->language
            );
        }
        return $products_for_template;
    }

    private function _getBestSales($idLang, $pageNumber = 0, $nbProducts = 10, $orderBy = null, $orderWay = null)
    {
        $context = Context::getContext();
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }
        if ($nbProducts < 1) {
            $nbProducts = 10;
        }

        $finalOrderBy = $orderBy;
        $orderTable = '';
        $invalidOrderBy = !Validate::isOrderBy($orderBy);
        if ($invalidOrderBy || is_null($orderBy)) {
            $orderBy == 'position';
            $orderTable = 'cp';
        } elseif ($orderBy == 'position') {
            $orderTable = 'cp';
        } elseif($orderBy == 'name') {
            $orderTable = 'pl';
        } elseif ($orderBy == 'id_product' || $orderBy == 'date_add' || $orderBy == 'date_upd') {
            $orderTable = 'product_shop';
        }

        $invalidOrderWay = !Validate::isOrderWay($orderWay);
        if ($invalidOrderWay || is_null($orderWay) || $orderBy == 'sales') {
            $orderWay = 'DESC';
        }
        $interval = Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20;
        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,
					'.(Combination::isFeatureActive()?'product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity,IFNULL(product_attribute_shop.id_product_attribute,0) id_product_attribute,':'').'
					pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
					pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`,
					m.`name` AS manufacturer_name, p.`id_manufacturer` as id_manufacturer,
					IFNULL(image_shop.`id_image`, i.`id_image`) id_image, il.`legend`,
					ps.`quantity` AS sales, t.`rate`, pl.`meta_keywords`, pl.`meta_title`, pl.`meta_description`,
					DATEDIFF(p.`date_add`, DATE_SUB("'.pSQL(date('Y-m-d')).' 00:00:00",
					INTERVAL '.(int) $interval.' DAY)) > 0 AS new'
            .' FROM `'._DB_PREFIX_.'product_sale` ps
				LEFT JOIN `'._DB_PREFIX_.'product` p ON ps.`id_product` = p.`id_product`
				LEFT JOIN `' . _DB_PREFIX_ . 'category_product` cp ON(p.id_product = cp.id_product)
				'.Shop::addSqlAssociation('product', 'p', false);
        if (Combination::isFeatureActive()) {
            $sql .= ' LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product`) ';
            $sql .= Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1');
        }
        $sql .='LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int) $idLang.Shop::addSqlRestrictionOnLang('pl').'
                LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'. Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int) $idLang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
				LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (product_shop.`id_tax_rules_group` = tr.`id_tax_rules_group`)
					AND tr.`id_country` = '.(int) $context->country->id.'
					AND tr.`id_state` = 0
				LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
				'.Product::sqlStock('p', 0);

        $sql .= '
				WHERE product_shop.`active` = 1
					AND product_shop.`visibility` != \'none\''.((int)Tools::getValue('id_category') >0 ? ' AND cp.id_category='.(int)Tools::getValue('id_category'): '');
        if (Group::isFeatureActive())
        {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql .= ' AND EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp
					JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` '.(count($groups) ? 'IN ('.pSQL(implode(',', $groups)).')' : '= 1').')
					WHERE cp.`id_product` = p.`id_product`)';
        }
        $sql .= ' GROUP BY p.id_product ';
        $sql .= (Configuration::get('ETS_HOMECAT_OUT_OF_STOCK')? ' HAVING quantity > 0 ' : '');
        if ($finalOrderBy != 'price') {
            $sql .= 'ORDER BY '.($orderBy != 'rand' ? (!empty($orderTable) ? '`'.pSQL($orderTable).'`.' : '').'`'.pSQL($orderBy).'` '.pSQL($orderWay): 'RAND('.pSQL($this->randSeed). ')').'
					LIMIT '.(int) (($pageNumber-1) * $nbProducts).', '.(int) $nbProducts;
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if ($finalOrderBy == 'price') {
            Tools::orderbyPrice($result, $orderWay);
            $result = array_slice($result, (int) (($pageNumber-1) * $nbProducts), (int) $nbProducts);
        }
        if (!$result) {
            return false;
        }
        return Product::getProductsProperties($idLang, $result);
    }

    private function _getNewProducts($id_lang, $page_number = 0, $nb_products = 10, $count = false, $order_by = null, $order_way = null, Context $context = null)
    {
        $now = date('Y-m-d') . ' 00:00:00';
        if (!$context) {
            $context = Context::getContext();
        }
        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }
        if ($page_number < 1) {
            $page_number = 1;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        if(!(int)Configuration::get('ETS_HOMECAT_FEED_NEW_ALL'))
        {
            if (empty($order_by)) {
                $order_by = 'position';
            } elseif ($order_by == 'position') {
                $order_by_prefix = 'cp';
            } elseif ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
                $order_by_prefix = 'product_shop';
            } elseif ($order_by == 'name') {
                $order_by_prefix = 'pl';
            }

            if (empty($order_way)) {
                $order_way = 'ASC';
            }
        }
        else
        {
            $order_by = 'id_product';
            $order_by_prefix = 'product_shop';
            $order_way = 'DESC';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }

        $sql_groups = '';
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = ' AND EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp
				JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= '.(int)Configuration::get('PS_UNIDENTIFIED_GROUP')).')
				WHERE cp.`id_product` = p.`id_product`)';
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }

        $nb_days_new_product = (int) Configuration::get('PS_NB_DAYS_NEW_PRODUCT');

        if ($count) {
            $sql = 'SELECT COUNT(DISTINCT p.`id_product`) AS nb
					FROM `'._DB_PREFIX_.'product` p
					'.Shop::addSqlAssociation('product', 'p').'
                    LEFT JOIN `'._DB_PREFIX_.'category_product` cp on (p.id_product=cp.id_product)
                    ' . Product::sqlStock('p', 0) . '
					WHERE product_shop.`active` = 1
					AND product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(int)$nb_days_new_product.' DAY')).'"
					'.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').((int)Tools::getValue('id_category') > 0 ? ' AND cp.id_category='.(int)Tools::getValue('id_category'): '').'
					'.( Configuration::get('ETS_HOMECAT_OUT_OF_STOCK') ? ' AND stock.`quantity` > 0' : '' ).'
					'.$sql_groups;
            return (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        }
        $sql = new DbQuery();
        $sql->select(
            'p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
			pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`, IFNULL(image_shop.`id_image`, i.`id_image`) id_image, il.`legend`, m.`name` AS manufacturer_name,
			(DATEDIFF(product_shop.`date_add`,
				DATE_SUB(
					"'.pSQL($now).'",
					INTERVAL '.(int)$nb_days_new_product.' DAY
				)
			) > 0) as new'
        );

        $sql->from('product', 'p');
        $sql->join(Shop::addSqlAssociation('product', 'p'));
        $sql->leftJoin('product_lang', 'pl', '
			p.`id_product` = pl.`id_product`
			AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl')
        );
        $sql->leftJoin('category_product','cp','p.id_product = cp.id_product');
        $sql->leftJoin('image', 'i', 'i.`id_product` = p.`id_product`');
        $sql->join(Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1'));
        $sql->leftJoin('image_lang', 'il', 'image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang);
        $sql->leftJoin('manufacturer', 'm', 'm.`id_manufacturer` = p.`id_manufacturer`');

        $sql->where('product_shop.`active` = 1');
        if ($front) {
            $sql->where('product_shop.`visibility` IN ("both", "catalog")');
        }
        if((int)Tools::getValue('id_category') > 0)
            $sql->where('cp.id_category='.(int)Tools::getValue('id_category'));
        if(!(int)Configuration::get('ETS_HOMECAT_FEED_NEW_ALL'))
            $sql->where('product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(int)$nb_days_new_product.' DAY')).'"');
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql->where('EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp
				JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` '.(count($groups) ? 'IN ('.pSQL(implode(',', $groups)).')' : '= 1').')
				WHERE cp.`id_product` = p.`id_product`)');
        }
        $sql->groupBy('p.`id_product`');
        if (Configuration::get('ETS_HOMECAT_OUT_OF_STOCK'))
            $sql->having('quantity > 0');
        $sql->orderBy($order_by!='rand'?(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').'`'.pSQL($order_by).'` '.pSQL($order_way) : 'RAND(' . pSQL($this->randSeed) . ')');
        $sql->limit($nb_products, (int)(($page_number-1) * $nb_products));
        if (Combination::isFeatureActive())
        {
            $sql->select('product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, IFNULL(product_attribute_shop.id_product_attribute,0) id_product_attribute');
            $sql->leftOuterJoin('product_attribute', 'pa', 'p.`id_product` = pa.`id_product`');
            $sql->join(Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on = 1'));
        }
        $sql->join(Product::sqlStock('p', Combination::isFeatureActive() ? 'product_attribute_shop' : 0));
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return false;
        }

        if ($order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }
        $products_ids = array();
        foreach ($result as $row) {
            $products_ids[] = $row['id_product'];
        }
        // Thus you can avoid one query per product, because there will be only one query for all the products of the cart
        Product::cacheFrontFeatures($products_ids, $id_lang);
        return Product::getProductsProperties((int)$id_lang, $result);
    }

    private function _getPricesDrop($id_lang, $page_number = 0, $nb_products = 12, $count = false, $order_by = null, $order_way = null, $beginning = false, $ending = false, Context $context = null)
    {
        if (!Validate::isBool($count)) {
            die(Tools::displayError());
        }
        if (!$context) {
            $context = Context::getContext();
        }
        if ($page_number < 1) {
            $page_number = 1;
        }
        if ($nb_products < 1) {
            $nb_products = 12;
        }

        if (empty($order_by)) {
            $order_by = 'position';
        } elseif ($order_by == 'position') {
            $order_by_prefix = 'cp';
        } elseif ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'product_shop';
        } elseif ($order_by == 'name') {
            $order_by_prefix = 'pl';
        }

        if (empty($order_way)) {
            $order_way = 'ASC';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }
        $current_date = date('Y-m-d H:i:00');
        $ids_product = self::_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context);

        $tab_id_product = array();
        foreach ($ids_product as $product) {
            if (is_array($product)) {
                $tab_id_product[] = (int)$product['id_product'];
            } else {
                $tab_id_product[] = (int)$product;
            }
        }

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        $sql_groups = '';
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = ' AND EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp
				JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` '.(count($groups) ? 'IN ('.pSQL(implode(',', $groups)).')' : '= 1').')
				WHERE cp.`id_product` = p.`id_product`)';
        }

        if ($count) {
            return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT COUNT(DISTINCT p.`id_product`)
			FROM `'._DB_PREFIX_.'product` p
			'.Shop::addSqlAssociation('product', 'p').'
            LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.id_product=p.id_product)'
            .Product::sqlStock('p', 0, false, $context->shop).'
			WHERE product_shop.`active` = 1
			AND product_shop.`show_price` = 1
			'.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').((int)Tools::getValue('id_category') > 0 ? ' AND cp.id_category='.(int)Tools::getValue('id_category'): '').'
			'.((!$beginning && !$ending) ? 'AND p.`id_product` IN('.((is_array($tab_id_product) && count($tab_id_product)) ? pSQL(implode(', ', $tab_id_product)) : 0).')' : '').'
			'. (Configuration::get('ETS_HOMECAT_OUT_OF_STOCK')? ' AND stock.`quantity` > 0 ' : '').'
			'.$sql_groups);
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by = pSQL($order_by[0]).'.`'.pSQL($order_by[1]).'`';
        }

        $sql = '
		SELECT
			p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`,
			IFNULL(product_attribute_shop.id_product_attribute, 0) id_product_attribute,
			pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`,
			pl.`name`, IFNULL(image_shop.`id_image`, i.`id_image`) id_image, il.`legend`, m.`name` AS manufacturer_name,
			DATEDIFF(
				p.`date_add`,
				DATE_SUB(
					"'.date('Y-m-d').' 00:00:00",
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
				)
			) > 0 AS new
		FROM `'._DB_PREFIX_.'product` p
		LEFT JOIN `' . _DB_PREFIX_ . 'category_product` cp ON(p.id_product = cp.id_product)
        '.Shop::addSqlAssociation('product', 'p')
        . (Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product`)
        '.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
        '.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, $context->shop)).'
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (
			p.`id_product` = pl.`id_product`
			AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
		)
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'. Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
		WHERE product_shop.`active` = 1
		AND product_shop.`show_price` = 1
		'.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').((int)Tools::getValue('id_category') > 0 ? ' AND cp.id_category='.(int)Tools::getValue('id_category'): '').'
		'.((!$beginning && !$ending) ? ' AND p.`id_product` IN ('.((is_array($tab_id_product) && count($tab_id_product)) ? pSQL(implode(', ', $tab_id_product)) : 0).')' : '').'
		'.$sql_groups.'
		GROUP BY p.`id_product` '
		.(Configuration::get('ETS_HOMECAT_OUT_OF_STOCK')? ' HAVING quantity > 0 ' : '').' 
		ORDER BY '.($order_by != 'rand'?(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').pSQL($order_by).' '.pSQL($order_way):'RAND(' . pSQL($this->randSeed) . ')').'
		LIMIT '.(int)(($page_number-1) * $nb_products).', '.(int)$nb_products;
       // die($sql);
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if (!$result) {
            return false;
        }
        if ($order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }
        return Product::getProductsProperties($id_lang, $result);
    }

    public static function _getProductIdByDate($beginning, $ending, Context $context = null, $with_combination = false)
    {
        if (!$context) {
            $context = Context::getContext();
        }

        $id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
        $ids = Address::getCountryAndState($id_address);
        $id_country = $ids['id_country'] ? (int)$ids['id_country'] : (int) Configuration::get('PS_COUNTRY_DEFAULT');

        return SpecificPrice::getProductIdByDate(
            $context->shop->id,
            $context->currency->id,
            $id_country,
            $context->customer->id_default_group,
            $beginning,
            $ending,
            0,
            $with_combination
        );
    }
    public function getProductsByIdCategory(
        $id_category,
        $p,
        $n,
        $orderyBy = null,
        $orderWay = null
    )
    {
        if(!(int)$id_category)
            return array();
        $context = Context::getContext();
        $idLang = (int)$context->language->id;
        if ((int)$p < 1) {
            $p = 1;
        }
        if((int)$n < 1)
            $n = 12;

        /** Tools::strtolower is a fix for all modules which are now using lowercase values for 'orderBy' parameter */
        $orderyBy  = Validate::isOrderBy($orderyBy)   ? Tools::strtolower($orderyBy)  : 'position';
        $orderWay = Validate::isOrderWay($orderWay) ? Tools::strtoupper($orderWay) : 'ASC';

        $orderByPrefix = false;
        if ($orderyBy == 'id_product' || $orderyBy == 'date_add' || $orderyBy == 'date_upd') {
            $orderByPrefix = 'p';
        } elseif ($orderyBy == 'name') {
            $orderByPrefix = 'pl';
        } elseif ($orderyBy == 'manufacturer' || $orderyBy == 'manufacturer_name') {
            $orderByPrefix = 'm';
            $orderyBy = 'name';
        } elseif ($orderyBy == 'position') {
            $orderByPrefix = 'cp';
        }

        if ($orderyBy == 'price') {
            $orderyBy = 'orderprice';
        }

        $nbDaysNewProduct = Configuration::get('PS_NB_DAYS_NEW_PRODUCT');
        if (!Validate::isUnsignedInt($nbDaysNewProduct)) {
            $nbDaysNewProduct = 20;
        }
        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) AS quantity'.(Combination::isFeatureActive() ? ', IFNULL(product_attribute_shop.id_product_attribute, 0) AS id_product_attribute,
					product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity' : '').', pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, IFNULL(image_shop.`id_image`, i.`id_image`) id_image,
					il.`legend` as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,
					DATEDIFF(product_shop.`date_add`, DATE_SUB("'.date('Y-m-d').' 00:00:00",
					INTERVAL '.(int)$nbDaysNewProduct.' DAY)) > 0 AS new, product_shop.price AS orderprice
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p')
                . (Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product`)
                '.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
                '.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, $context->shop)).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON (product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int) $idLang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON (p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int) $idLang.Shop::addSqlRestrictionOnLang('pl').')
                LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'. Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
					ON (image_shop.`id_image` = il.`id_image`
					AND il.`id_lang` = '.(int) $idLang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
				'.((int)Tools::getValue('id_category') > 0 ? '  
				JOIN (
				    SELECT id_product
				    FROM `'._DB_PREFIX_.'category_product` 
				    WHERE id_category='.(int)Tools::getValue('id_category').'
				) cp2 ON cp.id_product=cp2.id_product ' : '').'
				WHERE 
				     cp.id_category='.(int)$id_category.'
				    AND product_shop.`id_shop` = '.(int) $context->shop->id.'
                     AND product_shop.`active` = 1
                     AND product_shop.`visibility` IN ("both", "catalog")
                     GROUP BY p.id_product'
                    .(Configuration::get('ETS_HOMECAT_OUT_OF_STOCK')? ' HAVING quantity > 0 ' : ''). ' 
                ORDER BY '.($orderyBy=='rand' ? ' RAND('.pSQL($this->randSeed).')' : (!empty($orderByPrefix) ? $orderByPrefix.'.' : '').'`'.bqSQL($orderyBy).'` '.pSQL($orderWay)).'
			    LIMIT '.(((int) $p - 1) * (int) $n).','.(int) $n;
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, false);
        if (!$result) {
            return array();
        }
        if ($orderyBy == 'orderprice') {
            Tools::orderbyPrice($result, $orderWay);
        }
        return Product::getProductsProperties($idLang, $result);
    }
}
