$(document).ready( function(){
    // Catch all ajax response and redirect if not authenticated.
    $.ajaxSetup({
        statusCode: {
            401: function(){
                alert("Your session has been expired, please login.");
                window.location = window.base_url + '/login';
            }
        }
    });


 /*   if($('.my-rating').length)
    {
        $('.my-rating').starRating({
                starSize: 15,
            });
    }

*/
 /*   $.get(baseUrl+'/carttotal').done(function (data){
        $('.cartcount').html(data);
    });
*/

    display_select2();
    if($('#fileupload').length)
        file_upload();

    if($('.datepicker').length)
        $('.datepicker').datepicker({
            'format': 'dd-mm-yyyy',
        });

    $(document).on('click', '.btn-warning-popup', function(event){
        event.preventDefault();
        var url = $(this).attr('href');
        var redirect_url = $(this).data('redirect-url');
        var message = $(this).data('message');
        if (typeof redirect_url !== typeof undefined && redirect_url !== false)
            var action = 'redirect';

        $.confirm({
                title: 'Warning',
                content: message,
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'ok_button': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            var obj = this;
                            obj.buttons.ok_button.setText('Processing..'); // setText for 'hello' button
                            obj.buttons.ok_button.disable();
                            $.get(url).done(function (data) {
                                obj.$$close_button.trigger('click');
                                if (typeof data.error != "undefined") {
                                    var title = "Alert!";
                                    var response_msg = data.error;
                                }
                                else
                                {
                                    var title = "Success!";
                                    var response_msg = data.success;
                                }
                                $.confirm({
                                    title: title,
                                    content: response_msg,
                                    type: 'red',
                                    buttons: {
                                      'ok': function(){
                                        if(action == 'redirect')
                                            window.location.href= redirect_url;
                                        else
                                            dt();
                                      }
                                    },
                                   
                                });
                            });
                            return false;
                        }
                    },
                    close_button: {
                          text: 'Cancel',
                          action: function () {
                        }
                    },
                }
            });
    })

    if($('.select2-dropdown').length)
    {
        $('.select2-dropdown').select2();
    }

    $(document).on('click', '.view-image', function(){
        var src = $(this).data('src');
        var title = $(this).data('title');
        $.confirm({
            title: title,
            content: '<img src="'+src+'"/>',
            type: 'red',
            typeAnimated: true,
            buttons: {
                close: function () {
                }
            }
        });
    });

    $(document).on('click', '.open-ajax-confirm', function(e){
        e.preventDefault();
        var title = $(this).attr('title');
        if($(this).attr('data-url'))
            var targetUrl = $(this).data('url'); 
        else
            var targetUrl = $(this).attr('href');
        var popup_size = 'medium';
        if($(this).attr('data-popup-size'))
            popup_size = $(this).attr('data-popup-size');
        $.confirm({
                    title: title,
                    content: function(){
                        var self = this;
                        return $.ajax({
                            url: targetUrl,
                        }).done(function (response) {
                            self.setContent(response);
                            setTimeout( function() {
                                if($('.jconfirm-box-container .select2-dropdown').length)
                                    $('.jconfirm-box-container .select2-dropdown').select2();

                                if($('.fileinput').length)
                                    $('.fileinput').fileinput();
                                if($('.js-switch').length)
                                {
                                    var elem = document.querySelector('.js-switch');
                                    var init = new Switchery(elem, { size: 'small' });
                                }
                                display_select2();

                                if($('img.checkable').length)
                                {
                                    $("img.checkable").imgCheckbox({
                                        onclick: function(el){
                                            var popType = $('#popupType').val();
                                            if(popType == 'featured_image' || popType == 'featured_image_editor' || popType == 'featured_video')
                                            {
                                                $('.imgChked').each(function(i, e) {
                                                    $(this).removeClass('imgChked');
                                                });
                                                el.addClass("imgChked");
                                            }
                                        }
                                    });
                                }

                            }, 500 );
                            
                        });
                    },
                    columnClass: popup_size,
                    buttons: {
                      ok_button: {
                          text: 'Save',
                          btnClass: 'btn-success',
                          action: function () {
                            var obj = this;
                            var form = $('.confirm-wrap').find('form');
                            var form_id = form.attr('id');
                            console.log(form_id);
                            var frmValid = false;
                            if(form.attr('data-validate')!== "undefined")
                            {
                                validate();
                                frmValid = form.valid();
                                console.log(frmValid);
                            }
                            if(frmValid)
                            {
                                obj.buttons.ok_button.setText('Processing..'); // setText for 'hello' button
                                obj.buttons.ok_button.disable();
                                var data = new FormData( $('#'+form_id)[0] );
                                $.ajax({
                                    url : form.attr('action'),
                                    type: "POST",
                                    data : data,
                                    processData: false,
                                    contentType: false,
                                    success:function(data, textStatus, jqXHR){
                                        obj.$$close_button.trigger('click');
                                        if (typeof data.error != "undefined") {
                                            confirm_alert('Alert!', data.error);
                                        }
                                        else if (typeof data.errors != "undefined") {
                                            confirm_alert('Alert!', 'Oops!! look like you have missed some important data, please check.');
                                        }
                                        else if(typeof data.success != "undefined"){
                                            confirm_alert('Success!', data.success, 'redraw');
                                        }
                                    }
                                });
                            }
                            return false;
                          }
                      },
                      close_button: {
                          text: 'Close',
                          action: function () {
                          }
                      },
                  }
              });

    });

    var jc = false;


    $(document).on('click', '.open-ajax-popup', function(e){
        e.preventDefault();
        var title = $(this).attr('title');
        if($(this).attr('data-url'))
            var targetUrl = $(this).data('url'); 
        else
            var targetUrl = $(this).attr('href');
        var popup_size = 'medium';
        if($(this).attr('data-popup-size'))
            popup_size = $(this).attr('data-popup-size');
        jc = $.confirm({
                    title: title,
                    closeIcon: true,
                    buttons: {
                        close: {
                            text: 'Close', // text for button
                            isHidden: true, // initially not hidden
                        },
                    },
                    content: function(){
                        var self = this;
                        return $.ajax({
                            url: targetUrl,
                        }).done(function (response) {
                            self.setContent(response);
                            setTimeout( function() {
                                if($('.select2-dropdown').length)
                                    $('.select2-dropdown').select2();

                                if($('.fileinput').length)
                                    $('.fileinput').fileinput();

                                display_select2();

                                if($('img.checkable').length)
                                {
                                    $("img.checkable").imgCheckbox({
                                        onclick: function(el){
                                            var popType = $('#popupType').val();
                                            if(popType == 'single_image')
                                            {
                                                $('.imgChked').each(function(i, e) {
                                                    $(this).removeClass('imgChked');
                                                });
                                                el.addClass("imgChked");
                                            }
                                        }
                                    });
                                }
                                if($('#mediafileupload').length)
                                {
                                    media_file_upload();
                                }

                                if($('.fileinput').length)
                                    $('.fileinput').fileinput();

                                if($('#image').length)
                                {
                                    var $image = $('#image');
                                    //$image.cropper("destroy");
                                    var ratio = $image.parent().attr('data-crop-ratio');

                                    var $dataX = $("#dataX"),
                                    $dataY = $("#dataY"),
                                    $dataHeight = $("#dataHeight"),
                                    $dataWidth = $("#dataWidth");
                                    $cropData = $('#cropData');
                                    var init_data = { x: parseFloat($dataX.val()), y: parseFloat($dataY.val()), width: parseFloat($dataWidth.val()), height: parseFloat($dataHeight.val()) }
                                    var options = {
                                        autoCrop: true,
                                        aspectRatio: parseFloat(ratio),
                                        preview: '.img-preview',
                                        data: init_data,
                                        crop: function (e) {
                                          $dataX.val(Math.round(e.detail.x));
                                          $dataY.val(Math.round(e.detail.y));
                                          $dataHeight.val(Math.round(e.detail.height));
                                          $dataWidth.val(Math.round(e.detail.width));
                                          $cropData.val(JSON.stringify(e.detail));
                                        }
                                      };
                                    var cropper = $image.cropper(options);
                                    //cropper.setData(crop_data);
                                }

                                if($('.richtext').length)
                                {
                                    $('.richtext').summernote({
                                        callbacks: {
                                            onImageUpload: function(files) {
                                                that = $(this);
                                                sendFile(files[0], that);
                                            }
                                        }
                                    });
                                }

                            }, 500 );
                            
                        });
                    },
                    columnClass: popup_size,
              });
    });

    $(document).on('click', '.media-popup-nav .pagination .page-link', function(e){
              e.preventDefault();
              var loadurl = $(this).attr('href');
              var targ = $('#mediaList');
              if(loadurl != 'undefined'){
                  targ.load(loadurl, function(){
                    $("img.checkable").imgCheckbox({
                        onclick: function(el){
                            var popType = $('#popupType').val();
                            if(popType == 'single_image')
                            {
                                $('.imgChked').each(function(i, e) {
                                    $(this).removeClass('imgChked');
                                });
                                el.addClass("imgChked");
                            }
                        }
                    });
                  });
              }
          });

          $(document).on('keyup', '#mediaPopupSearchInput', function(e){
            var req = $(this).val();
            var loadurl = base_url+'/admin/media/popup';
            $.ajax({
               url: loadurl,
               data: {req: req}, // serializes the form's elements.
               success: function(data)
               {
                  $('#mediaList').html(data);
                  $("img.checkable").imgCheckbox({
                        onclick: function(el){
                            var popType = $('#popupType').val();
                            if(popType == 'single_image')
                            {
                                $('.imgChked').each(function(i, e) {
                                    $(this).removeClass('imgChked');
                                });
                                el.addClass("imgChked");
                            }
                        }
                    });
               }
             });
          });

        $(document).on('click', '#setSingleImage', function(){
            var id = $('.imgChked').find('img').attr('id');
            var src = $('.imgChked').find('img').attr('src');
            var extra_attr = "";
            if(typeof $('.imgChked').find('img').attr('data-extra-attr') !== undefined && $('.imgChked').find('img').attr('data-extra-attr') !== false) {
                 var extra_attr = $('.imgChked').find('img').attr('data-extra-attr');
            }
            var link = $('<img>').prop('src', src).attr('class', 'card-img-top padding-20');
            $('#mediaId'+extra_attr).val(id);
            $('#image-holder-'+extra_attr).html(link);
            jc.close();
        });

        $(document).on('click', '#setProductGallery', function(){
            var pId = $(this).data('product');
            $('.imgChked').each(function(i, e) {
                var id = $(this).find('img').attr('id');
                var src = $(this).find('img').attr('src');
                var img = '<a href="'+base_url+'/admin/media/popup/single_image/Products/'+id+'/'+pId+'" class="open-ajax-popup" title="Product Images" data-popup-size="large" id="image-holder-'+id+'">';
                    img += '<img src="'+src+'" class="card-img-top padding-20"/></a>';
                var innerHtml = '<div class="col-md-3 item-img default-padding"><div class="card">'+img+'<div class="card-body"><input type="hidden" name="media_id[]" id="mediaId'+id+'" value="'+id+'">';
                innerHtml += '<div class="form-group"><input type="text" name="title[]" class="form-control" placeholder="Title"></div>';
                innerHtml += '<div class="form-group"><input type="text" name="alt[]" class="form-control" placeholder="Alt"></div><a href="javascript:void(0)" class="product-img-item-remove">Remove</a>';
                innerHtml += '</div></div></div>';
                $(innerHtml).prependTo('#productGalleryList')
            });
            jc.close();
        });

        $(document).on('click', '#addPhotos', function(){
            $(this).prop('disabled', true);
            var url = $(this).attr('data-url');
            var ids = [];
            $('.imgChked').each(function(i, e) {
                var id = $(this).find('img').attr('id');
                ids.push(id);
            });
            $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                            "_token": _token,
                            ids: ids,
                    },
                    success: function(result){
                       location.reload(true);
                    },
                });
        });

        $(document).on('click', '.product-img-item-remove', function(){
            $(this).parents('.item-img').remove();
        })

        $(document).on('click', '.image-remove', function(){
            $(this).parent('.default-image-holder').find('img').attr('src', base_url+'/public/assets/img/add_image.png');
            $(this).parent('.default-image-holder').find("input[name='image_id']").val('');
            var holder_id = $(this).data('remove-id');
            if (typeof holder_id !== "undefined" || holder_id != null) {
                $('#'+holder_id).val('');
            }

        })


    //Created for jQuery Validation 1.11.1
    $.validator.addMethod("synchronousRemote", function (value, element, param) {
        if (this.optional(element)) {
            return "dependency-mismatch";
        }

        var previous = this.previousValue(element);
        if (!this.settings.messages[element.name]) {
            this.settings.messages[element.name] = {};
        }
        previous.originalMessage = this.settings.messages[element.name].remote;
        this.settings.messages[element.name].remote = previous.message;

        param = typeof param === "string" && { url: param } || param;

        if (previous.old === value) {
            return previous.valid;
        }

        previous.old = value;
        var validator = this;
        this.startRequest(element);
        var data = {};
        data[element.name] = value;
        var valid = "pending";
        $.ajax($.extend(true, {
            url: param,
            async: false,
            mode: "abort",
            port: "validate" + element.name,
            dataType: "json",
            data: data,
            success: function (response) {
                validator.settings.messages[element.name].remote = previous.originalMessage;
                valid = response === true || response === "true";
                if (valid) {
                    var submitted = validator.formSubmitted;
                    validator.prepareElement(element);
                    validator.formSubmitted = submitted;
                    validator.successList.push(element);
                    delete validator.invalid[element.name];
                    validator.showErrors();
                } else {
                    var errors = {};
                    var message = response || validator.defaultMessage(element, "remote");
                    errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message;
                    validator.invalid[element.name] = true;
                    validator.showErrors(errors);
                }
                previous.valid = valid;
                validator.stopRequest(element, valid);
            }
        }, param));
        return valid;
    }, "Please fix this field.");

    $('.numeric').ForceNumericOnly();
    $('.amount').ForcePriceOnly();

    $(document).on('click', '.addmore_text', function(e){
        var html = '<div class="input-group mt-2"><input type="text" class="form-control" name="value[]"><div class="input-group-append"><a href="javascript:void(0);" class="input-group-text danger addmore_text_remove">';
            html +='<i class="fa fa-times"></i></a></div></div>';
        $(this).parents('.addmore_holder').find('.add-more-first').after(html);
        var last_element = $(this).parents('.addmore_holder').find('.add-more-first');
        $(this).parents('.addmore_holder').find('.add-more-first').next('.input-group').find('.form-control').focus();
        $('.jconfirm-content-pane').animate({
            scrollTop: last_element.offset().top
        }, "slow");
    });

    $(document).on('click', '.addmore_text_remove', function(){
        var obj = $(this);
        var last_element = obj.parents('.addmore_holder').find('.add-more-first');
        $('.jconfirm-content-pane').animate({
            scrollTop: last_element.offset().top
        }, "slow");
        obj.parents('.input-group').remove();
    });

});

