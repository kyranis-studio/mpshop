/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

/**
 * This module exposes an extension point through `showModal` function.
 *
 * If you want to customize the way the modal window is displayed, you need to do:
 *
 * prestashop.blockcart = prestashop.blockcart || {};
 * prestashop.blockcart.showModal = function myOwnShowModal (modalHTML) {
 *   // your own code
 *   // please not that it is your responsibility to handle the modal "close" behavior
 * };
 *
 * Warning: your custom JavaScript needs to be included **before** this file.
 * The safest way to do so is to place your "override" inside the theme main JavaScript file.
 *
 */

$(document).ready(function () {
	cartCount = $('.cart-number').html().split("")[0]
	cartCountHide = true
	$("#_mobile_cart").append("<span class='mobile-count'>"+cartCount+"</span>")
	if(parseInt(cartCount) > 0){
		$("#_mobile_cart").find(".mobile-count").addClass("show")
	}else{
		$("#_mobile_cart").find(".mobile-count").removeClass("show")
	}
	
  prestashop.blockcart = prestashop.blockcart || {};

  var showModal = prestashop.blockcart.showModal || function (modal) {
    var $body = $('body');
    //$body.append(modal);
    $body.one('click', '#blockcart-modal', function (event) {
      if (event.target.id === 'blockcart-modal') {
        $(event.target).remove();
      }
    });
  };
	function drawCart(products){
		total = 0
		ul = ""
		cartUrl = document.querySelector("#mp-cart-url").value
		commandUrl = document.querySelector("#mp-order-url").value
		for (let product of products) {
			price = product.cart_quantity * product.price_with_reduction
			total = total + price
			productTPL = `<li class="cart-wishlist-item" data-prduct-id="${product.id}">
							<span class="thumbnail"><img class="product-image" src="${product.cover.small.url}" alt="${product.legend}" itemprop="image"></span>
							<span class="product-quantity">${product.cart_quantity} x </span>
							<span class="product-name">${product.name}</span>
							<span class="product-price">${parseFloat(product.price_with_reduction).toFixed(3)}&nbsp;DT</span>
							<span class="delete"><a class="remove-from-cart" rel="nofollow" href="${product.remove_from_cart_url}" data-link-action="delete-from-cart" data-id-product="${product.id}" data-id-customization="" title="supprimer du panier">
							<i class="fa fa-trash"></i>
							</a></span>
						</li>`
			ul = ul + productTPL
		}
		ul = "<ul>" + ul + "</ul>"
		summary =`<div class="cart-footer">
					<div class="cart-summary">
						<div class="cart-subtotals">
							<div class="products">
								<span class="label">Sous-total</span>
								<span class="value">${parseFloat(total).toFixed(3)}&nbsp;DT</span>
							</div>
							<div class="">
								<span class="label"></span>
								<span class="value"></span>
							</div>
							<div class="shipping">
								<span class="label">Livraison</span>
								<span class="value">gratuit</span>
							</div>
							<div class="">
								<span class="label"></span>
								<span class="value"></span>
							</div>
						</div>
						<div class="cart-total">
							<span class="label">Total</span>
							<span class="value">${parseFloat(total).toFixed(3)}&nbsp;DT</span>
						</div>
					</div>
					<div class="cart-wishlist-action">
						<a class="cart-wishlist-viewcart" href="${cartUrl}">Voir panier</a>
						<a class="cart-wishlist-checkout" href="${commandUrl}">Commander</a>
					</div>
				</div>`
		cart = ul+summary
		$(".ht_cart.cart-hover-content").html(cart)
	}
	function removeProduct(id){
		total = 0
		$(".cart-wishlist-item[data-prduct-id="+id+"]").remove()
		$(".remove-from-cart").removeAttr("style")
		$(".cart-wishlist-item").each(function(){
			quantity = parseInt($(this).find(".product-quantity").html())
			price = parseFloat($(this).find(".product-price").html().replace(",","."))
			total = total + (quantity * price)
		})
		if(total == 0){
			$(".ht_cart.cart-hover-content").html(`<p class="no-item">Pas de produits.</p>`)
		}
		total = parseFloat(total).toFixed(3) + " DT"
		$(".ht_cart.cart-hover-content").find(".products .value").html(total)
		$(".ht_cart.cart-hover-content").find(".cart-total .value").html(total)
		cartCount = parseInt($('.cart-number').html()) - 1
		$('.cart-number').html(cartCount)
	}
  prestashop.on(
    'updateCart',
    function (event) {
      var refreshURL = $('.blockcart').data('refresh-url');
	  if(event.reason.cart){
	    drawCart(event.reason.cart.products)
	  }else{
		removeProduct(event.reason.idProduct)
	  }
      var requestData = {};
      if (event && event.reason && typeof event.resp !== 'undefined' && !event.resp.hasError) {
        requestData = {
          id_customization: event.reason.idCustomization,
          id_product_attribute: event.reason.idProductAttribute,
          id_product: event.reason.idProduct,
          action: event.reason.linkAction
        };
      }
      if (event && event.resp && event.resp.hasError) {
        prestashop.emit('showErrorNextToAddtoCartButton', { errorMessage: event.resp.errors.join('<br/>')});
      }
      $.post(refreshURL, requestData).then(function (resp) {
        var html = $('<div />').append($.parseHTML(resp.preview));
        $('.blockcart').replaceWith($(resp.preview).find('.blockcart'));
        if (resp.modal) {
          //showModal(resp.modal);
        }
		cartCount = $('.cart-number').html().split("")[0]
	
		$("#_mobile_cart").find(".mobile-count").html(cartCount)
		if(parseInt(cartCount)>0){
			$("#_mobile_cart").find(".mobile-count").addClass("show")
		}else{
			$("#_mobile_cart").find(".mobile-count").removeClass("show")
		}
      }).fail(function (resp) {
        prestashop.emit('handleError', { eventType: 'updateShoppingCart', resp: resp });
      });
    }
  );
});
