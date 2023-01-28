{*
* 2017 Azelab
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@areama.net so we can send you a copy immediately.
*
*
*  @author Azelab <support@azelab.com>
*  @copyright  2017 Azelab
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of Azelab
*}
<style>
    #arcontactus-config-tabs{
        opacity: 0;
        transition: 0.2s all;
    }
    #arcontactus-config-tabs.active{
        opacity: 1;
    }
    #arcontactus-config .form-group .form-group{
        margin-bottom: 0;
    }
    #arcontactus-config .form-group .form-group .color{
        margin-left: 5px;
    }
    #arcu-schedule-group .cbx{
        margin-bottom: 0;
        margin-right: 10px;
        margin-top: 7px;
    }
</style>
<div class="row" id="arcontactus-config">
    <div class="col-lg-2 col-md-3">
        <div class="list-group arcontactusTabs">
            <a class="list-group-item {if empty($active_tab) or $active_tab == 'ArContactUsGeneralConfig'}active{/if}" data-tab="0" id="arcontactus-tab-0" data-target="arcontactus-general" href="#">
                <i class="icon-cog"></i> {l s='General configuration' mod='arcontactus'}
            </a>
            <a class="list-group-item {if $active_tab == 'ArContactUsButtonConfig' || $active_tab == 'ArContactUsButtonMobileConfig'}active{/if}" data-tab="1" id="arcontactus-tab-1" data-target="arcontactus-button" href="#">
                <i class="icon-cog"></i> {l s='Button settings' mod='arcontactus'}
            </a>
            <a class="list-group-item {if $active_tab == 'ArContactUsMenuConfig' || $active_tab == 'ArContactUsMenuMobileConfig'}active{/if}" data-tab="2" id="arcontactus-tab-2" data-target="arcontactus-menu" href="#">
                <i class="icon-cog"></i> {l s='Menu settings' mod='arcontactus'}
            </a>
            <a class="list-group-item {if $active_tab == 'ArContactUsCallbackConfig'}active{/if}" data-tab="3" id="arcontactus-tab-3" data-target="arcontactus-callback" href="#">
                <i class="icon-cog"></i> {l s='Callback popup settings' mod='arcontactus'}
            </a>
            <a class="list-group-item {if $active_tab == 'ArContactUsLiveChatConfig'}active{/if}" data-tab="2" data-target="arcontactus-livechat" href="#">
                <i class="icon-cog"></i> {l s='Live chat integrations' mod='arcontactus'}
            </a>
            <a class="list-group-item {if $active_tab == 'ArContactUsPromptConfig' || $active_tab == 'ArContactUsPromptMobileConfig'}active{/if}" data-tab="4" id="arcontactus-tab-4" data-target="arcontactus-prompt" href="#">
                <i class="icon-cog"></i> {l s='Prompt settings' mod='arcontactus'}
            </a>
            <a class="list-group-item" data-tab="4" id="arcontactus-tab-4" data-target="arcontactus-prompt-items" href="#">
                <i class="icon-cog"></i> {l s='Prompt messages' mod='arcontactus'}
            </a>
            <a class="list-group-item" data-tab="4" id="arcontactus-tab-4" data-target="arcontactus-items" href="#">
                <i class="icon-cog"></i> {l s='Menu items' mod='arcontactus'}
            </a>
            <a class="list-group-item {if $active_tab == 'callbacks'}active{/if}" data-tab="5" id="arcontactus-tab-5" data-target="arcontactus-callbacks" href="#">
                <i class="icon-cog"></i> {l s='Callback requests' mod='arcontactus'}
            </a>
            <a class="list-group-item" data-tab="10" id="arcontactus-tab-10" data-target="arcontactus-about" href="#">
                <i class="icon-info"></i> {l s='About' mod='arcontactus'}
            </a>
        </div>
    </div>
    <div class="col-lg-10 col-md-9" id="arcontactus-config-tabs">
        {include file="./_partials/_general.tpl"}
        {include file="./_partials/_button.tpl"}
        {include file="./_partials/_menu.tpl"}
        {include file="./_partials/_livechat.tpl"}
        {include file="./_partials/_callback.tpl"}
        {include file="./_partials/_prompt.tpl"}
        {include file="./_partials/_prompt_items.tpl"}
        {include file="./_partials/_items.tpl"}
        {include file="./_partials/_callbacks.tpl"}
        {include file="./_partials/_about.tpl"}
    </div>
</div>

