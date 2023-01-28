<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:10
  from '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/assign-js.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f84328c5d11_18009303',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a0692f7cc6eea6623942629d971b6c2f57e54904' => 
    array (
      0 => '/home/mpshop/public_html/modules/ets_homecategories/views/templates/hook/assign-js.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f84328c5d11_18009303 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
    <?php if ((isset($_smarty_tpl->tpl_vars['frontJs']->value)) && $_smarty_tpl->tpl_vars['frontJs']->value) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['frontJs']->value, 'config', false, 'ID');
$_smarty_tpl->tpl_vars['config']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['ID']->value => $_smarty_tpl->tpl_vars['config']->value) {
$_smarty_tpl->tpl_vars['config']->do_else = false;
?>
            <?php if ($_smarty_tpl->tpl_vars['config']->value['type'] == 'isInt') {?>
                var <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ID']->value,'html','utf-8' )), ENT_QUOTES, 'UTF-8');?>
 = <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['config']->value['value']), ENT_QUOTES, 'UTF-8');?>
;
            <?php } elseif ($_smarty_tpl->tpl_vars['config']->value['type'] == 'isString') {?>
                var <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ID']->value,'html','utf-8' )), ENT_QUOTES, 'UTF-8');?>
 ='<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['config']->value['value'],'html','utf-8' )), ENT_QUOTES, 'UTF-8');?>
';
            <?php }?>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>
    var homecat_ajax_link = '<?php echo $_smarty_tpl->tpl_vars['homecat_ajax_link']->value;?>
';
    var homecat_rand_seed = <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['homecat_rand_seed']->value), ENT_QUOTES, 'UTF-8');?>
;
    var homecat_more_txt = "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'View more products','mod'=>'ets_homecategories'),$_smarty_tpl ) );?>
";
    var homecat_no_more_found_txt = "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No more products found','mod'=>'ets_homecategories'),$_smarty_tpl ) );?>
";
<?php echo '</script'; ?>
>

<?php }
}
