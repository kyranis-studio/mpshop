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

<div class="form-group footer-step2 migrate">
    <button type="submit" value="1" class="ets_em_form_submit_btn no_svg_icon" name="submitConfig">{l s='Migrate' mod='ets_migrate'}</button>
	{if isset($show_btn_cancel) && $show_btn_cancel}
		<button name="module_form_cancel_btn" type="button" class="btn btn-default ets_em_popup_cancel no_svg_icon">{l s='Close' mod='ets_migrate'}</button>
	{/if}
	<button name="module_form_advanced_setting_btn" type="button" class="btn btn-default ets_em_advanced_setting no_svg_icon"style="display: none;">{l s='Advanced settings' mod='ets_migrate'}</button>
</div>
<div class="form-group footer-step2 migrate-resume" style="display: none;">
	<button type="button" class="btn btn-default ets_em_new_migration no_svg_icon ets_mg_button_default ets_em_popup_resume" name="ets_em_new_migration">{l s='New migration' mod='ets_migrate'}</button>
	<button type="button" class="ets_em_migrate_resume no_svg_icon ets_mg_button_primary pull-right ets_em_popup_resume" name="ets_em_migrate_resume">{l s='Resume' mod='ets_migrate'}</button>
</div>