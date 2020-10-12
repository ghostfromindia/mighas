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
                            <form action="{{url('admin/static/save')}}" method="post" enctype="multipart/form-data">@csrf
                                <div class="row column-seperation padding-5">

                                    <div class="col-md-12">
                                        Site Settings
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <label>Home banner title</label>
                                                    <input type="text" class="form-control" name="{{('hb-banner-title')}}" placeholder="Enter title" value="{{Key::get('hb-banner-title')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    @if(Key::get('site-logo-image') !== 'NA')

                                                        <img src="{{Key::get('site-logo-image')}}" alt="" width="100%;">
                                                        - <a href="{{url('admin/static/home/cmd/delete/'.encrypt('site-logo'))}}" >click here</a> to remove image
                                                    @endif
                                                    <label>Site Logo</label>
                                                    <input type="file" class="form-control" name="{{('site-logo-image')}}" placeholder="Enter title">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <label>Site description</label>
                                                    <input type="text" class="form-control" name="{{('site-description')}}" placeholder="Enter title" value="{{Key::get('site-description')}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <label>Contact us</label>
                                                    <input type="text" class="form-control" name="{{('site-contact-us')}}" placeholder="Enter title" value="{{Key::get('site-contact-us')}}">
                                                </div>
                                            </div>


                                        </div>


                                    </div>




                                </div>
                                <button class="btn btn-success" type="submit">Update data</button>
                            </form>
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

    </script>
@endsection