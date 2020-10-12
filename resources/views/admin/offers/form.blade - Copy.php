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
                                        {!! Form::select('is_active', array('1'=>'Enabled', '0'=>'Disabled'), ($obj->id && $obj->banned_at)?0:1, array('class'=>'full-width select2-dropdown', 'id'=>'inputStatus')); !!}
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
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default input-group required">
                                      <div class="form-input-group">
                                        <label>Offer Start Date</label>
                                        @php
                                          $validity_start_date = ($obj->validity_start_date)?date('d/m/Y', strtotime($obj->validity_start_date)):null;
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
                                          $validity_end_date = ($obj->validity_end_date)?date('d/m/Y', strtotime($obj->validity_end_date)):null;
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
                      <div class="row">
                        <div class="col-md-6 no-padding">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Offer Type</label>
                                        {!! Form::select('type', array('Price'=>'Price', 'Combo with Price'=>'Combo with Price', 'Combo with Free'=>'Combo with Free', 'Free'=>'Free'), $obj->type, array('class'=>'full-width select2-dropdown', 'id'=>'inputType')); !!}

                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6 no-padding category_wrapper" id="offer-applicable-to-sec">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Offer Applicable To</label>
                                        @php
                                          $offer_applicable_to = ($obj->categories)?'Category':'Product';
                                        @endphp
                                        {!! Form::select('offer_applicable_to', array('Product'=>'Product', 'Category'=>'Category'), $offer_applicable_to, array('class'=>'full-width select2-dropdown', 'id'=>'inputOfferApplicableTo')); !!}
                                    </div>
                                    <span class="error"></span>
                                </div>
                          </div>
                        <div class="col-md-6 offer-price-wrapper no-padding" id="price-discount-type-sec" @if($obj->type !='Price' && $obj->type !='') style="display:none"; @endif>
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Discount Type</label>
                                        {!! Form::select('discount_type', array('Discount Percentage'=>'Discount Percentage', 'Discount Price'=>'Discount Price'), null, array('class'=>'full-width select2-dropdown', 'id'=>'inputDiscountType')); !!}
                                    </div>
                                    <span class="error"></span>
                                </div>
                          </div>
                          <div class="col-md-6 offer-price-wrapper no-padding" id="combo-discount-type-sec" @if($obj->type =='Price' || $obj->type =='') style="display:none"; @endif>
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Discount Type</label>
                                        {!! Form::select('combo_discount_type', array('Discount Percentage'=>'Discount Percentage', 'Fixed Price'=>'Fixed Price', 'Discount Price'=>'Discount Price'), null, array('class'=>'full-width select2-dropdown', 'id'=>'inputComboDiscountType')); !!}
                                    </div>
                                    <span class="error"></span>
                                </div>
                          </div>
                          @php
                            $amount = null;
                            $percentage = null;
                            $min_purchase_amount = null;
                            $max_discount_amount = null;
                            if(isset($obj->offer_price))
                            {
                              if($obj->offer_price->type == 'Discount Percentage')
                                $percentage = $obj->offer_price->percentage;
                              elseif($obj->offer_price->type == 'Discount Price')
                                $amount = $obj->offer_price->amount;

                              $min_purchase_amount = $obj->offer_price->min_purchase_amount;
                              $max_discount_amount = $obj->offer_price->max_discount_amount;
                            }

                          @endphp
                          <div class="col-md-6 offer-price-wrapper no-padding" style="display: none;" id="offer-amount-sec">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Amount</label>
                                        {{ Form::text("amount", $amount, array('class'=>'form-control amount', 'id' => 'amount')) }}
                                    </div>
                                    <span class="error"></span>
                                </div>
                          </div>
                          <div class="col-md-6 offer-price-wrapper no-padding" id="offer-percentage-sec">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Percentage</label>
                                        {{ Form::text("percentage", $percentage, array('class'=>'form-control numeric', 'id' => 'percentage')) }}
                                    </div>
                                    <span class="error"></span>
                                </div>
                          </div>
                          <div class="col-md-6 offer-price-wrapper no-padding" id="minimum-purchase-amount-sec">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Minimum Purchase Amount</label>
                                        {{ Form::text("min_purchase_amount", $min_purchase_amount, array('class'=>'form-control amount', 'id' => 'min_purchase_amount')) }}
                                    </div>
                                    <span class="error"></span>
                                </div>
                          </div>
                          <div class="col-md-6 offer-price-wrapper no-padding" id="maximum-discount-amount-sec">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Maximum Discount Amount</label>
                                        {{ Form::text("max_discount_amount", $max_discount_amount, array('class'=>'form-control amount', 'id' => 'max_discount_amount')) }}
                                    </div>
                                    <span class="error"></span>
                                </div>
                          </div>
                          <div class="col-md-6 no-padding category_wrapper" id="category-sec" style="display: none;">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Categories</label>
                                        {!! Form::select('categories[]',[], null, array('data-placeholder'=>'Choose  categories','data-init-plugin'=>'select2','data-select2-url'=>route('select2.categories'),'class'=>'full-width select2_input', 'id'=>'category_id', 'multiple'=>true)); !!}
                                    </div>
                                    <span class="error"></span>
                                </div>
                          </div>
                      </div>
                      <div class="row offer-wrapper">
                          <div class="col-md-6">
                            <div class="card card-default">
                              <div class="card-header">
                              Products
                              <div class="row float-right">
                                <a href="javascript:void(0)" class="btn btn-success btn-sm" title="Filter Products" data-toggle="modal" data-target="#filterModal"><i class="fa fa-filter"></i></a>
                                <div style="margin-left:10px;">
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="source-btn">Move to Offers <i class="fa fa-angle-double-right"></i></a>
                                </div>
                                <div style="margin-left:10px;">
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="free-source-btn" style="display: none;">Move to Free <i class="fa fa-angle-double-right"></i></a>
                                </div>
                              </div>
                              </div>
                              <div class="card-body">
                                <ul class="list-group" id="source">
                                  @include('admin/offers/ajax_list')
                                </ul>
                                <div class="checkbox check-success">
                                  <input type="checkbox" value="1" id="all-select">
                                  <label for="all-select">Select All</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="card card-default" id="offer-product-wrapper">
                              <div class="card-header">
                                Offer Products
                                <div class="pull-right">
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="destination-btn"><i class="fa fa-angle-double-left"></i> Remove from Offer</a>
                                  <input type="hidden" name="offer_check" id="offer_check">
                                  <span class="error"></span>
                                </div>
                              </div>
                              <div class="card-body">
                                <ul class="list-group" id="destination">

                                </ul>
                              </div>
                            </div>
                            <div class="card card-default" id="free-product-wrapper" style="display: none;">
                              <div class="card-header">
                                Free Products
                                <div class="pull-right">
                                  <a href="javascript:void(0)" class="btn btn-sm btn-success" id="free-destination-btn"><i class="fa fa-angle-double-left"></i> Remove from Free</a>
                                  <input type="hidden" name="free_check" id="free_check">
                                  <span class="error"></span>
                                </div>
                              </div>
                              <div class="card-body">
                                <ul class="list-group" id="free-destination">

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
<div id="filterModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter Product</h4>
      </div>
      <div class="modal-body">
        <div class="settings-item w-100 confirm-wrap">
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Category</label>
                    @php
                        $category_url = url('select2/categories');
                    @endphp
                    {{ Form::select("category[]", [], null, array('class'=>'form-control select2_input full-width', 'id' => 'category', 'data-select2-url'=>$category_url, 'data-placeholder'=>'Choose category', 'multiple'=>true, 'data-parent'=>'#filterModal')) }}
                </div>
            </div>
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Brand</label>
                    {!! Form::select('brand[]',[], null, array('data-placeholder'=>'Choose a brand','data-init-plugin'=>'select2','data-select2-url'=>route('select2.brands'),'class'=>'full-width select2_input', 'id'=>'brand', 'multiple'=>true, 'data-parent'=>'#filterModal')); !!}
                </div>
            </div>
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Keyword</label>
                    {{ Form::text("keyword", null, array('class'=>'form-control', 'id' => 'keyword')) }}
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="filterBtn">Filter</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection
@section('bottom')
    <script>
      

      $(document).ready(function(){
        $(document).on('click', '#source .selectable', function(){
          if($(this).hasClass('selected'))
            $(this).removeClass('selected');
          else
            $(this).addClass('selected');
          check_all_selected();
        });

        $(document).on('click', '#destination .list-group-item, #free-destination .list-group-item', function(){
            if($(this).hasClass('deselected'))
              $(this).removeClass('deselected');
            else
              $(this).addClass('deselected');
        });

        $(document).on('click', '#source-btn', function(){
          $('.selected').each( function(){
            $(this).removeClass('selected selectable');
            var clone = $(this).clone();
            clone.find('input').each(function() {
                this.name= 'offer_products[]';
            });
            $('#destination').append(clone);
            $(this).addClass('disabled');
            $('#offer_check').val('1');
          })
        });

        $(document).on('click', '#free-source-btn', function(){
          $('.selected').each( function(){
            $(this).removeClass('selected selectable');
            var clone = $(this).clone();
            clone.find('input').each(function() {
                this.name= 'free_products[]';
            });
            $('#free-destination').append(clone);
            $(this).addClass('disabled');
            $('#free_check').val('1');
          })
        });

        $(document).on('click', '#destination-btn, #free-destination-btn', function(){
          $('.deselected').each( function(){
            var id = $(this).attr('id');
            $(this).detach();
            $('#source #'+id).removeClass('disabled').addClass('selectable');
          });
          if($("input[name='offer_products[]']").length == 0)
            $('#offer_check').val('');

          if($("input[name='free_products[]']").length == 0)
            $('#free_check').val('');
        });

        $(document).on('click', '#filterBtn', function(){
          var selected_item = [];
          $('#destination .list-group-item').each( function(){
              selected_item.push($(this).find("input[name='offer_products[]']").val());
          });
          var data = {
            selected_item: selected_item,
            category: $('#category').val(),
            brand: $('#brand').val(),
            keyword: $('#keyword').val(),
            _token: _token,
          }
          $.post("{{url('admin/offers/ajax-list')}}", data, function(result){
            $('#source').html(result);
            $('#filterModal').modal('hide');
          })
        })

        $('#source').bind('scroll', function(){
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
              load_more('scroll');
            }
        });

        $(document).on('click', '#load-more a', function(){
            load_more('click');
        });

        $(document).on('change', '#inputDiscountType, #inputComboDiscountType', function(){
          if($(this).val() == "Discount Percentage")
          {
            $('#offer-percentage-sec').show();
            $("#offer-amount-sec").hide();
          }
          else{
            $('#offer-percentage-sec').hide();
            $("#offer-amount-sec").show();
          }
        });

        $(document).on('change', '#inputType, #inputOfferApplicableTo', function(){
          if($('#inputType option:selected').val() == "Price")
          {
              if($('#inputOfferApplicableTo option:selected').val() == 'Category')
                price_with_category();
              else
                price_with_product();
          }
          else if($('#inputType option:selected').val() == "Combo with Price")
          {
            combo_with_price();
          }
          else if($('#inputType option:selected').val() == "Combo with Free")
          {
            combo_with_free();
          }
          else if($('#inputType option:selected').val() == "Free")
          {
              if($('#inputOfferApplicableTo option:selected').val() == 'Category')
                free_with_category();
              else
                free_with_product();
          }
        });

        $(document).on('click', '#all-select', function(){
          if($(this).is(':checked'))
          {
            $('#source .selectable').each(function(){
              $(this).addClass('selected');
            });
          }
          else{
            $('#source .selected').each(function(){
              $(this).removeClass('selected');
            });
          }
        })

       var validator = $('#OfferFrm').validate({
          ignore: [],
          invalidHandler: function() {
            if(validator.numberOfInvalids())
            {
                if($('.alert-error').length>0)
                    $('.alert-error').remove();
                  var html = '<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Error:</strong>Oops! look like you have missed some important fields, please check all tabs.</div>';
                  $( html ).insertBefore( ".page-wrapper" );
            }
          },
          errorPlacement: function(error, element){
              $(element).each(function (){
                  var id = $(this).attr('id');
                  if(id == 'offer_check' || id == 'free_check')
                    $(this).next('span.error').html(error);
                  else
                    $(this).parents('.form-group').next('span.error').html(error);
              });
          },
          rules: {
            offer_name: "required",
            type: "required",
            validity_start_date: "required",
            validity_end_date: "required",
            discount_type: {
              required: function(element){
                if($("#inputType option:selected").val() == 'Price')
                  return true;
                else
                  return false;
              }
            },
            combo_discount_type: {
              required: function(element){
                if($("#inputType option:selected").val() == 'Combo with Price')
                  return true;
                else
                  return false;
              }
            },
            amount: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Price' || $("#inputType option:selected").val() == 'Combo with Price') && ($('#inputDiscountType option:selected').val() == 'Fixed Price' || $('#inputDiscountType option:selected').val() == 'Discount Price'))
                  return true;
                else
                  return false;
              }
            },
            percentage: {
              required: function(element){
                if(($("#inputType option:selected").val() == 'Price' || $("#inputType option:selected").val() == 'Combo with Price') && $('#inputDiscountType option:selected').val() == 'Discount Percentage')
                  return true;
                else
                  return false;
              }
            },
            offer_check: {
              required: function(element){
                if($("#inputType option:selected").val() == 'Combo with Free' || $("#inputType option:selected").val() == 'Free' || ($("#inputType option:selected").val() == 'Price' && $('#inputOfferApplicableTo option:selected').val() == 'Product'))
                  return true;
                else
                  return false;
              }
            },
            free_check: {
              required: function(element){
                if($("#inputType option:selected").val() == 'Combo with Free' || $("#inputType option:selected").val() == 'Free')
                  return true;
                else
                  return false;
              }
            },
          },
          messages: {
            offer_name: "Offer name cannot be blank",
            type: "Please select an offer type",
            validity_start_date: "Please select validity start date",
            validity_end_date: "Please select validity end date",
            discount_type: "Please select discount type",
            amount: "Amount cannot be blank",
            percentage: "Percentage cannot be blank",
            offer_check: "Please add offer products",
            free_check: "Please add free products"
          },
        });
      });

    function check_all_selected()
    {
      if($('.selectable').length == $('.selected').length)
      {
        $('#all-select').prop('checked', true);
      }
      else{
        $('#all-select').prop('checked', false);
      }
    }
    function load_more($type)
    {
            var selected_item = [];
            $('#destination .list-group-item').each( function(){
                selected_item.push($(this).find("input[name='offer_products[]']").val());
            });
            var data = {
              category: $('#category').val(),
              brand: $('#brand').val(),
              keyword: $('#keyword').val(),
              select_all: $('#all-select').val(),
              "_token": _token,
            }
            var url = $('#pagination-ajax .pagination li.active + li a').attr('href');
            if (typeof url !== typeof undefined && url !== false)
            {
                  $('#pagination-ajax').remove();
                  $('#load-more').remove();
                  $.ajax({
                        url: url,
                        method: 'POST',
                        data: data,
                        success: function(result){
                          $('#source').append(result);
                      },
                  });
            }
    }

    function price_with_category()
    {
      $('.offer-price-wrapper').show();

      $('#price-discount-type-sec').show();
      $('#combo-discount-type-sec').hide();
      $('#inputDiscountType').trigger('change');

      $('.category_wrapper').show();
      $('#category-sec').show();

      $('#minimum-purchase-amount-sec').show();
      $('#maximum-discount-amount-sec').show();

      $('.offer-wrapper').hide();
    }

    function price_with_product()
    {
      $('.offer-price-wrapper').show();

      $('#price-discount-type-sec').show();
      $('#combo-discount-type-sec').hide();
      $('#inputDiscountType').trigger('change');

      $('#minimum-purchase-amount-sec').show();
      $('#maximum-discount-amount-sec').show();

      $('.category_wrapper').show();
      $('#category-sec').hide();

      $('.offer-wrapper').show();

      $('#free-source-btn').hide();
      $('#free-product-wrapper').hide();

      $('#source-btn').show();
      $('#offer-product-wrapper').show();
    }

    function combo_with_price()
    {
      $('.offer-price-wrapper').show();
      
      $('#price-discount-type-sec').hide();
      $('#combo-discount-type-sec').show();
      $('#inputComboDiscountType').trigger('change');

      $('#minimum-purchase-amount-sec').hide();
      $('#maximum-discount-amount-sec').show();

      $('.category_wrapper').hide();
      $('#category-sec').hide();

      $('.offer-wrapper').show();

      $('#free-source-btn').hide();
      $('#free-product-wrapper').hide();

      $('#source-btn').show();
      $('#offer-product-wrapper').show();
    }

    function combo_with_free()
    {
      $('.offer-price-wrapper').hide();

      $('.category_wrapper').hide();
      $('#category-sec').hide();

      $('.offer-wrapper').show();

      $('#free-source-btn').show();
      $('#free-product-wrapper').show();

      $('#source-btn').show();
      $('#offer-product-wrapper').show();
    }

    function free_with_product()
    {
      $('.offer-price-wrapper').hide();

      $('.category_wrapper').show();
      $('#category-sec').hide();

      $('.offer-wrapper').show();

      $('#free-source-btn').show();
      $('#free-product-wrapper').show();

      $('#source-btn').show();
      $('#offer-product-wrapper').show();

    }

    function free_with_category()
    {
      $('.offer-price-wrapper').hide();

      $('.category_wrapper').show();
      $('#category-sec').show();

      $('.offer-wrapper').show();

      $('#free-source-btn').show();
      $('#free-product-wrapper').show();

      $('#source-btn').hide();
      $('#offer-product-wrapper').hide();
    }
    </script>
    @parent
@endsection