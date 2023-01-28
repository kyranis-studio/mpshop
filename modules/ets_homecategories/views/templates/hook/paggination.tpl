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

{if isset($total_pages) && $total_pages}
    <ul class="pagination_hc" {if $total_pages == '1'}style="display: none;" {/if}>
        <li {if $page <= 1}class="disabled"{/if}>
            <a href="{$hc_ajax_link|escape:'html':'UTF-8'}&page=1" class="pagination-link" data-page="1" >
                <i class="fa fa-angle-double-left"></i>
            </a>
        </li>
        <li {if $page <= 1}class="disabled"{/if}>
            <a href="{$hc_ajax_link|escape:'html':'UTF-8'}?page={$page|intval - 1}" class="pagination-link" data-page="{$page|intval - 1}" >
                <i class="fa fa-angle-left"></i>
            </a>
        </li>
        {assign p 0}
        {while $p++ < $total_pages}
            {if $p < $page-2}
                <li class="disabled">
                    <a href="javascript:void(0);">&hellip;</a>
                </li>
                {assign p $page-3}
            {elseif $p > $page+2}
                <li class="disabled">
                    <a href="javascript:void(0);">&hellip;</a>
                </li>
                {assign p $total_pages}
            {else}
                <li {if $p == $page}class="active"{/if}>
                    <a href="{$hc_ajax_link|escape:'html':'UTF-8'}&page={$p|intval}" class="pagination-link {if $p == $page}active{/if}" data-page="{$p|intval}" >{$p|intval}</a>
                </li>
            {/if}
        {/while}
        <li {if $page >= $total_pages}class="disabled"{/if}>
            <a href="{$hc_ajax_link|escape:'html':'UTF-8'}&page={$page|intval + 1}" class="pagination-link" data-page="{$page|intval + 1}">
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
        <li {if $page >= $total_pages}class="disabled"{/if}>
            <a href="{$hc_ajax_link|escape:'html':'UTF-8'}&page={$total_pages|intval}" class="pagination-link" data-page="{$total_pages|intval}">
                <i class="fa fa-angle-double-right"></i>
            </a>
        </li>
    </ul>
{/if}