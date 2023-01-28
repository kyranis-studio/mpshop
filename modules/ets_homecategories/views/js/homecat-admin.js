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
$(document).on('click','.ets_homecat_form_tab > li',function(){
    if(!$(this).hasClass('active'))
    {
        $('.ets_homecat_form_tab > li').removeClass('active');
        $('.ets_homecat_form > div').removeClass('active');
        $(this).addClass('active');
        $('.ets_homecat_form > div.ets_homecat_form_'+$(this).attr('data-tab')).addClass('active');
        $('input[name="ETS_HOMECAT_CURENT_ACTIVE"]').val($(this).attr('data-tab'));
        if ($(this).attr('data-tab') == 'banner'){
            $('form').addClass('active_tab_banner');
        }else {
            $('form').removeClass('active_tab_banner');
        }
    }
});
$(document).on('change','input[name="ETS_HOMECAT_CATEGORIES[]"],input[name="ETS_HOMECAT_PRODUCTS_TABS[]"]',function(){
    if($(this).is(':checked'))
    {
        if($(this).parent('label').length > 0)
            var label = $(this).parent('label').children('.label-text').text();
        else
            var label = $(this).parent('span').children('label').text().replace(/\(.*\)/,'');
        var li = '<li class="hc-sortable" data-id-category="'+$(this).val()+'">'+label+'<span class="hc-delete">'+hc_dekete_title+'</span></li>';
        if(parseInt($(this).val())<0 && $('.featured-tab').length > 0)
            $('.featured-tab').append(li);
        else
            $('.categories-tab').append(li);
    }
    else
        if($('.hc-sort-tab > li[data-id-category="'+$(this).val()+'"]').length > 0)
            $('.hc-sort-tab > li[data-id-category="'+$(this).val()+'"]').remove();
        if($(this).val()==0)
        {
            if($(this).is(':checked'))
                $(this).parent('.tree-item-name').addClass('tree-selected');
            else
                $(this).parent('.tree-item-name').removeClass('tree-selected');
        }

    loadFormSpecifyProduct();
    renderIdStr();
    sortTabs();
});
$(document).on('change','input[name="ETS_HOMECAT_LAYOUT"]',function(){
    var layout = $(this).val();
    if((layout=='LIST' || layout=='TAB') && $('.featured-tab').length > 0)
    {
        if($('input[name="ETS_HOMECAT_BLOCK_SORT"]').val()=='FEATURE_ABOVE')
            $('.categories-tab').prepend($('.featured-tab').html());
        else
            $('.categories-tab').append($('.featured-tab').html());
        $('.categories-block > div').text(hc_tab_mix_title);
        $('.featured-block').remove();
    }
    if((layout!='LIST' && layout!='TAB') && $('.featured-tab').length <= 0 && $('.categories-tab > li').length > 0)
    {
        var htmlBlock = '<li class="hc-sort-block-item featured-block"><div>'+hc_tab_fea_title+'</div><ul class="hc-sort-tab featured-tab hc-sortable"></ul></li>';
        if($('input[name="ETS_HOMECAT_BLOCK_SORT"]').val()=='FEATURE_ABOVE')
            $('.categories-block').before(htmlBlock);
        else
            $('.categories-block').after(htmlBlock);
        $('.categories-tab > li').each(function(){
            if(parseInt($(this).attr('data-id-category'))<0)
            {
                $(this).appendTo($('.featured-tab'));
            }
        });
        $('.categories-block > div').text(hc_tab_cat_title);
    }
    sortTabs();
    renderIdStr();
});
$(document).on('click','.hc_clear_cache',function(){
    if(!$(this).hasClass('active'))
    {
        $(this).addClass('active');
        $.ajax({
            url: hc_admin_ajax_url,
            type: 'post',
            data: 'clearcache=1',
            dataType: 'json',
            success: function(json)
            {
                if(json.msg){
                    $("#growls").remove();
                    showSuccessMessage(json.msg);
                }

                $('.hc_clear_cache').removeClass('active');
            },
            error: function(json)
            {
                $('.hc_clear_cache').removeClass('active');
            }
        });
    }
    return false;
});
$(document).on('click','.hc_submit_config',function(){
    if(!$(this).hasClass('active'))
    {
        $(this).addClass('active');
        $.ajax({
            url: hc_admin_ajax_url,
            type: 'post',
            data: $('#module_form').serialize(),
            dataType: 'json',
            success: function(json)
            {
                if(json.success){
                    $("#growls").remove();
                    showSuccessMessage(json.msg);
                }else{
                    $("#growls").remove();
                    showErrorMessage(json.msg,10000);
                }

                $('.hc_submit_config').removeClass('active');
            },
            error: function(json)
            {
                $("#growls").remove();
                showErrorMessage(hc_unknown_error_txt,10000);
                $('.hc_submit_config').removeClass('active');
            }
        });
    }
    return false;
});
$(document).on('click','#check-all-categories-tree',function(){
    $('input[name="ETS_HOMECAT_CATEGORIES[]"][value="0"]').prop("checked",true).parent('span').addClass('tree-selected');
    $('.categories-tab li').each(function () {
        if ( $(this).attr('data-id-category') >= 0){
            $(this).remove();
        }
    });
    //$('.categories-tab').html('');

    $('input[name="ETS_HOMECAT_CATEGORIES[]"]').each(function(){
        var label = $(this).parent('span').children('label').text().replace(/\(.*\)/,'');
        var li = '<li class="hc-sortable" data-id-category="'+$(this).val()+'">'+label+'<span class="hc-delete">'+hc_dekete_title+'</span></li>';
        $('.categories-tab').append(li);
    });
    sortTabs();
    renderIdStr();
});
$(document).on('click','#uncheck-all-categories-tree',function(){
    $('input[name="ETS_HOMECAT_CATEGORIES[]"][value="0"]').prop("checked",false).parent('span').removeClass('tree-selected');
    $('.categories-tab li').each(function () {
        if ( $(this).attr('data-id-category') >= 0){
            $(this).remove();
        }
    });
    renderIdStr();
});
$(document).ready(function(){
    $('#categories-tree').before('<ul class="cattree tree"><li class="tree-item"><span class="tree-item-name '+($('.categories-tab > li[data-id-category="0"]').length > 0 ? 'tree-selected' : '')+'"><input type="checkbox" name="ETS_HOMECAT_CATEGORIES[]" value="0" '+($('.categories-tab > li[data-id-category="0"]').length > 0 ? ' checked="checked" ' : '')+' ><i class="tree-dot"></i><label class="tree-toggler">'+hc_all_product_title+'</label></span></li></ul>');
    loadFormSpecifyProduct();
    sortTabs();
});
$(document).on('click','.hc-delete',function(){
    var id_category = $(this).parent('li').attr('data-id-category');
    $('input[name="ETS_HOMECAT_PRODUCTS_TABS[]"][value="'+id_category+'"]').prop('checked',false);
    $('input[name="ETS_HOMECAT_CATEGORIES[]"][value="'+id_category+'"]').prop('checked',false).parent('span').removeClass('tree-selected');
    $(this).parent('li').remove();
    renderIdStr();
    sortTabs();
});
function renderIdStr()
{
    if($('.featured-tab').length > 0)
    {
        var idStr = '';
        if($('.featured-tab > li').length > 0)
            $('.featured-tab > li').each(function(){
                idStr += $(this).attr('data-id-category')+',';
            });
        $('input[name="ETS_HOMECAT_IDS_FEA"]').val(idStr);
        var idStr = '';
        if($('.categories-tab > li').length > 0)
            $('.categories-tab > li').each(function(){
                idStr += $(this).attr('data-id-category')+',';
            });
        $('input[name="ETS_HOMECAT_IDS"]').val(idStr);
    }
    else
    {
        var idStr = '';
        if($('.hc-sort-tab >li').length > 0)
            $('.hc-sort-tab > li').each(function(){
                idStr += $(this).attr('data-id-category')+',';
            });
        $('input[name="ETS_HOMECAT_IDS"]').val(idStr);
    }
    if($('.hc-sort-block-item').length > 1)
    {
        if($('.hc-sort-block > .hc-sort-block-item:first-child').hasClass('featured-block'))
            $('input[name="ETS_HOMECAT_BLOCK_SORT"]').val('FEATURE_ABOVE');
        else
            $('input[name="ETS_HOMECAT_BLOCK_SORT"]').val('CAT_ABOVE');
    }
}
function sortTabs()
{
    $('.hc-sortable').sortable({
        update: function()
        {
            renderIdStr();
        }
    });
}

