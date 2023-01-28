<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:46:17
  from '/home/mpshop/public_html/themes/etrendlite/templates/catalog/_partials/miniatures/product.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f87098fcfd3_47214045',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d5bbb0e8e2cefe2c9d82cd47e6f33f048fca2f5' => 
    array (
      0 => '/home/mpshop/public_html/themes/etrendlite/templates/catalog/_partials/miniatures/product.tpl',
      1 => 1643017660,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/variant-links.tpl' => 1,
  ),
),false)) {
function content_620f87098fcfd3_47214045 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_907175016620f87098e2af5_61972381', 'product_miniature_item');
?>

<?php }
/* {block 'product_thumbnail'} */
class Block_984137640620f87098e3a75_20389907 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
" class="thumbnail product-thumbnail">
                            <img src="<?php if ((isset($_smarty_tpl->tpl_vars['ets_link_base']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['ets_link_base']->value, ENT_QUOTES, 'UTF-8');?>
/modules/ets_superspeed/views/img/preloading.png<?php }?>" class="lazyload" data-src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['cover']['bySize']['home_default']['url'], ENT_QUOTES, 'UTF-8');?>
"
                                alt = "<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['cover']['legend'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['cover']['legend'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'truncate' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['name'],30,'...' )), ENT_QUOTES, 'UTF-8');
}?>"
                                data-full-size-image-url = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['cover']['large']['url'], ENT_QUOTES, 'UTF-8');?>
" /><span class="ets_loading">
<?php if ((isset($_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value)) && $_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value == 'type_1') {?>
    <div class="spinner_1"></div>
<?php } elseif ((isset($_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value)) && $_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value == 'type_2') {?>
    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
<?php } elseif ((isset($_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value)) && $_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value == 'type_3') {?>
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
<?php } elseif ((isset($_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value)) && $_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value == 'type_4') {?>
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
<?php } elseif ((isset($_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value)) && $_smarty_tpl->tpl_vars['ETS_SPEED_LOADING_IMAGE_TYPE']->value == 'type_5') {?>
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
<?php }?>
</span>
                        </a>
                    <?php
}
}
/* {/block 'product_thumbnail'} */
/* {block 'product_flags'} */
class Block_756680813620f87098ebc77_29830133 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                        <ul class="product-flags">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product']->value['flags'], 'flag');
$_smarty_tpl->tpl_vars['flag']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['flag']->value) {
$_smarty_tpl->tpl_vars['flag']->do_else = false;
?>
                                <li class="product-flag <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['flag']->value['type'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['flag']->value['label'], ENT_QUOTES, 'UTF-8');?>
</li>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </ul>
                    <?php
}
}
/* {/block 'product_flags'} */
/* {block 'quick_view'} */
class Block_1711260272620f87098ee182_98206085 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                            <a class="quick-view" href="#" data-link-action="quickview">
                                <i class="material-icons search">&#xE8B6;</i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Quick view','d'=>'Shop.Theme.Actions'),$_smarty_tpl ) );?>

                            </a>
                        <?php
}
}
/* {/block 'quick_view'} */
/* {block 'product_variants'} */
class Block_1270415532620f87098eee19_44892339 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                            <?php if ($_smarty_tpl->tpl_vars['product']->value['main_variants']) {?>
                                <?php $_smarty_tpl->_subTemplateRender('file:catalog/_partials/variant-links.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('variants'=>$_smarty_tpl->tpl_vars['product']->value['main_variants']), 0, false);
?>
                            <?php }?>
                        <?php
}
}
/* {/block 'product_variants'} */
/* {block 'product_name'} */
class Block_89471673620f87098f1315_32947875 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                        <h1 class="h3 product-title" itemprop="name"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'truncate' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['name'],60,'...' )), ENT_QUOTES, 'UTF-8');?>
</a></h1>
                        <?php
}
}
/* {/block 'product_name'} */
/* {block 'product_price_and_shipping'} */
class Block_1793436267620f87098f2c91_49035561 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                        <?php if ($_smarty_tpl->tpl_vars['product']->value['show_price']) {?>
                            <div class="product-price-and-shipping">
                                <?php if ($_smarty_tpl->tpl_vars['product']->value['has_discount']) {?>
                                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"old_price"),$_smarty_tpl ) );?>


                                    <span class="sr-only"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Regular price','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</span>
                                    <span class="regular-price"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['regular_price'], ENT_QUOTES, 'UTF-8');?>
