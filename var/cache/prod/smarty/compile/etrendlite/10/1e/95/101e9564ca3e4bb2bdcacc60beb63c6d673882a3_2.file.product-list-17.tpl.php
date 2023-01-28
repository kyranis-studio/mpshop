<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:13
  from '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/product-list-17.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f8435ebed31_74508923',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '101e9564ca3e4bb2bdcacc60beb63c6d673882a3' => 
    array (
      0 => '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/product-list-17.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/miniatures/product.tpl' => 1,
    'file:./loading-more.tpl' => 1,
  ),
),false)) {
function content_620f8435ebed31_74508923 (Smarty_Internal_Template $_smarty_tpl) {
if (!$_smarty_tpl->tpl_vars['loadmore']->value) {?>
    <div class="is_17 products <?php if (!$_smarty_tpl->tpl_vars['products']->value) {?>col-sm-12 col-xs-12<?php }?> hc-products-<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['id_category_ori']->value), ENT_QUOTES, 'UTF-8');?>
 <?php if ($_smarty_tpl->tpl_vars['active']->value) {?>active<?php }?>" data-id-parent="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['id_parent']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['id_parent']->value == 'tab') {?>data-id-parent-cat="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['id_category']->value), ENT_QUOTES, 'UTF-8');?>
"<?php }?> data-id-feature="<?php if ($_smarty_tpl->tpl_vars['id_feature']->value) {
echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['id_feature']->value), ENT_QUOTES, 'UTF-8');
} else { ?>no<?php }?>">
        <div data-number-product-desktop ="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP']->value), ENT_QUOTES, 'UTF-8');?>
"
             data-number-product-tablet ="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ETS_HOMECAT_NUMBER_DISPLAY_TABLET']->value), ENT_QUOTES, 'UTF-8');?>
"
             data-number-product-mobie ="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ETS_HOMECAT_NUMBER_DISPLAY_MOBIE']->value), ENT_QUOTES, 'UTF-8');?>
"
             class="hc-products-list <?php if ($_smarty_tpl->tpl_vars['products']->value) {?> has-products<?php }?>" data-rand-seed="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['randSeed']->value), ENT_QUOTES, 'UTF-8');?>
" data-index="0">
<?php }
if ($_smarty_tpl->tpl_vars['products']->value) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
          <?php $_smarty_tpl->_subTemplateRender("file:catalog/_partials/miniatures/product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
} elseif (!$_smarty_tpl->tpl_vars['loadmore']->value) {?>
    <div class="clearfix"></div>
    <span class="alert alert-warning"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No products available','mod'=>'ets_homecategories'),$_smarty_tpl ) );?>
</span>
<?php }
if (!$_smarty_tpl->tpl_vars['loadmore']->value) {?>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['nextPage']->value && $_smarty_tpl->tpl_vars['ETS_HOMECAT_ENBLE_LOAD_MORE']->value && $_smarty_tpl->tpl_vars['id_category']->value != -5) {?>
            <span class="hc-more-btn" data-next-page="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['nextPage']->value), ENT_QUOTES, 'UTF-8');?>
">
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'View more products','mod'=>'ets_homecategories'),$_smarty_tpl ) );?>

                <?php $_smarty_tpl->_subTemplateRender("file:./loading-more.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            </span><?php }?>
			<div class="mp-mobile-control" <?php if (count($_smarty_tpl->tpl_vars['products']->value) <= 1) {?>style="display:none"<?php }?>>
				<button class="mp-left"><i class="fa-solid fa-arrow-left"></i></button>
				<button class="mp-right"><i class="fa-solid fa-arrow-right"></i></button>
			</div>
	</div>
<?php }
}
}