$(document).ready( function(){
    if(!image_upload_url){
        console.error('Image upload url not added. please add \'image_upload_url\'')
        return;
    }
    if($('.richtext').length)
    {
        $( ".richtext" ).each(function( index ) {

            $(this).summernote({
                callbacks: {
                    onImageUpload: function(files) {
                        that = $(this);
                        sendFile(files[0], that);
                    }
                }
            });
            function sendFile(files, that){
                data = new FormData();
                data.append("file", files);
                data.append("_token", $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    data: data,
                    type: "POST",
                    url: image_upload_url,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(url){
                        that.summernote('insertImage', url)
                    }
                });
            }

        });
    }
});

function media_file_upload()
{
    var progressBar = $('<div/>').addClass('progress').append($('<div/>').addClass('progress-bar')); //progress bar

    $('#mediafileupload').fileupload({
        dataType: 'json',
        formData: {
            "_token": _token,
            "related_type": $('#related_type').val(),
            "related_id": $('#related_id').val(),
        },
        add: function (e, data) {
            $('.nav-tabs a[data-target="#tab2Media"]').tab('show');
            data.context = $('<div/>').addClass('col-md-3 media-previe-wrap').prependTo('#mediaList');
            $.each(data.files, function (index, file) {
                var node = $('<p/>').addClass('media-upload-preview');
                progressBar.clone().appendTo(node);
                node.appendTo(data.context);
            });
            data.submit();
        },
        progress: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            if (data.context) {
                data.context.each(function () {
                    $(this).find('.progress').attr('aria-valuenow', progress).children().first().css('width',progress + '%').text(progress + '%');
                });
            }
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var extra_attr = $('#holder_attr').val();
                    var link = $('<img>')
                            .prop('src', file.url).attr('id', file.id).attr('data-extra-attr', extra_attr)
                            .attr('data-original-src', file.original_file).attr('data-type', file.type);
                    var html = '<div class="thumbnail text-center">';
                        html +='<img src="'+file.url+'" id="'+file.id+'" data-extra-attr="'+extra_attr+'" data-original-src="'+file.original_file+'" data-type="'+file.type+'" />';
                        html +='</div>';
                    $(data.context.children()[index]).replaceWith(html);

                    var popType = $('#popupType').val();
                    if(popType == 'single_image')
                    {
                        $('.imgChked').each(function(i, e) {
                            $(this).removeClass('imgChked');
                        });
                    }

                    $('#'+file.id).imgCheckbox({preselect: true});
                                        
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                                              .append('<br>')
                                              .append(error);
                }
            });
        }
    });
}

