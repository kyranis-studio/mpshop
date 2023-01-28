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
var isMobile;
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
				var check_blok = '.featured-products ';
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
				var check_blok = '.featured-products ';
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

/** process Product page since 1.0.11 **/
var baproductzoom_cover_img_old = null;
var baproductzoom_timer = null;
function baproductzoom_addEventProductPage() {
	baproductzoom_timer = setInterval(baproductzoommagnifier_init, 500);
}
function baproductzoommagnifier_triggerVariants() {
	$(".product-variants").unbind('click');
	$(".product-variants").click(function(){
		$('#zoomple_previewholder').removeClass('zp-visible');
		$('#zoomple_image_overlay').css('display','none');
		$('#zoomple_previewholder .image_wrap img').css({"background" : "50% 50% no-repeat",'left' : 'auto','top' : 'auto','width' : 'auto','height' : 'auto'});
		$('#zoomple_previewholder').find("p").html('');
		baproductzoom_cover_img_old = 'product-variants';
	});
	$(".js-qv-mask .thumb-container").click(function(){
		baproductzoom_cover_img_old = 'thumb-container';
	});
}
function baproductzoommagnifier_init() {
	baproductzoommagnifier_triggerVariants();
	var img = $('.product-cover img');
	var src = img.attr("src");
	var pa = img.parent();
	// đang hiển thị icon viewer OR class cha khác zoomsl -> chứng tỏ chưa được add events -> add thêm
	var noevent = false;
	if($(".product-cover .layer").is(":visible") || !pa.hasClass("zoomsl")) {
		noevent = true;
	}
	if ((src == baproductzoom_cover_img_old) && noevent == false) {
		// console.log(noevent);
		return false;
	}
	baproductzoom_cover_img_old = src;

	$(document).on('click','#zoomple_image_overlay',function(event){
		event.preventDefault();
		if(isMobile != null){
			return false; // không cho click modal trên mobile
		}
		$('#zoomple_previewholder').removeClass('zp-visible');
		$('#zoomple_image_overlay').css('display','none');

		$('.modal-backdrop.fade.in').remove();
		$('.js-product-images-modal').addClass('fade in');
		$('.js-product-images-modal').css('display','block');
		$( "body" ).append('<div class="modal-backdrop fade in"></div>');
		$(document).on('click','.js-product-images-modal',function(event){
			if(!$(event.target).hasClass('js-product-images-modal')) {
				return false;
			}
			$('.js-product-images-modal').removeClass('fade in');
			$('.js-product-images-modal').css('display','none');
			$('.modal-backdrop.fade.in').remove();
		});
		// since 1.0.14+
		$(document).on('click','.modal.fade.quickview',function(event){
			if(!$(event.target).hasClass('quickview')) {
				return false;
			}
			$('.js-product-images-modal').removeClass('fade in');
			$('.js-product-images-modal').css('display','none');
			$('.modal-backdrop.fade.in').remove();			
		});
	});
	$(".product-cover .hidden-sm-down, .product-cover .layer").css('display','none');

	if(typeof src == "undefined") {
		return false;
	}
	
	var new_type = types;
	if(isMobile != null){
		new_type = typem;
	}
	if(pa.hasClass("zoomsl")) {
		img.unwrap();	
	}
	img.off();
	img.wrap("<a rel='"+src+"' class='"+new_type+" zoomsl'></a>");
	$('#zoomple_previewholder .image_wrap img').attr('src', src);
	
	if(isMobile != null){
		type_zoom_m();
	}
	else{
		type_zoom();
	}
	return true;
}
function zoom_cate(){
	if ($(".product-miniature .thumbnail-container>.thumbnail img").length > 0) {
		$('.quick-view').css('display','none');
		$(document).on('click','#zoomple_image_overlay',function(){
			$('#zoomple_previewholder').removeClass('zp-visible');
			$('#zoomple_image_overlay').css('display','none');
			$('.quick-view i:visible').click();
		});
		var abc;
		var new_src;
		var style;
		var new_src = $(".product-miniature .thumbnail-container>.thumbnail img").attr('src');
			abc = new_src.replace('home', 'large');
		if(isMobile != null){
			$(".product-miniature .thumbnail-container>.thumbnail img").wrap("<a rel='"+abc+"' class='"+typem+" zoomsl'></a>");
		}
		else{

			$(".product-miniature .thumbnail-container>.thumbnail img").wrap("<a rel='"+abc+"' class='"+types+" zoomsl'></a>");
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
					if(active_best == 1){
						 types = types_home;
						 typem = typem_home;
						 if($(".featured-products").length > 0){
							 var classr = $(".featured-products").find('.zoomsl').attr('class').split(' ')[0];
							 $(".featured-products").find('.zoomsl').removeClass(classr);
							 if(isMobile != null){
								$(".featured-products").find('.zoomsl').addClass(typem);
							 }
							 else{
								$(".featured-products").find('.zoomsl').addClass(types);
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
		$('.thumbnail-container').on('mouseenter touchmove touchstart',function(){
		
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
jQuery(function($) {
jQuery(window).ready(function () {
	$('.product-description').on('mouseenter',function(){
		$('.quick-view').css('display','block');
	});
	$('body').on('touchend touchcancel',function(e){
		$('#zoomple_previewholder').css('display','none');		  
	});
	$('#view_full_size .span_link').css('z-index','999999');
	isMobile = navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)/i);
	$('body').on('touchend touchcancel',function(e){
		$('#zoomple_previewholder').css('display','none');		  
	});
	$('#image-block').on('touchleave touchend',function(e){
		$('#zoomple_previewholder').css('display','none');		  
	});
	if(page_type == 'index'){
		 active = 1;
		 active_mobile =1;
	}
	if(active == 1){
		if(isMobile != null && active_mobile == 0){
		}
		else{
			baproductzoom_addEventProductPage();
			if(page_type == "index" || page_type == "category" || page_type == "search" || page_type == "pricesdrop" || page_type == "bestsales"){
				zoom_cate();
			}
		}
	}
	if($('div').hasClass('cursor') == true){
		$('.product-description').on('mouseleave',function(){
			$('.quick-view').css('display','none');
		});
	}
});
});