@extends('admin.common.fileupload')

@section('head')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/cropper/css/cropper.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/cropper/css/main.css')}}">
    <style>
        .page-sidebar{
            z-index: 999 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">Edit Slider</span>
            </div>
            <!-- START card -->
            <div class="card card-borderless filter-wrap">
                <form method="POST" action="{{ route($route.'.update', [encrypt($obj->id)]) }}" class="p-t-15" id="DealerFrm" data-validate=true>
                  @csrf
                  <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                <div class="row m-2">
                    <div class="col-md-12">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Slider Name</label>
                                <input type="text" name="slider_name" class="form-control" value="{{$obj->slider_name}}" >
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
                            <a href="{{url('admin/media/popup', ['popup_type'=>'sliders-'.$obj->id, 'type'=>'Image'])}}" class="open-ajax-popup btn btn-primary" title="Media Images" data-popup-size="large"><i class="glyphicon glyphicon-plus-sign"></i> Add Photos</a>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ url('admin/sliders') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="card card-borderless padding-15">
                    <div class="row" id="photoList">
                        @include('admin.sliders.ajax_photos', ['photos'=>$obj->photos, 'slider'=>$obj->id, 'type'=>$type])
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