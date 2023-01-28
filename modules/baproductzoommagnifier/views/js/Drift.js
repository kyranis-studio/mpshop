/**
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
* @author    Buy-addons    <contact@buy-addons.com>
* @copyright 2007-2021 Buy-addons
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
"use strict";
$(document).ready(function(){
      $('#td_id_category').keyup(function(){
         var name_product = jQuery('#td_id_category').val();
        if (name_product.length==0) { 
          $(".ss").css("display", "none");
        }
        else{
          $(".ss").css("display", "block");
        }
        $.ajax({
          url:base+"index.php?controller=zoom&fc=module&module=baproductzoommagnifier",
          dataType: 'json ',
          data: 'name_product=' + name_product + '&id_shop='+id_shop +'&id_langs='+id_langs,
          method:'POST',
          success:function(data){
            product_show(data);
          }
      });
    });
    function product_show(data){
      var html='';
      for(var i = 0;i<data.count;i++){
        html+='<li onclick="add(this)" id="'+data.shows[i]['id_product']+'" class="ui-widget-content ui-corner-tr rga">';
        html+='<p style="padding:5px;margin:0px;font-size:11px;"  >'+data.shows[i]['name']+" "+"(id: "+data.shows[i]['id_product']+")"+'</p>';
        html+='</li>';
      }
      $(".ss").html(html);
    };
    
});