function file_upload()
{
    var progressBar = $('<div/>').addClass('progress').append($('<div/>').addClass('progress-bar')); //progress bar

    $('#fileupload').fileupload({
        dataType: 'json',
        formData: {
            "_token": _token,
            "related_type": $('#related_type').val(),
            "related_id": $('#related_id').val(),
        },
        add: function (e, data) {
            var wrapper = $('<div/>').addClass('col-md-3 item-img default-padding');
            data.context = $('<div/>').addClass('card');

            var innerHtml = '<div class="card-body">';
                innerHtml += '<div class="form-group"><input type="text" name="title[]" class="form-control" placeholder="Title"></div>';
                innerHtml += '<div class="form-group"><input type="text" name="alt[]" class="form-control" placeholder="Alt"></div><a href="javascript:void(0)" class="product-img-item-remove">Remove</a>';
                innerHtml += '</div>';
            $.each(data.files, function (index, file) {
                
                var node = $('<p/>').addClass('media-upload-preview');
                progressBar.clone().appendTo(node);
                node.appendTo(data.context);
                $(innerHtml).appendTo(data.context);
                data.context.appendTo(wrapper);
                console.log(data.context);
                $(wrapper).prependTo('#productGalleryList');
            });
            data.submit();
        },
        progress: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            if (data.context) {
                data.context.each(function () {
                    $(this).find('.progress').attr('aria-valuenow', progress).children().first().css('width',progress + '%').text(progress + '%');
                });
            }
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<img>')
                        .prop('src', file.url).attr('id', file.id).attr('class', 'card-img-top padding-20');
                    $(data.context.children()[index]).replaceWith(link);
                    $(data.context.children()[index]).after('<input type="hidden" name="media_id[]" id="mediaId'+file.id+'" value="'+file.id+'">');
                                    
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }
    });
}


