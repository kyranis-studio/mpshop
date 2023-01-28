<?php
/* Smarty version 3.1.39, created on 2022-02-18 12:34:05
  from '/home/mpshop/public_html/modules/arcontactus/views/templates/hook/footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_620f842d619675_61903017',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '09a6e69f9af559cbf53aa658dec3267aeebb4345' => 
    array (
      0 => '/home/mpshop/public_html/modules/arcontactus/views/templates/hook/footer.tpl',
      1 => 1643017639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620f842d619675_61903017 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/mpshop/public_html/vendor/smarty/smarty/libs/plugins/modifier.replace.php','function'=>'smarty_modifier_replace',),));
?>

<?php if ($_smarty_tpl->tpl_vars['vkIntegrated']->value) {?>
    <?php echo '<script'; ?>
 type="text/javascript" src="https://vk.com/js/api/openapi.js?157"><?php echo '</script'; ?>
>
    <!-- VK Widget -->
    <?php if (!$_smarty_tpl->tpl_vars['isMobile']->value) {?>
    <style type="text/css">
        #vk_community_messages{
            <?php if ($_smarty_tpl->tpl_vars['buttonConfig']->value->position == 'right') {?>
                right: -10px !important;
            <?php } else { ?>
                left: -10px !important;
            <?php }?>
        }
    </style>
    <?php }?>
    <div id="vk_community_messages"></div>
<?php }
if ($_smarty_tpl->tpl_vars['jivosite']->value) {?>
    <style type="text/css">
        .globalClass_ET{
            display: none
        }
        .globalClass_ET.active{
            display: block
        }
    </style>
    <?php echo '<script'; ?>
 src="//code.jivosite.com/widget.js" data-jv-id="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->jivosite_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" async><?php echo '</script'; ?>
>
<?php }
if ($_smarty_tpl->tpl_vars['phplive']->value) {?>
    <span style="color: #0000FF; text-decoration: underline; line-height: 0px !important; cursor: pointer; position: fixed; bottom: 0px; right: 20px; z-index: 20000000;" id="phplive_btn_1576807307"></span>
<?php }
if ($_smarty_tpl->tpl_vars['hubspot']->value) {?>
    <?php echo '<script'; ?>
 type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->hubspot_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
.js"><?php echo '</script'; ?>
>
<?php }
if ($_smarty_tpl->tpl_vars['socialintents']->value) {?>
    <?php echo '<script'; ?>
 src="//www.socialintents.com/api/socialintents.1.3.js#<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->socialintents_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" async="async"><?php echo '</script'; ?>
>
<?php }?>
<style type="text/css">
    <?php if ($_smarty_tpl->tpl_vars['phplive']->value) {?>
        #phplive_btn_1576807307_clone{
            display: none !important;
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['paldesk']->value) {?>
        #paldesk-widget-btnframe{
            display: none;
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['hubspot']->value) {?>
        #hubspot-messages-iframe-container{
            display: none !important;
        }
        #hubspot-messages-iframe-container.active{
            display: initial !important;
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['facebookIntegrated']->value) {?>
        #fb-root{
            visibility: hidden;
        }
        #fb-root.active{
            visibility: visible;
        }
    <?php }?>
</style>
<?php if ($_smarty_tpl->tpl_vars['skypeIntegrated']->value) {?>
    <style type="text/css">
        #arcontactus-skype iframe[seamless="seamless"].swcChat_lwc{
            display: none;
        }
        #arcontactus-skype.active iframe[seamless="seamless"].swcChat_lwc{
            display: block;
        }
    </style>
    <?php echo '<script'; ?>
 src="https://swc.cdn.skype.com/sdk/v1/sdk.min.js"><?php echo '</script'; ?>
>
    <span 
        class="skype-chat" 
        id="arcontactus-skype"
        style="display: none"
        data-can-close=true
        data-can-collapse=true
        data-can-upload-file=true
        data-show-header=true
        data-entry-animation=true
        <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->skype_type == 'skype') {?>
            data-contact-id="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->skype_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" 
        <?php } else { ?>
            data-bot-id="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->skype_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
        <?php }?>
        data-color-message="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->skype_message_color,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
    ></span>
<?php }
if ($_smarty_tpl->tpl_vars['zaloIntegrated']->value) {?>
    <div id="ar-zalo-chat-widget">
        <div class="zalo-chat-widget" data-oaid="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->zalo_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" data-welcome-message="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->zalo_welcome[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" data-autopopup="0" data-width="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['liveChatConfig']->value->zalo_width), ENT_QUOTES, 'UTF-8');?>
" data-height="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['liveChatConfig']->value->zalo_height), ENT_QUOTES, 'UTF-8');?>
"></div>
    </div>
    <?php echo '<script'; ?>
 src="https://sp.zalo.me/plugins/sdk.js"><?php echo '</script'; ?>
>
<?php }
if ($_smarty_tpl->tpl_vars['tidioIntegrated']->value) {?>
    <style type="text/css">
        #tidio-chat{
            display: none;
        }
        #tidio-chat.active{
            display: block;
        }
    </style>
    <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->tidio_userinfo) {?>
        <?php echo '<script'; ?>
>
            document.tidioIdentify = {
                email: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
                name: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
            };
        <?php echo '</script'; ?>
>
    <?php }?>
    <?php echo '<script'; ?>
 src="//code.tidio.co/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->tidio_key,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
.js"><?php echo '</script'; ?>
>
<?php }
if ($_smarty_tpl->tpl_vars['botmake']->value) {?>
    <style type="text/css">
        #_chatBubble{
            display: none !important;
        }
    </style>
    <?php echo '<script'; ?>
 type="text/javascript"> let headID = document.getElementsByTagName("head")[0]; let newCss = document.createElement('link'); newCss.rel = 'stylesheet'; newCss.type = 'text/css'; newCss.href = "https://botmake.io/embed/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->botmake_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
.css"; let newScript = document.createElement('script'); newScript.src = "https://botmake.io/embed/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->botmake_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
.js"; newScript.type = 'text/javascript'; headID.appendChild(newScript); headID.appendChild(newCss); <?php echo '</script'; ?>
> 
<?php }
echo '<script'; ?>
>
    var lcpWidgetInterval;
    var closePopupTimeout;
    var lzWidgetInterval;
    var paldeskInterval;
    var hubspotInterval;
    var arcuOptions;
    <?php if (($_smarty_tpl->tpl_vars['promptConfig']->value->enable_prompt && $_smarty_tpl->tpl_vars['messagesCount']->value)) {?>
        var arCuMessages = <?php echo $_smarty_tpl->tpl_vars['messages']->value;?>
;
        var arCuLoop = <?php if ($_smarty_tpl->tpl_vars['promptConfig']->value->loop) {?>true<?php } else { ?>false<?php }?>;
        var arCuCloseLastMessage = <?php if ($_smarty_tpl->tpl_vars['promptConfig']->value->close_last) {?>true<?php } else { ?>false<?php }?>;
        var arCuPromptClosed = false;
        var _arCuTimeOut = null;
        var arCuDelayFirst = <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['promptConfig']->value->first_delay), ENT_QUOTES, 'UTF-8');?>
;
        var arCuTypingTime = <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['promptConfig']->value->typing_time), ENT_QUOTES, 'UTF-8');?>
;
        var arCuMessageTime = <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['promptConfig']->value->message_time), ENT_QUOTES, 'UTF-8');?>
;
        var arCuClosedCookie = 0;
    <?php }?>
    var arcItems = [];
    <?php if ($_smarty_tpl->tpl_vars['tawkToIntegrated']->value) {?>
        var tawkToSiteID = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->tawk_to_site_id[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
        var tawkToWidgetID = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->tawk_to_widget[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    <?php }?>
    window.addEventListener('load', function(){
        jQuery('#arcontactus').remove();
        var $arcuWidget = jQuery('<div>', {
            id: 'arcontactus'
        });
        jQuery('body').append($arcuWidget);
        <?php if ($_smarty_tpl->tpl_vars['promptConfig']->value->show_after_close != '-1') {?>
            arCuClosedCookie = arCuGetCookie('arcu-closed');
        <?php }?>
        jQuery('#arcontactus').on('arcontactus.init', function(){
            jQuery('#arcontactus').addClass('arcuAnimated').addClass('<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['buttonConfig']->value->animation,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
            setTimeout(function(){
                jQuery('#arcontactus').removeClass('<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['buttonConfig']->value->animation,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
            }, 1000);
            var $key = $('<input>', {
                type: 'hidden',
                name: 'key',
                value: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['securityKey']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
'
            });
            jQuery('#arcontactus .callback-countdown-block-phone form').append($key);
            <?php if ($_smarty_tpl->tpl_vars['popupConfig']->value->phone_mask_on) {?>
                jQuery.mask.definitions['#'] = "[0-9]";
                jQuery('#arcontactus .arcontactus-message-callback-phone').mask('<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->phone_mask[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
            <?php }?>
        });
        <?php if (($_smarty_tpl->tpl_vars['promptConfig']->value->enable_prompt && $_smarty_tpl->tpl_vars['messagesCount']->value)) {?>
            jQuery('#arcontactus').on('arcontactus.init', function(){
                if (arCuClosedCookie){
                    return false;
                }
                arCuShowMessages();
            });
            jQuery('#arcontactus').on('arcontactus.openMenu', function(){
                clearTimeout(_arCuTimeOut);
                if (!arCuPromptClosed){
                    arCuPromptClosed = true;
                    jQuery('#arcontactus').contactUs('hidePrompt');
                }
            });

            jQuery('#arcontactus').on('arcontactus.hidePrompt', function(){
                clearTimeout(_arCuTimeOut);
                if (arCuClosedCookie != "1"){
                    arCuClosedCookie = "1";
                    <?php if ($_smarty_tpl->tpl_vars['promptConfig']->value->show_after_close != '-1') {?>
                        arCuPromptClosed = true;
                        <?php if ($_smarty_tpl->tpl_vars['promptConfig']->value->show_after_close == '0') {?>
                            arCuCreateCookie('arcu-closed', 1, 0);
                        <?php } else { ?>
                            arCuCreateCookie('arcu-closed', 1, <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['promptConfig']->value->show_after_close)/1440, ENT_QUOTES, 'UTF-8');?>
);
                        <?php }?>
                    <?php }?>
                }
            });
        <?php }?>
        <?php if (($_smarty_tpl->tpl_vars['popupConfig']->value->close_timeout)) {?>
            jQuery('#arcontactus').on('arcontactus.successCallbackRequest', function(){
                closePopupTimeout = setTimeout(function(){
                    jQuery('#arcontactus').contactUs('closeCallbackPopup');
                }, <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['popupConfig']->value->close_timeout)*1000, ENT_QUOTES, 'UTF-8');?>
);
            });
            jQuery('#arcontactus').on('arcontactus.closeCallbackPopup', function(){
                clearTimeout(closePopupTimeout);
            })
        <?php }?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['items']->value, 'item');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
            <?php if (($_smarty_tpl->tpl_vars['item']->value['js'] && $_smarty_tpl->tpl_vars['item']->value['type'] == 3)) {?>
                jQuery('#arcontactus').on('arcontactus.successCallbackRequest', function(){
                    <?php echo $_smarty_tpl->tpl_vars['item']->value['js'];?>

                });
            <?php }?>
            var arcItem = {
            };
            <?php if (($_smarty_tpl->tpl_vars['item']->value['id'])) {?>
                arcItem.id = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['item']->value['id'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['type'] == 1) {?>
                arcItem.onClick = function(e){
                    e.preventDefault();
                    jQuery('#arcontactus').contactUs('closeMenu');
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'tawkto') {?>
                        if (typeof Tawk_API == 'undefined'){
                            console.error('Tawk.to integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        clearInterval(tawkToHideInterval);
                        Tawk_API.showWidget();
                        Tawk_API.maximize();
                        tawkToInterval = setInterval(function(){
                            checkTawkIsOpened();
                        }, 100);
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'crisp') {?>
                        if (typeof $crisp == 'undefined'){
                            console.error('Crisp integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        $crisp.push(["do", "chat:show"]);
                        $crisp.push(["do", "chat:open"]);
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'intercom') {?>
                        if (typeof Intercom == 'undefined'){
                            console.error('Intercom integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        Intercom('show');
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'facebook') {?>
                        if (typeof FB == 'undefined' || typeof FB.CustomerChat == 'undefined'){
                            console.error('Facebook customer chat integration is disabled in module configuration');
                            return false;
                        }
                        clearInterval(hideCustomerChatInterval);
                        jQuery('#arcontactus').contactUs('hide');
                        jQuery('#ar-fb-chat').addClass('active');
                        jQuery('.fb_customer_chat_bubble_animated_no_badge,.fb_customer_chat_bubble_animated_no_badge .fb_dialog_content').addClass('active');
                        setTimeout(function(){
                            FB.CustomerChat.show(true);
                            FB.CustomerChat.showDialog();
                        }, 500);
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'vk') {?>
                        if (typeof vkMessagesWidget == 'undefined'){
                            console.error('VK chat integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        vkMessagesWidget.expand();
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'zopim') {?>
                        <?php if ($_smarty_tpl->tpl_vars['isZendesk']->value) {?>
                            if (typeof zE == 'undefined'){
                                console.error('Zendesk integration is disabled in module configuration');
                                return false;
                            }
                            zE('webWidget', 'show');
                            zE('webWidget', 'open');
                        <?php } else { ?>
                            if (typeof $zopim == 'undefined'){
                                console.error('Zendesk integration is disabled in module configuration');
                                return false;
                            }
                            $zopim.livechat.window.show();
                        <?php }?>
                        jQuery('#arcontactus').contactUs('hide');
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'skype') {?>
                        if (typeof SkypeWebControl == 'undefined'){
                            console.error('Skype integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus-skype').show().addClass('active');
                        SkypeWebControl.SDK.Chat.showChat();
                        SkypeWebControl.SDK.Chat.startChat({
                            ConversationId: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->skype_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
                            ConversationType: 'agent'
                        });
                        skypeWidgetInterval = setInterval(function(){
                            checkSkypeIsOpened();
                        }, 100);
                        jQuery('#arcontactus').contactUs('hide');
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'zalo') {?>
                        if (typeof ZaloSocialSDK == 'undefined'){
                            console.error('Zalo integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        jQuery('#ar-zalo-chat-widget').addClass('active');
                        ZaloSocialSDK.openChatWidget();
                        zaloWidgetInterval = setInterval(function(){
                            checkZaloIsOpened();
                        }, 100);
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'lhc') {?>
                        if (typeof $_LHC == 'undefined'){
                            console.error('Live Helper Chat integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        jQuery('#lhc_container_v2').addClass('active');
                        $_LHC.attributes.mainWidget.show();
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'smartsupp') {?>
                        if (typeof smartsupp == 'undefined'){
                            console.error('Smartsupp chat integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        jQuery('#chat-application').addClass('active');
                        smartsupp('chat:show');
                        smartsupp('chat:open');
                        ssInterval = setInterval(function(){
                            checkSSIsOpened();
                        }, 100);
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'livechat') {?>
                        if (typeof LC_API == 'undefined'){
                            console.error('Live Chat integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        LC_API.open_chat_window();
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'tidio') {?>
                        if (typeof tidioChatApi == 'undefined'){
                            console.error('Tidio integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        tidioChatApi.show();
                        tidioChatApi.open();
                        jQuery('#tidio-chat').addClass('active');
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'livechatpro') {?>
                        if (typeof phpLiveChat == 'undefined'){
                            console.error('Live Chat Pro integration is disabled in module configuration');
                            return false;
                        }
                        <?php if (!$_smarty_tpl->tpl_vars['isMobile']->value) {?>
                            jQuery('#arcontactus').contactUs('hide');
                        <?php }?>
                        jQuery('#customer-chat-iframe').addClass('active');
                        setTimeout(function(){
                            lcpWidgetInterval = setInterval(function(){
                                checkLCPIsOpened();
                            }, 100);
                        }, 500);
                        phpLiveChat.show();
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'livezilla') {?>
                        if (typeof OverlayChatWidgetV2 == 'undefined'){
                            console.error('Live Zilla integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        jQuery('#lz_overlay_wm').addClass('active');
                        OverlayChatWidgetV2.Show();
                        lzWidgetInterval = setInterval(function(){
                            checkLZIsOpened();
                        }, 100);
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'jivosite') {?>
                        if (typeof jivo_api == 'undefined'){
                            console.error('Jivosite integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        jivo_api.open();
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'zoho') {?>
                        if (typeof $zoho == 'undefined'){
                            console.error('Zoho SalesIQ integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        $zoho.salesiq.floatwindow.visible('show');
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'fc') {?>
                        if (typeof fcWidget == 'undefined'){
                            console.error('FreshChat integration is disabled in module configuration');
                            return false;
                        }
                        jQuery('#arcontactus').contactUs('hide');
                        window.fcWidget.show();
                        window.fcWidget.open();
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'phplive') {?>
                        phplive_launch_chat_1();
                        jQuery('#arcontactus').contactUs('hide');
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'paldesk') {?>
                        window.BeeBeeate.widget.openChatWindow();
                        jQuery('#arcontactus').contactUs('hide');
                        paldeskInterval = setInterval(function(){
                            checkPaldeskIsOpened();
                        }, 100);
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'hubspot') {?>
                        window.HubSpotConversations.widget.open();
                        jQuery('#hubspot-messages-iframe-container').addClass('active');
                        jQuery('#arcontactus').contactUs('hide');
                        hubspotInterval = setInterval(function(){
                            checkHubspotIsOpened();
                        }, 200);
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'socialintents') {?>
                        SI_API.showTab();
                        SI_API.showPopup();
                        jQuery('#arcontactus').contactUs('hide');
                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['integration'] == 'botmake') {?>
                        jQuery('#chatWindow').show();
                        jQuery('#arcontactus').contactUs('hide');
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['js']) {?>
                        <?php echo $_smarty_tpl->tpl_vars['item']->value['js'];?>

                    <?php }?>
                }
            <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['js']) {?>
                arcItem.onClick = function(e){
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['type'] == 2) {?>
                        e.preventDefault();
                    <?php }?>
                    <?php echo $_smarty_tpl->tpl_vars['item']->value['js'];?>

                }
            <?php }?>
            arcItem.class = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['item']->value['class'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
            arcItem.title = "<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
";             <?php if (($_smarty_tpl->tpl_vars['item']->value['subtitle'])) {?>
                arcItem.subTitle = "<?php echo $_smarty_tpl->tpl_vars['item']->value['subtitle'];?>
";             <?php }?>
            arcItem.icon = '<?php echo $_smarty_tpl->tpl_vars['item']->value['icon'];?>
';
            arcItem.noContainer = <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['item']->value['no_container']), ENT_QUOTES, 'UTF-8');?>
;
            arcItem.href = '<?php if ($_smarty_tpl->tpl_vars['item']->value['type'] == '3') {?>callback<?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type'] == '0') {
echo $_smarty_tpl->tpl_vars['item']->value['href'];
}?>';
            arcItem.target = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['item']->value['target'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
            arcItem.color = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['item']->value['color'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
            <?php if ($_smarty_tpl->tpl_vars['item']->value['enable_qr'] && !$_smarty_tpl->tpl_vars['isMobile']->value) {?>
            arcItem.addons = [
                {
                    icon: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['path']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
views/img/qr.svg',
                    href: 'javascript:void(0);',
                    class: 'arcu-qr-addon',
                    color: '#000000',
                    target: '_self',
                    onClick: function(){
                        arCuShowQRCode('<?php echo $_smarty_tpl->tpl_vars['item']->value['qr_link'];?>
', "<?php echo $_smarty_tpl->tpl_vars['item']->value['qr_title'];?>
");
                        return false;
                    }
                },
            ];
            <?php }?>
            arcItems.push(arcItem);
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        arcuOptions = {
            drag: <?php if ($_smarty_tpl->tpl_vars['buttonConfig']->value->drag) {?>true<?php } else { ?>false<?php }?>,
            mode: '<?php if ($_smarty_tpl->tpl_vars['buttonConfig']->value->mode) {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['buttonConfig']->value->mode,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');
} else { ?>regular<?php }?>',
            align: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['buttonConfig']->value->position,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            reCaptcha: <?php if ($_smarty_tpl->tpl_vars['popupConfig']->value->recaptcha) {?>true<?php } else { ?>false<?php }?>,
            reCaptchaKey: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->key,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            countdown: <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['popupConfig']->value->timeout), ENT_QUOTES, 'UTF-8');?>
,
            theme: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['buttonConfig']->value->button_color,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            <?php if (($_smarty_tpl->tpl_vars['buttonConfig']->value->button_icon_type == 'builtin')) {?>
                <?php if ($_smarty_tpl->tpl_vars['buttonIcon']->value) {?>
                    buttonIcon: '<?php echo $_smarty_tpl->tpl_vars['buttonIcon']->value;?>
',
                <?php }?>
            <?php } elseif (($_smarty_tpl->tpl_vars['buttonConfig']->value->button_icon_type == 'fa')) {?>
                buttonIcon: '<?php echo $_smarty_tpl->tpl_vars['buttonConfig']->value->button_icon_svg;?>
',
            <?php } elseif (($_smarty_tpl->tpl_vars['buttonConfig']->value->button_icon_type == 'uploaded')) {?>
                buttonIcon: '<img src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['uploadsUrl']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');
echo $_smarty_tpl->tpl_vars['buttonConfig']->value->button_icon_img;?>
" />',
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['menuConfig']->value->menu_header_on) {?>
                showMenuHeader: true,
                menuHeaderText: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['menuConfig']->value->menu_header[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['menuConfig']->value->header_close) {?>
                showHeaderCloseBtn: true,
            <?php } else { ?>
                showHeaderCloseBtn: false,
            <?php }?>
            <?php if (($_smarty_tpl->tpl_vars['menuConfig']->value->header_close_bg)) {?>
                headerCloseBtnBgColor: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['menuConfig']->value->header_close_bg,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            <?php }?>
            <?php if (($_smarty_tpl->tpl_vars['buttonConfig']->value->text[$_smarty_tpl->tpl_vars['id_lang']->value])) {?>
                buttonText: "<?php echo $_smarty_tpl->tpl_vars['buttonConfig']->value->text[$_smarty_tpl->tpl_vars['id_lang']->value];?>
",
            <?php } else { ?>
                buttonText: false,
            <?php }?>
            itemsIconType: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['menuConfig']->value->item_style,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            buttonSize: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['buttonConfig']->value->button_size,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            buttonIconSize: <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['buttonConfig']->value->button_icon_size), ENT_QUOTES, 'UTF-8');?>
,
            menuSize: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['menuConfig']->value->menu_size,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            phonePlaceholder: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->phone_placeholder[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
            callbackSubmitText: "<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['popupConfig']->value->btn_title[$_smarty_tpl->tpl_vars['id_lang']->value],"\r\n",''),"\n",'');?>
",
            errorMessage: "<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['popupConfig']->value->fail_message[$_smarty_tpl->tpl_vars['id_lang']->value],"\r\n",''),"\n",'');?>
",
            callProcessText: "<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['popupConfig']->value->proccess_message[$_smarty_tpl->tpl_vars['id_lang']->value],"\r\n",''),"\n",'');?>
",
            callSuccessText: "<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['popupConfig']->value->success_message[$_smarty_tpl->tpl_vars['id_lang']->value],"\r\n",''),"\n",'');?>
",
            iconsAnimationSpeed: <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['buttonConfig']->value->icon_speed), ENT_QUOTES, 'UTF-8');?>
,
            iconsAnimationPause: <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['buttonConfig']->value->icon_animation_pause), ENT_QUOTES, 'UTF-8');?>
,
            callbackFormText: "<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['popupConfig']->value->message[$_smarty_tpl->tpl_vars['id_lang']->value],"\r\n",''),"\n",'');?>
",
            items: arcItems,
            ajaxUrl: '<?php echo $_smarty_tpl->tpl_vars['ajaxUrl']->value;?>
',             <?php if (($_smarty_tpl->tpl_vars['promptConfig']->value->prompt_position)) {?>
                promptPosition: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['promptConfig']->value->prompt_position,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['menuConfig']->value->menu_style == 1) {?>
                style: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['menuConfig']->value->sidebar_animation,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            <?php } else { ?>
                <?php if ($_smarty_tpl->tpl_vars['menuConfig']->value->popup_animation) {?>
                    popupAnimation: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['menuConfig']->value->popup_animation,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
                <?php }?>
                style: '',
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['menuConfig']->value->items_animation) {?>
                itemsAnimation: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['menuConfig']->value->items_animation,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
',
            <?php }?>
            callbackFormFields: {
                <?php if (($_smarty_tpl->tpl_vars['popupConfig']->value->name)) {?>
                name: {
                    name: 'name',
                    enabled: true,
                    required: <?php if ($_smarty_tpl->tpl_vars['popupConfig']->value->name_required) {?>true<?php } else { ?>false<?php }?>,
                    type: 'text',
                    value: 112,
                    label: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->name_title[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    placeholder: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->name_placeholder[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    <?php if (($_smarty_tpl->tpl_vars['popupConfig']->value->name_validation && $_smarty_tpl->tpl_vars['popupConfig']->value->name_max_len)) {?>
                        maxlength: <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['popupConfig']->value->name_max_len), ENT_QUOTES, 'UTF-8');?>
,
                    <?php }?>
                },
                <?php }?>
                <?php if (($_smarty_tpl->tpl_vars['popupConfig']->value->email_field)) {?>
                email: {
                    name: 'email',
                    enabled: true,
                    required: <?php if ($_smarty_tpl->tpl_vars['popupConfig']->value->email_required) {?>true<?php } else { ?>false<?php }?>,
                    type: 'email',
                    label: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->email_title[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    placeholder: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->email_placeholder[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                },
                <?php }?>
                phone: {
                    name: 'phone',
                    enabled: true,
                    required: true,
                    type: 'tel',
                    label: '',
                    placeholder: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->phone_placeholder[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
                },
                <?php if ($_smarty_tpl->tpl_vars['popupConfig']->value->gdpr) {?>
                gdpr: {
                    name: 'gdpr',
                    enabled: true,
                    required: true,
                    type: 'checkbox',
                    label: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popupConfig']->value->gdpr_title[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                }
                <?php }?>
            },
        };
        jQuery('#arcontactus').contactUs(arcuOptions);
        <?php if ($_smarty_tpl->tpl_vars['tawkToIntegrated']->value) {?>
            window.addEventListener('unreadMessagesCountChanged', function(e){
                jQuery('#arcontactus').contactUs('hide');
                clearInterval(tawkToHideInterval);
                Tawk_API.showWidget();
                Tawk_API.maximize();
                tawkToInterval = setInterval(function(){
                    checkTawkIsOpened();
                }, 100);
            });
            Tawk_API.onChatMinimized = function(){
                Tawk_API.hideWidget();
                jQuery('#arcontactus').contactUs('show');
            };
            Tawk_API.onChatEnded = function(){
                Tawk_API.hideWidget();
                jQuery('#arcontactus').contactUs('show');
            };
            Tawk_API.onChatStarted = function(){
                jQuery('#arcontactus').contactUs('hide');
                clearInterval(tawkToHideInterval);
                Tawk_API.showWidget();
                Tawk_API.maximize();
                tawkToInterval = setInterval(function(){
                    checkTawkIsOpened();
                }, 100);
            };
            <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->tawk_to_userinfo && $_smarty_tpl->tpl_vars['customer']->value->id) {?>
                Tawk_API.visitor = {
                    name : "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    email : '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
'
                };
            <?php }?>
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->tawk_to_custom_script) {?>
                    s1.src='<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
views/js/tawkto.custom.js';
                <?php } else { ?>
                    s1.src='https://embed.tawk.to/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->tawk_to_site_id[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->tawk_to_widget[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
                <?php }?>
                
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['facebookIntegrated']->value) {?>
            var hideCustomerChatInterval;
            FB.Event.subscribe('customerchat.dialogShow', function(){
                jQuery('#ar-fb-chat').addClass('active');
                jQuery('#fb-root').addClass('active');
                jQuery('#arcontactus').contactUs('hide');
                jQuery('.fb_customer_chat_bubble_animated_no_badge,.fb_customer_chat_bubble_animated_no_badge .fb_dialog_content').addClass('active');
            });
            FB.Event.subscribe('customerchat.dialogHide', function(){
                jQuery('#ar-fb-chat').removeClass('active');
                jQuery('#fb-root').removeClass('active');
                jQuery('#arcontactus').contactUs('show');
                jQuery('.fb_customer_chat_bubble_animated_no_badge,.fb_customer_chat_bubble_animated_no_badge .fb_dialog_content').removeClass('active');
                FB.CustomerChat.hide();
            });
                    <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['tidioIntegrated']->value) {?>
            function onTidioChatApiReady(){
                window.tidioChatApi.hide();
                jQuery('#tidio-chat').removeClass('active');
                setTimeout(function(){
                    jQuery('#arcontactus').contactUs('show');
                }, 1000);
            }
            function onTidioChatClose(){
                window.tidioChatApi.hide();
                jQuery('#tidio-chat').removeClass('active');
                jQuery('#arcontactus').contactUs('show');
            }
            if (window.tidioChatApi) {
                window.tidioChatApi.on("ready", onTidioChatApiReady);
                window.tidioChatApi.on("close", onTidioChatClose);
            }else{
                document.addEventListener("tidioChat-ready", onTidioChatApiReady);
                document.addEventListener("tidioChat-close", onTidioChatClose);
            }
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['paldesk']->value) {?>
            window.BeeBeeate.widget.closeChatWindow(function(){
                jQuery('#arcontactus').contactUs('show');
            }, function(error) {

            });
        <?php }?>
    });
    <?php if ($_smarty_tpl->tpl_vars['intercomIntegrated']->value) {?>
        window.intercomSettings = {
            app_id: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->intercom_app_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
            alignment: 'right',     
            horizontal_padding: 20, 
            vertical_padding: 20
        };
        (function() {
            var w = window;
            var ic = w.Intercom;
            if (typeof ic === "function") {
                ic('reattach_activator');
                ic('update', intercomSettings);
            } else {
                var d = document;
                var i = function() {
                    i.c(arguments)
                };
                i.q = [];
                i.c = function(args) {
                    i.q.push(args)
                };
                w.Intercom = i;

                function l() {
                    var s = d.createElement('script');
                    s.type = 'text/javascript';
                    s.async = true;
                    s.src = 'https://widget.intercom.io/widget/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->intercom_app_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
                    var x = d.getElementsByTagName('script')[0];
                    x.parentNode.insertBefore(s, x);
                }
                if (w.attachEvent) {
                    w.attachEvent('onload', l);
                } else {
                    w.addEventListener('load', l, false);
                }
            }
        })();
        Intercom('onHide', function(){
            jQuery('#arcontactus').contactUs('show');
        });
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['vkIntegrated']->value) {?>
        var vkMessagesWidget = VK.Widgets.CommunityMessages("vk_community_messages", <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->vk_page_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
, {
            disableButtonTooltip: 1,
            welcomeScreen: 0,
            expanded: 0,
            buttonType: 'no_button',
            widgetPosition: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['buttonConfig']->value->position,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
'
        });
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['ssIntegrated']->value) {?>
        var _smartsupp = _smartsupp || {};
        _smartsupp.key = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->ss_key,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
        window.smartsupp||(function(d) {
          var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
          s=d.getElementsByTagName('script')[0];c=d.createElement('script');
          c.type='text/javascript';c.charset='utf-8';c.async=true;
          c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
        })(document);
        <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->ss_userinfo && $_smarty_tpl->tpl_vars['customer']->value->id) {?>
            smartsupp('name', "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
");
            smartsupp('email', '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
            smartsupp('variables', {
                accountId: {
                    label: 'Customer ID',
                    value: <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['customer']->value->id), ENT_QUOTES, 'UTF-8');?>

                }
            });
        <?php }?>
        var ssInterval;
        function checkSSIsOpened(){
            if (jQuery('#chat-application').height() < 300){
                jQuery('#arcontactus').contactUs('show');
                clearInterval(ssInterval);
                jQuery('#chat-application').removeClass('active');
            }
        }
        smartsupp('on', 'message', function(model, message) {
            if (message.type == 'agent') {
                jQuery('#chat-application').addClass('active');
                smartsupp('chat:open');
                jQuery('#arcontactus').contactUs('hide');
                setTimeout(function(){
                    ssInterval = setInterval(function(){
                        checkSSIsOpened();
                    }, 100);
                }, 500);
                
            }
        });
        
        function smartsuppOnMessage() {
            setInterval(function(){
                if (jQuery('#chat-application').height() > 200 && !jQuery('#chat-application').hasClass('active')) {
                    // new message received
                    clearInterval(ssInterval);
                    jQuery('#chat-application').addClass('active');
                    smartsupp('chat:open');
                    jQuery('#arcontactus').contactUs('hide');
                    setTimeout(function(){
                        ssInterval = setInterval(function(){
                            checkSSIsOpened();
                        }, 100);
                    }, 500);
                }
            }, 200);
        }
        
        smartsupp('chat:close');
        smartsuppOnMessage();
        
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['tawkToIntegrated']->value) {?>
        var tawkToInterval;
        var tawkToHideInterval;
        
        function tawkToHide(){
            tawkToHideInterval = setInterval(function(){
                if (typeof Tawk_API.hideWidget != 'undefined'){
                    Tawk_API.hideWidget();
                }
            }, 100);
        }
        
        function checkTawkIsOpened(){
            if (Tawk_API.isChatMinimized()){ 
                Tawk_API.hideWidget();
                jQuery('#arcontactus').contactUs('show');
                tawkToHide();
                clearInterval(tawkToInterval);
            }
        }
        tawkToHide();
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['zaloIntegrated']->value) {?>
        var zaloWidgetInterval;
        function checkZaloIsOpened(){
            if (jQuery('#ar-zalo-chat-widget>div').height() < 100){ 
                jQuery('#ar-zalo-chat-widget').removeClass('active');
                jQuery('#arcontactus').contactUs('show');
                clearInterval(zaloWidgetInterval);
            }
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['lhcIntegrated']->value) {?>
        var LHC_API = LHC_API||{};
        LHC_API.args = {
            mode:'widget',
            lhc_base_url:'<?php echo $_smarty_tpl->tpl_vars['liveChatConfig']->value->lhc_uri;?>
',
            wheight:450,
            wwidth:350,
            pheight:520,
            pwidth:500,
            leaveamessage:true,
            department:[
                <?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['liveChatConfig']->value->lhc_department), ENT_QUOTES, 'UTF-8');?>

            ],
            check_messages: true
        };
        (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            var date = new Date();po.src = '<?php echo $_smarty_tpl->tpl_vars['liveChatConfig']->value->lhc_uri;?>
design/defaulttheme/js/widgetv2/index.js?'+(""+date.getFullYear() + date.getMonth() + date.getDate());
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
        setTimeout(() => {
            $_LHC.eventListener.addListener('closeWidget', () => {
                $_LHC.attributes.mainWidget.hide();
                jQuery('#arcontactus').contactUs('show');
                jQuery('#lhc_container_v2').removeClass('active');
            });
            $_LHC.eventListener.addListener('showWidget', () => {
                jQuery('#arcontactus').contactUs('hide');
                jQuery('#lhc_container_v2').addClass('active');
            });
        }, 500);
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['lcIntegrated']->value) {?>
        window.__lc = window.__lc || {};
        window.__lc.license = <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->lc_key,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
;
        (function() {
          var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
          lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
        })();
        var LC_API = LC_API || {};
        var livechat_chat_started = false;
        LC_API.on_before_load = function() {
            LC_API.hide_chat_window();
        };
        LC_API.on_after_load = function() {
            LC_API.hide_chat_window();
            <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->lc_userinfo && $_smarty_tpl->tpl_vars['customer']->value->id) {?>
                LC_API.set_visitor_name('<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
                LC_API.set_visitor_email('<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
            <?php }?>
        };
        LC_API.on_chat_window_minimized = function(){
            LC_API.hide_chat_window();
            jQuery('#arcontactus').contactUs('show');
        };
        LC_API.on_message = function(data) {
            LC_API.open_chat_window();
            jQuery('#arcontactus').contactUs('hide');
        };
        LC_API.on_chat_started = function() {
            livechat_chat_started = true;
        };
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['skypeIntegrated']->value) {?>
        var skypeWidgetInterval;
        function checkSkypeIsOpened(){
            if (jQuery('#arcontactus-skype iframe').hasClass('close-chat')){ 
                jQuery('#arcontactus').contactUs('show');
                jQuery('#arcontactus-skype').hide().removeClass('active');
                clearInterval(skypeWidgetInterval);
            }
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['lcp']->value) {?>
        function checkLCPIsOpened(){
            if (parseInt(jQuery('#customer-chat-iframe').css('bottom')) < -300){ 
                jQuery('#arcontactus').contactUs('show');
                jQuery('#customer-chat-iframe').removeClass('active');
                clearInterval(lcpWidgetInterval);
            }
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['liveZilla']->value) {?>
        function checkLZIsOpened(){
            if (!jQuery('#lz_overlay_chat').is(':visible')){ 
                jQuery('#arcontactus').contactUs('show');
                jQuery('#lz_overlay_wm').removeClass('active');
                clearInterval(lzWidgetInterval);
            }
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['lcp']->value) {?>
    (function(d,t,u,s,e){
        e=d.getElementsByTagName(t)[0];s=d.createElement(t);s.src=u;s.async=1;e.parentNode.insertBefore(s,e);
    })(document,'script','<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->lcp_uri,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['jivosite']->value) {?>
        <?php if (($_smarty_tpl->tpl_vars['liveChatConfig']->value->jivosite_userinfo && $_smarty_tpl->tpl_vars['customer']->value->id)) {?>
            function jivo_onLoadCallback(state) {
                jivo_api.setContactInfo({
                    "name": "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    "email": "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
                }); 
            }
        <?php }?>
        function jivo_onChangeState(state) {
            if (state == 'chat' || state == 'offline' || state == 'introduce') {
                jQuery('.globalClass_ET').addClass('active');
                jQuery('#arcontactus').contactUs('hide');
            }
            if (state == 'call' || state == 'chat/call') {
                jQuery('.globalClass_ET').addClass('active');
                jQuery('#arcontactus').contactUs('hide');
            }
            if (state == 'label' || state == 'chat/min'){
                jQuery('.globalClass_ET').removeClass('active');
                jQuery('#arcontactus').contactUs('show');
            }
        } 
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['zoho']->value) {?>
        var $zoho=$zoho || {};
        $zoho.salesiq = $zoho.salesiq || {widgetcode:"<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->zoho_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.eu/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
        $zoho.salesiq.ready=function(){
            $zoho.salesiq.floatbutton.visible("hide");
            $zoho.salesiq.floatwindow.minimize(function(){
                jQuery('#arcontactus').contactUs('show');
            });
            $zoho.salesiq.floatwindow.close(function(){
                jQuery('#arcontactus').contactUs('show');
            });
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['freshChat']->value) {?>
        function initFreshChat() {
            window.fcWidget.init({
                token: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->fc_token,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                host: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->fc_host,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
            });
            window.fcWidget.on("widget:closed", function(resp) {
                jQuery('#arcontactus').contactUs('show');
            });
                        <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->fc_userinfo && $_smarty_tpl->tpl_vars['customer']->value->id) {?>
                window.fcWidget.user.setProperties({
                    firstName: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    lastName: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    email: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
                });
            <?php }?>
        }
        
        function initialize(i,t){var e;i.getElementById(t)?initFreshChat():((e=i.createElement("script")).id=t,e.async=!0,e.src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->fc_host,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
/js/widget.js",e.onload=initFreshChat,i.head.appendChild(e))}function initiateCall(){initialize(document,"freshchat-js-sdk")}window.addEventListener?window.addEventListener("load",initiateCall,!1):window.attachEvent("load",initiateCall,!1);
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['phplive']->value) {?>
        <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->phplive_userinfo) {?>
                var phplive_v = new Object ;
                phplive_v["name"] = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" ;
                phplive_v["email"] = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" ;
        <?php }?>
        (function() {
            var phplive_href = encodeURIComponent( location.href ) ;
            var phplive_e_1576807307 = document.createElement("script") ;
            phplive_e_1576807307.type = "text/javascript" ;
            phplive_e_1576807307.async = true ;
            phplive_e_1576807307.src = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->phplive_src,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
?v=1%7C1576807307%7C2%7C&r="+phplive_href;
            document.getElementById("phplive_btn_1576807307").appendChild( phplive_e_1576807307 ) ;
            if ( [].filter ) { document.getElementById("phplive_btn_1576807307").addEventListener( "click", function(){ phplive_launch_chat_1() } ) ; } else { document.getElementById("phplive_btn_1576807307").attachEvent( "onclick", function(){ phplive_launch_chat_1() } ) ; }
        })() ;
        function phplive_callback_minimize() {
                jQuery('#arcontactus').contactUs('show');
                phplive_embed_window_close(1);
        }
        function phplive_callback_close() {
                jQuery('#arcontactus').contactUs('show');
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['paldesk']->value) {?>
            <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->paldesk_userinfo && $_smarty_tpl->tpl_vars['customer']->value->id) {?>
                custom_user_data = {
                    externalId: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    email: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    firstname: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                    lastname: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
                };
            <?php }?>
            if("undefined"!==typeof requirejs){
                window.onload=function(e){
                    requirejs(["https://paldesk.io/api/widget-client?apiKey=<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->paldesk_key,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"],function(e){
                        "undefined"!==typeof custom_user_data&&(beebeeate_config.user_data=custom_user_data),BeeBeeate.widget.new(beebeeate_config)
                    })
                };
            }else{
                var s=document.createElement("script");s.async=!0,s.src="https://paldesk.io/api/widget-client?apiKey=<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->paldesk_key,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",s.onload=function(){
                    "undefined"!==typeof custom_user_data&&(beebeeate_config.user_data=custom_user_data),BeeBeeate.widget.new(beebeeate_config)
                };
                if(document.body){
                    document.body.appendChild(s)
                }else if(document.head){
                    document.head.appendChild(s)
                }
            }

            function checkPaldeskIsOpened() {
                if (jQuery('#paldesk-widget-mainframe').height() < 100){ 
                    jQuery('#arcontactus').contactUs('show');
                    clearInterval(paldeskInterval);
                }
            }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['hubspot']->value) {?>
        function checkHubspotIsOpened(){
            if (jQuery('#hubspot-messages-iframe-container').height() < 200){ 
                jQuery('#hubspot-messages-iframe-container').removeClass('active');
                jQuery('#arcontactus').contactUs('show');
                clearInterval(hubspotInterval);
            }
        }
        if (window.HubSpotConversations) {
            initHubspotEvents();
        } else {
            window.hsConversationsOnReady = [
                () => {
                    initHubspotEvents();
                },
            ];
        }
        function initHubspotEvents(){
            window.HubSpotConversations.on('conversationStarted', payload => {
                jQuery('#arcontactus').contactUs('hide');
                jQuery('#hubspot-messages-iframe-container').addClass('active');
                window.HubSpotConversations.widget.open();
                hubspotInterval = setInterval(function(){
                    checkHubspotIsOpened();
                }, 200);
            });
            window.HubSpotConversations.on('unreadConversationCountChanged', payload => {
                jQuery('#arcontactus').contactUs('hide');
                jQuery('#hubspot-messages-iframe-container').addClass('active');
                window.HubSpotConversations.widget.open();
                hubspotInterval = setInterval(function(){
                    checkHubspotIsOpened();
                }, 200);
            });
        }
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['socialintents']->value) {?>
        function onSIApiReady() {
            SI_API.hidePopup();
            SI_API.hideTab();
            setTimeout(function(){
                SI_API.hidePopup();
                SI_API.hideTab();
            }, 200);
            <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->socialintents_userinfo && $_smarty_tpl->tpl_vars['customer']->value->id) {?>
                SI_API.setChatInfo("<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
", '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
            <?php }?>
            SI_API.onChatClosed = function(){
                SI_API.hideTab();
                SI_API.hidePopup();
                jQuery('#arcontactus').contactUs('show');
            };
            SI_API.onChatOpened = function(){
                jQuery('#arcontactus').contactUs('hide');
                SI_API.showTab();
            };
        };
        
    <?php }
echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['liveZilla']->value) {?>
    <?php echo '<script'; ?>
 type="text/javascript" id="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->getLiveZillaId(),'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->lz_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"><?php echo '</script'; ?>
>
<?php }
if ($_smarty_tpl->tpl_vars['zopimIntegrated']->value) {?>
    <?php if ($_smarty_tpl->tpl_vars['isZendesk']->value) {?>
        <!--script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->zopim_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"> <?php echo '</script'; ?>
 -->
        <?php echo '<script'; ?>
 type="text/javascript">
            (function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
            d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
            _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");$.setAttribute("id","ze-snippet");
            $.src="https://static.zdassets.com/ekr/snippet.js?key=<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->zopim_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
";z.t=+new Date;$.
            type="text/javascript";e.parentNode.insertBefore($,e);$.addEventListener('load', function(){
                zE('webWidget:on', 'chat:connected', function(){
                    zE('webWidget', 'hide');
                });
                zE('webWidget:on', 'open', function(){
                    jQuery('#arcontactus').contactUs('hide');
                });
                zE('webWidget:on', 'close', function(){
                    zE('webWidget', 'hide');
                    jQuery('#arcontactus').contactUs('show');
                });
                zE('webWidget:on', 'chat:unreadMessages', function(msgs){
                    jQuery('#arcontactus').contactUs('hide');
                    zE('webWidget', 'show');
                    zE('webWidget', 'open');
                });
                <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->zopim_userinfo && $_smarty_tpl->tpl_vars['customer']->value->id) {?>
                    zE('webWidget', 'identify', {
                        name: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->firstname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->lastname,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
                        email: '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['customer']->value->email,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
'
                    });
                <?php }?>
                }) 
            })(document,"script");
        <?php echo '</script'; ?>
>
    <?php } else { ?>
        <?php echo '<script'; ?>
 type="text/javascript">
            window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
            d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
            _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
            $.src="https://v2.zopim.com/?<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->zopim_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
";z.t=+new Date;$.
            type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
            $zopim(function(){
                $zopim.livechat.hideAll();
                <?php if ($_smarty_tpl->tpl_vars['buttonConfig']->value->position == 'left') {?>
                    $zopim.livechat.window.setPosition('bl');
                <?php } else { ?>
                    $zopim.livechat.window.setPosition('br');
                <?php }?>
                $zopim.livechat.window.onHide(function(){
                    $zopim.livechat.hideAll();
                    jQuery('#arcontactus').contactUs('show');
                });
            });
        <?php echo '</script'; ?>
>
    <?php }
}?>

<?php if ($_smarty_tpl->tpl_vars['crispIntegrated']->value) {?>
    <?php echo '<script'; ?>
 type="text/javascript">
        window.$crisp=[];window.CRISP_WEBSITE_ID="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->crisp_site_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
";(function(){
            d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);
        })();
        $crisp.push(["on", "session:loaded", function(){
            $crisp.push(["do", "chat:hide"]);
        }]);
        $crisp.push(["on", "chat:closed", function(){
            $crisp.push(["do", "chat:hide"]);
            jQuery('#arcontactus').contactUs('show');
        }]);
        $crisp.push(["on", "message:received", function(){
            $crisp.push(["do", "chat:show"]);
            jQuery('#arcontactus').contactUs('hide');
        }]);
    <?php echo '</script'; ?>
>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['facebookIntegrated']->value) {?>
    <style type="text/css">#ar-fb-chat{display: none;}#ar-fb-chat.active{display: block;}</style>
    <div id="ar-fb-chat">
        <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_init) {?>
            <?php echo '<script'; ?>
>
                <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_one_line) {?>
                    (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/<?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_lang[$_smarty_tpl->tpl_vars['id_lang']->value]) {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_lang[$_smarty_tpl->tpl_vars['id_lang']->value],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');
} else { ?>en_US<?php }?>/sdk/xfbml.customerchat.js#xfbml=<?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_xfbml) {?>1<?php } else { ?>0<?php }?>&version=v<?php if (call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_version,'htmlall','UTF-8' ))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_version, ENT_QUOTES, 'UTF-8');
} else { ?>10.0<?php }?>&autoLogAppEvents=1";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk-chat'));
                <?php } else { ?>
                    window.fbAsyncInit = function() {
                        FB.init({
                            xfbml            : <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_xfbml) {?>true<?php } else { ?>false<?php }?>,
                            version          : 'v<?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_version) {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_version,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');
} else { ?>10.0<?php }?>'
                        });
                    };

                    (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk-chat'));
                <?php }?>
            <?php echo '</script'; ?>
>
        <?php }?>
        <div class="fb-customerchat" page_id="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_page_id,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_color) {?>theme_color="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['liveChatConfig']->value->fb_color,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"<?php }?>></div>
    </div>
<?php }
}
}
