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
            <div class="card card-borderless" style="padding: 10px">
                <h4>Quick links</h4>
                <ul>
                    <li><a href="{{url('admin/menus/edit/'.encrypt(9))}}}"> Edit main menu</a></li>
                </ul>

            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                <div>
                    <div class="row m-3">
                        <div class="col-md-12">
                            <form action="{{url('admin/static/home/highlights')}}" method="post" enctype="multipart/form-data">@csrf
                            <div class="row column-seperation padding-5">

                                <div class="col-md-12">
                                Home page banners
                                <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-group-default">
                                                <label>Link</label>
                                                <input type="text" class="form-control" name="{{('hb-banner-title')}}" placeholder="Enter title" value="{{Key::get('hb-banner-title')}}">
                                            </div>
                                        </div>
                                        @for($i=0;$i<9;$i++)
                                            <div class="col-md-2">
                                            @if(Key::get('hb-banner-'.($i+1).'-image') !== 'NA')

                                                    <img src="{{Key::get('hb-banner-'.($i+1).'-image')}}" alt="" width="100%;">
                                                - <a href="{{url('admin/static/home/cmd/delete/'.encrypt('hb-banner-'.($i+1).'-image'))}}" >click here</a> to remove image
                                            @endif
                                            </div>


                                        <div class="col-md-5">
                                            <div class="form-group form-group-default">
                                                <label>Banner Image {{($i+1)}}</label>
                                                <input type="file" class="form-control" name="{{('hb-banner-'.($i+1).'-image')}}" placeholder="Enter title">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group form-group-default">
                                                <label>Link</label>
                                                <input type="text" class="form-control" name="{{('hb-banner-'.($i+1).'-link')}}" placeholder="Enter title" value="{{Key::get('hb-banner-'.($i+1).'-link')}}">
                                            </div>

                                        </div>
                                        @endfor
                                    </div>


                                </div>




                            </div>
                            <button class="btn btn-success" type="submit">Update Banners</button>
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
        $('.remove-item-domestic').click(function () {
            confirm_alert('Are you sure ?','You are going to delete this category','redirect','{{url('admin/static/home/domestic/remove')}}/'+$(this).data('id'));
        });
        $('.remove-item-corporate').click(function () {
            confirm_alert('Are you sure ?','You are going to delete this category','redirect','{{url('admin/static/home/corporate/remove')}}/'+$(this).data('id'));
        });
    </script>
@endsection