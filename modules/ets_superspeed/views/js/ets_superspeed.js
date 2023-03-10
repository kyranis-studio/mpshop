/**
 * 2007-2020 ETS-Soft
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
$(document).ready(function(){
        
   if($('.ets_speed_dynamic_hook').length)
   {
        var datas='';
		$('.ets_speed_dynamic_hook').each(function(index, domhook){
			datas = datas + '&hook_' + index + '=' + $(this).attr('data-hook')+'&module_'+index+'='+$(this).attr('data-moudule');
		});
        var url      = window.location.href;
        var indexphp = url.indexOf('?');
        var indexthang = url.indexOf('#');
        if(indexthang>=0)
            url = url.substr(0,indexthang);
        $.ajax({
			type: 'POST',
			headers: { "cache-control": "no-cache" },
			url: url,
			async: true,
			cache: false,
			dataType : "json",
			data: 'ajax=1&ets_superseed_load_content=1&ajax=1&count_datas='+$('.ets_speed_dynamic_hook').length+datas,
			success: function(jsonData,textStatus,jqXHR)
			{
			     if(jsonData)
                 {
                    renderDataAjax(jsonData);
                    if($(window).width()<768)
                    {
                        $("*[id^='_desktop_']").each(function(t, e){
                             var n = $("#" + e.id.replace("_desktop_", "_mobile_"));
                             if($(this).html().trim()!='' && n.length)
                                n.html($(this).html());
                        });
                    }
                    $(document).trigger("hooksLoaded");
                 }
				
            },
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				
			}
		});
   } 
});