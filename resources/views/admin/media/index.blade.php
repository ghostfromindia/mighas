@extends('admin.common.datatable')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Media Library
    </h1>

  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <div class="upload-wrapper">
          <div id="error_output"></div>
              <!-- file drop zone -->
          <div id="dropzone" class="dropzone-wrapper">
                  <i>Drop files here</i>
                  <i class="sm-text">or</i>
                  <!-- upload button -->
                  <span class="button btn-blue input-file">
                      Browse Files <input type="file" id="fileupload" name="files[]" data-url="{{ url('admin/media/save')}}" multiple />
                  </span>
          </div>
              <!-- The container for the uploaded files -->
        </div>
      </div>
      <div class="box-body">
          <div id="files" class="files col-md-12"></div>
          <div class="media-list-head col-md-12">
            <div class="col-md-6">
              <a href="javascript:void(0);" class="btn btn-danger bulk-select">Bulk Select</a>
              <div class="bulk-delete-action" style="display: none;">
                <a href="javascript:void(0);" class="btn btn-danger bulk-select-delete">Delete Selected</a>
                <a href="javascript:void(0);" class="btn btn-default bulk-select-cancel">Cancel</a>
              </div>
            </div>
            <div class="col-md-6 text-right">
              <label>
                <input class="form-control input-sm" placeholder="Search..." aria-controls="datatable" type="search" id="mediaSearchInput">
              </label>
            </div>
          </div>
          <div class="col-md-12" id="mediaList">
            @include('admin.media.ajax_index', ['files'=>$files])
          </div>
      </div><!-- /.box-body -->
      <div class="box-footer">
      </div><!-- /.box-footer-->
    </div><!-- /.box -->

  </section><!-- /.content -->  

@endsection

@section('bottom')
  @parent


  <script type="text/javascript">
      $(function () {
        var progressBar = $('<div/>').addClass('progress').append($('<div/>').addClass('progress-bar')); //progress bar

        $('#fileupload').fileupload({
            dataType: 'json',
            formData: {
              "_token": '{{csrf_token()}}',
            },
            add: function (e, data) {
                data.context = $('<div/>').addClass('col-md-2 media-previe-wrap').prependTo('#mediaList');
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
              $.ajax({
                               url: "{{url('admin/media')}}",
                               success: function(data)
                               {
                                  $('#mediaList').html(data);
                                  $('input').iCheck({
                                    checkboxClass: 'icheckbox_square-blue',
                                    increaseArea: '20%' // optional
                                  });
                                  $('.bulk-select-delete').parent().hide();
                                  $('.bulk-select').show();
                               }
                            });
            }
        });

          $(document).on('click', '.media-nav .pagination .page-link', function(e){
              e.preventDefault();
              var loadurl = $(this).attr('href');
              var targ = $('#mediaList');
              if(loadurl != 'undefined'){
                  targ.load(loadurl, function(){
                    $('#ajaxUrl').val(loadurl);
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        increaseArea: '20%' // optional
                    });
                    $('.bulk-select-delete').parent().hide();
                    $('.bulk-select').show();
                  });
              }
          });

          $(document).on('keyup', '#mediaSearchInput', function(e){
            var req = $(this).val();
            var loadurl = "{{url('admin/media')}}";
            $.ajax({
               url: loadurl,
               data: {req: req}, // serializes the form's elements.
               success: function(data)
               {
                  $('#mediaList').html(data);
                  $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    increaseArea: '20%' // optional
                  });
                  $('.bulk-select-delete').parent().hide();
                  $('.bulk-select').show();
               }
             });
          });

          $(document).on('click', '.media-delete', function(e){
              var id = $(this).attr('data-id');
              var req = $('#mediaSearchInput').val();
              var page = $('#currentPage').val();
              var loadurl = "{{url('admin/media')}}";
              BootstrapDialog.confirm({
                    title: 'WARNING',
                    message: "Are you sure?",
                    type: BootstrapDialog.TYPE_WARNING,
                    btnOKLabel: 'Proceed',
                    callback: function(result){
                        if(result) {
                            $.ajax({
                               url: loadurl,
                               data: {
                                  req: req,
                                  page: page,
                                  id: id,
                                  action: 'delete',
                               },
                               success: function(data)
                               {
                                  $('#mediaList').html(data);
                                  bd.close();
                                  $('input').iCheck({
                                    checkboxClass: 'icheckbox_square-blue',
                                    increaseArea: '20%' // optional
                                  });
                                  $('.bulk-select-delete').parent().hide();
                                  $('.bulk-select').show();
                               }
                            });
                        }else {
                            return false;
                        }
                    }
                }); 
            });

          $(document).on('click', '.bulk-select', function(){
              $('.parent .icheckbox_square-blue').each(function(){
                $(this).show();
                $(this).siblings('.media-delete').hide();
              });
              $(this).hide();
              $('.bulk-delete-action').show();
          });

          $(document).on('click', '.bulk-select-cancel', function(){
              $('.parent .icheckbox_square-blue').each(function(){
                $(this).hide();
                $(this).siblings('.media-delete').show();
              });
              $(this).parent().hide();
              $('.bulk-select').show();
          });

          $(document).on('click', '.bulk-select-delete', function(){
              var req = $('#mediaSearchInput').val();
              var page = $('#currentPage').val();
              var loadurl = "{{url('admin/media')}}";
              var ids = [];
              $("input:checked").each(function () {
                  var id = $(this).val();
                  ids.push(id);
              });
              if(ids != '')
              {
                    $.ajax({
                               url: loadurl,
                               data: {
                                  req: req,
                                  page: page,
                                  ids: ids,
                                  action: 'bulk_delete',
                               },
                               success: function(data)
                               {
                                  $('#mediaList').html(data);
                                  $('input').iCheck({
                                    checkboxClass: 'icheckbox_square-blue',
                                    increaseArea: '20%' // optional
                                  });
                                  $('.bulk-select-delete').parent().hide();
                                  $('.bulk-select').show();
                               }
                            });
              }
              else{
                BootstrapDialog.alert("Select a photo");
              }
          });
    });

    function readURL(input, ) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
  @parent
@endsection