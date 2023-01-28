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
<div class="form_header_block h_step4 step4" data-step="4">
	<div class="header_img text-center">
		<img src="{$img_path nofilter}origin/6.png">
	</div>
	<h2 class="text-center">{l s='Congratulations!' mod='ets_migrate'}</h2>
	<p class="title_sub text-center">{l s='Your migration has been successfully completed.' mod='ets_migrate'}
		<br/><span class="ets_em_title_sub">{l s='You are almost done, please do some final tweaks before putting your website to live.' mod='ets_migrate'}</span>
	</p>
</div>
<div class="keep_pwd ets_mg_thankyou">
	<img class="img_pos_left" src="{$img_path nofilter}origin/7.png"/>
	<h4>{l s='Keep customer passwords' mod='ets_migrate'}</h4>
	<p><b>{l s='Step 1:' mod='ets_migrate'}</b> {l s='Download our free' mod='ets_migrate'} <a href="{$download_plugin_link|cat:'&file=ets_passwordkeeper.zip' nofilter}" target="_blank"><b class="cl_red">Prestashop Password Keeper</b></a>{l s=' module' mod='ets_migrate'}</p>
	<p><b>{l s='Step 2:' mod='ets_migrate'}</b> {l s='Install' mod='ets_migrate'} <a href="{$download_plugin_link|cat:'&file=ets_passwordkeeper.zip' nofilter}" target="_blank"><b class="cl_red">Prestashop Password Keeper</b></a> {l s=' module on target store (this website)' mod='ets_migrate'}</p>
	<p><b>{l s='Step 3:' mod='ets_migrate'}</b> {l s='Copy the' mod='ets_migrate'} <b>_COOKIE_KEY_</b> {l s='of source store provided below then paste it into' mod='ets_migrate'} <b>Prestashop Password Keeper</b> {l s='configuration page.' mod='ets_migrate'}</p>
	<br/>
	<p>
        {l s='Here is' mod='ets_migrate'} <b>_COOKIE_KEY_</b> {l s='of the source store:' mod='ets_migrate'}
		<input class="ets_mg_keycode" type="text" title="{l s='Click to copy' mod='ets_migrate'}" value="">
	</p>
</div>
<div class="ets_em_todo_list ets_mg_thankyou images">
	<img class="img_pos_left" src="{$img_path|escape:'quotes':'UTF-8'}origin/7.png"/>
	<h4>{l s='Copy images' mod='ets_migrate'}</h4>
	<div class="ets_em_todo_list_des">{l s='Please copy images from the source store and upload them to respective folders on target store (this website) to complete the migration.' mod='ets_migrate'}</div>
    {*--- Product ---*}
	<div class="ets_em_todo_list_item image" data-image-type="image">
		<h5>{l s='Product images' mod='ets_migrate'}</h5>
		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/img/p/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}/img/p/
		</div>
	</div>
    {*---Category ---*}
	<div class="ets_em_todo_list_item category" data-image-type="category">
		<h5>{l s='Product category images' mod='ets_migrate'}</h5>

		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/img/c/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}/img/c/
		</div>
	</div>
    {*---Supplier ---*}
	<div class="ets_em_todo_list_item supplier" data-image-type="supplier">
		<h5>{l s='Supplier logo images' mod='ets_migrate'}</h5>

		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/img/su/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}/img/su/
		</div>
	</div>
    {*---Manufacturer ---*}
	<div class="ets_em_todo_list_item manufacturer" data-image-type="manufacturer">
		<h5>{l s='Manufacturer (Brand) logo images' mod='ets_migrate'}</h5>
		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/img/m/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}/img/m/
		</div>
	</div>
    {*---Carrier ---*}
	<div class="ets_em_todo_list_item carrier" data-image-type="carrier">
		<h5>{l s='Carrier logo images' mod='ets_migrate'}</h5>
		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/img/s/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}/img/s/
		</div>
	</div>
    {*---Blog ---*}
	<div class="ets_em_todo_list_item ybc_blog_gallery_lang" data-image-type="ybc_blog_gallery_lang">
		<div class="image ets_em_todo_list_item">
			<h5>{l s='Blog gallery images' mod='ets_migrate'}</h5>
			<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span
						class="path"></span>/img/ybc_blog/gallery/
			</div>
			<div class="ets_em_todo_url">
				<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
				/img/ybc_blog/gallery/
			</div>
		</div>
		<div class="thumb">
			<h5>{l s='Blog gallery thumbnail' mod='ets_migrate'}</h5>
			<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span
						class="path"></span>/img/ybc_blog/gallery/thumb/
			</div>
			<div class="ets_em_todo_url">
				<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
				/img/ybc_blog/gallery/thumb/
			</div>
		</div>
	</div>
    {*---Blog category ---*}
	<div class="ets_em_todo_list_item ybc_blog_category_lang" data-image-type="ybc_blog_category_lang">
		<div class="image ets_em_todo_list_item">
			<h5>{l s='Blog category images' mod='ets_migrate'}</h5>
			<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span
						class="path"></span>/img/ybc_blog/category/
			</div>
			<div class="ets_em_todo_url">
				<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
				/img/ybc_blog/category/
			</div>
		</div>
		<div class="thumb">
			<h5>{l s='Blog category thumbnail images' mod='ets_migrate'}</h5>
			<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span
						class="path"></span>/img/ybc_blog/category/thumb/
			</div>
			<div class="ets_em_todo_url">
				<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
				/img/ybc_blog/category/thumb/
			</div>
		</div>
	</div>
    {*---Blog post ---*}
	<div class="ets_em_todo_list_item ybc_blog_post_lang" data-image-type="ybc_blog_post_lang">
		<div class="image ets_em_todo_list_item">
			<h5>{l s='Blog post images' mod='ets_migrate'}</h5>
			<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span
						class="path"></span>/img/ybc_blog/post/
			</div>
			<div class="ets_em_todo_url">
				<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
				/img/ybc_blog/post/
			</div>
		</div>
		<div class="thumb">
			<h5>{l s='Blog post thumbnail images' mod='ets_migrate'}</h5>
			<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span
						class="path"></span>/img/ybc_blog/post/thumb/
			</div>
			<div class="ets_em_todo_url">
				<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
				/img/ybc_blog/post/thumb/
			</div>
		</div>
	</div>
    {*---Blog slide ---*}
	<div class="ets_em_todo_list_item ybc_blog_slide_lang" data-image-type="ybc_blog_slide_lang">
		<h5>{l s='Blog slider images' mod='ets_migrate'}</h5>
		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/img/ybc_blog/slide/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
			/img/ybc_blog/slide/
		</div>
	</div>
    {*---Blog employee ---*}
	<div class="ets_em_todo_list_item ybc_blog_employee" data-image-type="ybc_blog_employee">
		<h5>{l s='Blog author avatar images' mod='ets_migrate'}</h5>
		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/img/ybc_blog/avata/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
			/img/ybc_blog/avata/
		</div>
	</div>
    {*---Menus ---*}
	<div class="ets_em_todo_list_item ets_mm_block" data-image-type="ets_mm_block">
		<h5>{l s='Menu images' mod='ets_migrate'}</h5>
		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/modules/ets_megamenu/views/img/upload
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}
			/modules/ets_megamenu/views/img/upload
		</div>
	</div>
