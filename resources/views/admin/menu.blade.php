@extends('admin.common.base')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Menu Settings </span>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless padding-20">
                {!! Menu::render() !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {!! Menu::scripts() !!}
@endpush