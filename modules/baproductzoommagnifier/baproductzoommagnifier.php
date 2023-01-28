<?php
/**
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@buy-addons.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    Buy-Addons <contact@buy-addons.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
* @since 1.6
*/

class Baproductzoommagnifier extends Module
{
    public $demoMode=false;
    public function __construct()
    {
        $this->name = "baproductzoommagnifier";
        $this->tab = "shipping_logistics";
        $this->version = "1.0.16";
        $this->author = "buy-addons";
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        $this->module_key = 'f8937921adebca4fe32f5e08381a74b8';
        $this->displayName = $this->l('Prestashop Best Zoom Magnifier Module - BAZoom Magnifier');
        $this->description =$this->l('Allows you to add a zoom effect to all your product images on all pages, blocks');
        parent::__construct();
    }
    public function install()
    {
        if (parent::install() == false || !$this->registerhook('displayHeader')) {
            return false;
        }
        $url_cover_16 = _PS_ROOT_DIR_.'/js/jquery/plugins/jquery.easing.js';
        $fileContents16 = Tools::file_get_contents($url_cover_16);
        $replacement_start = '$(document).ready(function() {';
        $replacement_end = '});';
        $str = "jQuery.easing['jswing'] = jQuery.easing['swing'];";
        $lineNumber = '';
        $line = file($url_cover_16);
        foreach ($line as $key => $v) {
            if (strpos($v, $str) !== false) {
                $lineNumber = $key+1;
            }
        }
        if (strpos($fileContents16, $replacement_start) == false) {
            $contents16 = file($url_cover_16, FILE_IGNORE_NEW_LINES);
            $specific_line16 = $lineNumber + 1;
            array_splice($contents16, $specific_line16 - 2, 0, array(
                $replacement_start
            ));
            $contents16 = implode("\n", $contents16);
            file_put_contents($url_cover_16, $contents16);
            
            $contents = file($url_cover_16, FILE_IGNORE_NEW_LINES);
            $specific_line = sizeof($contents) + 1;
            array_splice($contents, $specific_line - 1, 0, array( $replacement_end));
            $contents = implode("\n", $contents);
            file_put_contents($url_cover_16, $contents);
        }
        Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'zoom_img`;');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $query = "CREATE TABLE IF NOT EXISTS  "._DB_PREFIX_.'zoom_img'."(id int(255) not null AUTO_INCREMENT";
        $query .=",width_box varchar(999) not null,height_box varchar(999) not null,";
        $query .="width_img varchar(999) not null,height_img varchar(999) not null,";
        $query .="active varchar(255) not null,active_mobile int(255) not null,";
        $query .="time_lens_run varchar(999) not null,exclude_cate varchar(999) not null,";
        $query .="active_product varchar(999) not null,types varchar(999) not null,";
        $query .="id_shop int(255) not null,cursors varchar(999) not null,opacity varchar(999) not null,";
        $query .="width_boxm int(255) not null,height_boxm varchar(999) not null,typem varchar(999) not null,";
        $query .="block varchar(999) not null,PRIMARY KEY (id))";
        $db->query($query);
        $list_id_shop = Shop::getCompleteListOfShopsID();
        foreach ($list_id_shop as $key_list) {
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','1','1','1',";
            $sqladd .="'','','$key_list','lens','true','1','product',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','category',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','search',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','pricesdrop',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','bestsales',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','newproducts',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','index_bestsales',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','index_pricesdrop',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','index_newproduct',200,200,'lens')";
            $db->query($sqladd);
            $sqladd="REPLACE INTO "._DB_PREFIX_.'zoom_img'."(width_box,height_box,";
            $sqladd .="width_img,height_img,active,active_mobile,time_lens_run,exclude_cate,";
            $sqladd .="active_product,id_shop,types,cursors,opacity,block,height_boxm,width_boxm,typem) ";
            $sqladd .="VALUES('200','200','700','700','0','0','1',";
            $sqladd .="'','','$key_list','lens','true','1','index_homefeatured',200,200,'lens')";
            $db->query($sqladd);
        };
    
