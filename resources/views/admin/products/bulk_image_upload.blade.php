@extends('admin.common.datatable')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Add Images for products</span>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                  <div class="padding-20">
                        <div class="upload-wrapper">
                            <div id="error_output"></div>
                                <!-- file drop zone -->
                            <div id="dropzone" class="dropzone-wrapper">
                                    <i>Drop files here</i>
                                    <i class="sm-text">or</i>
                                    <!-- upload button -->
                                    <span class="button btn-blue input-file">
                                        Browse Files <input type="file" id="bulkfileupload" name="files[]" data-url="{{ url('admin/bulk-image-upload-save')}}" multiple />
                                    </span>
                            </div>
                                <!-- The container for the uploaded files -->
                          </div>
                          <div class="row" id="mediaList"></div>
                    </div>
            </div>
        </div>
    </div>
@endsection
@section('bottom')
    <script>
      $(function(){
        var progressBar = $('<div/>').addClass('progress').append($('<div/>').addClass('progress-bar')); //progress bar

        $('#bulkfileupload').fileupload({
            dataType: 'json',
            formData: {
              "_token": '{{csrf_token()}}',
            },
            add: function (e, data) {
                data.context = $('<div/>').addClass('col-md-2 media-previe-wrap').appendTo('#mediaList');
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
                      var link = $('<img>')
                          .prop('src', file.url).attr('id', file.id).attr('class', 'card-img-top padding-20');
                      $(data.context.children()[index]).replaceWith(link);
                      $(data.context.children()[index]).after('<input type="hidden" name="media_id[]" id="mediaId'+file.id+'" value="'+file.id+'">');
                                      
                  } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                      $(data.context.children()[index]).replaceWith(error);
                  }
              });
            }
        });
      })
    </script>
    @parent
@endsection