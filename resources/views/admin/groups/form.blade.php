@extends('admin.common.base')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">@if($obj->id)Edit Group @else Add new Group @endif</span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/groups')}}" class="btn btn-success"><i class="fa fa-list"></i> List Groups</a>
                  @if($obj->id)
                    <a href="{{url('admin/groups/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                    <a href="{{url('admin/groups/destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{url('admin/groups')}}"><i class="fa fa-trash"></i> Delete</a>
                  @endif
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.groups.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'groupFrm'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
                @else
                    {{Form::open(['url' => route('admin.groups.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'groupFrm'])}}
                @endif
                
                <div class="row">
                      <div class="col-md-6 first-form-row">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default form-group-default-select2">
                                  <label>Status</label>
                                  {!! Form::select('status', array('1'=>'Enabled', '0'=>'Disabled'), $obj->status, array('class'=>'full-width select2-dropdown', 'id'=>'inputStatus')); !!}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>Group Name</label>
                                  {{ Form::text("group_name", $obj->group_name, array('class'=>'form-control', 'id' => 'name','required' => true)) }}
                                  <span class="error"></span>
                              </div>
                          </div>
                      </div>
                </div>
                <div class="row offer-wrapper">
                  <div class="col-md-6 p-2">
                            <div class="card card-default">
                              <div class="card-header">
                              Products
                              <div class="row float-right">
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" title="Filter Products" data-toggle="modal" data-target="#filterModal"><i class="fa fa-filter"></i></a>
                                <div>
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="source-btn" style="margin-left:10px;">Move to Group <i class="fa fa-angle-double-right"></i></a>
                                </div>
                              </div>
                              </div>
                              <div class="card-body">
                                @php
                                  $selected_items = [];
                                  if($obj->id && count($obj->products)>0)
                                  {
                                    $selected_items = $obj->products->pluck('products_id')->toArray();
                                  }
                                @endphp
                                <ul class="list-group" id="source">
                                  @include('admin/offers/ajax_list', ['products'=>$products, 'selected_items'=>$selected_items])
                                </ul>
                                <div class="checkbox check-success">
                                  <input type="checkbox" value="1" id="all-select">
                                  <label for="all-select">Select All</label>
                                </div>
                              </div>
                            </div>
                    </div>
                    <div class="col-md-6 p-2">
                      <div class="card card-default" id="offer-product-wrapper">
                              <div class="card-header">
                                Selected Products
                                <div class="pull-right">
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="destination-btn"><i class="fa fa-angle-double-left"></i> Remove from Group</a>
                                  <input type="hidden" name="offer_check" id="offer_check" @if(count($obj->products)>0) value="1" @endif>
                                  <span class="error"></span>
                                </div>
                              </div>
                              <div class="card-body">
                                <ul class="list-group" id="destination">
                                    @if($obj->id && count($obj->products)>0)
                                      @foreach($obj->products as $product)
                                        <li class="list-group-item"  id="{{$product->product->id}}">
                                            <label>{{$product->product->name}}</label>
                                            <input type="hidden" name="offer_products[]" value="{{$product->product->id}}">
                                        </li>
                                      @endforeach
                                    @endif
                                </ul>
                              </div>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 padding-10" align="right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    @include('admin.product_filter_modal')
@endsection
@section('bottom')
    <script>
    var validator = $("#groupFrm").validate({
          ignore: [],
          //errorElement : 'span',
          errorPlacement: function(error, element){
              $(element).each(function (){
                  $(this).parent('div').find('span.error').html(error);
              });
          },
          rules: {
            group_name: {
              required: true,
            },
            offer_check: "required",
          },
          messages: {
            group_name: {
              required: "Enter name for new group",
            },
            offer_check: "Add a product this group",
          },
        });
    </script>
    <script src="{{asset('js/offer.js')}}"></script>
    @parent
@endsection