function display_select2()
{
    if($('.select2_input').length)
    {
        $( ".select2_input" ).each(function( index ) {

            var url = $(this).data('select2-url');
            var placeholder = $(this).data('placeholder');
            var parent = $(this).data('parent');
            if (typeof parent !== typeof undefined && parent !== false)
                parent = $(parent);
            else
                parent = $('body');
            var can_tag = false;
            var check_is_tag = $(this).data('can-tag');
            if (typeof check_is_tag !== typeof undefined && check_is_tag !== false)
                can_tag = true;

            if (typeof url !== typeof undefined && url !== false){
                $(this).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    dropdownParent: parent,
                    tags: can_tag,
                    ajax: {
                        url: url,
                        dataType: 'json',
                        method: 'get',
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
            }
            else{
                $(this).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    dropdownParent: parent,
                    tags: can_tag
                });
            }
        });
    }
}

jQuery.fn.ForceNumericOnly = function()
{
    return this.each(function()
    {
        $(this).keypress(function(e)
        {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                var errorMessage = '<span class="text-danger">Invalid number!</span>';
                $(this).next('.text-danger').remove();
                $(this).after(errorMessage).next('.text-danger').fadeOut("slow");
                       return false;
            }
        });
    });
};

jQuery.fn.ForcePriceOnly = function()
{
    return this.each(function(){
        $(this).keyup(function(){
            var valid = /^\d{0,6}(\.\d{0,2})?$/.test(this.value),
            val = this.value;
            if(!valid){
                this.value = val.substring(0, val.length - 1);
                var errorMessage = '<span class="text-danger">Invalid amount!</span>';
                $(this).next('.text-danger').remove();
                $(this).after(errorMessage).next('.text-danger').fadeOut("slow");
                       return false;
            }
        })
    })
}

