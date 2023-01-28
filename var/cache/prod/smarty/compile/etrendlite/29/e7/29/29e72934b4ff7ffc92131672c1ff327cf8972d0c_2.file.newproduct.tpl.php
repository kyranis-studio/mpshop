<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:16
  from '/home/mpshop/public_html/modules/mp_new_product/views/templates/hook/newproduct.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f8438d232d6_66429860',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '29e72934b4ff7ffc92131672c1ff327cf8972d0c' => 
    array (
      0 => '/home/mpshop/public_html/modules/mp_new_product/views/templates/hook/newproduct.tpl',
      1 => 1644833218,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/miniatures/product.tpl' => 1,
  ),
),false)) {
function content_620f8438d232d6_66429860 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="featured-products clearfix" style="background:#eef1f3;margin-top: 0;" >
	<li class="hc-tab" data-id-category="-1" style="list-style: none;"> 
		<a class="homecat_image" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('new-products'), ENT_QUOTES, 'UTF-8');?>
">
			<div class="hc_bg_desktop"> 
				<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['bannerSrc']->value, ENT_QUOTES, 'UTF-8');?>
" alt="acc">
			</div> 
		</a>
		<div class="hc-tab-info">
			<a class="hc-cat parent-cat active" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('new-products'), ENT_QUOTES, 'UTF-8');?>
" data-id-category="-1" data-id-parent="-1" data-id-feature="no">Nouveaux produits</a>
			<a class="hc-view-all" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('new-products'), ENT_QUOTES, 'UTF-8');?>
">Voir tout</a>
			<div class="clearfix"></div>
		</div>
	</li>
  <div class="clearfix"></div>
  <div class="products" data-index="0">
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
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </div>
  
</section>
<?php }
}
