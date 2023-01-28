<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:11
  from '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/category-banner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f843364a234_85229911',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46180ca46f93933971c6243b6f216cf724852593' => 
    array (
      0 => '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/category-banner.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f843364a234_85229911 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['banner']->value) {?>
    <a class="homecat_image" href="<?php echo $_smarty_tpl->tpl_vars['banner']->value['link'];?>
">
        <div class="hc_bg_desktop">
            <img src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['banner']->value['image'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['banner']->value['alt'],'html','utf-8' )), ENT_QUOTES, 'UTF-8');?>
"/>
        </div>
    </a>
<?php }
}
}
