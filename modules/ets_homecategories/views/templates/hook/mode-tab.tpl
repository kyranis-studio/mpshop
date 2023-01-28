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
{if $categoryTabs}
    <div data-number-product-desktop="{$ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP|intval}" data-number-product-tablet="{$ETS_HOMECAT_NUMBER_DISPLAY_TABLET|intval}" data-number-product-mobile="{$ETS_HOMECAT_NUMBER_DISPLAY_MOBIE|intval}" class="hc-layout
    hc-mode-tab {if !$greater1760}hc-175{/if} hc-{$ETS_HOMECAT_LISTING_MODE|escape:'html':'UTF-8'} {if $ETS_HOMECAT_LOADING_ENABLED}hc-loading-enabled{/if}">
        <ul class="hc-tabs">
            <li class="hc-tab" data-id-category="tab">
                <div class="hc-tab-parent">
                    {foreach from=$categoryTabs item='category' key='key'}
                        {if $category.id_category>0 || isset($category.link)}
                            <a class="hc-cat parent-cat {if $key==0}active{/if}" href="{if isset($category.link)}{$category.link|escape:'html':'UTF-8'}{else}{$link->getCategoryLink($category.id_category)|escape:'html':'UTF-8'}{/if}" data-id-category="{$category.id_category|intval}" data-id-parent="tab" data-id-feature="no">{$category.name|escape:'html'}</a>
                        {else}
                            <span class="hc-cat parent-cat {if $key==0}active{/if} no-link" data-id-category="{$category.id_category|intval}"  data-id-parent="tab" data-id-feature="no">{$category.name|escape:'html'}</span>
                        {/if}
                    {/foreach}
                    {if $ETS_HOMECAT_ENABLE_VIEW_ALL}
                        {if $categoryTabs.0.id_category>0 || isset($categoryTabs.0.link)}
                            <a class="hc-view-all" href="{if isset($categoryTabs.0.link)}{$categoryTabs.0.link|escape:'html':'UTF-8'}{else}{$link->getCategoryLink($categoryTabs.0.id_category)|escape:'html':'UTF-8'}{/if}">{if $ETS_HOMECAT_TXT_VIEW_ALL_LABEL}{$ETS_HOMECAT_TXT_VIEW_ALL_LABEL|escape:'html'}{else}{l s='View all' mod='ets_homecategories'}{/if}</a>
                        {else}
                            <a class="hc-view-all hc-hidden" href="#">{if $ETS_HOMECAT_TXT_VIEW_ALL_LABEL}{$ETS_HOMECAT_TXT_VIEW_ALL_LABEL|escape:'html'}{else}{l s='View all' mod='ets_homecategories'}{/if}</a>
                        {/if}
                    {/if}
                </div>
                    {if $ETS_HOMECAT_DISPLAY_SUB || $ETS_HOMECAT_DISPLAY_SUB_FEATURED}
                        <div class="hc-tab-sub">
                            {foreach from=$categoryTabs item='category' key='key'}
                                {if $ETS_HOMECAT_DISPLAY_SUB && $category.id_category>=0 || $ETS_HOMECAT_DISPLAY_SUB_FEATURED && $category.id_category<0}
                                    {assign var='active' value=($key==0)}
                                    {hook h='displaySubCategories' id_category=$category.id_category active=$active layout='TAB'}
                                {/if}
                            {/foreach}
                        </div>
                    {/if}
                {include file="./sort.tpl" id_category=$categoryTabs.0.id_category}
                <div class="hc-products-container">
                    {hook h='displayProductList' id_category=$categoryTabs.0.id_category active=1 id_parent='tab'}
                </div>
            </li>
        </ul>
    </div>
{/if}
