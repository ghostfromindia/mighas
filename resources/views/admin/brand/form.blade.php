@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT Brand</span>
            @else
                <span class="page-heading">Create Brand</span>
            @endif
            <div >
                <div class="btn-group">
                    <a href="{{route('admin.brand.home')}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    @if($obj->id)
                        <a href="{{route('admin.brand.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
                        <a href="{{route($route.'.destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.home')}}"><i class="fa fa-trash"></i> Delete</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.brand.update'), 'method' => 'post','enctype' => 'multipart/form-data'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}">
                @else
                    {{Form::open(['url' => route('admin.brand.save'), 'method' => 'post','enctype' => 'multipart/form-data'])}}
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
                           data-target="#tab3SEO"
                           class="" aria-selected="false">SEO</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab4Media"
                           class="" aria-selected="false">Media</a>
                    </li>

                </ul>
                <div class="nav-tab-dropdown cs-wrapper full-width d-lg-none d-xl-none d-md-none"><div class="cs-select cs-skin-slide full-width" tabindex="0"><span class="cs-placeholder">Hello World</span><div class="cs-options"><ul><li data-option="" data-value="#tab2hellowWorld"><span>Hello World</span></li><li data-option="" data-value="#tab2FollowUs"><span>Hello Two</span></li><li data-option="" data-value="#tab2Inspire"><span>Hello Three</span></li></ul></div><select class="cs-select cs-skin-slide full-width" data-init-plugin="cs-select"><option value="#tab2hellowWorld" selected="">Hello World</option><option value="#tab2FollowUs">Hello Two</option><option value="#tab2Inspire">Hello Three</option></select><div class="cs-backdrop"></div></div></div>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Brand name</label>
                                        {{ Form::text("brand_name", $obj->brand_name, array('class'=>'form-control', 'id' => 'brand_name','required' => true)) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Page heading</label>
                                        {{ Form::text("page_heading", $obj->page_heading, array('class'=>'form-control', 'id' => 'page_heading','required' => true)) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Brand slug (for url)</label>
                                        {{ Form::text("slug", $obj->slug, array('class'=>'form-control', 'id' => 'slug')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Website</label>
                                        {{ Form::text("website", $obj->website, array('class'=>'form-control', 'id' => 'website')) }}

                                    </div>
                                </div>
                            </div>

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
                                        {{ Form::textarea("meta_description", $obj->meta_description, array('class'=>'form-control', 'id' => 'meta_description')) }}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4Media">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Logo</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId0"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'0', 'related_id'=>$obj->id])}}" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-0">
                                          @if($obj->media_id && $obj->logo)
                                            <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->logo->thumb_file_path) }}">
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="media_id" id="mediaId0" value="{{$obj->media_id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
    <script>

        custom_summernote('top-description',"{{route('admin.summernote.image')}}");
    </script>
    @parent
@endsection