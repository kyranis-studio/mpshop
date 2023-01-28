<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:11
  from '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/mode-list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f843361aba8_35981153',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '883621e8f7e34e90826e98d8436f4902aa0f310e' => 
    array (
      0 => '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/mode-list.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./sort.tpl' => 1,
  ),
),false)) {
function content_620f843361aba8_35981153 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['categoryTabs']->value) {?>
    <div class="
        ets-desktop-col-<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ETS_HOMECAT_NUMBER_DISPLAY_DESKTOP']->value), ENT_QUOTES, 'UTF-8');?>

        ets-tablet-col-<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ETS_HOMECAT_NUMBER_DISPLAY_TABLET']->value), ENT_QUOTES, 'UTF-8');?>

        ets-mobie-col-<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ETS_HOMECAT_NUMBER_DISPLAY_MOBIE']->value), ENT_QUOTES, 'UTF-8');?>

    hc-layout <?php if (!$_smarty_tpl->tpl_vars['greater1760']->value) {?>hc-175<?php }?> hc-mode-list hc-<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ETS_HOMECAT_LISTING_MODE']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php if ($_smarty_tpl->tpl_vars['ETS_HOMECAT_LOADING_ENABLED']->value) {?>hc-loading-enabled<?php }?>">
        <ul class="hc-tabs">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categoryTabs']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
            <li class="hc-tab" data-id-category="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['category']->value['id_category']), ENT_QUOTES, 'UTF-8');?>
">
                <?php if ($_smarty_tpl->tpl_vars['ETS_HOMECAT_DISPLAY_CATEGORY_BANNER']->value != 'below') {?>
                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayCategoryBanner','id_category'=>$_smarty_tpl->tpl_vars['category']->value['id_category']),$_smarty_tpl ) );?>

                <?php }?>
                <div class="hc-tab-info">
                    <?php if ($_smarty_tpl->tpl_vars['category']->value['id_category'] > 0 || (isset($_smarty_tpl->tpl_vars['category']->value['link']))) {?>
                        <a class="hc-cat parent-cat active" href="<?php if ((isset($_smarty_tpl->tpl_vars['category']->value['link']))) {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value['link'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category']),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
}?>" data-id-category="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['category']->value['id_category']), ENT_QUOTES, 'UTF-8');?>
"  data-id-parent="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['category']->value['id_category']), ENT_QUOTES, 'UTF-8');?>
" data-id-feature="no"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value['name'],'html' )), ENT_QUOTES, 'UTF-8');?>
</a>
                        <?php if ($_smarty_tpl->tpl_vars['ETS_HOMECAT_ENABLE_VIEW_ALL']->value) {?>
                            <a class="hc-view-all" href="<?php if ((isset($_smarty_tpl->tpl_vars['category']->value['link']))) {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value['link'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category']),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
}?>"><?php if ($_smarty_tpl->tpl_vars['ETS_HOMECAT_TXT_VIEW_ALL_LABEL']->value) {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ETS_HOMECAT_TXT_VIEW_ALL_LABEL']->value,'html' )), ENT_QUOTES, 'UTF-8');
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'View all','mod'=>'ets_homecategories'),$_smarty_tpl ) );
}?></a>
                        <?php }?>
                    <?php } else { ?>
                        <span class="hc-cat parent-cat active no-link" data-id-category="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['category']->value['id_category']), ENT_QUOTES, 'UTF-8');?>
" data-id-parent="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['category']->value['id_category']), ENT_QUOTES, 'UTF-8');?>
" data-id-feature="no"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value['name'],'html' )), ENT_QUOTES, 'UTF-8');?>
</span>
                    <?php }?>
                    <div class="clearfix"></div>
                    <?php if ($_smarty_tpl->tpl_vars['ETS_HOMECAT_DISPLAY_SUB']->value && $_smarty_tpl->tpl_vars['category']->value['id_category'] >= 0 || $_smarty_tpl->tpl_vars['ETS_HOMECAT_DISPLAY_SUB_FEATURED']->value && $_smarty_tpl->tpl_vars['category']->value['id_category'] < 0) {?>
                        <div class="hc-tab-sub">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displaySubCategories','id_category'=>$_smarty_tpl->tpl_vars['category']->value['id_category'],'layout'=>'LIST'),$_smarty_tpl ) );?>

                        </div>
                    <?php }?>
                    <?php $_smarty_tpl->_subTemplateRender("file:./sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('id_category'=>$_smarty_tpl->tpl_vars['category']->value['id_category']), 0, true);
?>
                    <div class="hc-products-container">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductList','id_category'=>$_smarty_tpl->tpl_vars['category']->value['id_category'],'id_parent'=>$_smarty_tpl->tpl_vars['category']->value['id_category'],'active'=>1),$_smarty_tpl ) );?>

                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['ETS_HOMECAT_DISPLAY_CATEGORY_BANNER']->value == 'below') {?>
                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayCategoryBanner','id_category'=>$_smarty_tpl->tpl_vars['category']->value['id_category']),$_smarty_tpl ) );?>

                <?php }?>
            </li>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>
    </div>
<?php }
}
}
