<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:02
  from '/home/mpshop/public_html/modules/mp_offre/views/templates/hook/offre.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f842a93e2d9_34209331',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1013ae7f7dd466df92268b40280d7f93e3a24785' => 
    array (
      0 => '/home/mpshop/public_html/modules/mp_offre/views/templates/hook/offre.tpl',
      1 => 1645114253,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f842a93e2d9_34209331 (Smarty_Internal_Template $_smarty_tpl) {
?><style>
	#header .header-nav .container {
		padding: 0;
	}
	#header .header-nav .container .row {
		margin: 0;
	}
	.payment-currency-block{
		padding:0;
		
	}
</style>
<div id="mp_offre" style="width: calc(100vw - 17px);padding: 0px;margin: 0;display: block;background:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['bgColor']->value, ENT_QUOTES, 'UTF-8');?>
">
	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8');?>
">
		<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['bannerSrc']->value, ENT_QUOTES, 'UTF-8');?>
" alt="" style="display:block;margin:auto;">
	</a>
</div>
<?php }
}
