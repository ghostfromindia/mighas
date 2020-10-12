@extends('admin.common.datatable')

@section('head')

@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT WARRANTY</span>
            @else
                <span class="page-heading">CREATE NEW WARRANTY</span>
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
                    <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="WarrantyFrm" data-validate=true>
                @else
                    <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="WarrantyFrm" data-validate=true>
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
                                        <label>Warranty Name</label>
                                        <input type="text" name="product_name" class="form-control" value="@if($obj->variant) {{$obj->variant->name}} @endif" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                      <div class="form-group form-group-default form-group-default-select2 required">
                                          <label>Category</label>
                                          @php
                                            $categories = [];
                                            if($obj->variant && $obj->variant->product->category_id)
                                              $categories = [$obj->variant->product->category_id => $obj->variant->product->category->category_name];
                                          @endphp
                                          {!! Form::select('category_id',$categories, $obj->category_id, array('data-placeholder'=>'Choose a category','data-init-plugin'=>'select2','data-select2-url'=>route('select2.categories'),'class'=>'full-width select2_input', 'id'=>'category_id')); !!}
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Warranty Price</label>
                                        <input type="number" name="sale_price" class="form-control amount" value="{{$obj->warranty_price}}" id="sale_price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Start Price</label>
                                        <input type="number" name="start_price" class="form-control amount" value="{{$obj->start_price}}" id="start_price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">End Price</label>
                                        <input type="number" name="end_price" class="form-control amount" value="{{$obj->end_price}}" id="end_price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label class="">Year</label>
                                        <select name="year" class="full-width select2_input" data-placeholder="Select Year" data-init-plugin="select2" id="year">
                                            <option value="1" @if($obj->year == 1) selected="selected" @endif >1 Year</option>
                                            <option value="2" @if($obj->year == 2) selected="selected" @endif >2 Year</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        @php
                                            $summary = null;
                                            if($obj->variant && $obj->variant->product->summary)
                                              $summary = $obj->variant->product->summary;
                                        @endphp
                                        <label>Summary</label>
                                        {{ Form::textarea("summary", $summary, array('class'=>'form-control richtext', 'id' => 'summary')) }}
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