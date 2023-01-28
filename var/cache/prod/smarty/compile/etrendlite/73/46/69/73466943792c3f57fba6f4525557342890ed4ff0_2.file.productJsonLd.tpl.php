<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:04
  from '/home/mpshop/public_html/modules/obsrichproducts/views/templates/hook/productJsonLd.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f842ccd19c7_34867752',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '73466943792c3f57fba6f4525557342890ed4ff0' => 
    array (
      0 => '/home/mpshop/public_html/modules/obsrichproducts/views/templates/hook/productJsonLd.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f842ccd19c7_34867752 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="application/ld+json" data-keepinline>
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productName']->value, ENT_QUOTES, 'UTF-8');?>
",
        <?php if ($_smarty_tpl->tpl_vars['productImages']->value) {?>"image": [
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['productImages']->value, 'productImage', true);
$_smarty_tpl->tpl_vars['productImage']->iteration = 0;
$_smarty_tpl->tpl_vars['productImage']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['productImage']->value) {
$_smarty_tpl->tpl_vars['productImage']->do_else = false;
$_smarty_tpl->tpl_vars['productImage']->iteration++;
$_smarty_tpl->tpl_vars['productImage']->last = $_smarty_tpl->tpl_vars['productImage']->iteration === $_smarty_tpl->tpl_vars['productImage']->total;
$__foreach_productImage_45_saved = $_smarty_tpl->tpl_vars['productImage'];
?>"<?php echo $_smarty_tpl->tpl_vars['productImage']->value;?>
"<?php if (!$_smarty_tpl->tpl_vars['productImage']->last) {?>,
            <?php }
$_smarty_tpl->tpl_vars['productImage'] = $__foreach_productImage_45_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

        ],<?php }?>

        <?php if ($_smarty_tpl->tpl_vars['productDescription']->value) {?>"description": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productDescription']->value, ENT_QUOTES, 'UTF-8');?>
",<?php }?>

        <?php if ($_smarty_tpl->tpl_vars['productSku']->value) {?>"sku": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productSku']->value, ENT_QUOTES, 'UTF-8');?>
",<?php }?>

        <?php if ($_smarty_tpl->tpl_vars['productGtin13']->value) {?>"gtin13": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productGtin13']->value, ENT_QUOTES, 'UTF-8');?>
",<?php }?>

        <?php if ($_smarty_tpl->tpl_vars['productIsbn']->value) {?>"mpn": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productIsbn']->value, ENT_QUOTES, 'UTF-8');?>
",<?php }?>

        <?php if ($_smarty_tpl->tpl_vars['brandName']->value) {?>"brand": {
            "@type": "Thing",
            "name": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brandName']->value, ENT_QUOTES, 'UTF-8');?>
"
        },<?php }?>

        "offers": {
            "@type": "Offer",
            "url": "<?php echo $_smarty_tpl->tpl_vars['productUrl']->value;?>
",
            "priceCurrency": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productPriceCurrency']->value, ENT_QUOTES, 'UTF-8');?>
",
            "price": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productPrice']->value, ENT_QUOTES, 'UTF-8');?>
",
            <?php if ($_smarty_tpl->tpl_vars['productPriceValidUntil']->value) {?>"priceValidUntil": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productPriceValidUntil']->value, ENT_QUOTES, 'UTF-8');?>
",<?php }?>
            "itemCondition": "https://schema.org/<?php if ($_smarty_tpl->tpl_vars['productIsNew']->value) {?>NewCondition<?php } else { ?>UsedCondition<?php }?>",
            "availability": "https://schema.org/<?php if ($_smarty_tpl->tpl_vars['productHasStock']->value) {?>InStock<?php } else { ?>OutOfStock<?php }?>"
        }<?php if (((isset($_smarty_tpl->tpl_vars['ratingCount']->value)) && $_smarty_tpl->tpl_vars['ratingCount']->value > 0) || ((isset($_smarty_tpl->tpl_vars['reviews']->value)) && count($_smarty_tpl->tpl_vars['reviews']->value) > 0)) {?>,<?php }?>

        <?php if ((isset($_smarty_tpl->tpl_vars['ratingCount']->value)) && $_smarty_tpl->tpl_vars['ratingCount']->value > 0) {?>
        "aggregateRating" : {
            "@type": "AggregateRating",
            "worstRating": "0",
            "ratingValue": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['averageRating']->value, ENT_QUOTES, 'UTF-8');?>
",
            "bestRating": "5",
            "ratingCount": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ratingCount']->value, ENT_QUOTES, 'UTF-8');?>
"
        }<?php if ((isset($_smarty_tpl->tpl_vars['reviews']->value)) && count($_smarty_tpl->tpl_vars['reviews']->value) > 0) {?>,<?php }?>
        <?php }?>

        <?php if ((isset($_smarty_tpl->tpl_vars['reviews']->value)) && count($_smarty_tpl->tpl_vars['reviews']->value) > 0) {?>
        "review" : [
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['reviews']->value, 'review', true);
$_smarty_tpl->tpl_vars['review']->iteration = 0;
$_smarty_tpl->tpl_vars['review']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['review']->value) {
$_smarty_tpl->tpl_vars['review']->do_else = false;
$_smarty_tpl->tpl_vars['review']->iteration++;
$_smarty_tpl->tpl_vars['review']->last = $_smarty_tpl->tpl_vars['review']->iteration === $_smarty_tpl->tpl_vars['review']->total;
$__foreach_review_46_saved = $_smarty_tpl->tpl_vars['review'];
?>
                <?php if ($_smarty_tpl->tpl_vars['review']->value->getContent()) {?>
                {
                    "@type": "Review",
                    "datePublished" : "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['review']->value->getDateAdd(), ENT_QUOTES, 'UTF-8');?>
",
                    "name" : "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['review']->value->getTitle(), ENT_QUOTES, 'UTF-8');?>
",
                    "reviewBody" : "<?php echo nl2br(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['review']->value->getContent(),'html','UTF-8' )));?>
",
                    "reviewRating" : {
                        "@type" : "Rating",
                        "worstRating" : "0",
                        "ratingValue" : "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['review']->value->getRating(),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                        "bestRating" : "5"
                    },
                    "author" : "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['review']->value->getAuthor(),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
                }<?php if (!$_smarty_tpl->tpl_vars['review']->last) {?>,<?php }?>
                <?php }?>
            <?php
$_smarty_tpl->tpl_vars['review'] = $__foreach_review_46_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        ]
        <?php }?>
    }

<?php echo '</script'; ?>
><?php }
}
