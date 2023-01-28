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

{extends file="helpers/form/form.tpl"}
{block name="input"}
    {if $input.type == 'checkbox'}
        {if isset($input.values) && $input.values}
            {if isset($fields_value[$input.name])}
                {if !is_array($fields_value[$input.name])}
                    {assign var='hometabs' value = ','|explode: $fields_value[$input.name]}
                {else}
                    {assign var='hometabs' value = $fields_value[$input.name]}
                {/if}
            {else}
                {assign var='hometabs' value = 0}
            {/if}
            {if isset($input.class) && $input.class}
                <div class="{$input.class|escape:'html':'utf-8'}">
            {/if}
            {foreach from = $input.values item ='checkbox'}
                {assign var='id_check' value=$input.name|cat:'_'|cat:$checkbox.id|escape:'html':'UTF-8'}
				<div class="checkbox">
                    {strip}
						<label class="md-checkbox" for="{$id_check|escape:'html':'UTF-8'}">
							<input type="checkbox" name="{if isset($checkbox.cname) && $checkbox.cname}{$checkbox.cname|escape:'html':'UTF-8'}{else}{$input.name|escape:'html':'UTF-8'}{/if}[]" id="{$id_check|escape:'html':'UTF-8'}" {if $checkbox.id} value="{$checkbox.id|escape:'html':'UTF-8'}"{/if}
                                    {if isset($input.selected_values) && is_array($input.selected_values) && in_array($checkbox.id, $input.selected_values) || !isset($input.selected_values) && $hometabs && in_array($checkbox.id, $hometabs)} checked="checked"{/if} />
                            <i class="md-checkbox-control"></i>
                            <span class="label-text">
                                {$checkbox.label|escape:'quotes':'UTF-8'}
                            </span>
						</label>
                    {/strip}
				</div>
            {/foreach}
            {if isset($input.class) && $input.class}
                </div>
            {/if}
        {/if}
    {elseif $input.type == 'radio' && $input.name == 'ETS_HOMECAT_LAYOUT'}
        {foreach $input.values as $value}
            <div class="radio ets_hc_type {if isset($input.class)}{$input.class|escape:'html':'UTF-8'}{/if} col-lg-3 col-sm-6 ">
                {strip}
                    <label class="md-checkbox {if $fields_value[$input.name] == $value.value} active {/if}">
                        <input type="radio" name="{$input.name|escape:'html':'UTF-8'}"
                               id="{$value.id|escape:'html':'UTF-8'}"
                               value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if (isset($input.disabled) && $input.disabled) or (isset($value.disabled) && $value.disabled)} disabled="disabled"{/if}/>

                        <span class="checkbox_radio_custom" >
                        <i class="md-checkbox-control"></i>
                        </span>
                        {if isset($value.link_image) && $value.link_image}<img src="{$value.link_image|escape:'html':'UTF-8'}"/>{/if}
                        <p class="radio_value">
                            {if $value.id == 'TAB'}
                                {l s='Both' mod='ets_homecategories'} <span class="color1">{l s='Featured products' mod='ets_homecategories'}</span> & <span class="color2">{l s='Category products' mod='ets_homecategories'}</span> {l s='in tabs' mod='ets_homecategories'}
                            {elseif $value.id == 'LIST'}
                                {l s='Both' mod='ets_homecategories'} <span class="color1">{l s='Featured products' mod='ets_homecategories'}</span> & <span class="color2">{l s='Category products' mod='ets_homecategories'}</span> {l s='in rows' mod='ets_homecategories'}
                            {elseif $value.id == 'TAB_LIST'}
                                <span class="color1">{l s='Featured products' mod='ets_homecategories'}</span> {l s='in tabs' mod='ets_homecategories'} & <span class="color2">{l s='Category products' mod='ets_homecategories'}</span> {l s='in rows' mod='ets_homecategories'}
                            {elseif $value.id == 'LIST_TAB'}
                                <span class="color1">{l s='Featured products' mod='ets_homecategories'}</span> {l s='in rows' mod='ets_homecategories'} & <span class="color2">{l s='Category products' mod='ets_homecategories'}</span> {l s='in tabs' mod='ets_homecategories'}
                            {/if}
                        </p>
                    </label>
                {/strip}
            </div>
            {if isset($value.p) && $value.p}<p
                    class="help-block">{$value.p}</p>{/if}
        {/foreach}
    {elseif $input.type == 'radio' && $input.name == 'ETS_HOMECAT_LISTING_MODE'}
        {foreach $input.values as $value}
            <div class="radio {if isset($input.class)}{$input.class|escape:'html':'UTF-8'}{/if} ">
                {strip}
                    <label class="md-checkbox">
                        <input type="radio" name="{$input.name|escape:'html':'UTF-8'}"
                               id="{$value.id|escape:'html':'UTF-8'}"
                               value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if (isset($input.disabled) && $input.disabled) or (isset($value.disabled) && $value.disabled)} disabled="disabled"{/if}/>
                        <i class="md-checkbox-control"></i>
                        {$value.label|escape:'html':'UTF-8'}
                    </label>
                {/strip}
            </div>
            {if isset($value.p) && $value.p}<p class="help-block">{$value.p|escape:'html':'utf8'}</p>{/if}
        {/foreach}
    {elseif $input.type == 'file_custom'}
        <div class="row">
			{foreach from=$languages item=language}
				{if $languages|count > 1}
					<div class="translatable-field lang-{$language.id_lang|intval}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
				{/if}
					<div class="col-lg-6 file_input">
                        <div class="hc-img-preview {if !$images[$language.id_lang]}hide{/if}">
						    <img src="{$images[$language.id_lang]|escape:'html':'utf-8'}" class="img-thumbnail" />
                            <a href="{$module_admin_link_base|escape:'html':'utf-8'}&del_banner_img=1&id_lang={$language.id_lang|intval}&id_banner={$id_ets_hc_banner|intval}" data-uploaded-img="{$images[$language.id_lang]|escape:'html':'utf-8'}" class="delbanner {if $images[$language.id_lang]}has_uploaded{/if} {if $language.id_lang == $defaultFormLanguage}default-lang{/if} hide btn btn-default" data-id-lang="{$language.id_lang|intval}"><i class="icon-trash"></i> {l s='Delete' mod='ets_homecategories'}</a>
                        </div>
						<div class="dummyfile input-group">
							<input id="{$input.name|escape:'html':'utf-8'}_{$language.id_lang|intval}" type="file" name="{$input.name|escape:'html':'utf-8'}_{$language.id_lang|intval}" class="hide-file-upload" />
							<span class="input-group-addon"><i class="icon-file"></i></span>
							<input id="{$input.name|escape:'html':'utf-8'}_{$language.id_lang|intval}-name" type="text" class="disabled" name="filename" readonly />
							<span class="input-group-btn">
								<button id="{$input.name|escape:'html':'utf-8'}_{$language.id_lang|intval}-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
									<i class="icon-folder-open"></i> {l s='Choose a file' mod='ets_homecategories'}
								</button>
							</span>
						</div>
					</div>
				{if $languages|count > 1}
					<div class="col-lg-2">
						<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
							{$language.iso_code|escape:'html':'utf-8'}
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							{foreach from=$languages item=lang}
							<li><a href="javascript:hideOtherLanguage({$lang.id_lang|intval});" tabindex="-1">{$lang.name|escape:'html':'utf-8'}</a></li>
							{/foreach}
						</ul>
					</div>
				{/if}
				{if $languages|count > 1}
					</div>
				{/if}

				<script type="text/javascript">
                    $(document).ready(function(){
                        $('#{$input.name|escape:'html':'utf-8'}_{$language.id_lang|intval}-selectbutton').click(function(e){
                            $('#{$input.name|escape:'html':'utf-8'}_{$language.id_lang|intval}').trigger('click');
                        });
                        $('#{$input.name|escape:'html':'utf-8'}_{$language.id_lang|intval}').change(function(e){
                            if(!(this.files && this.files[0]) || !['image/gif', 'image/jpeg', 'image/png'].includes(this.files[0]['type']))
                            {
                                alert('File type is not valid');
                                return false;
                            }
                            var val = $(this).val();
                            var file = val.split(/[\\/]/);
                            $('#{$input.name|escape:'html':'utf-8'}_{$language.id_lang|intval}-name').val(file[file.length-1]);
                            readFileURL(this);
                        });
                        $('.delbanner').click(function(){
                            var delLangId = $(this).attr('data-id-lang');
                            $('#{$input.name|escape:'html':'utf-8'}_'+delLangId).val('');
                            $('#{$input.name|escape:'html':'utf-8'}_'+delLangId+'-name').val('');
                            if($(this).attr('data-uploaded-img')!=='')
                                $(this).prev('.img-thumbnail').attr('src',$(this).attr('data-uploaded-img'));
                            else
                                $(this).parent('.hc-img-preview').addClass('hide');
                            $(this).addClass('hide');
                            return false;
                        });
				});
			</script>
			{/foreach}
		</div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
{block name="input_row"}
    {if $input.name=='ETS_HOMECAT_LAYOUT'}
        <div class="ets_homecat_form_tab_content">
            <div class="ets_homecat_form_tab_div">
                <ul class="ets_homecat_form_tab">
                    <li class="ets_homecat_layout {if !isset($smarty.get.currentTab) || $smarty.get.currentTab=='layout'}active{/if}" data-tab="layout"><i class="icon-desktop"></i>{l s='Product layout' mod='ets_homecategories'}</li>
                    <li class="ets_homecat_products {if isset($smarty.get.currentTab) && $smarty.get.currentTab=='products'}active{/if}" data-tab="products"><i class="icon-list-ul"></i>{l s='Products to display' mod='ets_homecategories'}</li>
                    <li class="ets_homecat_general {if isset($smarty.get.currentTab) && $smarty.get.currentTab=='general'}active{/if}" data-tab="general"><i class="icon-cogs"></i> {l s='Other settings' mod='ets_homecategories'}</li>
                    <li class="ets_homecat_banner {if isset($smarty.get.currentTab) && $smarty.get.currentTab=='banner'}active{/if}" data-tab="banner"><i class="icon-image"></i> {l s='Banners' mod='ets_homecategories'}</li>
                    {if isset($intro) && $intro}
                        <li class="li_othermodules ">
                            <a class="{if isset($refsLink) && $refsLink}refs_othermodules{else}link_othermodules{/if}" href="{$other_modules_link|escape:'html':'UTF-8'}" {if isset($refsLink) && $refsLink}target="_blank" {/if}>
                                <span class="tab-title">{l s='Other modules' mod='ets_homecategories'}</span>
                                <span class="tab-sub-title">{l s='Made by ETS-Soft' mod='ets_homecategories'}</span>
                            </a>
                        </li>
                    {/if}
                </ul>
            </div>
            <div class="ets_homecat_form">
                <div class="ets_homecat_form_layout {if !isset($smarty.get.currentTab) || $smarty.get.currentTab=='layout'}active{/if}">
                {/if}
                {if $input.name=='ETS_HOMECAT_PRODUCTS_TABS'}
                </div>
                <div class="ets_homecat_form_products {if isset($smarty.get.currentTab) && $smarty.get.currentTab=='products'}active{/if}">
                    <div class="wrap_sort">
                    <div class="left_sort">
                    <label>{l s='Available product tabs' mod='ets_homecategories'}</label>
                    <div class="wrap_group">

                {/if}
                {if $input.name=='ETS_HOMECAT_TXT_NEW_ARRIVALS'}
                    <div class="custom_tab_names">
                        <div class="custom_tab_names_left">{l s='Custom tab names' mod='ets_homecategories'}</div>
                        <div class="custom_tab_names_right">
                {/if}
                {if $input.name=='ETS_HOMECAT_PREVIEW'}
                        </div>{*/custom_tab_names_right*}
                    </div>{*/custom_tab_names*}
                    </div>{*/wrap_group*}
                    </div>{*/left_sort*}
                    <div class="right_sort">
                    {hook h='displaySelectedTabs'}
                {/if}
                {if $input.name=='ETS_HOMECAT_PREVIEW'}
                    </div>
                    </div>
                {/if}

                {if $input.name=='ETS_HOMECAT_INCLUDE_SUB'}
                    </div><div class="ets_homecat_form_general {if isset($smarty.get.currentTab) && $smarty.get.currentTab=='general'}active{/if}">
                {/if}

                {if $input.name=='ETS_HOMECAT_SPECIFIC_PRODUCTS'}
                    <div class="hc_search_product_form" id="hc_search_product_form">
                        <h2 class="title_specific">{l s='Featured' mod='ets_homecategories'}</h2>
                        <input class="hc_search_product" name="hc_search_product" {if isset($input.placeholder)}placeholder="{$input.placeholder|escape:'html':'utf-8'}"{/if} autocomplete="off" type="text" />
                        <ul class="hc_products">
                            {hook h='displaySpecificProducts'}
                        </ul>
                    </div>
                {/if}
                {if $input.name=='ETS_HOMECAT_CACHE_LIFETIME'}
                <div class="form-group">
                    <label class="control-label col-lg-3">
                    </label>
                    <div class="col-lg-2">
                        <a href="#" class="hc_clear_cache btn btn-default">
                            <i class="hc_clear"></i>
                            <span class="a_text">{l s='Clear cache' mod='ets_homecategories'}</span>
                        </a>
                    </div>
                </div>{/if}
                {$smarty.block.parent}
                {if $input.name=='ETS_HOMECAT_CATEGORY_BANNER'}
                    </div>
                    <div class="ets_homecat_form_banner {if isset($smarty.get.currentTab) && $smarty.get.currentTab=='banner'}active{/if}">
                        {hook h='displayBackEndBanner'}
                    </div>
            </div>
        </div>
        <input type="hidden" name="ajax" value="1"/>
    {/if}
{/block}
