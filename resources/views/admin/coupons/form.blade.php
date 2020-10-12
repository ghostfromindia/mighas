@extends('admin.common.datatable')

@section('head')

@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT COUPON</span>
            @else
                <span class="page-heading">CREATE NEW COUPON</span>
            @endif
            <div >
                <div class="btn-group">
                    <a href="{{route($route.'.index')}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    @if($obj->id)
                    <a href="{{route($route.'.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                    </a>
                    <a href="{{route($route.'.destroy', [encrypt($obj->id)])}}" class="btn btn-success miniweb-btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.index')}}"><i class="fa fa-trash"></i> Delete</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="CouponFrm" data-validate=true>
                @else
                    <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="CouponFrm" data-validate=true>
                @endif
                @csrf
                <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">

                <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active show" data-toggle="tab" role="tab"
                           data-target="#tab1Basic"
                        href="#" aria-selected="true">Basic Details</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-12">
                                <div data-keditor="html">
                                    <div id="content-area"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Coupon Code</label>
                                        <input type="text" name="coupon_code" class="form-control" value="{{$obj->coupon_code}}" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Minimum Purchase Value</label>
                                        <input type="text" name="minimum_purchase_value" class="form-control amount" value="{{$obj->minimum_purchase_value}}" id="minimum_purchase_value">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label class="">Discount Type</label>
                                        <select name="discount_type" class="full-width select2_input" data-placeholder="Select Discount Type" data-init-plugin="select2" id="discount_type">
                                            <option value="Percentage">Percentage</option>
                                            <option value="Amount">Amount</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" @if($obj->discount_type == "Amount") style="display:none;" @endif id="discount_percentage_wrap">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Discount Percentage</label>
                                        <input type="text" name="discount_percentage" id="discount_percentage" class="form-control numeric" value="{{$obj->discount_percentage}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" @if(!$obj->discount_type || $obj->discount_type == "Percentage") style="display:none;" @endif id="discount_amount_wrap">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Discount Amount</label>
                                        <input type="text" name="discount_amount" id="discount_amount" class="form-control numeric" value="{{$obj->discount_amount}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Maximum Discount Value</label>
                                        <input type="text" name="maximum_discount_value" class="form-control amount" value="{{$obj->maximum_discount_value}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Start Date</label>
                                        <input type="text" name="start_date" id="start_date" class="form-control datepicker" value="@if($obj->start_date) {{date('d-m-Y', strtotime($obj->start_date))}} @endif" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>End Date</label>
                                        <input type="text" name="end_date" class="form-control datepicker" value="@if($obj->end_date) {{date('d-m-Y', strtotime($obj->end_date))}} @endif" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3" id="description">{{$obj->description}}</textarea>
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
                </form>
            </div>
        </div>
    </div>
@endsection
@section('bottom')

        <script type="text/javascript" data-keditor="script">
            $(function () {

                $(document).on('change', '#discount_type', function(){
                    if($(this).val() == "Amount")
                    {
                        $('#discount_percentage_wrap').hide();
                        $('#discount_amount_wrap').show();
                    }
                    else{
                        $('#discount_percentage_wrap').show();
                        $('#discount_amount_wrap').hide();
                    }
                });

                $('.datepicker').datepicker({
                    format: 'dd-mm-yyyy',
                });

            });
        </script>
    <script type="text/javascript">
        jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) 
                || (Number(value) > Number($(params).val())); 
        },'Must be greater than {0}.');

        var validator = $('#CouponFrm').validate({
            ignore: [],
            rules: {
                coupon_code: {
                  required: true,
                  remote: {
                      url: "{{route('validate.unique.coupon-code')}}",
                      data: {
                        id: function() {
                          return $( "#inputId" ).val();
                      }
                    }
                  }
                },
                minimum_purchase_value: {
                    required: true,
                },
                discount_percentage: {
                  required: function(textarea) {
                     return $('#discount_type').val()=="Percentage";
                  }
                },
                discount_amount: {
                  required: function(textarea) {
                     return $('#discount_type').val()=="Amount";
                  }
                },
                maximum_discount_value:{
                    required: true,
                },
                start_date: "required",
                end_date: {
                    required: true,
                    greaterThan: "#start_date"
                },
              },
              messages: {
                coupon_code: {
                  required: "Coupon code cannot be blank",
                  remote: "Coupon code is already in use",
                },
                "minimum_purchase_value": "Minimum purchase value cannot be blank",
                "discount_percentage": "Discount percentage cannot be blank",
                "discount_amount": "Discount amount cannot be blank",
                "maximum_discount_value": "Maximum discount value cannot be blank",
                "start_date": "Start date cannot be blank",
                "end_date": {
                    required: "End date cannot be blank",
                    greaterThan: "End date must be greater than start date"
                }
              },
            });
    </script>
@parent
@endsection