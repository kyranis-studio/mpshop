<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:46:01
  from '/home/mpshop/public_html/themes/etrendlite/templates/contact.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f86f95a04d2_77615404',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8f6ecae3a095ecbee752e63a51a4b003ae123977' => 
    array (
      0 => '/home/mpshop/public_html/themes/etrendlite/templates/contact.tpl',
      1 => 1645027505,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f86f95a04d2_77615404 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1773025716620f86f9598281_68507417', 'page_header_container');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_896935071620f86f9599154_40673423', 'left_column');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1803263830620f86f959e5d7_79540272', 'page_content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'page.tpl');
}
/* {block 'page_header_container'} */
class Block_1773025716620f86f9598281_68507417 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_header_container' => 
  array (
    0 => 'Block_1773025716620f86f9598281_68507417',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_header_container'} */
/* {block 'left_column'} */
class Block_896935071620f86f9599154_40673423 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'left_column' => 
  array (
    0 => 'Block_896935071620f86f9599154_40673423',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div id="left-column" class="col-xs-12 col-sm-3">
    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widget'][0], array( array('name'=>"ps_contactinfo",'hook'=>'displayLeftColumn'),$_smarty_tpl ) );?>

  </div>
<?php
}
}
/* {/block 'left_column'} */
/* {block 'page_content'} */
class Block_1803263830620f86f959e5d7_79540272 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_content' => 
  array (
    0 => 'Block_1803263830620f86f959e5d7_79540272',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<ul>
	<li class="contact-title"><strong>HORAIRES DE TRAVAILLE :</strong></li>
	<li>Lundi à Vendredi de 9h à 14h et de 15h à 18h</li>
	<li>Samedi de 9h à 15h</li>
	<li class="contact-title"><strong>CONTACT</strong></li>
	<li>Adresse : 43, Rue de Marseille - Tunis</li>
	<li>Téléphone : (+216) 71 240 275</li>
	<li>Mobile / whatsapp : (+216) 23 746 196</li>
	<li>Email : <a href="mailto:commercial@mpshop.tn" style="color: #227ed1;">commercial@mpshop.tn</a></li>
	<li>Page Facebook : <a href="https://facebook.com/MPSHOPTUNISIE/" target="_blank" style="color: #227ed1;">facebook.com/MPSHOPTUNISIE/</a></li>
	<li>Page Instagram : <a href="https://www.instagram.com/mpshop.tn/" target="_blank" style="color: #227ed1;">instagram.com/mpshop.tn/</a></li>
</ul>
  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['widget'][0], array( array('name'=>"contactform"),$_smarty_tpl ) );?>

  <div>
	<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayContactForm'),$_smarty_tpl ) );?>

  </div>
</section>
<?php
}
}
/* {/block 'page_content'} */
}
