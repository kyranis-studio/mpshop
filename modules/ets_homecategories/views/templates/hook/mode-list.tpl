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
    <div class="
        ets-desktop-col-{$ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP|intval}
        ets-tablet-col-{$ETS_HOMECAT_NUMBER_DISPLAY_TABLET|intval}
        ets-mobie-col-{$ETS_HOMECAT_NUMBER_DISPLAY_MOBIE|intval}
    hc-layout {if !$greater1760}hc-175{/if} hc-mode-list hc-{$ETS_HOMECAT_LISTING_MODE|escape:'html':'UTF-8'} {if $ETS_HOMECAT_LOADING_ENABLED}hc-loading-enabled{/if}">
        <ul class="hc-tabs">
        {foreach from=$categoryTabs item='category'}
            <li class="hc-tab" data-id-category="{$category.id_category|intval}">
                {if $ETS_HOMECAT_DISPLAY_CATEGORY_BANNER!='below'}
                    {hook h='displayCategoryBanner' id_category=$category.id_category}
                {/if}
                <div class="hc-tab-info">
                    {if $category.id_category>0 || isset($category.link)}
                        <a class="hc-cat parent-cat active" href="{if isset($category.link)}{$category.link|escape:'html':'UTF-8'}{else}{$link->getCategoryLink($category.id_category)|escape:'html':'UTF-8'}{/if}" data-id-category="{$category.id_category|intval}"  data-id-parent="{$category.id_category|intval}" data-id-feature="no">{$category.name|escape:'html'}</a>
                        {if $ETS_HOMECAT_ENABLE_VIEW_ALL}
                            <a class="hc-view-all" href="{if isset($category.link)}{$category.link|escape:'html':'UTF-8'}{else}{$link->getCategoryLink($category.id_category)|escape:'html':'UTF-8'}{/if}">{if $ETS_HOMECAT_TXT_VIEW_ALL_LABEL}{$ETS_HOMECAT_TXT_VIEW_ALL_LABEL|escape:'html'}{else}{l s='View all' mod='ets_homecategories'}{/if}</a>
                        {/if}
                    {else}
                        <span class="hc-cat parent-cat active no-link" data-id-category="{$category.id_category|intval}" data-id-parent="{$category.id_category|intval}" data-id-feature="no">{$category.name|escape:'html'}</span>
                    {/if}
                    <div class="clearfix"></div>
                    {if $ETS_HOMECAT_DISPLAY_SUB && $category.id_category>=0 || $ETS_HOMECAT_DISPLAY_SUB_FEATURED && $category.id_category<0}
                        <div class="hc-tab-sub">
                            {hook h='displaySubCategories' id_category=$category.id_category layout='LIST'}
                        </div>
                    {/if}
                    {include file="./sort.tpl" id_category=$category.id_category}
                    <div class="hc-products-container">
                        {hook h='displayProductList' id_category=$category.id_category id_parent=$category.id_category active=1}
                    </div>
                </div>
                {if $ETS_HOMECAT_DISPLAY_CATEGORY_BANNER=='below'}
                    {hook h='displayCategoryBanner' id_category=$category.id_category}
                {/if}
            </li>
        {/foreach}
        </ul>
    </div>
{/if}
