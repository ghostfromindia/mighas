@extends('admin.common.base')

@section('head')
@endsection

@section('breadcrumb')
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
                        <!-- START BREADCRUMB -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin/products')}}">All Products</a></li>
                <li class="breadcrumb-item active">Add new Product</li>
            </ol>
                        <!-- END BREADCRUMB -->
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Add new Product</span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/products')}}" class="btn btn-success"><i class="fa fa-list"></i> List Products</a>
                  @if($obj->id)
                    <a href="{{url('admin/products/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                    <a href="{{url('admin/products/destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{url('admin/products')}}"><i class="fa fa-trash"></i> Delete</a>
                  @endif
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                {{Form::open(['url' => route('admin.products.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'ProductFrm'])}}
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
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            @include('admin.products.form.basic')
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2Basic">
                        <div class="row">
                            @include('admin.products.form.seo')
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
@endsection
@section('bottom')
    <script>


      $(document).ready(function(){
        var validator = $('#ProductFrm').validate({
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
            product_name: "required",
            summary: {
              required: function(textarea) {
                 return $('#'+textarea.id).summernote('isEmpty');
              }
            },
            page_heading: "required",
            slug: {
              required: true,
              /*remote: {
                  url: "{{url('validation/product-slug')}}",
                  data: {
                    id: function() {
                      return $( "#inputId" ).val();
                  }
                }
              }*/
            },
          },
          messages: {
            product_name: "Product name cannot be blank",
            summary: "Summary cannot be blank",
            slug: {
              required: "Slug cannot be blank",
              remote: "Slug is already in use",
            },
            page_heading: "Page heading cannot be blank",
          },
        });
      });

      $("#product_name").keyup(function () {
          $("#slug").val(slugify($("#product_name").val()))
      })
    </script>
    @parent
@endsection