</span>
                                <?php }?>

                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"before_price"),$_smarty_tpl ) );?>


                                <span class="sr-only"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Price','d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>
</span>
                                <span itemprop="price" class="price"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price'], ENT_QUOTES, 'UTF-8');?>
</span>

                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'unit_price'),$_smarty_tpl ) );?>


                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'weight'),$_smarty_tpl ) );?>

                            </div>
                        <?php }?>
                    <?php
}
}
/* {/block 'product_price_and_shipping'} */
/* {block 'product_reviews'} */
class Block_2055980780620f87098fbf33_87782896 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductListReviews','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl ) );?>

                    <?php
}
}
/* {/block 'product_reviews'} */
/* {block 'product_miniature_item'} */
class Block_907175016620f87098e2af5_61972381 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_miniature_item' => 
  array (
    0 => 'Block_907175016620f87098e2af5_61972381',
  ),
  'product_thumbnail' => 
  array (
    0 => 'Block_984137640620f87098e3a75_20389907',
  ),
  'product_flags' => 
  array (
    0 => 'Block_756680813620f87098ebc77_29830133',
  ),
  'quick_view' => 
  array (
    0 => 'Block_1711260272620f87098ee182_98206085',
  ),
  'product_variants' => 
  array (
    0 => 'Block_1270415532620f87098eee19_44892339',
  ),
  'product_name' => 
  array (
    0 => 'Block_89471673620f87098f1315_32947875',
  ),
  'product_price_and_shipping' => 
  array (
    0 => 'Block_1793436267620f87098f2c91_49035561',
  ),
  'product_reviews' => 
  array (
    0 => 'Block_2055980780620f87098fbf33_87782896',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="product-item">
        <article class="product-miniature js-product-miniature" data-id-product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" data-id-product-attribute="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], ENT_QUOTES, 'UTF-8');?>
" itemscope itemtype="http://schema.org/Product">
			<div class="thumbnail-container">
                <div class="product-image-block">
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_984137640620f87098e3a75_20389907', 'product_thumbnail', $this->tplIndex);
?>

                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_756680813620f87098ebc77_29830133', 'product_flags', $this->tplIndex);
?>

                    <div class="highlighted-informations<?php if (!$_smarty_tpl->tpl_vars['product']->value['main_variants']) {?> no-variants<?php }?> hidden-sm-down">
                        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1711260272620f87098ee182_98206085', 'quick_view', $this->tplIndex);
?>

                        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1270415532620f87098eee19_44892339', 'product_variants', $this->tplIndex);
?>

                    </div>
                </div>
                <div class="product-description">
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_89471673620f87098f1315_32947875', 'product_name', $this->tplIndex);
?>

                        
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1793436267620f87098f2c91_49035561', 'product_price_and_shipping', $this->tplIndex);
?>

                    <div class="add">
                        <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['cart'], ENT_QUOTES, 'UTF-8');?>
" class="cart-form-url" method="post">
                            <input type="hidden" name="token" class="cart-form-token" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['static_token']->value, ENT_QUOTES, 'UTF-8');?>
">
                            <input type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" name="id_product">
                            <input type="hidden" class="input-group form-control" value="1" name="qty" />
                            <button data-button-action="add-to-cart" class="btn btn-primary" <?php if ($_smarty_tpl->tpl_vars['product']->value->quantity == 0) {?>disabled<?php }?>>
							<?php if ($_smarty_tpl->tpl_vars['product']->value['availability'] == 'available') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to cart','d'=>'Shop.Theme.Actions'),$_smarty_tpl ) );?>

							  <?php } elseif ($_smarty_tpl->tpl_vars['product']->value['availability'] == 'last_remaining_items') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to cart','d'=>'Shop.Theme.Actions'),$_smarty_tpl ) );?>

							  <?php } else { ?>
								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['availability_message'], ENT_QUOTES, 'UTF-8');?>

							  <?php }?>
							</button>
                        </form>
                    </div>
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2055980780620f87098fbf33_87782896', 'product_reviews', $this->tplIndex);
?>

                </div>
            </div>
        </article>
    </div>
<?php
}
}
/* {/block 'product_miniature_item'} */
}
