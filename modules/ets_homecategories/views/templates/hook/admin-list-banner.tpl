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

<div class="panel">
    <span class="panel-heading-action header_btn_add">
		<a id="desc-product-new" data-action="add" data-href="{$add_url nofilter}" class="btn_add_edit list-toolbar-btn ac_input update_banner" href="javascript:void(0)">
            <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Add banner' mod='ets_homecategories'}" data-html="true">
				<i class="process-icon-new "></i><span class="text_link">{l s='Add banner' mod='ets_homecategories'}</span>
			</span>
		</a>
	</span>
    <h3><i class="icon-list-ul"></i> {l s='Banner list' mod='ets_homecategories'}</h3>
    <div class="wrap_table_list">
        <table class="table ets_hc_banner" id="ets_hc_banner">
            <thead>
                <tr class="left">
                    <th><span class="title_box">{l s='Banner image' mod='ets_homecategories'}</span></th>
                    <th><span class="title_box">{l s='Tabs to display' mod='ets_homecategories'}</span></th>
                    <th class="text-center"><span class="title_box">{l s='Action' mod='ets_homecategories'}</span></th>
                </tr>
            </thead>
            <tbody>
                {if isset($banners) && $banners}
                    {foreach from=$banners key=k item=banner}
                        <tr class="item_banner" id="slides_{$banner.id_ets_hc_banner|intval}" data-id="{$banner.id_ets_hc_banner|intval}">
                            <td class="td_image">
                                {if $banner.image}
                                    <img src="{$banner.image|escape:'html':'UTF-8'}" alt="{if isset($banner.alt) && $banner.alt}{$banner.alt|escape:'html':'UTF-8'}{else}img banner{/if}" class="img_thumbnail" />
                                {/if}
                            </td>
                            <td class="td_feature align_top">
                                {if isset($banner.cats) && $banner.cats}
                                    <ul>
                                        {foreach $banner.cats as $banne}
                                            <li>{$banne.name|escape:'html':'utf-8'}</li>
                                        {/foreach}
                                    </ul>
                                {/if}
                            </td>
                            <td class="td_action align_top text-center">
                                <div class="btn-group-action">
                                    <a data-action="edit" class="btn btn-default btn_add_edit" data-href="{$banner.edit_url nofilter}" href="javascript:void(0)">
                                        <i class="icon-edit"></i>
                                        {l s='Edit' mod='ets_homecategories'}
                                    </a>
                                    <a class="btn btn-default btn_delete_banner" data-href="{$banner.delete_url nofilter}" href="javascript:void(0)" onclick="if (confirm('{l s='Do you want to delete this banner?' mod='ets_homecategories'}')){ldelim}return true;{rdelim}else{ldelim}event.stopPropagation(); event.preventDefault();{rdelim};">
                                        <i class="icon-trash"></i>
                                        {l s='Delete' mod='ets_homecategories'}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                {else}
                    <tr class="item_banner no_data">
                        <td class="td_image">
                            {l s='No data found' mod='ets_homecategories'}
                        </td>
                        <td class="td_feature">
                            {l s='No data found' mod='ets_homecategories'}
                        </td>
                        <td class="td_action">

                        </td>
                    </tr>

                {/if}
            </tbody>
        </table>
    </div>
</div>