function loadFormSpecifyProduct(){
    if ( $('input[name="ETS_HOMECAT_PRODUCTS_TABS[]"][value="-8"]').is(':checked') ){
        if ( ! $('.hc_search_product_form').hasClass('acive')){
            $('.hc_search_product_form').addClass('active');
        }
    }else{
        $('.hc_search_product_form').removeClass('active');
    }
}

var hc_func_search = {
    init : function(){
        this.search();
        this.removeProduct();
        this.sortProductFeature();
    },
    search : function() {
        if ($('.hc_search_product_form').length > 0 && typeof hc_admin_ajax_url !== "undefined")
        {
            var hc_autocomplete = $('.hc_search_product');
            //var mm_product_ids = $('.hc_product_ids').val();
            hc_autocomplete.autocomplete(hc_admin_ajax_url, {
                resultsClass: "hc_results",
                minChars: 1,
                delay: 300,
                appendTo: '.hc_search_product_form',
                autoFill: false,
                max: 20,
                matchContains: false,
                mustMatch: false,
                scroll: true,
                cacheLength: 100,
                scrollHeight: 180,
                extraParams: {
                    excludeIds: $('input[name="ETS_HOMECAT_SPECIFIC_PRODUCTS"]').val(),
                },
                formatItem: function (item) {
                    return '<span data-item-id="'+item[0]+'-'+item[1]+'" class="mm_item_title">' + (item[5] ? '<img src="'+item[5]+'" alt=""/> ' : '') + item[2] + (item[3]? item[3] : '') + (item[4] ? ' (Ref:' + item[4] + ')' : '') + '</span>';
                },
            }).result(function (event, data, formatted) {
                if (data)
                {
                    hc_func_search.addProduct(data);
                }
                hc_autocomplete.val('');
                hc_func_search.closeSearch();
            });
        }
        if ($('.hc_products').length > 0) {
            hc_func_search.sortProductFeature();
            hc_func_search.sortProductList();
        }
    },
    addProduct: function (data) {
        if ($('.hc_products').length > 0) {
            var li = '<li class="media_product" data-product-id="'+data[0]+'">'+
                '<div class="media_left">'+
                '<img src="'+data[5]+'" class="media_object image">'+
                '</div>'+
                '<div class="media_body">'+
                    '<span class="label_pro">'+data[2]+'</span><i class="fa fa-arrows-alt"></i><i class="icon-trash"></i>'+
                '</div>'+
                '</li>';
            $('.hc_products').append(li);
            hc_func_search.sortProductFeature();
            hc_func_search.sortProductList();
        }
    },
    removeIds: function (parent, element) {
        var ax = -1;
        if ((ax = parent.indexOf(element)) !== -1)
            parent.splice(ax, 1);
        return parent;
    },
    removeProduct : function() {
        $(document).on('click','.hc_products i.icon-trash',function(e){
            e.preventDefault();
            $(this).closest('li').first().remove();
            hc_func_search.sortProductFeature();
            hc_func_search.sortProductList();
        });
    },
    closeSearch: function () {
        $('.hc_search_product').val('');
        if ($('.ybc_ins_results').length > 0)
            $('.ybc_ins_results').hide();
    },
    sortProductList: function () {
        var idStr = '';
        if($('.hc_products > li').length > 0)
            $('.hc_products > li').each(function(){
                idStr += $(this).attr('data-product-id')+',';
            });
        $('input[name="ETS_HOMECAT_SPECIFIC_PRODUCTS"]').val(idStr);
    },
    sortProductFeature : function(){
        $('.hc_products').sortable({
            update: function()
            {
                hc_func_search.sortProductList();
            },
        });
    }
};

$(document).ready(function(){
    hc_func_search.init();
    $(document).on('click','.link_add_specific',function(e){
        e.stopPropagation();
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#hc_search_product_form").offset().top
        }, 1000);
        e.preventDefault();
    });
});