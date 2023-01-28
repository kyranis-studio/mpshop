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
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2021 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;

Class Ets_homecategoriesAjaxModuleFrontController extends ModuleFrontController{
    public function __construct()
    {
        parent::__construct();
    }
    public function init() {
        // Send noindex to avoid ghost carts by bots
        header('X-Robots-Tag: noindex, nofollow', true);
        parent::init();
    }
    public function initContent() {
        parent::initContent();
        $id_cateory = (int)Tools::getValue('id_category');
        $id_parent = Tools::strtolower(Tools::getValue('id_parent'));
        $page = (int)Tools::getValue('page');
        $id_feature = Tools::getValue('id_feature',false);
        $sortby = Tools::getValue('sortby');
        $updatesort = (int)Tools::getValue('updatesort') ? true : false;
        $loadmore = (int)Tools::getValue('loadmore');
        if($sortby && $updatesort && in_array($sortby, array('price asc', 'price desc', 'pl.name asc', 'pl.name desc', 'cp.position asc', 'p.id_product desc', 'rand')))
        {
            $this->context->cookie->ets_homecat_order = $sortby;
            $this->context->cookie->write();
        }
        $result = $this->module->hookDisplayProductList(array(
            'ajax'=> true,
            'sortby' => $sortby,
            'page' => $page,
            'id_category' => $id_cateory,
            'id_parent' => $id_parent,
            'id_feature' => $id_feature!='no' && $id_feature!==false ? (int)$id_feature : 'no',
            'loadmore' => $loadmore,
        ));
        die(Tools::jsonEncode($result));
    }
}
