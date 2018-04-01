jQuery(document).ready(function($) {

       function media_upload(button_class) {

        var _custom_media = false,

        _orig_send_attachment = wp.media.editor.send.attachment;



        $('body').on('click', button_class, function(e) {

            var button_id ='#'+$(this).attr('id');

            var self = $(button_id);

            var send_attachment_bkp = wp.media.editor.send.attachment;

            var button = $(button_id);

            var id = button.attr('id').replace('_button', '');

            _custom_media = true;

            wp.media.editor.send.attachment = function(props, attachment){

                if ( _custom_media  ) {

                    $('.custom_media_id').val(attachment.id);

                    $('.custom_media_url').val(attachment.url);

                    $('.custom_media_image').attr('src',attachment.url).css('display','block');

                } else {

                    return _orig_send_attachment.apply( button_id, [props, attachment] );

                }

            }

            wp.media.editor.open(button);

                return false;

        });

     }

     media_upload('.custom_media_button');

});




(function ( $, window, document, undefined ) {
    'use strict';
    var at_document = $(document);

       // Runs when the image button is clicked.
    jQuery('body').on('click','.media-image-remove', function(e){
        $(this).siblings('.img-preview-wrap').hide();
        $(this).prev().prev().val('');
    });
    
    /**repeater**/
    /*sortable*/
    var ATREFRESHVALUE = function (wrapObject) {
        wrapObject.find('[name]').each(function(){
            $(this).trigger('change');
        });
    };
    var ATSORTABLE = function () {
        var repeaters = $('.pt-repeater');
        repeaters.sortable({
            orientation: "vertical",
            items: '> .repeater-table',
            placeholder: 'pt-sortable-placeholder',
            update: function( event, ui ) {
                ATREFRESHVALUE(ui.item);
            }
        });
        repeaters.trigger("sortupdate");
        repeaters.sortable("refresh");
    };
    /*replace*/
    var ATREPLACE = function( str, replaceWhat, replaceTo ){
        var re = new RegExp(replaceWhat, 'g');
        return str.replace(re,replaceTo);
    };
    var ATREPEATER =  function (){
        at_document.on('click','.pt-add-repeater',function (e) {
            e.preventDefault();
            var add_repeater = $(this),
                repeater_wrap = add_repeater.closest('.pt-repeater'),
                code_for_repeater = repeater_wrap.find('.pt-code-for-repeater'),
                total_repeater = repeater_wrap.find('.pt-total-repeater'),
                total_repeater_value = parseInt( total_repeater.val() ),
                repeater_html = code_for_repeater.html();

            total_repeater.val( total_repeater_value +1 );
            var final_repeater_html = ATREPLACE( repeater_html, add_repeater.attr('id'),total_repeater_value );
            add_repeater.before($('<div class="repeater-table"></div>').append( final_repeater_html ));
            var new_html_object = add_repeater.prev('.repeater-table');
            var repeater_inside = new_html_object.find('.pt-repeater-inside');
            repeater_inside.slideDown( 'fast',function () {
                new_html_object.addClass( 'open' );
                ATREFRESHVALUE(new_html_object);
            } );

        });
        at_document.on('click', '.pt-repeater-top, .pt-repeater-close', function (e) {
            e.preventDefault();
            var accordion_toggle = $(this),
                repeater_field = accordion_toggle.closest('.repeater-table'),
                repeater_inside = repeater_field.find('.pt-repeater-inside');

            if ( repeater_inside.is( ':hidden' ) ) {
                repeater_inside.slideDown( 'fast',function () {
                    repeater_field.addClass( 'open' );
                } );
            }
            else {
                repeater_inside.slideUp( 'fast', function() {
                    repeater_field.removeClass( 'open' );
                });
            }
        });
        at_document.on('click', '.pt-repeater-remove', function (e) {
            e.preventDefault();
            var repeater_remove = $(this),
                repeater_field = repeater_remove.closest('.repeater-table'),
                repeater_wrap = repeater_remove.closest('.pt-repeater');

            repeater_field.remove();
            ATREFRESHVALUE(repeater_wrap);
        });

        at_document.on('change', '.pt-select', function (e) {
            e.preventDefault();
            var select = $(this),
                repeater_inside = select.closest('.pt-repeater-inside'),
                postid = repeater_inside.find('.pt-postid'),
                repeater_control_actions = repeater_inside.find('.pt-repeater-control-actions'),
                optionSelected = select.find("option:selected"),
                valueSelected = optionSelected.val();

            if( valueSelected == 0 ){
                postid.remove();
            }
            else{
                postid.remove();
                $.ajax({
                    type      : "GET",
                    data      : {
                        action: 'at_get_edit_post_link',
                        id: valueSelected
                    },
                    url       : ajaxurl,
                    beforeSend: function ( data, settings ) {
                        postid.remove();

                    },
                    success   : function (data) {
                        if( 0 != data ){
                            repeater_control_actions.append( data );
                        }
                    },
                    error     : function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    }
                });
            }
        });
    };

    /*call all methods on ready*/
    at_document.ready( function() {
        at_document.on('widget-added widget-updated, panelsopen', function( event, widgetContainer ) {
            ATSORTABLE();
        });

        /*
         * Manually trigger widget-added events for media widgets on the admin
         * screen once they are expanded. The widget-added event is not triggered
         * for each pre-existing widget on the widgets admin screen like it is
         * on the customizer. Likewise, the customizer only triggers widget-added
         * when the widget is expanded to just-in-time construct the widget form
         * when it is actually going to be displayed. So the following implements
         * the same for the widgets admin screen, to invoke the widget-added
         * handler when a pre-existing media widget is expanded.
         */
        $( function initializeExistingWidgetContainers() {
            var widgetContainers;
            if ( 'widgets' !== window.pagenow ) {
                return;
            }
            widgetContainers = $( '.widgets-holder-wrap:not(#available-widgets)' ).find( 'div.widget' );
            widgetContainers.one( 'click.toggle-widget-expanded', function toggleWidgetExpanded() {
                ATSORTABLE();
            });
        });
        ATREPEATER();

        /**
         * Script for Customizer icons
         */
        at_document.on('click', '.pt-icons-wrapper .single-icon', function() {
            var single_icon = $(this),
                at_customize_icons = single_icon.closest( '.pt-icons-wrapper' ),
                icon_display_value = single_icon.children('i').attr('class'),
                icon_split_value = icon_display_value.split(' '),
                icon_value = icon_split_value[1];

            single_icon.siblings().removeClass('selected');
            single_icon.addClass('selected');
            at_customize_icons.find('.pt-icon-value').val( icon_value );
            at_customize_icons.find('.icon-preview').html('<i class="' + icon_display_value + '"></i>');
            at_customize_icons.find('.pt-icon-value').trigger('change');
        });

        at_document.on('click', '.pt-icons-wrapper .icon-toggle ,.pt-icons-wrapper .icon-preview', function() {
            var icon_toggle = $(this),
                at_customize_icons = icon_toggle.closest( '.pt-icons-wrapper' ),
                icons_list_wrapper = at_customize_icons.find( '.icons-list-wrapper' ),
                dashicons = at_customize_icons.find( '.dashicons' );

            if ( icons_list_wrapper.is(':hidden') ) {
                icons_list_wrapper.slideDown();
                dashicons.removeClass('dashicons-arrow-down');
                dashicons.addClass('dashicons-arrow-up');
            } else {
                icons_list_wrapper.slideUp();
                dashicons.addClass('dashicons-arrow-down');
                dashicons.removeClass('dashicons-arrow-up');
            }

        });
        at_document.on('keyup', '.pt-icons-wrapper .icon-search', function() {
            var text = $(this),
                value = this.value,
                at_customize_icons = text.closest( '.pt-icons-wrapper' ),
                icons_list_wrapper = at_customize_icons.find( '.icons-list-wrapper' );

            icons_list_wrapper.find('i').each(function () {
                if ($(this).attr('class').search(value) > -1) {
                    $(this).parent('.single-icon').show();
                } else {
                    $(this).parent('.single-icon').hide();

                }
            });
        });

        /*hide meta on pagebuilder */
        function at_build_hide_unnecessary_meta() {
            var page_template = $('#page_template'),
                nexas_sidebar_layout = $('#nexas_sidebar_layout'),
                nexas_meta_fields = $('#nexas_meta_fields'),
                postimagediv = $('#postimagediv'),
                optionSelected = page_template.find("option:selected"),
                valueSelected = optionSelected.val();
            if( valueSelected === 'page-templates/template-builder.php' ){
                nexas_sidebar_layout.addClass('hidden');
                nexas_meta_fields.addClass('hidden');
                postimagediv.addClass('hidden');
            }
            else{
                nexas_sidebar_layout.removeClass('hidden');
                nexas_meta_fields.removeClass('hidden');
                postimagediv.removeClass('hidden');
            }
        }
        at_build_hide_unnecessary_meta();
        at_document.on('change', '#page_template', function (e) {
            at_build_hide_unnecessary_meta();
        })
    });
})( jQuery, window, document );