<script type="text/javascript">
    var max_image_size = {$max_image_size|escape:'htmlall':'UTF-8'};
    window.addEventListener('load', function(){
        arCU.ajaxUrl = '{$link->getAdminLink('AdminArContactUs') nofilter}'; {* URL generated by Link object, no escape necessary. Escaping will break functionality *}
        arCU.prompt.ajaxUrl = '{$link->getAdminLink('AdminArContactUsPrompt') nofilter}'; {* URL generated by Link object, no escape necessary. Escaping will break functionality *}
        arCU.addTitle = "{l s='Add new item' mod='arcontactus'}";
        arCU.editTitle = "{l s='Edit item' mod='arcontactus'}";
        arCU.successSaveMessage = "{l s='Item saved' mod='arcontactus'}";
        arCU.successOrderMessage = "{l s='Order updated' mod='arcontactus'}";
        arCU.successDeleteMessage = "{l s='Item deleted' mod='arcontactus'}";
        arCU.errorMessage = "{l s='Error has occured' mod='arcontactus'}";
        $(".arcontactusTabs a").click(function(e){
            e.preventDefault();
            $(".arcontactusTabs .active").removeClass('active');
            $(this).addClass('active');
            if ($(this).data('target') == 'arcontactus-callbacks') {
                arCU.callback.reload();
            }
            $('#arcontactus-config .arcontactus-config-panel').addClass('hidden');
            $('#' + $(this).data('target')).removeClass('hidden');
            $('#arcontactusActiveTab').remove();
            $('#arcontactusActiveTab').val($(this).data('tab'));
        });
        $('.arcontactusTabs .active').trigger('click');
        arContactUsSwitchFields();
        arcuLoadModules();
        switchMenuStyle();
        switchButtonIconType();
        $('.field_menu_style select').change(function(){
            switchMenuStyle();
        });
        $('.field_button_icon_type select').change(function(){
            switchButtonIconType();
        });
        $('.prestashop-switch').click(function(){
            arContactUsSwitchFields();
        });
        {if !$onesignalInstalled}
            $('#arcontactus-callback .field_onesignal').remove();
        {/if}
        $('#arcontactus-config-tabs').addClass('active');
        arCU.init();
        $('.time-mask').mask('XX:XX:XX');
        var currentTime = '{$currentTime|escape:'htmlall':'UTF-8'}';
        var currentMoment = moment(currentTime, 'kk:mm:ss');
        $('#arcontactus_uploaded_img').fileupload({
            dataType: 'json',
            async: false,
            autoUpload: false,
            singleFileUploads: true,
            maxFileSize: max_image_size,
            done: function (e, data){
                var images = data.result.arcontactus_uploaded_img;
                $.each(images, function(){
                    if (this.error){
                        $('#arcontactus_uploaded_img-errors').append('<div class="form-group"><strong>'+this.name+'</strong> ('+humanizeSize(this.size)+') : '+this.error+'</div>').parent().show();
                    }else{
                        $('#arcontactus_uploaded_img_list').html('<img width="120" src="' + this.url + '" />');
                        $('#arcontactus_icon_img').val(this.filename);
                    }
                });
                $('#arcontactus_uploaded_img-files-list').html('');
            },
            fail: function (e, data) {
                $('#arcontactus_uploaded_img-errors').html(data.errorThrown.message).parent().show();
            }
        });
        
        setInterval(function(){
            $('#server-time').text(currentMoment.add(1, 'seconds').format('kk:mm:ss'));
        }, 1000);
    });
    
    function arContactUsSwitchFields(){
        if ($('#ARCUC_EMAIL_on').is(':checked')){
            $('.field_email_list').removeClass('hidden');
        }else{
            $('.field_email_list').addClass('hidden');
        }
        
        if ($('#ARCUC_RECAPTCHA_on').is(':checked')){
            $('.field_key, .field_secret').removeClass('hidden');
        }else{
            $('.field_key, .field_secret').addClass('hidden');
        }
        
        if ($('#ARCUC_TWILIO_on').is(':checked')){
            $('.field_twilio_api_key, .field_twilio_auth_token, .field_twilio_phone, .field_twilio_tophone, .field_twilio_message').removeClass('hidden');
        }else{
            $('.field_twilio_api_key, .field_twilio_auth_token, .field_twilio_phone, .field_twilio_tophone, .field_twilio_message').addClass('hidden');
        }
        
        if ($('#ARCUPR_LOOP_on').is(':checked')){
            $('.field_close_last').addClass('hidden');
        }else{
            $('.field_close_last').removeClass('hidden');
        }
        
        if ($('#ARCUC_PHONE_MASK_ON_on').is(':checked')){
            $('.field_phone_mask, .field_maskedinput').removeClass('hidden');
        }else{
            $('.field_phone_mask, .field_maskedinput').addClass('hidden');
        }
        
        if ($('#ARCUL_TAWK_TO_ON_on').is(':checked')){
            $('.field_tawk_to_site_id, .field_tawk_to_widget, .field_tawk_to_userinfo').removeClass('hidden');
        }else{
            $('.field_tawk_to_site_id, .field_tawk_to_widget, .field_tawk_to_userinfo').addClass('hidden');
        }
        
        if ($('#ARCUL_CRISP_ON_on').is(':checked')){
            $('.field_crisp_site_id').removeClass('hidden');
        }else{
            $('.field_crisp_site_id').addClass('hidden');
        }
        
        if ($('#ARCUL_INTERCOM_ON_on').is(':checked')){
            $('.field_intercom_app_id').removeClass('hidden');
        }else{
            $('.field_intercom_app_id').addClass('hidden');
        }
        
        if ($('#ARCUL_FB_ON_on').is(':checked')){
            $('.field_fb_page_id, .field_fb_init, .field_fb_lang, .field_fb_color').removeClass('hidden');
        }else{
            $('.field_fb_page_id, .field_fb_init, .field_fb_lang, .field_fb_color').addClass('hidden');
        }
        
        if ($('#ARCUL_VK_ON_on').is(':checked')){
            $('.field_vk_page_id').removeClass('hidden');
        }else{
            $('.field_vk_page_id').addClass('hidden');
        }
        
        if ($('#ARCUL_ZOPIM_ON_on').is(':checked')){
            $('.field_zopim_id, .field_zopim_userinfo').removeClass('hidden');
        }else{
            $('.field_zopim_id, .field_zopim_userinfo').addClass('hidden');
        }
        
        if ($('#ARCUL_SKYPE_ON_on').is(':checked')){
            $('.field_skype_type, .field_skype_id, .field_skype_message_color').removeClass('hidden');
        }else{
            $('.field_skype_type, .field_skype_id, .field_skype_message_color').addClass('hidden');
        }
        
        if ($('#ARCUL_ZALO_ON_on').is(':checked')){
            $('.field_zalo_id, .field_zalo_welcome, .field_zalo_width, .field_zalo_height').removeClass('hidden');
        }else{
            $('.field_zalo_id, .field_zalo_welcome, .field_zalo_width, .field_zalo_height').addClass('hidden');
        }
        
        if ($('#ARCUL_LHC_ON_on').is(':checked')){
            $('.field_lhc_uri, .field_lhc_width, .field_lhc_height, .field_lhc_popup_width, .field_lhc_popup_height').removeClass('hidden');
        }else{
            $('.field_lhc_uri, .field_lhc_width, .field_lhc_height, .field_lhc_popup_width, .field_lhc_popup_height').addClass('hidden');
        }
        
        if ($('#ARCUL_SS_ON_on').is(':checked')){
            $('.field_ss_key, .field_ss_userinfo').removeClass('hidden');
        }else{
            $('.field_ss_key, .field_ss_userinfo').addClass('hidden');
        }
        
        if ($('#ARCUL_LC_ON_on').is(':checked')){
            $('.field_lc_key, .field_lc_userinfo').removeClass('hidden');
        }else{
            $('.field_lc_key, .field_lc_userinfo').addClass('hidden');
        }
        
        if ($('#ARCUL_TIDIO_ON_on').is(':checked')){
            $('.field_tidio_key, .field_tidio_userinfo').removeClass('hidden');
        }else{
            $('.field_tidio_key, .field_tidio_userinfo').addClass('hidden');
        }
        
        if ($('#ARCUL_LCP_ON_on').is(':checked')){
            $('.field_lcp_uri').removeClass('hidden');
        }else{
            $('.field_lcp_uri').addClass('hidden');
        }
        
        if ($('#ARCUL_LZ_ON_on').is(':checked')){
            $('.field_lz_id').removeClass('hidden');
        }else{
            $('.field_lz_id').addClass('hidden');
        }
        
        if (jQuery('#ARCUL_JIVOSITE_ON_on').is(':checked')){
            jQuery('.field_jivosite_id, .field_jivosite_userinfo').removeClass('hidden');
        }else{
            jQuery('.field_jivosite_id, .field_jivosite_userinfo').addClass('hidden');
        }
        
        if (jQuery('#ARCUL_ZOHO_ON_on').is(':checked')){
            jQuery('.field_zoho_id').removeClass('hidden');
        }else{
            jQuery('.field_zoho_id').addClass('hidden');
        }
        
        if (jQuery('#ARCUL_FC_ON_on').is(':checked')){
            jQuery('.field_fc_token, .field_fc_host, .field_fc_userinfo').removeClass('hidden');
        }else{
            jQuery('.field_fc_token, .field_fc_host, .field_fc_userinfo').addClass('hidden');
        }
        
        if (jQuery('#ARCUL_PHPLIVE_ON_on').is(':checked')){
            jQuery('.field_phplive_src, .field_phplive_userinfo').removeClass('hidden');
        }else{
            jQuery('.field_phplive_src, .field_phplive_userinfo').addClass('hidden');
        }
        
        if (jQuery('#ARCUL_PALDESK_ON_on').is(':checked')){
            jQuery('.field_paldesk_key, .field_paldesk_userinfo').removeClass('hidden');
        }else{
            jQuery('.field_paldesk_key, .field_paldesk_userinfo').addClass('hidden');
        }
        
        if (jQuery('#ARCUL_HUBSPOT_ON_on').is(':checked')){
            jQuery('.field_hubspot_id, .field_hubspot_userinfo').removeClass('hidden');
        }else{
            jQuery('.field_hubspot_id, .field_hubspot_userinfo').addClass('hidden');
        }
        
        if (jQuery('#ARCUL_SOCIALINTENTS_ON_on').is(':checked')){
            jQuery('.field_socialintents_id, .field_socialintents_userinfo').removeClass('hidden');
        }else{
            jQuery('.field_socialintents_id, .field_socialintents_userinfo').addClass('hidden');
        }
        
        if (jQuery('#ARCUC_NAME_on').is(':checked')){
            jQuery('.field_name_required, .field_name_title, .field_name_placeholder, .field_name_validation').removeClass('hidden');
            switchValidationFields();
        }else{
            jQuery('.field_name_required, .field_name_title, .field_name_placeholder, .field_name_validation, .field_name_max_len, .field_name_filter_laters').addClass('hidden');
        }
        
        
        if (jQuery('#ARCUC_EMAIL_FIELD_on').is(':checked')){
            jQuery('.field_email_required, .field_email_title, .field_email_placeholder').removeClass('hidden');
        }else{
            jQuery('.field_email_required, .field_email_title, .field_email_placeholder').addClass('hidden');
        }
        
        if (jQuery('#ARCUC_TG_on').is(':checked')){
            jQuery('.field_tg_token, .field_tg_chat_id, .field_tg_text').removeClass('hidden');
        }else{
            jQuery('.field_tg_token, .field_tg_chat_id, .field_tg_text').addClass('hidden');
        }
        
        if ($('#ARCUC_GDPR_on').is(':checked')){
            $('.field_gdpr_title').removeClass('hidden');
        }else{
            $('.field_gdpr_title').addClass('hidden');
        }
        
        if ($('#ARCUM_MENU_HEADER_ON_on').is(':checked')){
            $('#arcu-menu-desktop .field_menu_header, #arcu-menu-desktop .field_header_close, #arcu-menu-desktop .field_header_close_bg, #arcu-menu-desktop .field_header_close_color').removeClass('hidden');
        }else{
            $('#arcu-menu-desktop .field_menu_header, #arcu-menu-desktop .field_header_close, #arcu-menu-desktop .field_header_close_bg, #arcu-menu-desktop .field_header_close_color').addClass('hidden');
        }
        
        if ($('#ARCUMM_MENU_HEADER_ON_on').is(':checked')){
            $('#arcu-menu-mobile .field_menu_header, #arcu-menu-mobile .field_header_close, #arcu-menu-mobile .field_header_close_bg, #arcu-menu-mobile .field_header_close_color').removeClass('hidden');
        }else{
            $('#arcu-menu-mobile .field_menu_header, #arcu-menu-mobile .field_header_close, #arcu-menu-mobile .field_header_close_bg, #arcu-menu-mobile .field_header_close_color').addClass('hidden');
        }
        
        if ($('#ARCU_SANDBOX_on').is(':checked')){
            $('.field_allowed_ips').removeClass('hidden');
        }else{
            $('.field_allowed_ips').addClass('hidden');
        }
        
        if ($('#ARCU_ALWAYS_on').is(':checked')){
            $('#arcu-schedule-group').addClass('hidden');
            $('#arcontactus_always').val(1);
        }else{
            $('#arcu-schedule-group').removeClass('hidden');
            $('#arcontactus_always').val(0);
        }
        
        if ($('#ARCU_enable_qr_on').is(':checked')){
            $('#arcu-qr-group').removeClass('hidden');
            $('#arcontactus_enable_qr').val(1);
        }else{
            $('#arcu-qr-group').addClass('hidden');
            $('#arcontactus_enable_qr').val(0);
        }
        
        if ($('#ARCU_product_page_on').is(':checked')){
            $('#arcontactus_product_page').val(1);
        }else{
            $('#arcontactus_product_page').val(0);
        }
        if ($('#ARCU_no_container_on').is(':checked')){
            $('#arcontactus_no_container').val(1);
        }else{
            $('#arcontactus_no_container').val(0);
        }
    }
    
    function switchButtonIconType(){
        if ($('#ARCUB_BUTTON_ICON_TYPE').val() == 'builtin') {
            $('#arcu-button-desktop .field_button_icon').removeClass('hidden');
            $('#arcu-button-desktop .field_button_icon_img').addClass('hidden');
            $('#arcu-button-desktop .field_button_icon_svg').addClass('hidden');
            $('#arcu-button-desktop .field_button_icon_preview').addClass('hidden');
        } else if ($('#ARCUB_BUTTON_ICON_TYPE').val() == 'fa') {
            $('#arcu-button-desktop .field_button_icon').addClass('hidden');
            $('#arcu-button-desktop .field_button_icon_img').addClass('hidden');
            $('#arcu-button-desktop .field_button_icon_svg').removeClass('hidden');
            $('#arcu-button-desktop .field_button_icon_preview').addClass('hidden');
        } else if ($('#ARCUB_BUTTON_ICON_TYPE').val() == 'uploaded') {
            $('#arcu-button-desktop .field_button_icon').addClass('hidden');
            $('#arcu-button-desktop .field_button_icon_img').removeClass('hidden');
            $('#arcu-button-desktop .field_button_icon_svg').addClass('hidden');
            $('#arcu-button-desktop .field_button_icon_preview').removeClass('hidden');
        }
        
        if ($('#ARCUBM_BUTTON_ICON_TYPE').val() == 'builtin') {
            $('#arcu-button-mobile .field_button_icon').removeClass('hidden');
            $('#arcu-button-mobile .field_button_icon_svg').addClass('hidden');
            $('#arcu-button-mobile .field_button_icon_img').addClass('hidden');
            $('#arcu-button-mobile .field_button_icon_preview').addClass('hidden');
        } else if ($('#ARCUBM_BUTTON_ICON_TYPE').val() == 'fa') {
            $('#arcu-button-mobile .field_button_icon').addClass('hidden');
            $('#arcu-button-mobile .field_button_icon_svg').removeClass('hidden');
            $('#arcu-button-mobile .field_button_icon_img').addClass('hidden');
            $('#arcu-button-mobile .field_button_icon_preview').addClass('hidden');
        } else if ($('#ARCUBM_BUTTON_ICON_TYPE').val() == 'uploaded') {
            $('#arcu-button-mobile .field_button_icon').addClass('hidden');
            $('#arcu-button-mobile .field_button_icon_img').removeClass('hidden');
            $('#arcu-button-mobile .field_button_icon_svg').addClass('hidden');
            $('#arcu-button-mobile .field_button_icon_preview').removeClass('hidden');
        }
    }
    
    function switchMenuStyle(){
        if ($('#ARCUM_MENU_STYLE').val() == 0) {
            $('#arcu-menu-desktop .field_sidebar_animation').addClass('hidden');
            $('#arcu-menu-desktop .field_popup_animation').removeClass('hidden');
        } else {
            $('#arcu-menu-desktop .field_sidebar_animation').removeClass('hidden');
            $('#arcu-menu-desktop .field_popup_animation').addClass('hidden');
        }
        
        if ($('#ARCUMM_MENU_STYLE').val() == 0) {
            $('#arcu-menu-mobile .field_sidebar_animation').addClass('hidden');
            $('#arcu-menu-mobile .field_popup_animation').removeClass('hidden');
        } else {
            $('#arcu-menu-mobile .field_sidebar_animation').removeClass('hidden');
            $('#arcu-menu-mobile .field_popup_animation').addClass('hidden');
        }
    }
    
    function switchValidationFields(){
        if (jQuery('#ARCUC_NAME_VALIDATION_on').is(':checked')){
            jQuery('.field_name_max_len, .field_name_filter_laters').removeClass('hidden');
        }else{
            jQuery('.field_name_max_len, .field_name_filter_laters').addClass('hidden');
        }
    }
    
    function arcuLoadModules(){
        $.post(
            arCU.ajaxUrl, {
                action: 'loadModules',
                ajax: true
            }, function(data){
                $('#areama-modules').html(data.content);
            }, 'json'
        );
    }
</script>