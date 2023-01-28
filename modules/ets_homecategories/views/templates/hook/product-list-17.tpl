{*
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
* needs please, contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2021 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{if !$loadmore}
    <div class="is_17 products {if !$products}col-sm-12 col-xs-12{/if} hc-products-{$id_category_ori|intval} {if $active}active{/if}" data-id-parent="{$id_parent|escape:'html':'UTF-8'}" {if $id_parent=='tab'}data-id-parent-cat="{$id_category|intval}"{/if} data-id-feature="{if $id_feature}{$id_feature|intval}{else}no{/if}">
        <div data-number-product-desktop ="{$ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP|intval}"
             data-number-product-tablet ="{$ETS_HOMECAT_NUMBER_DISPLAY_TABLET|intval}"
             data-number-product-mobie ="{$ETS_HOMECAT_NUMBER_DISPLAY_MOBIE|intval}"
             class="hc-products-list {if $products} has-products{/if}" data-rand-seed="{$randSeed|intval}" data-index="0">
{/if}
{if $products}
    {foreach from=$products item="product"}
          {include file="catalog/_partials/miniatures/product.tpl" product=$product}
    {/foreach}
{elseif !$loadmore}
    <div class="clearfix"></div>
    <span class="alert alert-warning">{l s='No products available' mod='ets_homecategories'}</span>
{/if}
{if !$loadmore}
        </div>
        {if $nextPage && $ETS_HOMECAT_ENBLE_LOAD_MORE && $id_category!=-5}
            <span class="hc-more-btn" data-next-page="{$nextPage|intval}">
                {l s='View more products' mod='ets_homecategories'}
                {include file="./loading-more.tpl"}
            </span>{/if}
			<div class="mp-mobile-control" {if count($products) <= 1}style="display:none"{/if}>
				<button class="mp-left"><i class="fa-solid fa-arrow-left"></i></button>
				<button class="mp-right"><i class="fa-solid fa-arrow-right"></i></button>
			</div>
	</div>
{/if}