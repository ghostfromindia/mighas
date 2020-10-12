@extends('admin._layouts.default')


@section('content-area')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Menu
      <a href="{{url('admin/menus/create')}}" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Add new</a>
    </h1>
  </section>

   <!-- Main content -->
  <section class="content">
      <div class="box">
        @if($obj->id)
                            
                            {!! Form::model($obj, array('method' => 'post', 'url' => url('admin/menus/update', $obj->id), 'files' => true, 'role' => 'form', 'id' => 'menuFrm')) !!}
                        @else
                            
                            {!! Form::open(array('url' => url('admin/menus/store'), 'files' => true, 'role' => 'form', 'id' => 'menuFrm')) !!} 
                        @endif
        <div class="box-header">
          @include('admin._partials.notifications')
        </div>
        <div class="box-body">
                          <div class="col-md-6">
                              <div class="form-group required">
                                  <label class="control-label" for="inputStatus">Status</label>
                                  {!! Form::select('status', array('1'=>'Enabled', '0'=>'Disabled'), null, array('class'=>'form-control', 'id'=>'inputStatus')); !!}
                              </div>
                          </div><!-- /.box-body -->

                          <div class="col-md-6">
                              <div class="form-group required">
                                  <label class="control-label" for="inputCode">Menu Position</label>
                                  {!! Form::select('menu_position', array('Header'=>'Header', 'Footer'=>'Footer', 'Social Media Links'=>'Social Media Links'), null, array('class'=>'form-control', 'id'=>'inputPosition')); !!}
                              </div>
                          </div><!-- /.box-body -->
                          <div class="col-md-12">
                            <div class="form-group required">
                                  <label class="control-label" for="inputCode">Name</label>
                                  {{ Form::text('name', null, array('class'=>'form-control', 'id' => 'inputName')) }}
                                  <span class="error"></span>
                              </div>
                            <label class="col-md-12 row">Menu Settings ( Select and add menus to right )  </label> 
                            <div class="col-md-4 row"> 
                              <div class="custom-accordion">
                                <div class="accord-header">Pages<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content accord-on">
                                  @if(count($pages)>0)
                                    
                                      {!! Helper::admin_page_list(0) !!}
                                   
                                    <p class="text-right">
                                      <button type="button" id="add-page-links" class="btn btn-primary btn-sm">Add to Menu</button>
                                    </p>
                                  @endif
                                </div>
                                <div class="accord-header">Internal Links<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  <p><input type="checkbox" name="internal_links[]" value="internal_link-product" class="internal_links" data-name="Products" data-url="products"> Products</p>
                                  <p><input type="checkbox" name="internal_links[]" value="internal_link-photo_gallery" class="internal_links" data-name="Photo Gallery" data-url="photos"> Photo Gallery</p>
                                  <p><input type="checkbox" name="internal_links[]" value="internal_link-video_gallery" class="internal_links" data-name="Video Gallery" data-url="videos"> Video Gallery</p>
                                  <p><input type="checkbox" name="internal_links[]" value="internal_link-news" class="internal_links" data-name="News & Press Release" data-url="news"> News & Press Release</p>
                                  <p><input type="checkbox" name="internal_links[]" value="internal_link-warranty_support" class="internal_links" data-name="Warranty Support" data-url="warranty-support"> Warranty Support</p>
                                  <p><input type="checkbox" name="internal_links[]" value="internal_link-tech_support" class="internal_links" data-name="Tech Support" data-url="tech-support"> Tech Support</p>
                                  <p><input type="checkbox" name="internal_links[]" value="internal_link-sales_support" class="internal_links" data-name="Sales Support" data-url="sales-support"> Sales Support</p>
                                  <p><input type="checkbox" name="internal_links[]" value="internal_link-jobs" class="internal_links" data-name="Careers" data-url="jobs"> Careers</p>
                                  <p class="text-right">
                                    <button type="button" id="add-internal-links" class="btn btn-primary btn-sm">Add to Menu</button>
                                  </p>
                                </div>
                                <div class="accord-header">Custom Links<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  <div class="form-group">
                                      <span class="control-label" for="inputCode">Link Text</span>
                                      {{ Form::text('custom_link_text', null, array('class'=>'form-control', 'id' => 'inputCustomLinkText')) }}
                                  </div>
                                  <div class="form-group">
                                      <span class="control-label" for="inputCode">Url</span>
                                      {{ Form::text('custom_url', null, array('class'=>'form-control', 'id' => 'inputCustomUrl')) }}
                                  </div>
                                  <div class="form-group">
                                      <input type="checkbox" id="inputTarget"> New Window
                                  </div>
                                  <div class="form-group text-right">
                                      <button type="button" id="add-custom-links" class="btn btn-primary btn-sm">Add to Menu</button>
                                  </div>
                                </div>
                              </div> 
                            </div>
                            <div class="col-md-8">
                              <div class="dd">
                                  <ol class="dd-list custom-accordion-menu">
                                    @if($obj->id && $obj->menu_items)
                                      @include('admin._partials.menu', ['items'=>$obj->menu_items])
                                    @endif
                                  </ol>
                              </div>
                              <input type="hidden" name="menu_settings" id="inputMenuSettings">
                              <span class="error"></span>
                            </div>
                          </div>
        </div>
        <div class="box-footer">
          <div class="btn-holder text-right">
                    <button type="button" class="btn btn-primary" id="save-btn">Save</button>
                    <a href="{{url('admin/menus')}}" class="btn btn-default">Cancel</a>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
  </section><!-- /.content -->  
