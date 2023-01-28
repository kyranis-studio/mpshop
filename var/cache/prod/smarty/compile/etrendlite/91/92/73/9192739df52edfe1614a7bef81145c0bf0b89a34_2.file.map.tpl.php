<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:05
  from '/home/mpshop/public_html/modules/mp_google_map/views/templates/hook/map.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f842d841882_76996803',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9192739df52edfe1614a7bef81145c0bf0b89a34' => 
    array (
      0 => '/home/mpshop/public_html/modules/mp_google_map/views/templates/hook/map.tpl',
      1 => 1644999058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f842d841882_76996803 (Smarty_Internal_Template $_smarty_tpl) {
?><style>
	#google-map:not(.active):after{
		content:"Cliquer pour naviguer";
		text-align:center;
		display:block;
		position:absolute;
		width:100%;
		height:100%;
		top:0;
		line-height:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['height']->value+65, ENT_QUOTES, 'UTF-8');?>
px;
		font-weight:bold;
		font-size:18px;
		background:rgba(0,0,0,0.2);
		backdrop-filter: blur(2px);
		color: #0061b9;
	}
</style>
<div id="google-map" style="position:relative;">
	<div id="map-header" style="display: flex;width: 100%;height: 65px;position: absolute;background: #e5e1e1;top : 0;left: 0;border-top: solid 1px silver;border-bottom: solid 1px silver;align-items: center;z-index:10">
		<h2 style="text-align:center;width: 100%;margin: 0;"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8');?>
 </h2>
	</div>
	<iframe width="300" height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['height']->value, ENT_QUOTES, 'UTF-8');?>
" style="width: 100%; border: solid 1px silver;" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mapUrl']->value, ENT_QUOTES, 'UTF-8');?>
" async="" defer="defer"></iframe>
</div>
<?php echo '<script'; ?>
>
	document.querySelector("#google-map").addEventListener('click',function(){
		this.classList.add('active')
	})
	document.querySelector("#google-map").addEventListener('mouseleave',function(){
		this.classList.remove('active')
	})
<?php echo '</script'; ?>
><?php }
}
