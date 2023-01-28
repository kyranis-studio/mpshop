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
<script type="text/javascript">
    var ETS_EM_REQUEST_URL = "{$request_url|escape:'quotes':'UTF-8'}";
    var ets_em_copied_translate = "{l s='Copied' mod='ets_migrate' js=1}";
    var ets_em_do_not_import = "{l s='--- Do not import ---' mod='ets_migrate' js=1}";
    var ets_em_create_shop = "{l s='--- Create shop ---' mod='ets_migrate' js=1}";
    var ets_em_mapping_shop_invalid = "{l s='Shop mapping is invalid. Please select target shop or create new shop.' mod='ets_migrate' js=1}";
    var ets_em_migrate = "{l s='Migrate' mod='ets_migrate' js=1}";
    var ets_em_migrate_now = "{l s='Migrate now' mod='ets_migrate' js=1}";
    var ets_em_new_migration = "{l s='Do you want to migrate again?' mod='ets_migrate' js=1}";
    var ets_em_migrate_data_empty = "{l s='Data entities to migrate cannot be empty!' mod='ets_migrate' js=1}";
</script>
{if isset($js_files) && $js_files}{foreach from=$js_files item='file'}
	<script src="{$file|escape:'quotes':'UTF-8'}"></script>
{/foreach}{/if}