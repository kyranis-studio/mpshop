<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:15
  from '/home/mpshop/public_html/modules/arcontactus/views/templates/hook/admin_head.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f843793dbe3_37485502',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3c8c61585713f788882d26e0d98e02a42b8860eb' => 
    array (
      0 => '/home/mpshop/public_html/modules/arcontactus/views/templates/hook/admin_head.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f843793dbe3_37485502 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['moduleConfig']->value) {
echo '<script'; ?>
 type="text/javascript">
    if (document.getElementById('maintab-AdminArCu')){
        document.getElementById('maintab-AdminArCu').classList.add("active");
    }else if(document.getElementById('subtab-AdminArCu')){
        document.getElementById('subtab-AdminArCu').classList.add("active");
        document.getElementById('subtab-AdminArCu').classList.add("-active");
        document.getElementById('subtab-AdminArCu').classList.add("ul-open");
        document.getElementById('subtab-AdminArCu').classList.add("open");
        var arCUIcon = document.getElementById('subtab-AdminArCu').querySelector('a i');
        if (arCUIcon && arCUIcon.innerHTML == ''){
            arCUIcon.innerHTML = 'link';
        }
    }
    if (document.getElementById('maintab-AdminParentModules')){
        document.getElementById('maintab-AdminParentModules').classList.remove("active");
    }
    if (document.getElementById('subtab-AdminParentModulesSf')){
        document.getElementById('subtab-AdminParentModulesSf').classList.remove("active");
        document.getElementById('subtab-AdminParentModulesSf').classList.remove("-active");
        document.getElementById('subtab-AdminParentModulesSf').classList.remove("ul-open");
        document.getElementById('subtab-AdminParentModulesSf').classList.remove("open");
    }
<?php echo '</script'; ?>
>
<?php }?>
<style type="text/css">
    .icon-AdminArCu:before{
        content:"";
    }
</style><?php }
}
