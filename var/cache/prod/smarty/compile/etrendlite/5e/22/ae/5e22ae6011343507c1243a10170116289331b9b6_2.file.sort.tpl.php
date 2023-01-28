<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:11
  from '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/sort.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f843369d777_70566585',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e22ae6011343507c1243a10170116289331b9b6' => 
    array (
      0 => '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/sort.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f843369d777_70566585 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['ETS_HOMECAT_ALLOW_SORT']->value && $_smarty_tpl->tpl_vars['sortOptions']->value && !($_smarty_tpl->tpl_vars['id_category']->value == -1 && $_smarty_tpl->tpl_vars['ETS_HOMECAT_FEED_NEW_ALL']->value)) {?>
    <form action="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['homecat_ajax_link']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" method="post" <?php if ($_smarty_tpl->tpl_vars['id_category']->value == -5) {?>class="hc-hidden"<?php }?>>
        <label for="homecat_sort_by_<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['id_category']->value,'html','utf-8' )), ENT_QUOTES, 'UTF-8');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sort by','mod'=>'ets_homecategories'),$_smarty_tpl ) );?>
</label>
        <select name="homecat_sort_by" class="homecat_sort_by">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sortOptions']->value, 'option');
$_smarty_tpl->tpl_vars['option']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['option']->value) {
$_smarty_tpl->tpl_vars['option']->do_else = false;
?>
                <option <?php if ($_smarty_tpl->tpl_vars['sort_by']->value == $_smarty_tpl->tpl_vars['option']->value['id_option']) {?>selected="selected"<?php }?>
                        value="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['option']->value['id_option'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['option']->value['name'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</option>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </select>
    </form>
<?php }
}
}