        return true;
    }
    public function uninstall()
    {
        if (parent::uninstall() == false) {
            return false;
        }
        return true;
    }
    public function hookdisplayHeader($params)
    {
         $html = '';
         $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

         $page_type = Tools::getValue('controller');

        if ($page_type != "product") {
            if ($page_type != "category") {
                if ($page_type != "search") {
                    if ($page_type != "pricesdrop") {
                        if ($page_type != "bestsales") {
                            if ($page_type != "newproducts") {
                                if ($page_type != "index") {
                                    $page_type = "product";
                                }
                            }
                        }
                    }
                }
            }
        }
         $get_idpro=Tools::getValue('id_product');
         $product_cate = Product::getProductCategories(Tools::getValue('id_product'));
         $id_shop = $this->context->shop->id;
         $showdb = "SELECT * FROM "._DB_PREFIX_.'zoom_img'." WHERE id_shop = ".(int)$id_shop."";
         $showdb .= " AND block = '".pSQL($page_type)."'";
         $javaend = Configuration::get('PS_JS_DEFER');
         $bases = __PS_BASE_URI__ ;
        $this->context->smarty->assign('bases', $bases);
        if ($page_type == 'index') {
            $showdb = "SELECT * FROM "._DB_PREFIX_.'zoom_img'." WHERE id_shop = ".(int)$id_shop."";
            $showdb .= " AND block like '%".pSQL($page_type)."%'";
        }
         $shows = $db->ExecuteS($showdb);
        foreach ($shows as $key) {
             $test = $key["width_img"];
             $test1 = $key["height_img"];
             $test2 = $key['width_box'];
             $test3 = $key['height_box'];
             $test4 = $key['time_lens_run'];
             $test5 = $key['active_mobile'];
             $test6 = $key['types'];
             $test7 = $key['cursors'];
             $test8 = $key['opacity'];
             $active = $key['active'];
             $width_boxm = $key['width_boxm'];
             $height_boxm = $key['height_boxm'];
             $typem = $key['typem'];
            if ($page_type == 'index') {
                if ($key['block'] == 'index_bestsales') {
                     $active_best = $key['active'];

                     $test2_best = $key['width_box'];
                     $test3_best = $key['height_box'];
                     $test4_best = $key['time_lens_run'];
                     $test5_best = $key['active_mobile'];
                     $test6_best = $key['types'];
                     $test7_best = $key['cursors'];

                     $width_boxm_best = $key['width_boxm'];
                     $height_boxm_best = $key['height_boxm'];
                     $typem_best = $key['typem'];
                }
                if ($key['block'] == 'index_pricesdrop') {
                     $active_prices = $key['active'];

                     $test2_prices = $key['width_box'];
                     $test3_prices = $key['height_box'];
                     $test4_prices = $key['time_lens_run'];
                     $test5_prices = $key['active_mobile'];
                     $test6_prices = $key['types'];
                     $test7_prices = $key['cursors'];

                     $width_boxm_prices = $key['width_boxm'];
                     $height_boxm_prices = $key['height_boxm'];
                     $typem_prices = $key['typem'];
                }
                if ($key['block'] == 'index_newproduct') {
                     $active_new = $key['active'];

                     $test2_new = $key['width_box'];
                     $test3_new = $key['height_box'];
                     $test4_new = $key['time_lens_run'];
                     $test5_new = $key['active_mobile'];
                     $test6_new = $key['types'];
                     $test7_new = $key['cursors'];

                     $width_boxm_new = $key['width_boxm'];
                     $height_boxm_new = $key['height_boxm'];
                     $typem_new = $key['typem'];
                }
                if ($key['block'] == 'index_homefeatured') {
                     $active_home = $key['active'];

                     $test2_home = $key['width_box'];
                     $test3_home = $key['height_box'];
                     $test4_home = $key['time_lens_run'];
                     $test5_home = $key['active_mobile'];
                     $test6_home = $key['types'];
                     $test7_home = $key['cursors'];

                     $width_boxm_home = $key['width_boxm'];
                     $height_boxm_home = $key['height_boxm'];
                     $typem_home = $key['typem'];
                }
            }
             $json=str_replace("['[',']']", "", json_decode($key['exclude_cate']));
             $json_pros=str_replace("['[',']']", "", json_decode($key['active_product']));
        }
        $this->context->smarty->assign('sass', '' . __PS_BASE_URI__ . 'modules/baproductzoommagnifier/');
        $this->context->smarty->assign('width_img', $test);
        $this->context->smarty->assign('height_img', $test1);
        $this->context->smarty->assign('opacity', $test8);
        $jquery = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/jquery-3.3.1.min.js';
        $this->context->controller->addCSS($this->_path . 'views/css/zoomple.css');
        $zoomple = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/zoomple.js';
        $this->context->smarty->assign('zoomple', $zoomple);
        $this->context->smarty->assign('jquery', $jquery);
        $zoomfix = "";
        $zoomfixss = "";
        $zoomfixs = "";
        if (is_array($json)) {
            if (count(array_intersect($json, $product_cate))>0) {
                if (is_array($json_pros)) {
                    if (in_array($get_idpro, $json_pros)) {
                        if (Tools::version_compare(_PS_VERSION_, '1.6.0.0', '>')) {
                            if (Tools::version_compare(_PS_VERSION_, '1.6.1.0', '<')) {
                                 $zoomfix = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/zoomfix.js';
                            };
                        };
                        if (Tools::version_compare(_PS_VERSION_, '1.6.0.14', '>')) {
                            if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '<')) {
                                if ($javaend == 0) {
                                    $zoomfixss = __PS_BASE_URI__ ;
                                    $zoomfixss .= 'modules/baproductzoommagnifier/views/js/zoomfixss.js';
                                } else {
                                     $zoomfixss = __PS_BASE_URI__ ;
                                     $zoomfixss .= 'modules/baproductzoommagnifier/views/js/jsend.js';
                                }
                            }
                        };
                        if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>')) {
                                 $zoomfixs = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/zoomfixs.js';
                        };
                    };
                };
            } else {
                if (Tools::version_compare(_PS_VERSION_, '1.6.0.0', '>')) {
                    if (Tools::version_compare(_PS_VERSION_, '1.6.1.0', '<')) {
                         $zoomfix = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/zoomfix.js';
                    };
                };
                if (Tools::version_compare(_PS_VERSION_, '1.6.0.14', '>')) {
                    if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '<')) {
                        if ($javaend == 0) {
                             $zoomfixss = __PS_BASE_URI__ ;
                             $zoomfixss .= 'modules/baproductzoommagnifier/views/js/zoomfixss.js';
                        } else {
                             $zoomfixss = __PS_BASE_URI__ ;
                             $zoomfixss .= 'modules/baproductzoommagnifier/views/js/jsend.js';
                        }
                    }
                };
                if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>')) {
                         $zoomfixs = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/zoomfixs.js';
                };
            };
        } else {
            if (Tools::version_compare(_PS_VERSION_, '1.6.0.0', '>')) {
                if (Tools::version_compare(_PS_VERSION_, '1.6.1.0', '<')) {
                     $zoomfix = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/zoomfix.js';
                };
            };
            if (Tools::version_compare(_PS_VERSION_, '1.6.0.14', '>')) {
                if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '<')) {
                    if ($javaend == 0) {
                         $zoomfixss = __PS_BASE_URI__ ;
                         $zoomfixss .= 'modules/baproductzoommagnifier/views/js/zoomfixss.js';
                    } else {
                         $zoomfixss = __PS_BASE_URI__ ;
                         $zoomfixss .= 'modules/baproductzoommagnifier/views/js/jsend.js';
                    }
                }
            };
            if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>')) {
                 $zoomfixs = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/zoomfixs.js';
            };
        };
        $this->context->smarty->assign('zoomfixs', $zoomfixs);
        $this->context->smarty->assign('zoomfixss', $zoomfixss);
        $this->context->smarty->assign('zoomfix', $zoomfix);
        $html .= $this->display(__FILE__, 'views/templates/front/template.tpl');
        $check160 = Tools::version_compare(_PS_VERSION_, '1.6.0.14', '<');
        $check170 = Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>');
         $html .= '
             <script>
                 var width_box = \'' .$test2. '\';
                 var height_box = \'' .$test3. '\';
                 var time_lens_run = \'' .$test4. '\';
                 var active_mobile = \'' .$test5. '\';
                 var types = \'' .$test6. '\';
                 var cursors = \'' .$test7. '\';
                 var active = \'' .$active. '\';
                 var page_type = \'' .$page_type. '\';
                 var width_boxm = \'' .$width_boxm. '\';
                 var height_boxm = \'' .$height_boxm. '\';
                 var typem = \'' .$typem. '\';
                 var check160 = \'' .$check160. '\';
                 var check170 = \'' .$check170. '\';
             </script>';
        if ($page_type == 'index') {
            $html .= '
             <script>
                 var bases = \'' .$bases. '\';                 
                 var active_best = \'' .$active_best. '\';
                 var width_box_best = \'' .$test2_best. '\';
                 var height_box_best = \'' .$test3_best. '\';
                 var time_lens_run_best = \'' .$test4_best. '\';
                 var active_mobile_best = \'' .$test5_best. '\';
                 var types_best = \'' .$test6_best. '\';
                 var cursors_best = \'' .$test7_best. '\';
                 var width_boxm_best = \'' .$width_boxm_best. '\';
                 var height_boxm_best = \'' .$height_boxm_best. '\';
                 var typem_best = \'' .$typem_best. '\';

                 var active_new = \'' .$active_new. '\';
                 var width_box_new = \'' .$test2_new. '\';
                 var height_box_new = \'' .$test3_new. '\';
                 var time_lens_run_new = \'' .$test4_new. '\';
                 var active_mobile_new = \'' .$test5_new. '\';
                 var types_new = \'' .$test6_new. '\';
                 var cursors_new = \'' .$test7_new. '\';
                 var width_boxm_new = \'' .$width_boxm_new. '\';
                 var height_boxm_new = \'' .$height_boxm_new. '\';
                 var typem_new = \'' .$typem_new. '\';

                 var active_prices = \'' .$active_prices. '\';
                 var width_box_prices = \'' .$test2_prices. '\';
                 var height_box_prices = \'' .$test3_prices. '\';
                 var time_lens_run_prices = \'' .$test4_prices. '\';
                 var active_mobile_prices = \'' .$test5_prices. '\';
                 var types_prices = \'' .$test6_prices. '\';
                 var cursors_prices = \'' .$test7_prices. '\';
                 var width_boxm_prices = \'' .$width_boxm_prices. '\';
                 var height_boxm_prices = \'' .$height_boxm_prices. '\';
                 var typem_prices = \'' .$typem_prices. '\';

                 var active_home = \'' .$active_home. '\';
                 var width_box_home = \'' .$test2_home. '\';
                 var height_box_home = \'' .$test3_home. '\';
                 var time_lens_run_home = \'' .$test4_home. '\';
                 var active_mobile_home = \'' .$test5_home. '\';
                 var types_home = \'' .$test6_home. '\';
                 var cursors_home = \'' .$test7_home. '\';
                 var width_boxm_home = \'' .$width_boxm_home. '\';
                 var height_boxm_home = \'' .$height_boxm_home. '\';
                 var typem_home = \'' .$typem_home. '\';
             </script>';
        }
         return $html;
    }

    public function getContent()
    {
        
        $html = '';
        if (Tools::getValue('ok') == 1) {
            $html .= $this->displayConfirmation($this->l('Successful Update'));
        }
        if (Tools::getValue('val') == 1) {
                $alert_error = $this->l('Value Zoom Box Height is a number, Greater than 0, Is not a decimal digit.');
                $html = $this->displayError($alert_error);
        }
        if (Tools::getValue('val') == 2) {
                $alert_error = $this->l('Value Image zoom size is a number, Greater than 0, Is not a decimal digit.');
                $html = $this->displayError($alert_error);
        }
        if (Tools::getValue('val') == 3) {
                $alert_error = $this->l('Value Time Lens Show/Hidden
                 is a number, Greater than 0, Is not a decimal digit.');
                $html = $this->displayError($alert_error);
        }
        if (Tools::getValue('val') == 5) {
                $alert_error = $this->l('Value Mobile Zoom Box Height
                 is a number, Greater than 0, Is not a decimal digit.');
                $html = $this->displayError($alert_error);
        }
        if (Tools::getValue('val') == 6) {
                $alert_error = $this->l('Value Mobile Zoom Box Width
                 is a number, Greater than 0, Is not a decimal digit.');
                $html = $this->displayError($alert_error);
        }
        if (Tools::getValue('val') == 7) {
                $alert_error = $this->l('Value Zoom Box Width is a number, Greater than 0, Is not a decimal digit.');
                $html = $this->displayError($alert_error);
        }

        $demoMode=0;
        if (Tools::getValue('demo')=="1") {
            $demoMode=Tools::getValue('demo');
        }
        $this->smarty->assign('demoMode', $demoMode);
        $bamodule = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        $id_langs = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        $iso_lang = $this->context->language->iso_code;
        $base=Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__;
        $this->smarty->assign('base', $base);
        $this->smarty->assign('iso_lang', $iso_lang);
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);

        $showdb = "SELECT * FROM "._DB_PREFIX_.'zoom_img'." WHERE id_shop = ".(int) $id_shop."";
        $showdbp = "SELECT * FROM "._DB_PREFIX_.'zoom_img'." WHERE id_shop = ".(int) $id_shop." AND block = 'product'";
        $shows = $db->ExecuteS($showdb);
        $showsp = $db->ExecuteS($showdbp);
        $this->smarty->assign('shows', $shows);
        foreach ($showsp as $key) {
             $json=str_replace("['[',']']", "", json_decode($key['exclude_cate']));
             $prods=str_replace("['[',']']", "", json_decode($key['active_product']));
        }
       
        $this->smarty->assign('json', $json);
        $message = "";
        if (Tools::isSubmit('save')) {
            $height_box = Tools::getValue('height_box');
            $width_box = Tools::getValue('width_box');
            $height_img = Tools::getValue('height_img');
            $width_img = Tools::getValue('width_img');
            $active = Tools::getValue('active');
            $active_m = Tools::getValue('active_m');
            $time_lens_run = Tools::getValue('time_lens_run');
            $type=Tools::getValue('type');
            $cursors=Tools::getValue('cursors');
            $opacity=Tools::getValue('opacity');
            $cate=Tools::getValue('categoryBox');

            $block=Tools::getValue('block');
            $check_block=Tools::getValue('check_block');

            $typem=Tools::getValue('typem');
            $height_boxm=Tools::getValue('height_boxm');
            $width_boxm=Tools::getValue('width_boxm');
            $cates=json_encode($cate);
            $active_product=Tools::getValue('active_pro');
            $active_products=json_encode($active_product);
            if (!ValidateCore::isUnsignedInt($height_box)) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.
                    $block . '&val=1');
            }
            if (!ValidateCore::isUnsignedInt($width_img)) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.
                    $block . '&val=2');
            }
            if (!ValidateCore::isUnsignedInt($time_lens_run)) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.
                    $block . '&val=3');
            }

            if (!ValidateCore::isUnsignedInt($height_boxm)) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.
                    $block . '&val=5');
            }
            if (!ValidateCore::isUnsignedInt($width_boxm)) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.
                    $block . '&val=6');
            }
            if (!ValidateCore::isUnsignedInt($width_box)) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.
                    $block . '&val=7');
            }
            if (!ValidateCore::isUnsignedInt($height_img)) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.
                    $block . '&val=2');
            }
            if ($block == 'index') {
                $block = $block .'_'. $check_block;
            }
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.$block.'&demo=1');
            }
            $sqladd="UPDATE "._DB_PREFIX_.'zoom_img'." SET height_box = '".pSQL($height_box)."',";
            $sqladd .="width_box = '".pSQL($width_box)."',height_img = '".pSQL($height_img)."',";
            $sqladd .="width_img = '".pSQL($width_img)."',";
            $sqladd .="active_mobile='".(int) $active_m ."',";
            $sqladd .="time_lens_run='".pSQL($time_lens_run)."',exclude_cate='".pSQL($cates)."',";
            $sqladd .="active_product='".pSQL($active_products)."',";
            $sqladd .="types='".pSQL($type)."',cursors='".pSQL($cursors)."',";
            $sqladd .="opacity='".pSQL($opacity)."',active= '".(int) $active . "',";
            $sqladd .="typem='".pSQL($typem)."',height_boxm='".pSQL($height_boxm)."',";
            $sqladd .="width_boxm = '".pSQL($width_boxm)."'";
            $sqladd .=" WHERE id_shop = " . (int) $id_shop . " AND block = '".pSQL($block)."'";
            $db->query($sqladd);
            Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&checksb='.$block . '&ok=1');
        }
        $this->context->smarty->assign('message', $message);
        if (is_array($json)) {
            $id_category_dbboo = $json;
        } else {
            $id_category_dbboo = array();
        }
        $tree = new HelperTreeCategories('categories-tree');
        $tree->setRootCategory(Category::getRootCategory()
            ->id_category)
            ->setUseCheckBox(true)
            ->setUseSearch(true)
            ->setSelectedCategories($id_category_dbboo);
        $menu = $this->tpl_list_vars['category_tree'] = $tree->render();
        $this->context->smarty->assign("tree", $menu);
        $product=array();
        if (is_array($prods)) {
            foreach ($prods as $prodss) {
                $product[]=new Product($prodss, true, $id_langs);
            };
        } else {
            $product[]="";
        }
        $checksb = Tools::getValue('checksb');
        $this->context->smarty->assign('product', $product);
        $this->context->smarty->assign('checksb', $checksb);
        $Drift = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/Drift.js';
        $dropdown = __PS_BASE_URI__ . 'modules/baproductzoommagnifier/views/js/dropdown.js';
        $this->context->smarty->assign('Drift', $Drift);
        $this->context->smarty->assign('dropdown', $dropdown);
        $html .= '<script>
                     var id_shop = \'' .$id_shop. '\';
                     var id_langs = \'' .$id_langs. '\';
                     var base = \'' .$base. '\';
                     var name_m = \'' .$this->name. '\';
                 </script>';
        $this->context->controller->addCSS($this->_path . 'views/css/style.css');
        $html .= $this->addAwesomeFont();
        $html .= $this->display(__FILE__, 'views/templates/admin/template.tpl');
        return $html;
    }
    public function addAwesomeFont()
    {
        $html = '';
        if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
            $awesome_font = __PS_BASE_URI__. 'themes/_libraries/font-awesome/css/font-awesome.css';
        } else {
            $awesome_font = $this->_path . 'views/css/fontawesome_16.css';
        }
        $this->context->smarty->assign('awesome_font', $awesome_font);
        $html .= $this->display(__FILE__, 'views/templates/admin/awesome_font.tpl');
        return $html;
    }
}
