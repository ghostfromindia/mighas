@extends('admin.common.fileupload')

@section('breadcrumb')
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
                        <!-- START BREADCRUMB -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin/products')}}">All Products</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin/products/edit', [encrypt($product->id)])}}">{{$product->product_name}}</a></li>
                <li class="breadcrumb-item active">@if(!$obj->id) Add new @else Edit @endif Variant</li>
            </ol>
                        <!-- END BREADCRUMB -->
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">@if(!$obj->id) Add new @else Edit @endif variant for <a href="{{url('admin/products/edit', [encrypt($product->id)])}}">{{$product->product_name}}</a></span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/products/edit', [encrypt($product->id)])}}" class="btn btn-success"><i class="fa fa-list"></i> Return to Product</a>
                  @if($obj->id)
                    <a href="{{url('admin/products/variants/create', $product->id)}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                    <a href="{{url('admin/products/variants/destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{url('admin/products/edit', [encrypt($product->id)])}}"><i class="fa fa-trash"></i> Delete</a>
                  @endif
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.products.variants.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'VariantFrm'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
                @else
                    {{Form::open(['url' => route('admin.products.variants.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'VariantFrm'])}}
                    <input type="hidden" name="products_id" value="{{encrypt($product->id)}}">
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
                        href="#" aria-selected="true">Gallery</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Variant Name</label>
                                        @php
                                          if($obj->name)
                                            $name = $obj->name;
                                          else
                                            $name = $product->product_name;
                                        @endphp
                                        {{ Form::text("name", $name, array('class'=>'form-control', 'id' => 'name')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        @php
                                          if($obj->name)
                                            $slug = $obj->slug;
                                          else
                                            $slug = $product->slug;
                                        @endphp
                                        <label>Slug</label>
                                        {{ Form::text("slug", $slug, array('class'=>'form-control', 'id' => 'slug')) }}
                                    </div>
                                    <p class="hint-text small">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
                                </div>
                            </div>
                            <div class="col-md-6 first-form-row">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label>Level1 Attribute</label>
                                        <select name="level1_attribute_value_id" class="full-width select2-dropdown" id="inputLevel1">
                                          <option value="">Select Level1 Attribute</option>
                                          @if($level1)
                                            @foreach($level1 as $item)
                                              @php
                                                $item_id = $item['id'];
                                              @endphp
                                              <option value="{{$item['id']}}" data-text="{{$item['value']}}" @if($item_id ==$obj->level1_attribute_value_id ) selected @endif >{{$item['text']}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @php
                              $level2_disable = $obj->level2_attribute_value_id?'':'disabled';
                            @endphp
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 {{$level2_disable}}" >
                                        <label>Level2 Attribute</label>
                                        <select name="level2_attribute_value_id" class="full-width select2-dropdown" {{$level2_disable}} id="inputLevel2">
                                          <option value="">Select Level2 Attribute</option>
                                          @if($level2)
                                            @foreach($level2 as $item)
                                              @php
                                                $item_id = $item['id'];
                                              @endphp
                                              <option value="{{$item['id']}}" data-text="{{$item['value']}}" @if($item_id == $obj->level2_attribute_value_id ) selected @endif>{{$item['text']}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @php
                              $level3_disable = $obj->level3_attribute_value_id?'':'disabled';
                            @endphp
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 {{$level3_disable}}">
                                        <label>Level3 Attribute</label>
                                        <select name="level3_attribute_value_id" class="full-width select2-dropdown" {{$level3_disable}} id="inputLevel3">
                                          <option value="">Select Level3 Attribute</option>
                                          @if($level3)
                                            @foreach($level3 as $item)
                                              @php
                                                $item_id = $item['id'];
                                              @endphp
                                              <option value="{{$item['id']}}" data-text="{{$item['value']}}" @if($item_id ==$obj->level3_attribute_value_id ) selected @endif>{{$item['text']}}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @include('admin.products.variants.product_common')
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Short Description</label>
                                        {{ Form::textarea("short_description", $obj->short_description, array('class'=>'form-control richtext', 'id' => 'short_description')) }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <label for="specification">Upload Specification Excel sheet</label>
                                    <input type="file" name="specification" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2Basic">
                        @include('admin.products.variants.gallery', ['product'=>$product, 'gallery'=> $gallery])
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
@endsection
@section('bottom')
    <script>
      var change_name = true;
      var product_name = "{{$product->product_name}}";
      $("#name").on('input', function (){
        if($(this).val() != product_name)
          change_name = false;
      });

      $(document).ready(function(){
        var validator = $('#VariantFrm').validate({
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
          rules: {
            name: "required",
            slug: {
              required: true,
              remote: {
                  url: "{{url('validation/product-variant-slug')}}",
                  data: {
                    id: function() {
                      return $( "#inputId" ).val();
                  }
                }
              }
            },
            sku: "required",
            retail_price: "required",
            sale_price: "required",
          },
          messages: {
            name: "Product name cannot be blank",
            slug: {
              required: "Slug cannot be blank",
              remote: "Slug is already in use",
            },
            sku: "SKU cannot be blank",
            retail_price: "Retail price cannot be blank",
            sale_price: "Sale price cannot be blank",
          },
        });

        $(document).on('change', '#inputLevel1', function(){
          if($(this).val() != '')
          {
            $('#inputLevel2').parents('.form-group-default').removeClass('disabled');
            $('#inputLevel2').prop('disabled', false);
          }
          else{
            $('#inputLevel2').val('').change();
            $('#inputLevel2').parents('.form-group-default').addClass('disabled');
            $('#inputLevel2').prop('disabled', true);

            $('#inputLevel3').val('').change();
            $('#inputLevel3').parents('.form-group-default').addClass('disabled');
            $('#inputLevel3').prop('disabled', true);
          }
          update_name();
        });

        $(document).on('change', '#inputLevel2', function(){
          if($(this).val() != '')
          {
            $('#inputLevel3').parents('.form-group-default').removeClass('disabled');
            $('#inputLevel3').prop('disabled', false);
          }
          else{
            $('#inputLevel3').val('').change();
            $('#inputLevel3').parents('.form-group-default').addClass('disabled');
            $('#inputLevel3').prop('disabled', true);
          }
          update_name();
        });

        $(document).on('change', '#inputLevel3', function(){
          update_name();
        });

        $("#name").keyup(function () {
            $("#slug").val(slugify($("#name").val()))
        })
        
      });

      function update_name()
      {
        if(change_name)
        {
          var extra = [];
          if($('#inputLevel1').val() != '')
            extra.push($('#inputLevel1 option:selected').text());
          if($('#inputLevel2').val() != '')
            extra.push($('#inputLevel2 option:selected').text());
          if($('#inputLevel3').val() != '')
            extra.push($('#inputLevel3 option:selected').text());

          if(extra)
          {
            var name = product_name+' ('+extra.join(", ")+')';
            $('#name').val(name);
            $("#slug").val(slugify(name))
          }
        }
      }
    </script>
    @parent
@endsection