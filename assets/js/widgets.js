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


jQuery(document).ready(function($) {

    var count = 0;
    jQuery("body").on('click','.pt-nexas-add', function(e) {

      e.preventDefault();
      var additional = $(this).parent().parent().find('.pt-nexas-additional');
      var container = $(this).parent().parent().parent().parent();
     
      var container_class = container.attr('id');
   
      var arr = container_class.split('-');
    
      var val=  arr[1].split('_');
  
       val.shift();
      
      var liver=  val.join('_')
   
      var container_class_array = container_class.split(liver+"-");
      var instance = container_class_array[1];
      var add = $(this).parent().parent().find('.pt-nexas-add');
      count = additional.find('.pt-nexas-sec').length;
   
      //Json response
      $.ajax({
        type      : "GET",
        url       : ajaxurl,
        data      : {
            action: 'nexas_wp_pages_plucker',
        },
        dataType: "json",
        success: function (data) {

            var options = '<option disabled>Select pages</option>';

            $.each(data, function( index, value ) {
                var option = '<option value="'+index+'">'+value+'</option>';
                options += option;
            });


            additional.append(
                '<div class="pt-nexas-sec"><div class="sub-option section widget-upload">'+
                '<label for="widget-'+liver+'-'+instance+'-features-'+count+'-page_ids">Pages</label>'+
                '<select class="widefat" id="widget-'+liver+'-'+instance+'-features-'+count+'-page_ids"'+
                'name="widget-'+liver+'['+instance+'][features]['+count+'][page_ids]">'+ options + '</select>' +
                '<a class="pt-nexas-remove delete">Remove Feature</a></div></div>' );

        }
        });
      
    });

    jQuery(".pt-nexas-remove").live('click', function() {
        jQuery(this).parent().remove();
    });
    

   

 

    

});





