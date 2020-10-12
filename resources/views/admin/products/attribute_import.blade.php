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
                <li class="breadcrumb-item active">Import Product Attributes</li>
            </ol>
                        <!-- END BREADCRUMB -->
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Import Product Attributes</span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/products')}}" class="btn btn-success"><i class="fa fa-list"></i> List Products</a>
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
              {{Form::open(['url' => route('admin.products.attribute-import-save'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'ProductImportFrm'])}}
                <div class="form-group m-3">
                  <label for="exampleFormControlFile1">Import File</label>
                  <input type="file" class="form-control-file" id="excel_file" name="excel_file">
                </div>
                <div class="form-group m-3 row">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                </div>
              {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('bottom')
    <script>
    </script>
    @parent
@endsection