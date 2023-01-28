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
jQuery(function($) {
jQuery(document).ready(function () {
	$('#view_full_size .span_link').css('z-index','999999');
	var isMobile = navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)/i);
	$('body:not(.fancybox-margin)').on('touchend touchcancel',function(e){
		$('#zoomple_previewholder').css('display','none');		  
	});
		$('.span_link').on('click',function(){
			$(this).addClass('fixz checkz');
		});
		$('body').on('click',function(e){
			if(!$('html').hasClass('fancybox-margin')){
				if(!$('span').hasClass('fixz')){
					$('.span_link').css('z-index','9');
					$('.span_link').addClass( "fixz" );
				}
				else{
					$('.span_link').removeClass( "fixz" );
					$('.span_link').css('z-index','9999999');
				}
			}
		});
	function type_zoom_m(){
		$('.lens').zoomple({ 
			offset : {x:-width_boxm/2,y:-height_boxm/2},
			zoomWidth : width_boxm,  
			zoomHeight : height_boxm,
			delay : time_lens_run,
			roundedCorners : true,
			showCursor : cursors,
			source :'rel',
		});
		$('.square').zoomple({ 
			offset : {x:5,y:5},
			zoomWidth : width_boxm,
			delay : time_lens_run,
			zoomHeight : height_boxm,
			showCursor : cursors,
			source :'rel',			
		});
		$('.sniper_zoom').zoomple({
			offset : {x:-width_boxm/2,y:-height_boxm/2},
			zoomWidth : width_boxm,  
			zoomHeight : height_boxm,
			delay : time_lens_run,
			showCursor : cursors,
			source :'rel',
		});
	}
	function type_zoom(){
		$('.lens').zoomple({ 
			offset : {x:-width_box/2,y:-height_box/2},
			zoomWidth : width_box,  
			zoomHeight : height_box,
			delay : time_lens_run,
			roundedCorners : true,
			showCursor : cursors,
			source :'rel',
		});
		$('.square').zoomple({ 
			offset : {x:5,y:5},
			zoomWidth : width_box,
			delay : time_lens_run,
			zoomHeight : height_box,
			showCursor : cursors,
			source :'rel',			
		});
		
		$('.box_zoom_left').zoomple({
			offset : {x:5,y:0},
			showOverlay : true , 
			roundedCorners: false, 
			windowPosition : {x:'left',y:'top'}, 
			zoomWidth : width_box,
			delay : time_lens_run,  
			zoomHeight : height_box,
			showCursor : cursors,
			attachWindowToMouse : false,
			source :'rel',
		}); 
		$('.box_zoom_right').zoomple({
			offset : {x:10,y:0},
			showOverlay : true , 
			zoomWidth : 250, 
			showCursor : true, 
			delay : 1000,
			showCursor : cursors,
			zoomWidth : width_box,
			delay : time_lens_run,  
			zoomHeight : height_box,
			source :'rel',
		}); 
		$('.sniper_zoom').zoomple({
			offset : {x:-width_box/2,y:-height_box/2},
			zoomWidth : width_box,  
			zoomHeight : height_box,
			delay : time_lens_run,
			showCursor : cursors,
			source :'rel',
		});
	}
	function type_zoom_m_index(){
		for(var x = 1 ;x<5;x++){
			if(x==1){
				if(active_mobile_new == 1){
					var check_blok = '#blocknewproducts ';
					var width_boxm = width_boxm_new;
					var height_boxm = height_boxm_new;
				}
			}
			if(x==2){
				if(active_mobile_prices == 1){
					var check_blok = '#blockspecials ';
					var width_boxm = width_boxm_prices;
					var height_boxm = height_boxm_prices;
				}
			}
			if (x==3) {
				if(active_mobile_best == 1){
					var check_blok = '#blockbestsellers ';
					var width_boxm = width_boxm_best;
					var height_boxm = height_boxm_best;
				}
			}
			if (x==4) {
				if(active_mobile_home == 1){
					var check_blok = '#homefeatured ';
					var width_boxm = width_boxm_home;
					var height_boxm = height_boxm_home;
				}
			}
			$(check_blok+'.lens').zoomple({ 
				offset : {x:-width_boxm/2,y:-height_boxm/2},
				zoomWidth : width_boxm,  
				zoomHeight : height_boxm,
				delay : time_lens_run,
				roundedCorners : true,
				showCursor : cursors,
				source :'rel',
			});
			$(check_blok+'.square').zoomple({ 
				offset : {x:5,y:5},
				zoomWidth : width_boxm,
				delay : time_lens_run,
				zoomHeight : height_boxm,
				showCursor : cursors,
				source :'rel',			
			});
			$(check_blok+'.sniper_zoom').zoomple({
				offset : {x:-width_boxm/2,y:-height_boxm/2},
				zoomWidth : width_boxm,  
				zoomHeight : height_boxm,
				delay : time_lens_run,
				showCursor : cursors,
				source :'rel',
			});
		}
	}
	function type_zoom_index(){
		for(var x = 1 ;x<5;x++){
			if(x==1){
				if(active_new == 1){
					var check_blok = '#blocknewproducts ';
					var width_box = width_box_new;
					var height_box = height_box_new;
					var time_lens_run = time_lens_run_new;
					var cursors = cursors_new;
					var types = types_new;
				}
			}
			if(x==2){
				if(active_prices == 1){
					var check_blok = '#blockspecials ';
					var width_box = width_box_prices;
					var height_box = height_box_prices;
					var time_lens_run = time_lens_run_prices;
					var cursors = cursors_prices;
					var types = types_prices;
				}
			}
			if (x==3) {
				if(active_best == 1){
					var check_blok = '#blockbestsellers ';
					var width_box = width_box_best;
					var height_box = height_box_best;
					var time_lens_run = time_lens_run_best;
					var cursors = cursors_best;
					var types = types_best;
				}
			}
			if (x==4) {
				if(active_home == 1){
					var check_blok = '#homefeatured ';
					var width_box = width_box_home;
					var height_box = height_box_home;
					var time_lens_run = time_lens_run_home;
					var cursors = cursors_home;
					var types = types_home;
				}
			}
			$(check_blok+'.lens').zoomple({ 
				offset : {x:-width_box/2,y:-height_box/2},
				zoomWidth : width_box,  
				zoomHeight : height_box,
				delay : time_lens_run,
				roundedCorners : true,
				showCursor : cursors,
				source :'rel',
			});
			$(check_blok+'.square').zoomple({ 
				offset : {x:5,y:5},
				zoomWidth : width_box,
				delay : time_lens_run,
				zoomHeight : height_box,
				showCursor : cursors,
				source :'rel',			
			});	
			$(check_blok+'.box_zoom_left').zoomple({
				offset : {x:5,y:0},
				showOverlay : true , 
				roundedCorners: false, 
				windowPosition : {x:'left',y:'top'}, 
				zoomWidth : width_box,
				delay : time_lens_run,  
				zoomHeight : height_box,
				showCursor : cursors,
				attachWindowToMouse : false,
				source :'rel',
			}); 
			$(check_blok+'.box_zoom_right').zoomple({
				offset : {x:10,y:0},
				showOverlay : true , 
				zoomWidth : 250, 
				showCursor : true, 
				delay : 1000,
				showCursor : cursors,
				zoomWidth : width_box,
				delay : time_lens_run,  
				zoomHeight : height_box,
				source :'rel',
			}); 
			$(check_blok+'.sniper_zoom').zoomple({
				offset : {x:-width_box/2,y:-height_box/2},
				zoomWidth : width_box,  
				zoomHeight : height_box,
				delay : time_lens_run,
				showCursor : cursors,
				source :'rel',
			});
		}
	}
	if(page_type == 'index'){
		 active = 1;
		 active_mobile =1;
	}
	if(active == 1){
		function myFunction1() {
			var abc;
			var new_src;
			var $window = $(window);
			var windowsize = $window.width();
			if ($("#bigpic").length > 0) {
				$(document).on('click','#zoomple_image_overlay',function(){
				$('#zoomple_previewholder').removeClass('zp-visible');
				$('#views_block .shown img').click();
				});
				$("#zoomple_previewholder").remove();
				$("#bigpic").wrap("<a rel='"+abc+"' class='"+types+" zoomsl'></a>");
				new_src = $("#bigpic").attr('src');
				abc = new_src.replace('large', 'thickbox');
				$(".zoomsl").attr('rel',abc);

				$(".fancybox").on('mouseover mouseleave',function(){
					var abc;
					var new_src;
					new_src = $("#bigpic").attr('src');
					abc = new_src.replace('large', 'thickbox');
					$(".zoomsl").attr('rel',abc);
				});
				$(".fancybox").click(function(){
					var abc;
					var new_src;
					new_src = $("#bigpic").attr('src');
					abc = new_src.replace('large', 'thickbox');
					$(".zoomsl").attr('rel',abc);
				});
				$(".clearfix>li").mouseover(function(){
					var abc;
					var new_src;
					new_src = $("#bigpic").attr('src');
					abc = new_src.replace('large', 'thickbox');
					$(".zoomsl").attr('rel',abc);
				});
				$('body').on('mouseover','.fancybox-image',function(e){
					if (!$('a').hasClass("zoombig")) {
						style = "<style>.image_wrap img{width:1000px !important;height:1000px !important}</style>"
						$(".fancybox-inner").append(style);
					    $(".fancybox-image").wrap("<a rel='"+abc+"' class='lens zoomsl zoombig'></a>");

					    new_src = $(".fancybox-image").attr('src');
					    $(".zoomsl").attr('rel',new_src);
						    $('.lens').zoomple({ 
								offset : {x:-width_box/2,y:-height_box/2},
								zoomWidth : width_box,  
								zoomHeight : height_box,
								delay : time_lens_run,
								roundedCorners : true,
								showCursor : cursors,
								source :'rel',
							});
				   }; 
				});
				$('body').on('touchstart touchmove','.fancybox-image',function(e){
				if (!$('a').hasClass("zoombig")) {
					style = "<style>.image_wrap img{width:1000px !important;height:1000px !important}</style>"
					$(".fancybox-inner").append(style);
				    $(".fancybox-image").wrap("<a rel='"+abc+"' class='"+typem+" zoomsl zoombig'></a>");

				    new_src = $(".fancybox-image").attr('src');
				    $(".zoomsl").attr('rel',new_src);
				    type_zoom_m();
			   }; 
			});
			};
			if(isMobile != null){
				type_zoom_m();
			}
			else{
				type_zoom();
			}
		};
		function zoom_cate(){
			if ($(".product-container .product_img_link>.replace-2x").length > 0) {
			$(document).on('click','#zoomple_image_overlay',function(){
				$('#zoomple_previewholder').removeClass('zp-visible');
				$('#zoomple_image_overlay').css('display','none');
				$('.quick-view:visible span').click();
			});
			var abc;
			var new_src;
			var style;
			var new_src = $(".product-container .product_img_link>.replace-2x").attr('src');
				abc = new_src.replace('home', 'large');
			if(isMobile != null){
				$(".product-container .product_img_link>.replace-2x").wrap("<a rel='"+abc+"' class='"+typem+" zoomsl'></a>");
			}
			else{

				$(".product-container .product_img_link>.replace-2x").wrap("<a rel='"+abc+"' class='"+types+" zoomsl'></a>");
			}
			if(page_type == 'index'){
				for(var x = 1 ;x<5;x++){
					if(x==1){
						if(active_new == 1){
							 types = types_new;
							 typem = typem_new;
							 if($("#blocknewproducts").length > 0){
								 var classr = $("#blocknewproducts").find('.zoomsl').attr('class').split(' ')[0];
								 $("#blocknewproducts").find('.zoomsl').removeClass(classr);
								 if(isMobile != null){
								 	$("#blocknewproducts").find('.zoomsl').addClass(typem);
								 }
								 else{
								 	$("#blocknewproducts").find('.zoomsl').addClass(types);
								 }
							 }
						}
					}
					if(x==2){
						if(active_prices == 1){
							 types = types_prices;
							 typem = typem_prices;
							 if($("#blockspecials").length > 0){
								 var classr = $("#blockspecials").find('.zoomsl').attr('class').split(' ')[0];
								 $("#blockspecials").find('.zoomsl').removeClass(classr);
								 if(isMobile != null){
								 	$("#blockspecials").find('.zoomsl').addClass(typem);
								 }
								 else{
								 	$("#blockspecials").find('.zoomsl').addClass(types);
								 }
							}
						}
					}
					if (x==3) {
						if(active_best == 1){
							 types = types_best;
							 typem = typem_best;
							 if($("#blockbestsellers").length > 0){
								 var classr = $("#blockbestsellers").find('.zoomsl').attr('class').split(' ')[0];
								 $("#blockbestsellers").find('.zoomsl').removeClass(classr);
								 if(isMobile != null){
								 	$("#blockbestsellers").find('.zoomsl').addClass(typem);
								 }
								 else{
								 	$("#blockbestsellers").find('.zoomsl').addClass(types);
								 }
							}
						}
					}
					if (x==4) {
						if(active_home == 1){
							 types = types_home;
							 typem = typem_home;
							 if($("#homefeatured").length > 0 && $("#homefeatured").is('.product_list')){
								 var classr = $("#homefeatured").find('.zoomsl').attr('class').split(' ')[0];
								 $("#homefeatured").find('.zoomsl').removeClass(classr);
								 if(isMobile != null){
								 	$("#homefeatured").find('.zoomsl').addClass(typem);
								 }
								 else{
								 	$("#homefeatured").find('.zoomsl').addClass(types);
								 }
							}
						}
					}
				}
			}
			$(".zoomsl").attr('rel',abc);

			if(isMobile != null){
					if(page_type == "index"){
						type_zoom_m_index();
					}else{
						type_zoom_m();
					}
				}
				else{
					if(page_type == "index"){
						type_zoom_index();
					}else{
						type_zoom();
					}
				}
			$('.product-container').on('mouseover touchmove touchstart',function(){
			
			var abc;
			var new_src;
			var style;
			var new_src = $(this).find("img").attr('src')
				abc = new_src.replace('home', 'large');
			
			$(".zoomsl").attr('rel',abc);

			if(isMobile != null){
					if(page_type == "index"){
						type_zoom_m_index();
					}else{
						type_zoom_m();
					}
				}
				else{
					if(page_type == "index"){
						type_zoom_index();
					}else{
						type_zoom();
					}
				}
		});	
		}
			}
		if(isMobile != null && active_mobile == 0){
		}
		else{
			myFunction1();
			if(page_type == "index" || page_type == "category" || page_type == "search" || page_type == "pricesdrop" || page_type == "bestsales" || page_type == "newproducts"){
				zoom_cate();
			}
		}
};
});
});