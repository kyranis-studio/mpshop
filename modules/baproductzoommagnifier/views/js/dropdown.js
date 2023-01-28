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
    $('select.cheks_type').on('click',function(){
        var rr = base+'modules/'+name_m+"/views/img/"+$(this).parent().find('option.checks_type:selected').val()+'.png';
        $(this).parent().find('.demo_type img').attr('src',rr);
    });
    var opt_ch = base+'modules/'+name_m+"/views/img/"+$('option.checks_type:selected').val()+'.png';
    $('select.cheks_type .demo_type img').attr('src',opt_ch);
    $('select.cheks_type').click();
    $('select.cheks_typem').on('click',function(){
        var rrr = base+'modules/'+name_m+"/views/img/"+$(this).parent().find('option.checks_typem:selected').val()+'.png';
        $(this).parent().find('.demo_type img').attr('src',rrr);
    });
    var opt_chm = base+'modules/'+name_m+"/views/img/"+$('option.checks_typem:selected').val()+'.png';
    $('select.cheks_typem .demo_type img').attr('src',opt_ch);
    $('select.cheks_typem').click();

	var check_hidet = $("form");
	for(var e = 0;e<check_hidet.length;e++){
		check_hidet.eq(e).find('.panel:not(:first)').find('.panel-heading').nextAll().addClass("selecteds");
	}
	$(".panel-heading").click(function() {
        var li = $(this).nextAll();
        var icons = $(this).children().not('.icon-cogs');
        if (li.hasClass("selecteds")) {
	    	$(li).removeClass('selecteds');
	    	icons.addClass("fa-minus-circle");
	    	icons.removeClass('fa-plus-circle');
            return false;
        } 
        else {
            $(li).removeClass('selecteds');
            li.addClass("selecteds");
            icons.addClass("fa-plus-circle");
            icons.removeClass('fa-minus-circle');
        }
    });
    
	$('.reser').click(function(){
    		$(this).parent().remove();
    });
    $('.list-group-item').click(function(){
		var id_list = $(this).attr('id');
		var get_hf =$("#"+id_list+"_f");
		if (get_hf.hasClass("hidden")) {
				$('.list-group-item').removeClass('active');
				$('form.td_t').addClass( "hidden" );
				$(this).addClass('active');
				get_hf.removeClass( "hidden" );
		}		    	
    });
});