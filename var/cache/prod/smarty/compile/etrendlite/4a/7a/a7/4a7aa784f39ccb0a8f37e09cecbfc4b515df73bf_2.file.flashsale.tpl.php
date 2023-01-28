<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:11
  from '/home/mpshop/public_html/modules/mp_flash_sale/views/templates/hook/flashsale.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f8433539498_58861239',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4a7aa784f39ccb0a8f37e09cecbfc4b515df73bf' => 
    array (
      0 => '/home/mpshop/public_html/modules/mp_flash_sale/views/templates/hook/flashsale.tpl',
      1 => 1645181484,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f8433539498_58861239 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/mpshop/public_html/vendor/smarty/smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div id="sale-flash">
  <div id="countdown">
    <div id="product-thumbnail">
		<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['bannerSrc']->value, ENT_QUOTES, 'UTF-8');?>
" />
    </div>
    <ul>
      <li><span id="days"></span>Joures</li>
      <li><span id="hours"></span>Heures</li>
      <li><span id="minutes"></span>Minutes</li>
      <li><span id="seconds"></span>Secondes</li>
    </ul>
  </div>
  <div id="mp-product">
		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8');?>
">
			<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['afficheSrc']->value, ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['start']->value,'%d/%m/%Y/%H:%M'), ENT_QUOTES, 'UTF-8');?>
-<?php echo htmlspecialchars(smarty_modifier_date_format($_smarty_tpl->tpl_vars['end']->value,'%d/%m/%Y/%H:%M'), ENT_QUOTES, 'UTF-8');?>
" style="width: 100%;"/>
		</a>	
  </div>
</div><?php }
}
