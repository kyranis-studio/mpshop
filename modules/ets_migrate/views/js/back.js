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
 * @author ETS-Soft <contact@etssoft.net>
 * @copyright  2007-2021 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

var ETS_EM_REQUEST_API = ETS_EM_REQUEST_URL || false,
    ETS_EM_XHR_POOL = [],
    ETS_EM_PROCESS_STOP = false,
    ETS_EM_TIMER = 0,
    ETS_EM_DATA_INFO_SOURCE = ETS_EM_DATA_INFO_SOURCE || [],
    ETS_EM_MIGRATE_RESOURCE = 'minor_data',
    ETS_EM_CURRENT_TASK = ''
;
var ETS_EM_MIGRATE_GROUP_ORDERS = [
    'orders',
    'customer',
    'carrier',
];
var ETS_EM_MIGRATE_GROUP_PRODUCT = [
    'category',
    'product',
];
var ets_em_copied_translate = ets_em_copied_translate || 'Copied',
    ets_em_do_not_import = ets_em_do_not_import || '--- Do not import ---',
    ets_em_create_shop = ets_em_create_shop || '--- Create shop ---',
    ets_em_mapping_shop_invalid = ets_em_mapping_shop_invalid || 'Shop mapping is invalid. Please select target shop or create new shop.',
    ets_em_migrate = ets_em_migrate || 'Migrate',
    ets_em_migrate_now = ets_em_migrate_now || 'Migrate now',
    ets_em_new_migration = ets_em_new_migration || 'Do you want to migrate again?',
    ets_em_migrate_data_empty = ets_em_migrate_data_empty || 'Data entities to migrate cannot be empty!',
    ets_em_resources_timeout = [
        'minor_data',
        'finished',
    ];
