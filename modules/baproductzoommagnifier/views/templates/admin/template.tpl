{*
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@buy-addons.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    Buy-addons    <contact@buy-addons.com>
* @copyright 2007-2021 Buy-addons
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<script src="{$Drift|escape:'htmlall':'UTF-8'}" type="text/javascript" charset="utf-8" ></script>
<script src="{$dropdown|escape:'htmlall':'UTF-8'}" type="text/javascript" charset="utf-8" ></script>
<script>
	
	function add(oj){
		var text='';
		var id=$(oj).attr("id");
		var checks='div'+id;
		
		
		if(!document.getElementById(checks)){
			text += '<div id="div'+id+'" style="margin-top:10px;float:left;width:100%">';
			text += '<button type="button" class="delAccessory btn btn-default reser"><i class="icon-remove text-danger"></i></button>'
			text += '<input type="hidden" name="active_pro[]" value="'+id+'">'
			text += '<a href="" style="float:left;font-size:14px;margin-top: 3px;color:black;">'+$(oj).text()+'</a>';
			text += '</div>'
	    	$(".add").append(text);
    	}
    	$(".ss").css("display", "none");
    	$('.reser').click(function(){
    		$(this).parent().remove();
    	});
	}
	
</script>

{if $demoMode=="1"}
	<div class="bootstrap ba_error">
		<div class="module_error alert alert-danger">
			{l s='You are use ' mod='baproductzoommagnifier'}
			<strong>{l s='Demo Mode ' mod='baproductzoommagnifier'}</strong>
			{l s=', so some buttons, functions will be disabled because of security. ' mod='baproductzoommagnifier'}
			{l s='You can use them in Live mode after you puchase our module. ' mod='baproductzoommagnifier'}
			{l s='Thanks !' mod='baproductzoommagnifier'}
		</div>
	</div>
{/if}
<div class="row">
<div style="margin:0px" class="col-lg-2">
	<div class="list-group">
	 {foreach from=$shows key=key item=test}
			<a style="text-align: left;" id="{$test.block|escape:'htmlall':'UTF-8'}" class="list-group-item group_block {if $checksb == null && $test.block == 'product'} active {/if}{if $checksb == $test.block|escape:'htmlall':'UTF-8'}active{/if}">{str_replace(array("product","category","search","pricesdrop","bestsales","newproduct pages","index_newproduct","index_specials","index_best salles","index_homefeatured","index_best Seller page","new product block page","specials block page"),array("product page","category page","search page","specials page", "best Seller page","new product page","new product block","specials block","best Seller block","popular block","best Seller block","New arrivals block","specials block"),$test.block|escape:'htmlall':'UTF-8')} </a>
		{/foreach} 
	</div>
</div>

{foreach from=$shows item=test}

<form id="{$test.block|escape:'htmlall':'UTF-8'}_f"  class="{if $checksb == null && $test.block == 'product'}{elseif $test.block !== $checksb}hidden{/if} td_t"  action="" method="POST" accept-charset="utf-8">
	<input type="hidden" name="block" value="{$test.block|escape:'htmlall':'UTF-8'}">
	<div style="padding-bottom: 80px" class="col-lg-10">
			<div class="panel " id="configuration_fieldset_order_by_pagination">
				<div class="panel-heading">
					<i class="icon-cogs"></i>
					{l s='General Settings' mod='baproductzoommagnifier'}
					<i class="icon_hide fa fa-minus-circle"></i>
				</div>
				<div class="row" style="margin-top: 30px;">
					<div class="col-lg-2">
						<label class="control-label">
							<span class="label-tooltip">Activate</span>
						</label>
					</div>
					<div class="col-lg-8">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
									<input type="radio" name="active" id="active_on_{$test.block|escape:'htmlall':'UTF-8'}" value="1" {if $test.active == 1} checked="checked"{/if}/>
									<label for="active_on_{$test.block|escape:'htmlall':'UTF-8'}" class="radioCheck">
										on
									</label>
									<input type="radio" name="active" id="active_off_{$test.block|escape:'htmlall':'UTF-8'}" {if $test.active == 0} checked="checked"{/if} value="0"/>
									<label for="active_off_{$test.block|escape:'htmlall':'UTF-8'}" class="radioCheck">
										off
									</label>
									<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div class="row" style="margin-top: 30px;">
					<div class="col-lg-2">
						<label class="control-label">
							<span class="label-tooltip">Activate On Mobile Device</span>
						</label>
					</div>
					<div class="col-lg-8">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
									<input type="radio" name="active_m" id="activem_on_{$test.block|escape:'htmlall':'UTF-8'}" value="1" {if $test.active_mobile == 1} checked="checked"{/if}/>
									<label for="activem_on_{$test.block|escape:'htmlall':'UTF-8'}" class="radioCheck">
										on
									</label>
									<input type="radio" name="active_m" id="activem_off_{$test.block|escape:'htmlall':'UTF-8'}" {if $test.active_mobile == 0} checked="checked"{/if} value="0"/>
									<label for="activem_off_{$test.block|escape:'htmlall':'UTF-8'}" class="radioCheck">
										off
									</label>
									<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				{if $test.block == "product"}
				<div class="row" style="margin-top: 30px;">
					<div class="col-lg-2">
						<label class="control-label">
							<span class="label-tooltip">Exclude Product Categories</span>
						</label>
					</div>
					<div class="col-lg-8">
						{$tree nofilter} {*Escape is unnecessary*}
					</div>
				</div>
				
				<div class="row" style="margin-top: 30px">
					<div class="col-lg-2">
						<label class="control-label">
							<span class="label-tooltip">Product Active</span>
						</label>
					</div>
					<div class="col-lg-8">
						<div class="input-group">
						<input  type="text" value="" name="id_category" id="td_id_category" class="form-control">
						<span class="input-group-addon"><i class="icon-search"></i></span>
						</div>
						<div style="" class="ss ">
  
  
						</div>
						<div style="margin-top: 10px;max-height: 400px;overflow: auto;min-height: 0px;" class="add">
							{if $product[0] !== ''}
								{foreach from=$product item=prods}
								<script>
									var url = "{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/{$prods->category|escape:'htmlall':'UTF-8'}/{$prods->id|escape:'htmlall':'UTF-8'}-{strtolower(str_replace(' ','-',$prods->name|escape:'htmlall':'UTF-8'))}"+".html";
								</script>
									<div id="div{$prods->id|escape:'htmlall':'UTF-8'}" style="margin-top:10px;float:left;width:100%">
										<button type="button" class="reser delAccessory btn btn-default" ><i class="icon-remove text-danger"></i></button>
										<input type="hidden" name="active_pro[]" value="{$prods->id|escape:'htmlall':'UTF-8'}">
										<a class="urlss" target="_blank" href="{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/{$prods->category|escape:'htmlall':'UTF-8'}/{$prods->id|escape:'htmlall':'UTF-8'}-{strtolower(str_replace(' ','-',$prods->name|escape:'htmlall':'UTF-8'))}.html" style="float:left;font-size:14px;margin-top: 3px;color:black;">{$prods->name|escape:'htmlall':'UTF-8'} (id: {$prods->id|escape:'htmlall':'UTF-8'})</a>
									</div>
								{/foreach}
							{else}
							
							{/if}

						</div>
					</div>
				</div>
				{/if}
				<div style="" class="row panel-footer">
					<button style="" type="submit" name="save"  class="btn btn-default pull-right">
					<i class="process-icon-save"></i>
					Save
					</button>
				</div>
			</div>
			<div class="panel " id="configuration_fieldset_order_by_pagination">
				<div class="panel-heading">
					<i class="icon-cogs"></i>
					{l s='Activate On Mobile/Tablet Device' mod='baproductzoommagnifier'}
					<i class="icon_hide fa fa-minus-circle"></i>
				</div>
				<div class="row" style="margin-top: 30px;">
					<div class="col-lg-2">
						<label class="control-label">
							<span class="label-tooltip">Zoom Box Width</span>
						</label>
					</div>
					<div class="col-lg-3">
						<input type="text" class="form-control" value="{$test.width_boxm|escape:'htmlall':'UTF-8'}" name="width_boxm">
					</div>
				</div>
				<div class="row" style="margin-top: 30px;">
					<div class="col-lg-2">
						<label class="control-label">
							<span class="label-tooltip">Zoom Box Height</span>
						</label>
					</div>
					<div class="col-lg-3">
						<input type="text" class="form-control" value="{$test.height_boxm|escape:'htmlall':'UTF-8'}" name="height_boxm">
					</div>
				</div>
				<div class="row" style="margin-top: 30px;">
				<div class="col-lg-2">
					<label class="control-label">
						<span class="label-tooltip">Type Zoom</span>
					</label>
				</div>
				<div class="col-lg-3">
					<select class="form-control cheks_typem" name="typem">
						<option class="checks_typem" {if $test.typem == "lens"} selected="" {/if} value="lens">Lens</option>					    
					    <option class="checks_typem" {if $test.typem == "square"} selected="" {/if} value="square">Lens Square</option>
					    <option class="checks_typem" {if $test.typem == "sniper_zoom"} selected="" {/if} value="sniper_zoom">Sniper Zoom</option>
					 </select>
					 <div class="demo_type" style="margin-top: 20px">
					 	<img width="100%" src="" alt="">
					 </div>
				</div>
			</div>
			<div style="" class="row panel-footer">
				<button style="" type="submit" name="save"   class="btn btn-default pull-right">
				<i class="process-icon-save"></i>
				Save
				</button>
			</div>
			</div>
			<div class="panel " id="configuration_fieldset_order_by_pagination">
				<div class="panel-heading">
					<i class="icon-cogs"></i>
					{l s='Zoom Settings Desktop (Only Desktop)' mod='baproductzoommagnifier'}
					<i class="icon_hide fa fa-minus-circle"></i>
				</div>
			<div class="row" style="margin-top: 30px;">
				<div class="col-lg-2">
					<label class="control-label">
						<span class="label-tooltip">Zoom Box Width</span>
					</label>
				</div>
				<div class="col-lg-3">
					<input type="text" class="form-control" value="{$test.width_box|escape:'htmlall':'UTF-8'}" name="width_box">
				</div>
			</div>
			<div class="row" style="margin-top: 30px;">
				<div class="col-lg-2">
					<label class="control-label">
						<span class="label-tooltip">Zoom Box Height</span>
					</label>
				</div>
				<div class="col-lg-3">
					<input type="text" class="form-control" value="{$test.height_box|escape:'htmlall':'UTF-8'}" name="height_box">
				</div>
			</div>
			<div class="row" style="margin-top: 30px;">
				<div class="col-lg-2">
					<label class="control-label">
						<span class="label-tooltip">Image Zoom Size</span>
					</label>
				</div>
				<div class="col-lg-8">
					<div class="col-lg-1">
						<input type="text" class="form-control" value="{$test.height_img|escape:'htmlall':'UTF-8'}" name="height_img">

					</div>
					<span style="float: left;margin-top: 2px">x</span>
					<div class="col-lg-1">
						<input type="text" class="form-control" value="{$test.width_img|escape:'htmlall':'UTF-8'}" name="width_img">
					</div>
					<div class="col-lg-1">
						<h4 style="margin-top: 4px;">Px</h4>
					</div>
					
				</div>
			</div>
			<div class="row" style="margin-top: 30px;">
				<div class="col-lg-2">
					<label class="control-label">
						<span class="label-tooltip">Time Lens Show/Hidden</span>
					</label>
				</div>
				<div class="col-lg-3">
					<input type="text" class="form-control" name="time_lens_run" value="{$test.time_lens_run|escape:'htmlall':'UTF-8'}">
				</div>
			</div>
			<div class="row" style="margin-top: 30px;">
				<div class="col-lg-2">
					<label class="control-label">
						<span class="label-tooltip">Type Zoom</span>
					</label>
				</div>
				<div class="col-lg-3">
					<select class="form-control cheks_type" name="type">
					    <option class="checks_type" {if $test.types == "lens"} selected="" {/if} value="lens">Lens</option>
					    <option class="checks_type" {if $test.types == "square"} selected="" {/if} value="square">Lens Square</option>
					    <option class="checks_type" {if $test.types == "box_zoom_left"} selected="" {/if} value="box_zoom_left">Box Zoom Left</option>
					    <option class="checks_type" {if $test.types == "box_zoom_right"} selected="" {/if} value="box_zoom_right">Box Zoom Right</option>
					    <option class="checks_type" {if $test.types == "sniper_zoom"} selected="" {/if} value="sniper_zoom">Sniper Zoom</option>
					 </select>
					 <div class="demo_type" style="margin-top: 20px">
					 	<img width="100%" src="" alt="">
					 </div>
				</div>
			</div>
			
			<div class="row" style="margin-top: 30px;">
				<div class="col-lg-2">
					<label class="control-label">
						<span class="label-tooltip">Display Cursor</span>
					</label>
				</div>
				<div class="col-lg-3">
					<input type="checkbox" {if $test.cursors == "true"} checked {/if} name="cursors" value="true">
				</div>
			</div>
			<div class="row" style="margin-top: 30px;">
				<div class="col-lg-2">
					<label class="control-label">
						<span class="label-tooltip">Opacity Lens</span>
					</label>
				</div>
				<div class="col-lg-8">
					<input style="margin-top: 5px;float: left;" type="range" min="0" max="1" Step = 0.1  class="slider"   name="opacity" value="{$test.opacity|escape:'htmlall':'UTF-8'}">
					 <span style="float: left;font-size: 14px;margin-left: 20px;" class="demom" id="demo"></span>
				</div>
				<script>
					$('.slider').on('click',function(){
						$(this).next().html($(this).val());
					});
					$('.slider').click();
					/*slider.oninput = function() {
					  output.innerHTML = this.value;
					}*/
				</script>
			</div>
			<div style="" class="row panel-footer">
				<button style="" type="submit" name="save" class="btn btn-default pull-right">
				<i class="process-icon-save"></i>
				Save
				</button>
			</div>
		</div>
		</div>

		</form>

{/foreach}
</div>