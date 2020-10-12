@extends('admin.common.datatable')

@section('head')

@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            <span class="page-heading">Support Requests</span>
            <div >
                <div class="btn-group">
                    <a href="{{route($route.'.index')}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    <a href="{{route($route.'.destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.index')}}"><i class="fa fa-trash"></i> Delete</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                <div>
                    <div class="row m-3">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Name</label>
                                        {{$obj->name}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                      <div class="form-group form-group-default">
                                          <label>Email</label>
                                         {{$obj->email}}
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Subject</label>
                                        {{$obj->subject}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Message</label>
                                        {{$obj->message}}
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

    <script type="text/javascript">

        var validator = $('#WarrantyFrm').validate({
            ignore: [],
            rules: {
                product_name: {
                    required: true,
                },
                category_id:{
                    required: true,
                },
                sale_price: "required",
              },
              messages: {
                "product_name": "Warranty name cannot be blank",
                "category_id": "Category cannot be blank",
                "sale_price": "Warranty price cannot be blank",
              },
            });
    </script>
@parent
@endsection