function confirm_alert(title, message, action, redirect_url)
{
    $.confirm({
        title: title,
        content: message,
        autoClose: 'ok_button1|8000',
        buttons: {
            ok_button1: {
                text: 'OK',
                btnClass: 'btn-success',
                action: function(){
                    if (typeof action !== "undefined" || action != null) { 
                        if(action == 'redraw')
                            dt();
                        else if(action == 'redirect'){
                            if (typeof redirect_url !== "undefined" || redirect_url != null) {
                                window.location.href= redirect_url;
                            }
                        } 
                    }
                }
            }
        }
    });
}

function slugify(string) {
    const a = 'Ã Ã¡Ã¢Ã¤Ã¦Ã£Ã¥ÄÄƒÄ…Ã§Ä‡ÄÄ‘ÄÃ¨Ã©ÃªÃ«Ä“Ä—Ä™Ä›ÄŸÇµá¸§Ã®Ã¯Ã­Ä«Ä¯Ã¬Å‚á¸¿Ã±Å„Ç¹ÅˆÃ´Ã¶Ã²Ã³Å“Ã¸ÅÃµá¹•Å•Å™ÃŸÅ›Å¡ÅŸÈ™Å¥È›Ã»Ã¼Ã¹ÃºÅ«Ç˜Å¯Å±Å³áºƒáºÃ¿Ã½Å¾ÅºÅ¼Â·/_,:;'
    const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiilmnnnnooooooooprrsssssttuuuuuuuuuwxyyzzz------'
    const p = new RegExp(a.split('').join('|'), 'g')

    return string.toString().toLowerCase()
        .replace(/\s+/g, '-') // Replace spaces with -
        .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
        .replace(/&/g, '-and-') // Replace & with 'and'
        .replace(/[^\w\-]+/g, '') // Remove all non-word characters
        .replace(/\-\-+/g, '-') // Replace multiple - with single -
        .replace(/^-+/, '') // Trim - from start of text
        .replace(/-+$/, '') // Trim - from end of text
}

function guidGenerator() {
    var S4 = function() {
        return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}


