@extends('admin.common.datatable')

@section('head')
    <style>
        .icon-bg{
            background: deepskyblue;
            width: auto;
            padding: 5px 10px;
            border-radius: 9px;
            display: inline-block;
        }

        .box-categories{
            background: aliceblue;
            margin: 10px 0px;
            border-radius: 5px;
            padding: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card card-borderless">
                <div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="row column-seperation padding-5">



                                <div class="col-md-12">
                                    <form action="{{url('admin/static/about')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        About us page
                                        <hr>
                                        <div class="form-group form-group-default">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="about_title" placeholder="Enter title" value="{{Key::get('about_title')}}">
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Summary</label>
                                            <textarea type="text" class="form-control richtext" name="about_description" placeholder="Enter summary">{{Key::get('about_description')}}</textarea>
                                        </div>

                                        <div class="col-md-12">
                                            @if(Key::get('about_intro_image') !== 'NA')
                                                <img src="{{Key::get('about_intro_image')}}" alt="" width="100px;">
                                                - <a href="{{url('admin/static/home/cmd/delete/'.encrypt('about_intro_image'))}}" >click here</a> to remove image
                                            @endif
                                            <div class="form-group form-group-default">
                                                <label>about_intro_image</label>
                                                <input type="file" class="form-control" name="about_intro_image" placeholder="Eg. 10">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            @if(Key::get('about_banner_image') !== 'NA')
                                                <img src="{{Key::get('about_banner_image')}}" alt="" width="100px;">
                                                - <a href="{{url('admin/static/home/cmd/delete/'.encrypt('about_banner_image'))}}" >click here</a> to remove image
                                            @endif
                                            <div class="form-group form-group-default">
                                                <label>about_banner_image</label>
                                                <input type="file" class="form-control" name="about_banner_image" placeholder="Eg. 10">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>about_vision_title</label>
                                                    <input type="text" class="form-control" name="about_vision_title"  value="{{Key::get('about_vision_title')}}">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>about_vision_description</label>
                                                    <textarea type="text" class="form-control" name="about_vision_desc">{{Key::get('about_vision_desc')}}</textarea>
                                                </div>
                                                @if(Key::get('about_vision_image') !== 'NA')
                                                    <img src="{{Key::get('about_vision_image')}}" alt="" width="100px;">
                                                    - <a href="{{url('admin/static/home/cmd/delete/'.encrypt('about_vision_image'))}}" >click here</a> to remove image
                                                @endif
                                                <div class="form-group form-group-default">
                                                    <label>about_vision_image</label>
                                                    <input type="file" class="form-control" name="about_vision_image" placeholder="Eg. 10">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>about_mission_title</label>
                                                    <input type="text" class="form-control" name="about_mission_title"  value="{{Key::get('about_mission_title')}}">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>about_mission_description</label>
                                                    <textarea type="text" class="form-control" name="about_mission_desc">{{Key::get('about_mission_desc')}}</textarea>
                                                </div>
                                                @if(Key::get('about_mission_image') !== 'NA')
                                                    <img src="{{Key::get('about_mission_image')}}" alt="" width="100px;">
                                                    - <a href="{{url('admin/static/home/cmd/delete/'.encrypt('about_mission_image'))}}" >click here</a> to remove image
                                                @endif
                                                <div class="form-group form-group-default">
                                                    <label>about_mission_image</label>
                                                    <input type="file" class="form-control" name="about_mission_image" placeholder="Eg. 10">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Why Hykon?</label>
                                                    <textarea type="text" class="form-control richtext" name="why_hykon">{{Key::get('why_hykon')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Highlights</label>
                                                    <textarea type="text" class="form-control richtext" name="about_highlights">{{Key::get('about_highlights')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-success" style="margin-top: 10px;" type="submit">Update</button>
                                    </form>
                                </div>

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('bottom')
    @parent

    <script>
        $('.remove-item-popular').click(function () {
            confirm_alert('Are you sure ?','You are going to delete this category','redirect','{{url('admin/static/home/popular/remove')}}/'+$(this).data('id'));
        });
        $('.remove-item-domestic').click(function () {
            confirm_alert('Are you sure ?','You are going to delete this category','redirect','{{url('admin/static/home/domestic/remove')}}/'+$(this).data('id'));
        });
        $('.remove-item-corporate').click(function () {
            confirm_alert('Are you sure ?','You are going to delete this category','redirect','{{url('admin/static/home/corporate/remove')}}/'+$(this).data('id'));
        });
    </script>
@endsection