@endsection
@section('footer-assets')
  @parent
  <script src="{{ asset('public/assets/js/jquery.nestable.js')}}"></script> 
  <script type="text/javascript">
    $(document).ready(function(){
      $('.dd').nestable({ /* config options */ });
      var validator = $("#menuFrm").validate({
          ignore: [],
          errorPlacement: function(error, element){
              $(element).each(function (){
                  $(this).parent('div').find('span.error').html(error);
              });
          },
          rules: {
            name: "required",
            menu_settings: "required",
          },
          messages: {
            name: "Enter menu name",
            menu_settings: "Setup a menu using menu settings",
          },
        });

      $(document).on('click', '#save-btn', function(){
        $('#inputMenuSettings').val(JSON.stringify($('.dd').nestable('serialize')));
        if($("#menuFrm").valid())
        {
          $('#menuFrm').submit();
        }
      })
      $(document).on('click', '#add-internal-links', function(){
          $(".internal_links:checked").each(function () {
              var id = $(this).val();
              var name = $(this).attr('data-name');
              var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group required"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/><input type="hidden" name="menu['+id+'][url]" value="'+$(this).attr('data-url')+'"/><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/><input type="hidden" name="menu['+id+'][original_title]" value="'+name+'"/></div><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
              var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
              $('.dd > .dd-list').append(html);
              $('.dd').nestable();
              $(this).iCheck('uncheck');
          });

      });

      $(document).on('click', '#add-custom-links', function(){
          var name = $('#inputCustomLinkText').val();
          var url = $('#inputCustomUrl').val();
          if(name != '' && url != '')
          {
              $('#inputCustomLinkText').removeClass('errorBox');
              $('#inputCustomUrl').removeClass('errorBox');
              var id = 'custom_link-'+name;
              var target_blank = 0;
              var checked = "";
              if($("#inputTarget").is(":checked"))
              {
                target_blank = 1
                checked = "checked";
              }
              var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group required"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/></div><div class="form-group required"><label class="control-label" for="inputCode">Url</label><input type="text" name="menu['+id+'][url]" class="form-control" value="'+url+'"/></div><div class="form-group required"><input type="checkbox" name="menu['+id+'][target_blank]" '+checked+'/> New Window</div><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/><input type="hidden" name="menu['+id+'][original_title]" value="'+name+'"/><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
              var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
              $('.dd > .dd-list').append(html);
              $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
              });
              $('.dd').nestable();
              $('#inputCustomLinkText').val('');
              $('#inputCustomUrl').val('');
              $("#inputTarget").iCheck('uncheck');
          }
          else{
            if(name == "")
              $('#inputCustomLinkText').addClass('errorBox');
            else
              $('#inputCustomLinkText').removeClass('errorBox');

            if(url == "")
              $('#inputCustomUrl').addClass('errorBox');
            else
              $('#inputCustomUrl').removeClass('errorBox');
          }
      });

      $(document).on('click', '#add-page-links', function(){
          $(".page_links:checked").each(function () {
              var id = $(this).val();
              var name = $(this).attr('data-name');
              var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group required"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/><input type="hidden" name="menu['+id+'][id]" value="'+$(this).attr('data-id')+'"/><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/></div><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
              var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
              $('.dd > .dd-list').append(html);
              $('.dd').nestable();
              $(this).iCheck('uncheck');
          });
      });

      $(document).on('click', '.custom-accordion .accord-header', function(){
          if($(this).next("div").is(":visible")){
            $(this).next("div").slideUp("slow");
            $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
          } else {
            $(".custom-accordion .accord-content").slideUp("slow");
            $('.toggle-arraow').each(function(i, e) {
              $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
            });
            $(this).next("div").slideToggle("slow");
            $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
          }
      });

      $(document).on('click', '.custom-accordion-menu .accord-header', function(){
          if($(this).next("div").is(":visible")){
            $(this).next("div").slideUp("slow");
            $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
          } else {
            $(".custom-accordion-menu .accord-content").slideUp("slow");
            $('.toggle-arraow').each(function(i, e) {
              $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
            });
            $(this).next("div").slideToggle("slow");
            $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
          }
      });

      $(document).on('click', '.remove-menu', function(){
        $(this).parents('.accord-content').parent().remove();
        $('.dd').nestable();
      });

      $(document).on('keyup', '.menu-title-input', function(){
        $(this).parents('.accord-content').siblings('.accord-header').find('.menu-title').html($(this).val());
      })
  
    });
  </script>
@endsection