@extends('admin.common.datatable')

@section('head')
  <style type="text/css">
    .dataTables_wrapper .row > div{
      display: block !important;
    }

    div.dataTables_wrapper div.dataTables_length label {
        font-weight: normal;
        text-align: left;
        white-space: nowrap;
    }

    div.dataTables_wrapper div.dataTables_filter {
        text-align: right;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 75px;
        display: inline-block;
    }

    #datatable {
      width: 100% !important;
    }
  </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT Category</span>
            @else
                <span class="page-heading">Create Category</span>
            @endif
            <div >
                <div class="btn-group">
                    <a href="{{route('admin.category.home')}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    @if($obj->id)
                    <a href="{{route('admin.category.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                    </a>
                    <a href="{{route($route.'.destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.home')}}"><i class="fa fa-trash"></i> Delete</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.category.update'), 'method' => 'post','enctype' => 'multipart/form-data'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}">
                @else
                    {{Form::open(['url' => route('admin.category.save'), 'method' => 'post','enctype' => 'multipart/form-data'])}}
                @endif
                @csrf

                <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active show" data-toggle="tab" role="tab"
                           data-target="#tab1Basic"
                        href="#" aria-selected="true">Mandatory Details</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab2Content"
                        class="" aria-selected="false">Content</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab3SEO"
                        class="" aria-selected="false">SEO</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab4Media"
                           class="" aria-selected="false">Media</a>
                    </li>
                    @if($obj->id)
                        <li class="nav-item">
                            <a href="#" data-toggle="tab" role="tab"
                               data-target="#tab5Media"
                               class="" aria-selected="false">Attributes</a>
                        </li>
                    @endif
                </ul>
                <div class="nav-tab-dropdown cs-wrapper full-width d-lg-none d-xl-none d-md-none"><div class="cs-select cs-skin-slide full-width" tabindex="0"><span class="cs-placeholder">Hello World</span><div class="cs-options"><ul><li data-option="" data-value="#tab2hellowWorld"><span>Hello World</span></li><li data-option="" data-value="#tab2FollowUs"><span>Hello Two</span></li><li data-option="" data-value="#tab2Inspire"><span>Hello Three</span></li></ul></div><select class="cs-select cs-skin-slide full-width" data-init-plugin="cs-select"><option value="#tab2hellowWorld" selected="">Hello World</option><option value="#tab2FollowUs">Hello Two</option><option value="#tab2Inspire">Hello Three</option></select><div class="cs-backdrop"></div></div></div>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Category name</label>
                                        {{ Form::text("category_name", $obj->category_name, array('class'=>'form-control', 'id' => 'category_name','required' => true)) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Page title</label>
                                        {{ Form::text("page_title", $obj->page_title, array('class'=>'form-control', 'id' => 'page_title')) }}

                                    </div>
                                </div>
                            </div>

                            @php
                                $category = Key::get('category-type');
                                $types = explode(',',$category)
                            @endphp

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Category type</label>
                                        <select name="type" class="form-control">
                                            @if($obj->type == null)
                                                <option value="">Choose a type</option>
                                            @else
                                                <option value="{{$obj->type}}">{{$obj->type}}</option>
                                            @endif
                                        @foreach($types as $type)
                                            <option value="{{$type}}">{{$type}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Category tagline</label>
                                        {{ Form::text("tagline", $obj->tagline, array('class'=>'form-control', 'id' => 'tagline')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label class="">Parent Category</label>
                                        {!! Form::select('parent_category_id',$obj->selected($obj->parent_category_id), $obj->parent_category_id, array('placeholder'=>'Choose a category','data-init-plugin'=>'select2','data-select2-url'=>route('admin.category.select2'),'class'=>'full-width select2_input', 'id'=>'parent')); !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Category slug (for url)</label>
                                        {{ Form::text("slug", $obj->slug, array('class'=>'form-control', 'id' => 'slug')) }}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2Content">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default required">
                                            <label>Policies</label>
                                            {{ Form::textarea("policies", $obj->policies, array('class'=>'form-control topdescription richtext', 'id' => 'policies')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default required">
                                            <label>Top content</label>
                                            {{ Form::textarea("top_description", $obj->top_description, array('class'=>'form-control topdescription richtext', 'id' => 'top-description')) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default required">
                                            <label>Bottom content</label>
                                            {{ Form::textarea("bottom_description", $obj->bottom_description, array('class'=>'form-control topdescription richtext', 'id' => 'bottom-description')) }}
                                        </div>
                                    </div>
                                </div>



                                {{--@if($types && $obj->parent_category_id == 0)--}}

                                    {{--@foreach($types as $o)--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="row column-seperation padding-5">--}}
                                            {{--<div class="form-group form-group-default required">--}}
                                                {{--<label>{{$o}} content</label>--}}
                                                {{--{{ Form::textarea($o."_description",Key::get($obj->id.'-'.$o), array('class'=>'form-control topdescription richtext', 'id' => $o.'-description')) }}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--@endforeach--}}
                                        {{--@php $o = "POPULAR"; @endphp--}}
                                        {{--<div class="col-md-12">--}}
                                            {{--<div class="row column-seperation padding-5">--}}
                                                {{--<div class="form-group form-group-default required">--}}
                                                    {{--<label>{{$o}} content</label>--}}
                                                    {{--{{ Form::textarea($o."_description",Key::get($obj->id.'-'.$o), array('class'=>'form-control topdescription richtext', 'id' => $o.'-description')) }}--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                {{--@endif--}}
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3SEO">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Meta title</label>
                                        {{ Form::text("browser_title", $obj->browser_title, array('class'=>'form-control', 'id' => 'browser_title')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Meta Keywords</label>
                                        {{ Form::text("meta_keywords", $obj->meta_keywords, array('class'=>'form-control', 'id' => 'meta_keywords')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Meta description</label>
                                        <input type="text" class="form-control" name="meta_description">
                                        {{ Form::text("meta_description", $obj->meta_description, array('class'=>'form-control', 'id' => 'meta_description')) }}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4Media">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Banner Image</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId0"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'0', 'related_id'=>$obj->id])}}" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-0">
                                          @if($obj->banner_image && $obj->banner)
                                            <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->banner->thumb_file_path) }}">
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="banner_image" id="mediaId0" value="{{$obj->banner_image}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Featured Image</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId1"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'1', 'related_id'=>$obj->id])}}" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-1">
                                          @if($obj->thumbnail_image && $obj->primary)
                                            <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->primary->thumb_file_path) }}">
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="thumbnail_image" id="mediaId1" value="{{$obj->thumbnail_image}}">
                                    </div>
                              </div>
                            </div>


                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Brochure upload</p>
                                    <div class="default-image-holder padding-5">
                                        @if($obj->brochure) <a href="javascript:void(0);" class="pdf-remove" data-remove-id="mediaId2" data-remove="{{encrypt($obj->id)}}"><i class="fa  fa-times-circle"></i></a>  @endif
                                        <a href="{{route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Pdf', 'holder_attr'=>'2', 'related_id'=>$obj->id])}}" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-1">
                                            @if($obj->brochure)
                                                <a class="pdf" href="{{ asset('public/'.$obj->brochure->file_path) }}" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 120px;"></i></a>
                                            @else
                                                <img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}">
                                            @endif
                                        </a>
                                        <input type="hidden" name="brochure_pdf" id="mediaId2" value="{{$obj->brochure_pdf}}">
                                    </div>
                                </div>
                            </div>

                            {{--@if($types && $obj->parent_category_id == 0)--}}

                                {{--@foreach($types as $o)--}}
                                    {{--<div class="col-md-6">--}}
                                        {{--<div class="row column-seperation padding-5">--}}
                                            {{--<img src="{{Key::get($obj->id.'-img-'.$o)}}" alt="" width="100px">--}}
                                            {{--<div class="form-group form-group-default required">--}}
                                                {{--<label>{{$o}} Banner</label>--}}
                                                {{--<input type="file" name="{{$o}}_img" class="form-control">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--@endforeach--}}
                                {{--@php $o = "POPULAR"; @endphp--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="row column-seperation padding-5">--}}
                                        {{--<img src="{{Key::get($obj->id.'-img-'.$o)}}" alt="" width="100px">--}}
                                        {{--<div class="form-group form-group-default required">--}}
                                            {{--<label>{{$o}} Banner</label>--}}
                                            {{--<input type="file" name="{{$o}}_img" class="form-control">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                            {{--@endif--}}



                        </div>
                    </div>
                    @if($obj->id)
                        <div class="tab-pane" id="tab5Media">
                            <div class="">
                                <div class="row pull-right mb-2">
                                    <a href="{{route('admin.category.attribute.create', $obj->id)}}" class="btn btn-success open-ajax-confirm" title="Create New Attribute"><i class="fa fa-pencil"></i> Create new Attribute</a>
                                </div>
                                @include('admin.category.attributes.list', ['is_category'=>$obj->id])
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('bottom')
    <script type="text/javascript">

        $(document).on('click', '.pdf-remove', function(){
            var remove = $(this).data('remove');
            $.get('{{url('admin/category/brochure')}}/'+remove).done(function () {
                window.location.reload()
            })

        })





        var my_columns = [
            {data: null, name: 'id'},
            {data: 'group_name', name: 'product_cateory_attribute_groups.group_name'},
            {data: 'attribute_name', name: 'attribute_name'},
            {data: 'show_as_variant', name: 'show_as_variant'},
            {data: 'value_count', name: 'value_count'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [4, 'desc'];

        function validate()
        {
            $('#AttributeFrm').validate({
                ignore: [],
                rules: {
                    category_id: "required",
                    attribute_name: "required",
                  },
                  messages: {
                    category_id: "Category cannot be blank",
                    attribute_name: "Attribute name cannot be blank",
                  },
            });
        }
        
        $(document).ready(function(){
            $(document).on('change', '#inputAttributeType', function(){
                if($(this).val() == 'Selectable')
                {
                    $('.addmore_holder').show();
                    $('.variant-level-holder').show();
                }
                else
                {
                    $('.addmore_holder').hide();
                    $('.variant-level-holder').hide();
                }
            });

            $(document).on('click', '#create_new_group', function(){
                var obj = $(this);
                if ($('#new-group-sec').css('display') == 'none') {
                    obj.text('Cancel');
                    $('#new-group-sec').show();
                }
                else{
                    obj.text('Create New Group');
                    $('#new-group-sec').hide();
                }
            })
        })
    </script>
@parent
@endsection