/**
 * 2007-2021 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2021 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

$(document).on('click','.btn_add_edit',function(){
    if(!$(this).hasClass('loading')) {
        $(this).addClass('loading');
        var btn = $(this);
        $.ajax({
            url: $(this).attr('data-href'),
            type: 'post',
            dataType: 'json',
            success: function(json)
            {
                if(json && json.html){
                    var html = '<div class="wrap_form_add">'+json.html+'</div>';
                    var select = $(html).find('form').clone(true);
                    $('.ets_homecat_form_banner .panel').replaceWith(select);
                }
                else
                {
                    $("#growls").remove();
                    showErrorMessage(json.msg);
                    btn.removeClass('loading');
                }
            },
            error: function(json)
            {
                $("#growls").remove();
                showErrorMessage(json.msg);
                btn.removeClass('loading');
            }
        });
    }
    return false;
});

$(document).on('click','button[name="saveBanner"]',function(){
    var self = $(this);
    var formData = new FormData(self.parents('form').get(0));
    formData.append('save_banner', true);
    if(!self.hasClass('loading')) {
        self.addClass('loading');
        $.ajax({
            url: homecat_banner_ajax_url,
            data: formData,
            type: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(json)
            {
                if(json.success){
                    $("#growls").remove();
                    showSuccessMessage(json.success);
                    if(json.html){
                        $('.ets_homecat_form_banner .panel').replaceWith(json.html);
                    }
                } else{
                    $("#growls").remove();
                    showErrorMessage(json.error);
                }
                self.removeClass('loading');
            },
            error: function(json)
            {
                self.removeClass('loading');
            }
        });
    }
    return false;
});
$(document).on('click','.back_to_list',function(){
    if(!$(this).hasClass('loading'))
    {
        $(this).addClass('loading');
        $.ajax({
            url: $(this).attr('href'),
            type: 'post',
            dataType: 'json',
            success: function(json)
            {
                if(json && json.html)
                {
                    $('.ets_homecat_form_banner .panel').replaceWith(json.html);
                }
                $('.back_to_list').removeClass('loading');
            },
            error: function(json)
            {
                $('.back_to_list').removeClass('loading');
            }
        });
    }
    return false;
});
$(document).on('click','.btn_delete_banner',function(){
    if(!$(this).hasClass('loading'))
    {
        $(this).addClass('loading');
        $.ajax({
            url: $(this).attr('data-href'),
            type: 'post',
            dataType: 'json',
            success: function(json)
            {
                if(json && json.success){
                    $("#growls").remove();
                    showSuccessMessage(json.success);
                }else{
                    $("#growls").remove();
                    showErrorMessage(json.error);
                }

                if(json && json.html)
                {
                    $('.ets_homecat_form_banner .panel').replaceWith(json.html);
                }
                $('.btn_delete_banner').removeClass('loading');
            },
            error: function(json)
            {
                $('.btn_delete_banner').removeClass('loading');
            }
        });
    }
    return false;
});
function readFileURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $(input).parents('.file_input').eq(0).children('.hc-img-preview').eq(0).removeClass('hide').children('.img-thumbnail').eq(0).attr('src', e.target.result).next('.delbanner').removeClass('hide');
    }
    reader.readAsDataURL(input.files[0]);
  }
}