;
var ets_em_fn = {
    displayImportNewDataOnly: function () {
        if ($('#import_delete_before_on').is(':checked') || !$('#import_force_all_id_on').is(':checked')) {
            $('.form-group.import-new-data-only').hide();
        } else if ($('#import_force_all_id_on').is(':checked')) {
            $('.form-group.import-new-data-only').show();
        }
    },
    goSteps: function (option) {
        if (option.length > 0) {
            $('.ets-em-nav-step.active, .form-wrapper-group-step.active, .form_header_block, .panel-form-footer').removeClass('active');
            var go_step = option.data('step');
            option.addClass('active');
            $('.form-wrapper-group-step.step' + go_step).addClass('active');
            $('.form_header_block.step' + go_step).addClass('active');
            $('.panel-form-footer.step' + go_step).addClass('active');
            $('#current_step').val(go_step);
        }
    },
    displayTask: function (json) {
        if ($('.ets_mg_process_item').length > 0) {
            if (json.task_complete) {
                $('.ets_mg_process_item_content.' + json.migrating).removeClass('item_processing').removeClass('item_waiting').addClass('item_success');
                $('.ets_mg_process_item_icon.' + json.migrating + ' span').removeClass('dot-flashing').addClass('icon_success');
                $('.ets_mg_process_item_percent.' + json.migrating).html('100%');
                $('.ets_mg_process_item_running.' + json.migrating).css('width', '100%');
                if ($('.ets_mg_process_item.' + json.migrating + ':not(:last-child)').length > 0) {
                    var task = $('.ets_mg_process_item.' + json.migrating).next();
                    if (task.length > 0) {
                        ets_em_fn.todoTask({migrating: task.data('task'), percent: 0});
                    }
                }
            } else if (json.migrating) {
                ets_em_fn.todoTask(json);
            }
            // Migrate images:
            var countItem = $('.ets_mg_process_item_files.' + json.migrating);
            if (countItem.length > 0 && (json.migrating.trim() === 'images' || json.migrating.trim() === 'files') && parseInt(json.nb_group_table) > 0) {
                countItem.text(json.nb_group_table);
            }
        }
    },
    pauseTask: function () {
        var current_task = $('.ets_mg_process_item_icon span.dot-flashing');
        if (current_task.length > 0) {
            current_task.removeClass('dot-flashing');
            ETS_EM_CURRENT_TASK = current_task.parents('.ets_mg_process_item').data('task');
        }
        $('.action_start').removeClass('disabled');
        $('.action_pause').addClass('disabled');
    },
    playTask: function () {
        if (ETS_EM_CURRENT_TASK) {
            var current_task = $('.ets_mg_process_item.' + ETS_EM_CURRENT_TASK + ' .ets_mg_process_item_icon span');
            if (current_task.hasClass('.dot-flashing') > 0) {
                current_task.addClass('dot-flashing');
            }
        }
        $('.action_start').addClass('disabled');
        $('.action_pause').removeClass('disabled');
    },
    todoTask: function (json) {
        if (json.migrating === 'finished') {
            $('.ets_mg_action .action_setting').addClass('disabled');
        }
        $('.ets_mg_process_item_content.' + json.migrating).removeClass('item_waiting').addClass('item_processing');
        $('.ets_mg_process_item_icon.' + json.migrating + ' span').addClass('dot-flashing');
        $('.ets_mg_process_item_percent.' + json.migrating).html(json.percent.toFixed(2) + '%');
        $('.ets_mg_process_item_running.' + json.migrating).css('width', json.percent.toFixed(2) + '%');
    },
    copyToClipboard: function (el) {
        el.select();
        document.execCommand('copy');
        showSuccessMessage(ets_em_copied_translate);
        setTimeout(function () {
            el.removeClass('copy');
        }, 300);
    },
    doRequest: function (data) {
        ets_em_fn.cleanError();
        ets_em_fn.timer();
        if (ETS_EM_REQUEST_API) {
            // Cancel all request.
            if (ETS_EM_PROCESS_STOP) {
                if (ETS_EM_TIMER)
                    ETS_EM_TIMER.pause();
                ets_em_fn.pauseTask();
                if (ETS_EM_XHR_POOL)
                    ets_em_fn.abortAll(ETS_EM_XHR_POOL);

                return false;
            }
            data['ajax'] = 1;
            $.ajax({
                type: 'POST',
                data: data,
                url: ETS_EM_REQUEST_API,
                dataType: 'json',
                beforeSend: function (jqXHR) {
                    ETS_EM_XHR_POOL.push(jqXHR);
                },
                complete: function (jqXHR) {
                    // just remove the item to the "abort list"
                    ETS_EM_XHR_POOL.pop();
                },
                success: function (json) {
                    if (json) {
                        if (json.error || json.errors) {
                            // Pause:
                            ETS_EM_PROCESS_STOP = true;
                            if (ETS_EM_TIMER)
                                ETS_EM_TIMER.pause();
                            ets_em_fn.pauseTask();
                            if (ETS_EM_XHR_POOL)
                                ets_em_fn.abortAll(ETS_EM_XHR_POOL);
                            // End pause:
                            if (json.error) {
                                ets_em_fn.showErrorMessage(json.error);
                            }
                            if (json.errors) {
                                ets_em_fn.showErrorMessage(json.errors);
                            }
                        } else {
                            if (json.migrating !== ETS_EM_MIGRATE_RESOURCE) {
                                ETS_EM_MIGRATE_RESOURCE = json.migrating
                            }
                            if (json.ok) {
                                ets_em_fn.displayTask(json);
                                ets_em_fn.doRequest(data);
                            } else if (json.end) {
                                // off popup setting when migrate success.
                                $('.ets_em_overload.active').removeClass('active');

                                ets_em_fn.displayTask(json);
                                ETS_EM_TIMER.stop();
                                var _COOKIE_KEY_ = $('#ETS_NEW_COOKIE_KEY').val();
                                if (_COOKIE_KEY_.trim() !== '') {
                                    $('.ets_mg_keycode').val(_COOKIE_KEY_.trim());
                                }
                                ++data.current_step;

                                // Images:
                                if (json.images) {
                                    $('.ets_em_todo_list.images').show();
                                    $('.ets_em_todo_list.images .ets_em_todo_list_item').hide();
                                    $.each(json.images, function (i, item) {
                                        $('.ets_em_todo_list.images .ets_em_todo_list_item.' + i).show();
                                        if (json.ps_root_dir)
                                            $('.ets_em_todo_list.images .ets_em_todo_list_item.' + i + ' .ets_em_todo_url .path').text(json.ps_root_dir);
                                    });
                                } else {
                                    $('.ets_em_todo_list.images').hide();
                                }

                                // Products thumbnail:
                                if (json.products_thumb) {
                                    $('.ets_em_todo_list.products').show();
                                } else {
                                    $('.ets_em_todo_list.products').hide();
                                }

                                // Attachments && Files:
                                if (json.files) {
                                    $('.ets_em_todo_list.files').show();
                                    $('.ets_em_todo_list.files .ets_em_todo_list_item').hide();
                                    $.each(json.files, function (i, item) {
                                        $('.ets_em_todo_list.files .ets_em_todo_list_item.' + i).show();
                                        if (json.ps_root_dir)
                                            $('.ets_em_todo_list.files .ets_em_todo_list_item.' + i + ' .ets_em_todo_url .path').text(json.ps_root_dir);
                                    });
                                } else {
                                    $('.ets_em_todo_list.files').hide();
                                }

                                // Show title:
                                if (json.keep_pwd || json.images || json.files || json.products_thumb) {
                                    $('.ets_em_title_sub').show();
                                } else {
                                    $('.ets_em_title_sub').hide();
                                }

                                // Show box keep password:
                                if (json.keep_pwd) {
                                    $('.keep_pwd.ets_mg_thankyou').show();
                                } else {
                                    $('.keep_pwd.ets_mg_thankyou').hide();
                                }

                                setTimeout(function () {
                                    ets_em_fn.goSteps($('.ets-em-nav-step[data-step=' + data.current_step + ']'));
                                }, 3000);
                            }
                        }
                    }
                    if ($('li.ets-em-nav-step.step3.active').length <= 0) {
                        $('body').removeClass('ets-em-step3-active');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (ets_em_resources_timeout.indexOf(ETS_EM_MIGRATE_RESOURCE) !== -1) {
                        ets_em_fn.doRequest(data);
                    } else if (textStatus.trim() === "timeout") {
                        ets_em_fn.doRequest(data);
                    } else {
                        try {
                            res = $.parseJSON(jqXHR.responseText);
                            // Todo:
                        } catch (e) {
                            var responseText = "[Ajax / Server Error] textStatus: \"" + textStatus + " \" errorThrown:\"" + errorThrown + " \" jqXHR: \" " + jqXHR.responseText + "\"";
                            responseText = responseText.replace(/<\s*style[^\r]+?<\s*\/\s*style.*?>/gi, '');
                            ets_em_fn.showErrorMessage(responseText);
                            // Pause:
                            ETS_EM_PROCESS_STOP = true;
                            if (ETS_EM_TIMER)
                                ETS_EM_TIMER.pause();
                            ets_em_fn.pauseTask();
                            if (ETS_EM_XHR_POOL)
                                ets_em_fn.abortAll(ETS_EM_XHR_POOL);
                            // End pause:
                        }
                    }
                }
            });
        }
    },
    speed: function (form) {
        if (form.length > 0) {
            var speed = form.find('#ETS_EM_MIGRATE_SPEED').eq(0),
                speed_val = form.find('#ETS_EM_MIGRATE_SPEED_value').eq(0)
            ;
            if (speed.length > 0) {
                speed_val.html(speed.val());
                var max = speed.attr('max'),
                    min = speed.attr('min'),
                    step = speed.attr('step'),
                    total_range = step > 0 ? (max - min) / step : max - min,
                    current_range = (speed.val() - min) / step, percent = (current_range / total_range) * 100
                ;
                form.find('span.ets_range_input_val').css('width', percent + '%');
                speed_val.css('left', percent + '%');
            }
        }
    },
    ignoreKeepId: function (option) {
        var choice = option || $('input[name=ETS_EM_KEEP_ALL_ID]:checked').val();
        if (parseInt(choice) === 1) {
            $('.form-group.ets_em_delete_all').hide();
            $('.form-group.ets_em_migrate_images:not(.disabled), .form-group.ets_em_gene_product_thumbnail:not(.disabled), .form-group.ets_em_migrate_image_speed:not(.disabled)').show();
        } else {
            $('.form-group.ets_em_delete_all').show();
            $('.form-group.ets_em_migrate_images:not(.disabled), .form-group.ets_em_gene_product_thumbnail:not(.disabled), .form-group.ets_em_migrate_image_speed:not(.disabled)').hide();
        }
        ets_em_fn.migrateImage();
    },
    initialization: function () {
        ets_em_fn.goSteps($('.ets-em-nav-step.active').length > 0 ? $('.ets-em-nav-step.active') : $('.ets-em-nav-step:first'));
        var speedForms = $('form');
        if (speedForms.length > 0) {
            speedForms.each(function () {
                ets_em_fn.speed($(this));
            });
        }
        ets_em_fn.migrateImage();
        ets_em_fn.migrateFiles();
        ets_em_fn.ignoreKeepId();
        if (ETS_EM_DATA_INFO_SOURCE) {
            ets_em_fn.config(ETS_EM_DATA_INFO_SOURCE);
        }
    },
    abortAll: function (jqXHR) {
        if (jqXHR) {
            $.each(jqXHR, function (xhr) {
                if (xhr && (xhr.readystate !== 4)) {
                    xhr.abort();
                }
            });
        }
    },
    migrateImage: function (option) {
        var choice = option || $('input[name=ETS_EM_MIGRATE_IMAGES]:checked').val();
        if (parseInt($('input[name=ETS_EM_KEEP_ALL_ID]:checked').val()) !== 1 || choice.trim() === 'manual') {
            $('.form-group.ets_em_gene_product_thumbnail:not(.disabled), .form-group.ets_em_migrate_image_speed:not(.disabled)').hide();
        } else {
            $('.form-group.ets_em_gene_product_thumbnail:not(.disabled), .form-group.ets_em_migrate_image_speed:not(.disabled)').show();
        }
    },
    timer: function () {
        var clock = $('.ets_mg_timerun_clock');
        if (!ETS_EM_TIMER) {
            ETS_EM_TIMER = new Timer();
            ETS_EM_TIMER.start({precision: 'seconds'});
            ETS_EM_TIMER.addEventListener('secondsUpdated', function (e) {
                clock.find('.hours > .number').html(ETS_EM_TIMER.getTimeValues().hours);
                clock.find('.minutes > .number').html(ETS_EM_TIMER.getTimeValues().minutes);
                clock.find('.second > .number').html(ETS_EM_TIMER.getTimeValues().seconds);
            });
        } else
            ETS_EM_TIMER.start({precision: 'seconds'});
        clock.show();
    },
    newMigrate: function (btn) {
        if (!btn.hasClass('active') && ETS_EM_REQUEST_API !== '') {
            ets_em_fn.cleanError();
            btn.addClass('active');
            $.ajax({
                url: ETS_EM_REQUEST_API,
                data: {
                    action: 'new_migrate',
                    ajax: 1,
                },
                dataType: 'json',
                success: function (json) {
                    btn.removeClass('active');
                    if (json) {
                        if (json.errors) {
                            ets_em_fn.showErrorMessage(json.errors);
                        } else if (json.new_migrate) {
                            location.reload();
                        }
                    }
                },
                error: function () {
                    btn.removeClass('active');
                }
            });
        }
    },
    config: function (json) {
        if (json) {
            if (json.ps_version) {
                $('#ETS_EM_MIGRATE_VERSION').val(json.ps_version);
            }
            if (json.cookie_key) {
                $('#ETS_NEW_COOKIE_KEY').val(json.cookie_key);
            }
            if (json.nb) {
                for (const prop in json.nb) {
                    if (parseInt(json.nb[prop]['nb']) > 0) {
                        $('#ETS_EM_DATA_TO_MIGRATE_' + prop).prop('checked', true);
                        $('.nb_' + prop).html(json.nb[prop]['nb']);
                    } else {
                        $('#ETS_EM_DATA_TO_MIGRATE_' + prop).prop('checked', false);
                        //$('.data_to_migrate.' + prop).hide();
                        $('.data_to_migrate.' + prop).remove();
                    }
                }
            }
            if (json.source_shops && json.target_shops) {
                var count_source_shop = Object.keys(json.source_shops).length,
                    count_target_shop = Object.keys(json.target_shops).length
                ;
                if (count_source_shop > 1 || count_target_shop > 1) {
                    var mappingList = $('.ets-em-shop-mapping-list'),
                        source_shop_options = '',
                        target_shop_options = count_source_shop > 1 ? '<option value="-1">' + ets_em_do_not_import + '</option>' : '',
                        shopList = []
                    ;

                    // Build select shop target:
                    for (const ik2 in json.target_shops) {
                        target_shop_options += '<option value="' + json.target_shops[ik2].id_shop + '">' + json.target_shops[ik2].name + '</option>';
                    }
                    target_shop_options += '<option value="0">' + ets_em_create_shop + '</option>';

                    // Build mapping shop source to target shop:
                    mappingList.html('');
                    for (const ik in json.source_shops) {
                        var selectBuild = $('<div class="shop-mapping-item form-group"><select class="col-lg-4" id="id_shop_source_' + json.source_shops[ik].id_shop + '" name="id_shop_source_' + json.source_shops[ik].id_shop + '"><option value="' + json.source_shops[ik].id_shop + '">' + json.source_shops[ik].name + '</option>' + source_shop_options + '</select><span class="ets_svg_icon"><svg class="w_14 h_14" width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1600 960q0 54-37 91l-651 651q-39 37-91 37-51 0-90-37l-75-75q-38-38-38-91t38-91l293-293h-704q-52 0-84.5-37.5t-32.5-90.5v-128q0-53 32.5-90.5t84.5-37.5h704l-293-294q-38-36-38-90t38-90l75-75q38-38 90-38 53 0 91 38l651 651q37 35 37 90z"/></svg></span><select class="col-lg-4" id="id_shop_target_' + json.source_shops[ik].id_shop + '" name="id_shop_target_' + json.source_shops[ik].id_shop + '">' + target_shop_options + '</select></div>');
                        $('#id_shop_target_' + json.source_shops[ik].id_shop, selectBuild).val(json.source_shops[ik].id_shop);
                        mappingList.append(selectBuild);
                        shopList.push(json.source_shops[ik].id_shop);
                    }

                    $('#ETS_EM_SHOPS_MAPPING').val(shopList.join(','));

                } else if ($('#current_step').val().trim() === '1') {
                    $('.form-group.ets-em-shop-mapping').hide();
                }
            }
            if (json.migrate) {
                $('.ets_em_form_group.active').removeClass('active');
                $('.ets_em_migrate_popup').html(json.migrate);
                $('.ets_em_form_group.migrate_review,.form-group.wrap-migrate').addClass('active');
                $('input[type=hidden][name=migrate_option]').val(1);
                $('.form-group.footer-step2.migrate, button.ets_em_advanced_setting').show();
                $('.form-group.footer-step2 .ets_em_form_submit_btn').text(ets_em_migrate_now);
                $('.form-group.footer-step2.migrate-resume, button.ets_em_popup_cancel').hide();
                $('.ets_em_migrate_option p').each(function () {
                    var option = $('.form-group.ets_migrate_option.' + $(this).data('id').toLowerCase());
                    if (option.css('display') === 'none' || option.hasClass('disabled')) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            }
            if (json.confirm) {
                $('.ets_em_form_group.active').removeClass('active');
                $('.form-group.wrap-migrate, .ets_em_form_group.migrate_resume').addClass('active');
                $('.form-group.footer-step2.migrate').hide();
                $('.form-group.footer-step2.migrate-resume').show();
            }
            if (parseInt(json.images) <= 0) {
                $('.form-group.group-images').addClass('disabled');
            }
            if (parseInt(json.files) <= 0) {
                $('.form-group.group-files').addClass('disabled');
            }
            ets_em_fn.emptyCart();
            ets_em_fn.choiceMigrate();
            ets_em_fn.migrateSupplierAndManufacturer();
            ets_em_fn.migrateProductThumbnail();
        }
    },
    migrateFiles: function (option) {
        var choice = option || $('input[name=ETS_EM_ATTACHMENTS_FILES]:checked').val();
        if (choice.trim() === 'manual') {
            $('.form-group.ets_em_attachments_files_speed:not(.disabled)').hide();
        } else {
            $('.form-group.ets_em_attachments_files_speed:not(.disabled)').show();
        }
    },
    emptyCart: function () {
        if ($('input[id^=ETS_EM_DATA_TO_MIGRATE_orders]:checked').length > 0) {
            $('.form-group.ets_em_migrate_empty_cart').show();
        } else {
            $('.form-group.ets_em_migrate_empty_cart').hide();
        }
    },
    choiceMigrate: function () {
        // Images:
        if ($('.data_to_migrate.group-images input[id^=ETS_EM_DATA_TO_MIGRATE]:not([id$=ALL]):not([id$=minor_data]):checked').length > 0) {
            $('.form-group.group-images').removeClass('hide');
        } else {
            $('.form-group.group-images').addClass('hide');
        }
        // Attachments & Files
        if ($('.data_to_migrate.group-files input[id^=ETS_EM_DATA_TO_MIGRATE]:not([id$=ALL]):not([id$=minor_data]):checked').length > 0) {
            $('.form-group.group-files').removeClass('hide');
        } else {
            $('.form-group.group-files').addClass('hide');
        }
    },
    migrateSupplierAndManufacturer: function () {
        // Supplier:
        if ($('#ETS_EM_DATA_TO_MIGRATE_supplier').is(':checked')) {
            $('.ets_migrate_option.ets_em_supplier_default').hide();
        } else {
            $('.ets_migrate_option.ets_em_supplier_default').show();
        }

        //Manufacturer
        if ($('#ETS_EM_DATA_TO_MIGRATE_manufacturer').is(':checked')) {
            $('.ets_migrate_option.ets_em_manufacturer_default').hide();
        } else {
            $('.ets_migrate_option.ets_em_manufacturer_default').show();
        }
    },
    migrateProductThumbnail: function () {
        // Supplier:
        if ($('#ETS_EM_DATA_TO_MIGRATE_product').is(':checked')) {
            $('.ets_migrate_option.ets_em_gene_product_thumbnail').show();
        } else {
            $('.ets_migrate_option.ets_em_gene_product_thumbnail').hide();
        }
    },
    cleanError: function () {
        $('#growls .growl').remove();
    },
    showErrorMessage: function (msg) {
        ets_em_fn.cleanError();
        $.growl.error({title: "", message: msg, duration: 86400000});
    },
};

$(document).ready(function () {
    ets_em_fn.initialization();
    $(document).on('input change', '#ETS_EM_MIGRATE_SPEED', function () {
        ets_em_fn.speed($(this).parents('form').eq(0));
    });
    $('.ets_mg_keycode').click(function (e) {
        e.preventDefault();
        ets_em_fn.copyToClipboard($(this));
    });
    $(document).on('click', '.viewmore_button.more', function (e) {
        $(this).removeClass('active');
        $('.viewmore_button.less').addClass('active');
        $(this).parent().prev('.ets_mg_wrap').addClass('more').removeClass('less');

    });
    $(document).on('click', '.viewmore_button.less', function (e) {
        $(this).removeClass('active');
        $('.viewmore_button.more').addClass('active');
        $(this).parent().prev('.ets_mg_wrap').addClass('less').removeClass('more');
    });
    $(document).on('click', '.back_step1', function (e) {
        e.preventDefault();
        ets_em_fn.goSteps($('.ets-em-nav-step.active:not(:first-child)').prev());
    });

    $(document).on('click', '#module_form_submit_btn, .ets_em_form_submit_btn, .ets_em_migrate_resume', function (ev) {
        ev.preventDefault();
        var next = $(this),
            newSetting = next.hasClass('ets_em_setting') ? 1 : 0,
            currentStep = $('.ets-em-nav-step.active')
        ;
        ets_em_fn.cleanError();
        if (!newSetting && parseInt(currentStep.data('step')) > 1 && $('.ets_em_form_group.advanced_settings.active').length > 0 && $('input[id^=ETS_EM_DATA_TO_MIGRATE]:not([id$=ALL]):not([id$=minor_data]):checked').length <= 0) {
            ets_em_fn.showErrorMessage(ets_em_migrate_data_empty);
            return;
        }
        if (ETS_EM_REQUEST_API && !next.hasClass('active') && (newSetting || parseInt(currentStep.data('step')) < 3)) {
            next.addClass('active');
            var formData = new FormData();
            if (next.hasClass('ets_em_migrate_resume')) {
                formData.append('current_step', currentStep.data('step'));
                formData.append('migrate_resume', 1);
                formData.append('ETS_EM_MIGRATE_SPEED', $('#ETS_EM_MIGRATE_SPEED').val());
            } else {
                formData = new FormData(next.parents('form').get(0));
                if (newSetting) {
                    formData.append('new_setting', 1);
                }
            }
            $.ajax({
                type: 'POST',
                url: ETS_EM_REQUEST_API + '&ajax=1&action=migrate',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (json) {
                    next.removeClass('active');
                    if (json) {
                        if (json.errors || json.error) {
                            // Pause:
                            ETS_EM_PROCESS_STOP = true;
                            if (ETS_EM_TIMER)
                                ETS_EM_TIMER.pause();
                            ets_em_fn.pauseTask();
                            if (ETS_EM_XHR_POOL)
                                ets_em_fn.abortAll(ETS_EM_XHR_POOL);
                            // End pause:
                            if (json.errors)
                                ets_em_fn.showErrorMessage(json.errors);
                            if (json.error)
                                ets_em_fn.showErrorMessage(json.error);
                        } else {
                            ETS_EM_PROCESS_STOP = false;
                            ets_em_fn.playTask();
                            if (newSetting) {
                                $('.ets_em_overload.active').removeClass('active');
                                if (json.ok) {
                                    ets_em_fn.displayTask(json);
                                    ets_em_fn.doRequest({current_step: 3, action: 'migrate'});
                                }
                            } else {
                                if (json.process) {
                                    $('.ets_mg_list_process').html(json.process);
                                }
                                ets_em_fn.displayTask(json);
                                if (json.continue) {
                                    ets_em_fn.goSteps($('.ets-em-nav-step[data-step=' + json.step + ']'));
                                    ets_em_fn.doRequest({current_step: json.step, action: 'migrate'});
                                } else {
                                    // Msg:
                                    if (json.ok && json.msg) {
                                        showSuccessMessage(json.msg);
                                    }
                                    // Number record catalog imports:
                                    ets_em_fn.config(json);
                                    if (!json.migrate) {
                                        ets_em_fn.goSteps(currentStep.not(':last-child').next());
                                        if (parseInt($('#current_step').val()) === 3) {
                                            ets_em_fn.doRequest({current_step: 3, action: 'migrate'});
                                        }
                                    }
                                }
                            }
                        }
                        // Sang:
                        if ($('li.ets-em-nav-step.step3.active').length > 0) {
                            $('body').addClass('ets-em-step3-active');
                        } else {
                            $('body').removeClass('ets-em-step3-active');
                        }
                        if ($('li.ets-em-nav-step.step3.active').length <= 0) {
                            $('body').removeClass('ets-em-step3-active');
                        }
                    }
                },
                error: function () {
                    next.removeClass('active');
                }
            });
        } else {
            ets_em_fn.doRequest({current_step: currentStep.data('step'), action: 'migrate'});
        }
    });

    $(document).on('change', 'select[id^=id_shop_target]', function () {
        var flag = false,
            btn = $('.ets_em_form_submit_btn')
        ;
        $('select[id^=id_shop_target]').each(function () {
            if ($(this).val().trim() !== '-1') {
                return (flag = true);
            }
        });
        if (!flag) {
            ets_em_fn.showErrorMessage(ets_em_mapping_shop_invalid);
            btn.prop('disabled', true);
        } else {
            btn.prop('disabled', false);
        }
    });
    $('#module_form_back_btn').click(function (ev) {
        ev.preventDefault();
        ets_em_fn.goSteps($('.ets-em-nav-step.active:not(:first-child)').prev());
    });
    $('input[name=ETS_EM_MIGRATE_IMAGES]').change(function () {
        ets_em_fn.migrateImage($(this).val());
    });
    $('input[name=ETS_EM_ATTACHMENTS_FILES]').change(function () {
        ets_em_fn.migrateFiles($(this).val());
    });
    $('input[name=ETS_EM_KEEP_ALL_ID]').change(function () {
        ets_em_fn.ignoreKeepId($(this).val());
    });
    $('.ets_em_advanced_settings').click(function (ev) {
        ev.preventDefault();
        $('.ets_em_form_group').removeClass('active');
        $('.form-group.wrap-migrate, .ets_em_form_group.advanced_settings').addClass('active');
        $('input[type=hidden][name=migrate_option]').val(0);
        $('.form-group.footer-step2.migrate, button.ets_em_popup_cancel').show();
        $('.form-group.footer-step2.migrate-resume, button.ets_em_advanced_setting').hide();
        $('.form-group.footer-step2 .ets_em_form_submit_btn').text(ets_em_migrate);
    });
    $('button.ets_em_advanced_setting').click(function (ev) {
        $(this).addClass('active');
        setTimeout(function () {
            ev.preventDefault();
            $('.ets_em_form_group').removeClass('active');
            $('.form-group.wrap-migrate, .ets_em_form_group.advanced_settings').addClass('active');
            $('input[type=hidden][name=migrate_option]').val(0);
            $('.form-group.footer-step2.migrate, button.ets_em_popup_cancel').show();
            $('.form-group.footer-step2.migrate-resume, button.ets_em_advanced_setting').hide();
            $('button.ets_em_advanced_setting').removeClass('active');
            $('.form-group.footer-step2 .ets_em_form_submit_btn').text(ets_em_migrate);
        }, 350);
    });
    $(document).on('click', '.ets_em_close_popup, .ets_em_popup_cancel', function (ev) {
        ev.preventDefault();
        $('.form-group.wrap-migrate.active, .ets_em_form.active').removeClass('active');
        $('input[type=hidden][name=migrate_option]').val(0);
        $('.form-group.footer-step2.migrate, button.ets_em_popup_cancel').show();
        $('.form-group.footer-step2.migrate-resume, button.ets_em_advanced_setting').hide();
        $('.form-group.footer-step2 .ets_em_form_submit_btn').text(ets_em_migrate);
        var overload = $('.ets_em_overload.active');
        if (overload.length > 0) {
            ETS_EM_PROCESS_STOP = false;
            ets_em_fn.playTask();
            ets_em_fn.doRequest({current_step: 3, action: 'migrate'});
            overload.removeClass('active');
        }
    });
    $('#ETS_EM_DATA_TO_MIGRATE_ALL').click(function () {
        var data_to_migrate = $('input[id^=ETS_EM_DATA_TO_MIGRATE]:not([id$=shop])');
        if ($(this).is(':checked')) {
            data_to_migrate.prop('checked', true);
        } else {
            data_to_migrate.prop('checked', false);
        }
        ets_em_fn.emptyCart();
        ets_em_fn.choiceMigrate();
        ets_em_fn.migrateSupplierAndManufacturer();
        ets_em_fn.migrateProductThumbnail();
    });
    $('input[id^=ETS_EM_DATA_TO_MIGRATE]:not([id$=ALL]):not([id$=minor_data])').click(function () {
        var migrate_all = $('#ETS_EM_DATA_TO_MIGRATE_ALL');

        if (ETS_EM_MIGRATE_GROUP_ORDERS) {
            var orders = $('input[id=ETS_EM_DATA_TO_MIGRATE_orders]');
            if ($(this).val() === orders.val() && orders.is(':checked')) {
                ETS_EM_MIGRATE_GROUP_ORDERS.forEach(function (item) {
                    $('input[id=ETS_EM_DATA_TO_MIGRATE_' + item + ']').prop('checked', true);
                });
            } else if (orders.is(':checked') && ETS_EM_MIGRATE_GROUP_ORDERS.indexOf($(this).val()) !== -1) {
                ETS_EM_MIGRATE_GROUP_ORDERS.forEach(function (item) {
                    $('input[id=ETS_EM_DATA_TO_MIGRATE_' + item + ']').prop('checked', false);
                });
            }
        }
        if (ETS_EM_MIGRATE_GROUP_PRODUCT) {
            var product = $('input[id=ETS_EM_DATA_TO_MIGRATE_product]');
            if ($(this).val() === product.val() && product.is(':checked')) {
                ETS_EM_MIGRATE_GROUP_PRODUCT.forEach(function (item) {
                    $('input[id=ETS_EM_DATA_TO_MIGRATE_' + item + ']').prop('checked', true);
                });
            } else if (product.is(':checked') && ETS_EM_MIGRATE_GROUP_PRODUCT.indexOf($(this).val()) !== -1) {
                ETS_EM_MIGRATE_GROUP_PRODUCT.forEach(function (item) {
                    $('input[id=ETS_EM_DATA_TO_MIGRATE_' + item + ']').prop('checked', false);
                });
            }
        }
        if (!$(this).is(':checked')) {
            migrate_all.prop('checked', false);
        } else {
            var flag = true;
            $('input[id^=ETS_EM_DATA_TO_MIGRATE]:not([id$=ALL]):not([id$=minor_data])').each(function () {
                if (!$(this).is(':checked')) {
                    flag = false;
                }
            });
            migrate_all.prop('checked', flag);
        }
        ets_em_fn.emptyCart();
        ets_em_fn.choiceMigrate();
        ets_em_fn.migrateSupplierAndManufacturer();
        ets_em_fn.migrateProductThumbnail();
    });
    $(window).bind('beforeunload', function (e) {
        if (confirm('Do you want to cancel this migration?')) {
            ets_em_fn.abortAll(ETS_EM_XHR_POOL);
            $(window).unbind('beforeunload');
            return true;
        }
    });
    $('.ets_mg_action .action_setting:not(.disabled)').click(function () {
        if ($('.ets_em_overload:not(.active)').length > 0) {
            ets_em_fn.cleanError();
            // Pause:
            ETS_EM_PROCESS_STOP = true;
            if (ETS_EM_TIMER)
                ETS_EM_TIMER.pause();
            ets_em_fn.pauseTask();
            if (ETS_EM_XHR_POOL)
                ets_em_fn.abortAll(ETS_EM_XHR_POOL);
            // End pause:
            var btn = $(this);
            if (!btn.hasClass('active') && ETS_EM_REQUEST_API !== '') {
                $.ajax({
                    url: ETS_EM_REQUEST_API,
                    data: {
                        ajax: 1,
                        action: 'settingForm',
                    },
                    dataType: 'json',
                    success: function (json) {
                        btn.removeClass('active');
                        if (json) {
                            if (json.form && ETS_EM_MIGRATE_RESOURCE !== 'finished') {
                                var wrap = $('.ets_em_form_wrap');
                                wrap.html(json.form);
                                $('.ets_em_overload').addClass('active');
                                ets_em_fn.speed(wrap.find('form').eq(0));
                                $('.ets_em_form_wrap .form-wrapper-group-step.step2:not(.active)').addClass('active');
                            }
                        }
                    },
                    error: function () {
                        btn.removeClass('active');
                    }
                });
            }
        }
    });
    $('.ets_mg_action .action_cancel').click(function () {
        if (confirm('Do you want to cancel this migration?')) {
            // Pause:
            ETS_EM_PROCESS_STOP = true;
            if (ETS_EM_TIMER)
                ETS_EM_TIMER.pause();
            ets_em_fn.pauseTask();
            if (ETS_EM_XHR_POOL)
                ets_em_fn.abortAll(ETS_EM_XHR_POOL);
            // End pause:
            ets_em_fn.abortAll(ETS_EM_XHR_POOL);
            ets_em_fn.newMigrate($(this));
        }
    });
    $('.ets_mg_action .action_pause:not(.disabled)').click(function (e) {
        if (!ETS_EM_PROCESS_STOP) {
            $(this).addClass('disabled').addClass('loading');
            $('.ets_mg_action .action_start.disabled').removeClass('disabled');
            $('.ets_mg_list_process').addClass('pausing');
            // Pause:
            ETS_EM_PROCESS_STOP = true;
            if (ETS_EM_TIMER)
                ETS_EM_TIMER.pause();
            ets_em_fn.pauseTask();
            if (ETS_EM_XHR_POOL)
                ets_em_fn.abortAll(ETS_EM_XHR_POOL);
            // End pause:
            setTimeout(function (e) {
                $('.ets_mg_action .action_pause.disabled').removeClass('loading');
            }, 4000);
        }
    });
    $('.ets_mg_action .action_start').click(function (e) {
        if (!$(this).hasClass('disabled')) {
            if (ETS_EM_PROCESS_STOP) {
                ETS_EM_PROCESS_STOP = false;
                ets_em_fn.playTask();
                ets_em_fn.doRequest({current_step: 3, action: 'migrate'});
                $(this).addClass('disabled');
                $('.ets_mg_action .action_pause.disabled').removeClass('disabled');
                $('.ets_mg_list_process').removeClass('pausing');
            }
        }

    });
    $('.ets_em_new_migration').click(function (e) {
        e.preventDefault();
        if (!$(this).hasClass('ets_em_popup_resume') || confirm(ets_em_new_migration)) {
            ets_em_fn.newMigrate($(this));
        }
    });
});
