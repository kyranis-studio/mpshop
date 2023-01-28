<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:33:51
  from '/home/mpshop/public_html/modules/ets_superspeed/views/templates/hook/javascript.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f841f38a489_12089122',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '96b626665261164e9842e7bf84206fd6e4ade283' => 
    array (
      0 => '/home/mpshop/public_html/modules/ets_superspeed/views/templates/hook/javascript.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f841f38a489_12089122 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
var sp_link_base ='<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['sp_link_base']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">
function renderDataAjax(jsonData)
{
    for (var key in jsonData) {
	    if(key=='java_script')
        {
            $('body').append(jsonData[key]);
        }
        else
            if($('#ets_speed_dy_'+key).length)
              $('#ets_speed_dy_'+key).replaceWith(jsonData[key]);  
    }
    if($('#header .shopping_cart').length && $('#header .cart_block').length)
    {
        var shopping_cart = new HoverWatcher('#header .shopping_cart');
        var cart_block = new HoverWatcher('#header .cart_block');
        $("#header .shopping_cart a:first").live("hover",
            function(){
    			if (ajaxCart.nb_total_products > 0 || parseInt($('.ajax_cart_quantity').html()) > 0)
    				$("#header .cart_block").stop(true, true).slideDown(450);
    		},
    		function(){
    			setTimeout(function(){
    				if (!shopping_cart.isHoveringOver() && !cart_block.isHoveringOver())
    					$("#header .cart_block").stop(true, true).slideUp(450);
    			}, 200);
    		}
        );
    }
    if(typeof jsonData.custom_js!== undefined && jsonData.custom_js)
        $('head').append('<?php echo '<script'; ?>
 src="'+sp_link_base+'/modules/ets_superspeed/views/js/script_custom.js"></javascript');
}
<?php echo '</script'; ?>
>

<style>
.layered_filter_ul .radio,.layered_filter_ul .checkbox {
    display: inline-block;
}
.ets_speed_dynamic_hook .cart-products-count{
    display:none!important;
}
.ets_speed_dynamic_hook .ajax_cart_quantity ,.ets_speed_dynamic_hook .ajax_cart_product_txt,.ets_speed_dynamic_hook .ajax_cart_product_txt_s{
    display:none!important;
}
.ets_speed_dynamic_hook .shopping_cart > a:first-child:after {
    display:none!important;
}
</style><?php }
}
