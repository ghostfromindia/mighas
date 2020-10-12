@extends('admin.common.fileupload')

@section('head')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/cropper/css/cropper.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/cropper/css/main.css')}}">
    <style>
        .page-sidebar{
            z-index: 999 !important;
        }
        .thumbnail{
            background: #e8e9ea;margin: 5px 5px 10px 10px
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">Edit Banner <small style="    text-transform: none;
    font-size: 11px;">- <a href="{{url('admin/banners')}}">Go back to banner list</a></small></span>
            </div>
            <!-- START card -->
            <div class="card card-borderless filter-wrap">
                <form method="POST" action="{{ route($route.'.update', [encrypt($obj->id)]) }}" class="p-t-15" id="DealerFrm" data-validate=true>
                  @csrf
                  <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                <div class="row m-2">
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Name</label>
                                <input type="text" name="banner_name" class="form-control" value="{{$obj->banner_name}}" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Link</label>
                                <input type="text" name="link" class="form-control" value="{{$obj->link}}" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Title</label>
                                <input type="text" name="title" class="form-control" value="{{$obj->title}}" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Width</label>
                                <input type="text" name="width" class="form-control" value="{{$obj->width}}" maxLength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Height</label>
                                <input type="text" name="height" class="form-control" value="{{$obj->height}}" maxLength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <a href="{{url('admin/media/popup', ['popup_type'=>'banners-'.$obj->id, 'type'=>'Image'])}}" class="open-ajax-popup btn btn-primary" title="Media Images" data-popup-size="large"><i class="glyphicon glyphicon-plus-sign"></i> Add Photos</a>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ url('admin/banners') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="card card-borderless padding-15">
                    <div class="row" id="photoList">
                        @include('admin.banners.ajax_photos', ['photos'=>$obj->photos, 'slider'=>$obj->id, 'type'=>$type])
                    </div>
            </div>
            <!-- END card -->
        </div>
    </div>
@endsection
@section('bottom')

    <script src="{{ asset('assets/plugins/cropper/js/common.js')}}"></script>
    <script src="{{ asset('assets/plugins/cropper/js/cropper.js')}}"></script>
    <script src="{{ asset('assets/plugins/cropper/js/jquery-cropper.js')}}"></script>
    @parent
@endsection