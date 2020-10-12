@extends('admin.common.base')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">@if($obj->id)Edit Offer @else Add new Offer @endif</span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/offers')}}" class="btn btn-success"><i class="fa fa-list"></i> List Offers</a>
                  @if($obj->id)
                    <a href="{{url('admin/offers/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                    <a href="{{url('admin/offers/destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{url('admin/offers')}}"><i class="fa fa-trash"></i> Delete</a>
                  @endif
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.offers.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'OfferFrm'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
                @else
                    {{Form::open(['url' => route('admin.offers.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'OfferFrm'])}}
                @endif
                <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active show" data-toggle="tab" role="tab"
                           data-target="#tab1Basic"
                        href="#" aria-selected="true">Basic Details</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" role="tab"
                           data-target="#tab2Basic"
                        href="#" aria-selected="true">SEO</a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" role="tab"
                           data-target="#tab3Basic"
                        href="#" aria-selected="true">Offer Management</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Status</label>
                                        {!! Form::select('is_active', array('1'=>'Enabled', '0'=>'Disabled'), (!$obj->id || $obj->is_active)?1:0, array('class'=>'full-width select2-dropdown', 'id'=>'inputStatus')); !!}
                                    </div>
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Offer Name</label>
                                        {{ Form::text("offer_name", $obj->offer_name, array('class'=>'form-control', 'id' => 'offer_name','required' => true)) }}
                                    </div>
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6 no-padding">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default form-group-default-select2 required">
                                            <label>Offer Type</label>
                                            {!! Form::select('type', array('Price'=>'Price', 'Combo'=>'Combo', 'Group'=>'Group', 'Free'=>'Free'), $obj->type, array('class'=>'full-width select2-dropdown', 'id'=>'inputType')); !!}
                                        </div>
                                    </div>
                            </div>
                            @if(config('common.multi_vendor'))
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label class="">Vender</label>
                                        @php
                                          $venders = [];
                                          if($obj->vender_id)
                                            $venders = [$obj->vender_id => $obj->vendor->vendor_name];
                                        @endphp
                                        {!! Form::select('vender_id',$venders, $obj->vender_id, array('data-placeholder'=>'Choose a vender','data-init-plugin'=>'select2','data-select2-url'=>route('select2.venders'),'class'=>'full-width select2_input', 'id'=>'vender_id')); !!}
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default input-group required">
                                      <div class="form-input-group">
                                        <label>Offer Start Date</label>
                                        @php
                                          $validity_start_date = ($obj->validity_start_date)?date('d-m-Y', strtotime($obj->validity_start_date)):null;
                                        @endphp
                                        {{ Form::text("validity_start_date", $validity_start_date, array('class'=>'form-control datepicker', 'id' => 'validity_start_date')) }}
                                      </div>
                                      <div class="input-group-append ">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                      </div>
                                    </div>
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default input-group required">
                                      <div class="form-input-group">
                                        <label class="">Offer End Date</label>
                                        @php
                                          $validity_end_date = ($obj->validity_end_date)?date('d-m-Y', strtotime($obj->validity_end_date)):null;
                                        @endphp
                                        {!! Form::text('validity_end_date',$validity_end_date, array('class'=>'form-control datepicker', 'id'=>'validity_end_date')); !!}
                                      </div>
                                      <div class="input-group-append ">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                      </div>
                                    </div>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2Basic">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="row column-seperation padding-5">
                                  <div class="form-group form-group-default">
                                      <label>Browser Title</label>
                                      {{ Form::text("browser_title", $obj->browser_title, array('class'=>'form-control', 'id' => 'browser_title')) }}
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="row column-seperation padding-5">
                                  <div class="form-group form-group-default">
                                      <label>Meta Tags</label>
                                      {{ Form::textarea("meta_keywords", $obj->meta_keywords, array('class'=>'form-control', 'id' => 'meta_keywords')) }}
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="row column-seperation padding-5">
                                  <div class="form-group form-group-default">
                                      <label>Meta Description</label>
                                      {{ Form::textarea("meta_description", $obj->meta_description, array('class'=>'form-control', 'id' => 'meta_description')) }}
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3Basic">
                      <div class="row offer-manager-sec" id="price-wrapper" @if($obj->id && $obj->type != "Price") style="display: none;" @endif>
                        @include('admin/offers/offer_manage/price', ['obj'=>$obj])
                      </div>
                      <div class="row offer-manager-sec" id="combo-wrapper" @if($obj->type != "Combo") style="display: none;" @endif>
                        @include('admin/offers/offer_manage/combo', ['obj'=>$obj])
                      </div>
                      <div class="row offer-manager-sec" id="group-wrapper" @if($obj->type != "Group") style="display: none;" @endif>
                        @include('admin/offers/offer_manage/group', ['obj'=>$obj])
                      </div>
                      <div class="row offer-manager-sec" id="free-wrapper" @if($obj->type != "Free") style="display: none;" @endif>
                        @include('admin/offers/offer_manage/free', ['obj'=>$obj])
                      </div>
                      <div class="row offer-wrapper" @if(($obj->type == 'Price' && $obj->applicable_for_full_order == 1) || ($obj->type == 'Price' && count($obj->categories)>0) || $obj->type == 'Group') style="display:none;" @endif>
                          <div class="col-md-6">
                            <div class="card card-default">
                              <div class="card-header">
                              Products
                              <div class="row float-right">
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" title="Filter Products" data-toggle="modal" data-target="#filterModal"><i class="fa fa-filter"></i></a>
                                <div>
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="source-btn" style="@if(($obj->type == 'Free' && $obj->applicable_for_full_order == 1) || ($obj->type == 'Free' && count($obj->categories)>0)) display: none; @endif margin-left:10px;">Move to Offers <i class="fa fa-angle-double-right"></i></a>
                                </div>
                                <div>
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="free-source-btn" style="@if($obj->type != 'Free') display: none; @endif margin-left:10px;">Move to Free <i class="fa fa-angle-double-right"></i></a>
                                </div>
                                <div>
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="combo-free-source-btn" style="@if($obj->type != 'Combo' || ($obj->type == 'Combo' && count($obj->free_products)<=0)) display: none; @endif margin-left:10px;">Move to Combo <i class="fa fa-angle-double-right"></i></a>
                                </div>
                              </div>
                              </div>
                              <div class="card-body">
                                @php
                                  $selected_items = [];
                                  if($obj->price_offers)
                                  {
                                    $offer_products = $obj->price_offers->pluck('products_id')->toArray();
                                    $selected_items = array_merge($selected_items, $offer_products);
                                  }
                                  if($obj->combo_offers)
                                  {
                                    $combo_products = $obj->combo_offers->pluck('products_id')->toArray();
                                    $selected_items = array_merge($selected_items, $combo_products);
                                  }
                                  if($obj->free_products)
                                  {
                                    $free_products = $obj->free_products->pluck('products_id')->toArray();
                                    $selected_items = array_merge($selected_items, $free_products);
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
                          <div class="col-md-6">
                            <div class="card card-default" id="offer-product-wrapper" @if(($obj->type == 'Free' && $obj->applicable_for_full_order == 1) || ($obj->type == 'Free' && count($obj->categories)>0)) style="display:none;" @endif>
                              <div class="card-header">
                                Selected Products
                                <div class="pull-right">
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="destination-btn"><i class="fa fa-angle-double-left"></i> Remove from Offer</a>
                                  <input type="hidden" name="offer_check" id="offer_check" @if($selected_items) value="1" @endif>
                                  <span class="error"></span>
                                </div>
                              </div>
                              <div class="card-body">
                                <ul class="list-group" id="destination">
                                    @if($obj->id && ($obj->type == 'Price' || $obj->type == 'Combo' || $obj->type == 'Free'))
                                      @if($obj->type == 'Price' && count($obj->price_offers)>0)
                                        @foreach($obj->price_offers as $price_offer)
                                          <li class="list-group-item"  id="{{$price_offer->product->id}}">
                                            <label>{{$price_offer->product->name}}</label>
                                            <input type="hidden" name="offer_products[]" value="{{$price_offer->product->id}}">
                                          </li>
                                        @endforeach
                                      @elseif(count($obj->combo_offers)>0)
                                        @foreach($obj->combo_offers as $combo_offer)
                                          <li class="list-group-item"  id="{{$combo_offer->product->id}}">
                                            <label>{{$combo_offer->product->name}}</label>
                                            <input type="hidden" name="offer_products[]" value="{{$combo_offer->product->id}}">
                                          </li>
                                        @endforeach
                                      @endif
                                    @endif
                                </ul>
                              </div>
                            </div>
                            <div class="card card-default" id="free-product-wrapper" @if($obj->type != 'Free') style="display: none;" @endif>
                              <div class="card-header">
                                Free Products
                                <div class="pull-right">
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="free-destination-btn"><i class="fa fa-angle-double-left"></i> Remove from Free</a>
                                  <input type="hidden" name="free_check" id="free_check" @if($obj->type == 'Free' && $obj->free_products) value="1" @endif>
                                  <span class="error"></span>
                                </div>
                              </div>
                              <div class="card-body">
                                <ul class="list-group" id="free-destination">
                                  @if($obj->type == 'Free' && $obj->free_products)
                                    @foreach($obj->free_products as $free_product)
                                      <li class="list-group-item"  id="{{$free_product->product->id}}">
                                          <label>{{$free_product->product->name}}</label>
                                          <input type="hidden" name="free_products[]" value="{{$free_product->product->id}}">
                                      </li>
                                    @endforeach
                                  @endif
                                </ul>
                              </div>
                            </div>
                            <div class="card card-default" id="combo-free-product-wrapper" @if($obj->type != 'Combo' || ($obj->type == 'Combo' && count($obj->free_products)<=0)) style="display: none;" @endif>
                              <div class="card-header">
                                Offer Products
                                <div class="pull-right">
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="combo-free-destination-btn"><i class="fa fa-angle-double-left"></i> Remove from Free</a>
                                  <input type="hidden" name="combo_free_check" id="combo_free_check" @if($obj->type == 'Combo' && count($obj->free_products)>0) value="1" @endif>
                                  <span class="error"></span>
                                </div>
                              </div>
                              <div class="card-body">
                                <ul class="list-group" id="combo-free-destination">
                                  @if($obj->type == 'Combo' && $obj->free_products)
                                    @foreach($obj->free_products as $free_product)
                                      <li class='list-group-item' id='{{$free_product->product->id}}'>
                                        <div>
                                          <label>{{$free_product->product->name}}</label>
                                          <div class="row column-seperation padding-5 combo-free-checkbox">
                                            <div class="checkbox check-success">
                                              <input type="checkbox" value="1" name="free[]" id="checkbox-{{$free_product->product->id}}" @if($free_product->type == 'Free') checked="checked" @endif><label for="checkbox-{{$free_product->product->id}}">Free</label>
                                            </div>
                                          </div>
                                          <div @if($free_product->type == 'Free') style="display: none;" @endif class="combo-free-discount">
                                            <div class="row column-seperation padding-5">
                                              <div class="form-group form-group-default form-group-default-select2"><label>Discount Type</label>
                                                @php
                                                  $free_discount_type = (!$free_product->type || $free_product->type == 'Free')?'Discount Percentage':$free_product->type;
                                                @endphp
                                                <select class="full-width select2-dropdown combo-free-discount-type" name="free_discount_type[]" >
                                                  <option value="Discount Percentage" @if($free_product->type == 'Discount Percentage') selected="selected" @endif>Discount Percentage</option>
                                                  <option value="Fixed Price" @if($free_product->type == 'Fixed Price') selected="selected" @endif>Fixed Price</option>
                                                  <option value="Discount Price" @if($free_product->type == 'Discount Price') selected="selected" @endif>Discount Price</option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="row column-seperation padding-5 combo-free-discount-amount" @if($free_discount_type == 'Discount Percentage') style="display:none;" @endif>
                                              <div class="form-group form-group-default"><label>Amount</label>
                                                <input class="form-control amount" name="free_discount_amount[]" type="text"  @if($free_product->type == 'Fixed Price') value="{{$free_product->fixed_price}}" @elseif($free_product->type == 'Discount Price') value="{{$free_product->discount_amount}}" @endif>
                                              </div>
                                            </div>
                                            <div class="row column-seperation padding-5 combo-free-discount-percentage" @if($free_discount_type != 'Discount Percentage') style="display:none;" @endif>
                                              <div class="form-group form-group-default required"><label>Percentage</label>
                                                <input class="form-control numeric" name="free_discount_percentage[]" type="text" value="{{$free_product->discount_percentage}}">
                                              </div>
                                            </div>
                                            <div class="row column-seperation padding-5">
                                              <div class="form-group form-group-default required"><label>Maximum discount amount</label>
                                                <input class="form-control numeric" name="free_max_discount_amount[]" type="text" value="{{$free_product->max_discount_amount}}">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <input type='hidden' name='combo_free_products[]' value='{{$free_product->product->id}}'/>
                                      </div>
                                    </li>
                                    @endforeach
                                  @endif
                                </ul>
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
    @include('admin.product_filter_modal')
@endsection
@section('bottom')
    <script src="{{asset('js/offer.js')}}"></script>
    @parent
@endsection