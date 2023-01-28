<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:03
  from '/home/mpshop/public_html/modules/ets_megamenu/views/templates/hook/block.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f842b3a3f18_23559584',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd1e3b8cb1e5af7197ca2d67cb01c4858cbe6696b' => 
    array (
      0 => '/home/mpshop/public_html/modules/ets_megamenu/views/templates/hook/block.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f842b3a3f18_23559584 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['block']->value)) && $_smarty_tpl->tpl_vars['block']->value && $_smarty_tpl->tpl_vars['block']->value['enabled']) {?>    
    <div class="ets_mm_block mm_block_type_<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( strtolower($_smarty_tpl->tpl_vars['block']->value['block_type']),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php if (!$_smarty_tpl->tpl_vars['block']->value['display_title']) {?>mm_hide_title<?php }?>">
        <span class="h4" <?php if (Configuration::get('ETS_MM_TEXTTITLE_FONT_SIZE')) {?> style="font-size:<?php echo htmlspecialchars(intval(Configuration::get('ETS_MM_TEXTTITLE_FONT_SIZE')), ENT_QUOTES, 'UTF-8');?>
px"<?php }?>><?php if ($_smarty_tpl->tpl_vars['block']->value['title_link']) {?><a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['block']->value['title_link'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" <?php if (Configuration::get('ETS_MM_TEXTTITLE_FONT_SIZE')) {?> style="font-size:<?php echo htmlspecialchars(intval(Configuration::get('ETS_MM_TEXTTITLE_FONT_SIZE')), ENT_QUOTES, 'UTF-8');?>
px"<?php }?>><?php }
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['block']->value['title'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
if ($_smarty_tpl->tpl_vars['block']->value['title_link']) {?></a><?php }?></span>
        <div class="ets_mm_block_content">        
            <?php if ($_smarty_tpl->tpl_vars['block']->value['block_type'] == 'CATEGORY') {?>
                <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['categoriesHtml']))) {
echo $_smarty_tpl->tpl_vars['block']->value['categoriesHtml'];
}?>
            <?php } elseif ($_smarty_tpl->tpl_vars['block']->value['block_type'] == 'MNFT') {?>
                <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['manufacturers'])) && $_smarty_tpl->tpl_vars['block']->value['manufacturers']) {?>
                    <ul <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_mnu_img'])) && $_smarty_tpl->tpl_vars['block']->value['display_mnu_img']) {?>class="mm_mnu_display_img"<?php }?>>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['block']->value['manufacturers'], 'manufacturer');
$_smarty_tpl->tpl_vars['manufacturer']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['manufacturer']->value) {
$_smarty_tpl->tpl_vars['manufacturer']->do_else = false;
?>
                            <li class="<?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_mnu_img'])) && $_smarty_tpl->tpl_vars['block']->value['display_mnu_img']) {?>item_has_img <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_mnu_inline'])) && $_smarty_tpl->tpl_vars['block']->value['display_mnu_inline']) {?>item_inline_<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['block']->value['display_mnu_inline'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
}
}?>">
                                <a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['manufacturer']->value['link'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
">
                                    <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_mnu_img'])) && $_smarty_tpl->tpl_vars['block']->value['display_mnu_img']) {?>
                                        <span class="ets_item_img">
                                            <img src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['manufacturer']->value['image'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" alt="" title="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['manufacturer']->value['label'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"/>
                                        </span>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_mnu_name'])) && $_smarty_tpl->tpl_vars['block']->value['display_mnu_name']) {?>
                                            <span class="ets_item_name"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['manufacturer']->value['label'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</span>
                                        <?php }?>
                                    <?php } else { ?>
                                        <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['manufacturer']->value['label'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>

                                    <?php }?>
                                </a>
                            </li>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </ul>
                <?php }?>
            <?php } elseif ($_smarty_tpl->tpl_vars['block']->value['block_type'] == 'MNSP') {?>
                <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['suppliers'])) && $_smarty_tpl->tpl_vars['block']->value['suppliers']) {?>
                    <ul <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_suppliers_img'])) && $_smarty_tpl->tpl_vars['block']->value['display_suppliers_img']) {?>class="mm_mnu_display_img"<?php }?>>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['block']->value['suppliers'], 'supplier');
$_smarty_tpl->tpl_vars['supplier']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['supplier']->value) {
$_smarty_tpl->tpl_vars['supplier']->do_else = false;
?>
                            <li class="<?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_suppliers_img'])) && $_smarty_tpl->tpl_vars['block']->value['display_suppliers_img']) {
if ((isset($_smarty_tpl->tpl_vars['block']->value['display_suppliers_inline'])) && $_smarty_tpl->tpl_vars['block']->value['display_suppliers_inline']) {?>item_inline_<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['block']->value['display_suppliers_inline'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
}?> item_has_img<?php }?>">
                                <a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['supplier']->value['link'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
">
                                    <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_suppliers_img'])) && $_smarty_tpl->tpl_vars['block']->value['display_suppliers_img']) {?>
                                        <span class="ets_item_img">
                                            <img src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['supplier']->value['image'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" alt="" title="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['supplier']->value['label'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" />
                                        </span>
                                        <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['display_suppliers_name'])) && $_smarty_tpl->tpl_vars['block']->value['display_suppliers_name']) {?>
                                            <span class="ets_item_name"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['supplier']->value['label'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</span>
                                        <?php }?>
                                    <?php } else { ?>
                                        <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['supplier']->value['label'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>

                                    <?php }?>
                                </a>
                            </li>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </ul>
                <?php }?>
            <?php } elseif ($_smarty_tpl->tpl_vars['block']->value['block_type'] == 'CMS') {?>
                <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['cmss'])) && $_smarty_tpl->tpl_vars['block']->value['cmss']) {?>
                    <ul>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['block']->value['cmss'], 'cms');
$_smarty_tpl->tpl_vars['cms']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['cms']->value) {
$_smarty_tpl->tpl_vars['cms']->do_else = false;
?>
                            <li><a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['cms']->value['link'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['cms']->value['label'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</a></li>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </ul>
                <?php }?>
            <?php } elseif ($_smarty_tpl->tpl_vars['block']->value['block_type'] == 'IMAGE') {?>
                <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['image'])) && $_smarty_tpl->tpl_vars['block']->value['image']) {
if ($_smarty_tpl->tpl_vars['block']->value['image_link']) {?><a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['block']->value['image_link'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"><?php }?>
                    <span class="mm_img_content">
                        <img src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['block']->value['image'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['block']->value['title'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" />
                    </span>
                <?php if ($_smarty_tpl->tpl_vars['block']->value['image_link']) {?></a><?php }
}?>
            <?php } elseif ($_smarty_tpl->tpl_vars['block']->value['block_type'] == 'PRODUCT') {?>
                <?php if ((isset($_smarty_tpl->tpl_vars['block']->value['productsHtml']))) {
echo $_smarty_tpl->tpl_vars['block']->value['productsHtml'];
}?>
            <?php } else { ?>
                <?php echo $_smarty_tpl->tpl_vars['block']->value['content'];?>

            <?php }?>
        </div>
    </div>
    <div class="clearfix"></div>
<?php }
}
}