</div>
<div class="ets_em_todo_list ets_mg_thankyou products">
	<img class="img_pos_left" src="{$img_path|escape:'quotes':'UTF-8'}origin/7.png"/>
	<h4>{l s='Generate thumbnail images' mod='ets_migrate'}</h4>
	<div class="product_thumbnail">
		{l s='Main product images have been downloaded from source store, however thumbnail images have not been generated yet. Please generate thumbnail images for products to complete the migration.' mod='ets_migrate'}
		<br/>
		<a href="{$product_thumb_link nofilter}" target="_blank">
			<span>{l s='Generate thumbnail images now' mod='ets_migrate'}</span>
		</a>
	</div>
</div>
<div class="ets_em_todo_list ets_mg_thankyou files">
	<img class="img_pos_left" src="{$img_path|escape:'quotes':'UTF-8'}origin/7.png"/>
	<h4>{l s='Copy files & attachments' mod='ets_migrate'}</h4>
	<div class="ets_em_todo_list_des">{l s='Please download files & attachments from source store and upload them into respective folders on target store (this website) to complete the migration.' mod='ets_migrate'}</div>
	<div class="ets_em_todo_list_item attachment" data-file-type="attachment">
		<h5>{l s='Attachment files' mod='ets_migrate'}</h5>
		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/download/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}/download/
		</div>
	</div>
	<div class="ets_em_todo_list_item customized_data" data-file-type="customized_data">
		<h5>{l s='Customization files' mod='ets_migrate'}</h5>
		<div class="ets_em_todo_url"><span>{l s='Source store:' mod='ets_migrate'}</span> <span class="path"></span>/upload/
		</div>
		<div class="ets_em_todo_url">
			<span>{l s='Target store:' mod='ets_migrate'}</span> {$PS_ROOT_DIR|escape:'quotes':'UTF-8'}/upload/
		</div>
	</div>
</div>
<div class="ets_mg_thankyou_footer">
	<button class="ets_mg_button_default ets_em_new_migration">{l s='NEW MIGRATION' mod='ets_migrate'}</button>
	<a href="{$page_index nofilter}" class="ets_mg_button_primary pull-right"
	   target="_blank">{l s='VIEW YOUR SHOP' mod='ets_migrate'}</a>
</div>












