@extends('admin.common.base')

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT Vendor</span>
            @else
                <span class="page-heading">Create Vendor</span>
            @endif
            <div >
                <div class="btn-group">
                    <a href="{{route('admin.vendor.home')}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    @if($obj->id)
                        <a href="{{route('admin.vendor.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
                        <button type="button" class="btn btn-success"><i class="fa fa-trash-o"></i> Delete
                        </button>
                    @endif
                </div>
            </div>
        </div>


        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.vendor.update'), 'method' => 'post','enctype' => 'multipart/form-data'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}">
                @else
                    {{Form::open(['url' => route('admin.vendor.save'), 'method' => 'post','enctype' => 'multipart/form-data'])}}
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

                </ul>
                <div class="nav-tab-dropdown cs-wrapper full-width d-lg-none d-xl-none d-md-none"><div class="cs-select cs-skin-slide full-width" tabindex="0"><span class="cs-placeholder">Hello World</span><div class="cs-options"><ul><li data-option="" data-value="#tab2hellowWorld"><span>Hello World</span></li><li data-option="" data-value="#tab2FollowUs"><span>Hello Two</span></li><li data-option="" data-value="#tab2Inspire"><span>Hello Three</span></li></ul></div><select class="cs-select cs-skin-slide full-width" data-init-plugin="cs-select"><option value="#tab2hellowWorld" selected="">Hello World</option><option value="#tab2FollowUs">Hello Two</option><option value="#tab2Inspire">Hello Three</option></select><div class="cs-backdrop"></div></div></div>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Vendor name</label>
                                        {{ Form::text("vendor_name", $obj->vendor_name, array('class'=>'form-control', 'id' => 'vendor_name','required' => true)) }}

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
                                        <label>Contact name</label>
                                        {{ Form::text("contact_name", $obj->contact_name, array('class'=>'form-control', 'id' => 'contact_name')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Phone number</label>
                                        {{ Form::text("phone", $obj->phone, array('class'=>'form-control', 'id' => 'phone')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Email address</label>
                                        {{ Form::email("email", $obj->email, array('class'=>'form-control', 'id' => 'email')) }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Vendor slug (for url)</label>
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
                                        <label>Description</label>
                                        {{ Form::textarea("top_description", $obj->top_description, array('class'=>'richtext form-control topdescription', 'id' => 'top-description')) }}
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
                                        {{ Form::textarea("meta_description", $obj->meta_description, array('class'=>'form-control rich_text', 'id' => 'meta_description')) }}

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