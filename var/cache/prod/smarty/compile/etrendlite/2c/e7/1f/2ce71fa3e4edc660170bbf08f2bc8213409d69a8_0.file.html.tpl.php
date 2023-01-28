<?php
/* Smarty version 3.1.39, created on 2022-02-18 13:14:03
  from '/home/mpshop/public_html/modules/ets_delete_order/views/templates/hook/html.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f8d8b182cc8_52443440',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ce71fa3e4edc660170bbf08f2bc8213409d69a8' => 
    array (
      0 => '/home/mpshop/public_html/modules/ets_delete_order/views/templates/hook/html.tpl',
      1 => 1643118555,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f8d8b182cc8_52443440 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['tag']->value) {?>
<<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['tag']->value,'html','UTF-8' ));?>

    <?php if ($_smarty_tpl->tpl_vars['attr_datas']->value) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['attr_datas']->value, 'value', false, 'name');
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['name']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
            <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['name']->value,'html','UTF-8' ));?>
="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['value']->value,'html','UTF-8' ));?>
"
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['tag']->value == 'img' || $_smarty_tpl->tpl_vars['tag']->value == 'br' || $_smarty_tpl->tpl_vars['tag']->value == 'path' || $_smarty_tpl->tpl_vars['tag']->value == 'input') {?> /<?php }?>
    
>
    <?php }
if ($_smarty_tpl->tpl_vars['tag']->value && $_smarty_tpl->tpl_vars['tag']->value != 'img' && $_smarty_tpl->tpl_vars['tag']->value != 'input' && $_smarty_tpl->tpl_vars['tag']->value != 'br' && !is_null($_smarty_tpl->tpl_vars['content']->value)) {
echo $_smarty_tpl->tpl_vars['content']->value;
}
if ($_smarty_tpl->tpl_vars['tag']->value && $_smarty_tpl->tpl_vars['tag']->value != 'img' && $_smarty_tpl->tpl_vars['tag']->value != 'path' && $_smarty_tpl->tpl_vars['tag']->value != 'input' && $_smarty_tpl->tpl_vars['tag']->value != 'br') {?></<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['tag']->value,'html','UTF-8' ));?>
><?php }
}
}
