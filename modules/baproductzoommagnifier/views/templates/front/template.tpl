{*
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
*}

<script>   
	var linkjq = "{$jquery|escape:'htmlall':'UTF-8'}";
	
	if (!window.jQuery){
		var jq = document.createElement("script");
		jq.type = "text/javascript";
		jq.src = linkjq;
		document.getElementsByTagName('head')[0].appendChild(jq);
		console.log("Added jQuery!");
	} else {
		console.log("jQuery already exists.");
	}
	window.onload = function(){
		$('body').append('<script src="{$zoomple|escape:'htmlall':'UTF-8'}" type="text/javascript" charset="utf-8">');
		var ba1 = "{$zoomfix|escape:'htmlall':'UTF-8'}";
		var ba2 = "{$zoomfixs|escape:'htmlall':'UTF-8'}";
		var ba3 = "{$zoomfixss|escape:'htmlall':'UTF-8'}";
		if (ba1 != '') {
			$('body').append('<script src="{$zoomfix|escape:'htmlall':'UTF-8'}" type="text/javascript" charset="utf-8">');
		}
		if (ba2 != '') {
			$('body').append('<script src="{$zoomfixs|escape:'htmlall':'UTF-8'}" type="text/javascript" charset="utf-8">');
		}
		if (ba3 != '') {
			$('body').append('<script src="{$zoomfixss|escape:'htmlall':'UTF-8'}" type="text/javascript" charset="utf-8">');
		}
	}
</script>

<style type="text/css" media="screen">
	#index ul.product_list.tab-pane > li,ul.product_list.grid > li{
		height: auto !important;
	}
	.image_wrap img{
 		width:{$width_img|escape:'htmlall':'UTF-8'}px !important;
 		height:{$height_img|escape:'htmlall':'UTF-8'}px !important;

	}
	.image_wrap>img,#zoomple_image_overlay{
		max-width: none !important;
	}
	.magnify > .magnify-lens{
		box-shadow: 0 0 20px 4px #000;
	}
	.caption-wrap{
		display: none;
	}
	.image_wrap{
		opacity: {$opacity|escape:'htmlall':'UTF-8'};
	}
	
	.container1{
  max-width:500px;
  position:relative;
  border:solid;
  font-size:0;
  overflow:hidden;
  }
.origin{
  width:100%;
}

.zoom{
  width:140px;
  height:140px;
  border-radius:50%;
  position:absolute;
  top:0;z-index:2;
  border:solid 4px #ccc;
  z-index: 9999;

}
.span_link{
	display: none !important;
}
</style>
<script type="text/javascript">
	var linkurl = "{$sass|escape:'htmlall':'UTF-8'}";
	if (navigator.appVersion.indexOf("Win")!=-1){
		
		var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
		if(isSafari == true ){
			$('body').append(linkurl + '/views/css/safaw.css');
		}
		
	}
</script>