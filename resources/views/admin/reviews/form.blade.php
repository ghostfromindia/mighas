@extends('admin.common.base')

@section('head')
<link href="{{ asset('assets/css/star-rating-svg.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Edit Review and Rating</span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/reviews')}}" class="btn btn-success"><i class="fa fa-list"></i> List Reviews</a>
                  @if($obj->id)
                    <a href="{{url('admin/reviews/destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{url('admin/reviews')}}"><i class="fa fa-trash"></i> Delete</a>
                  @endif
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.reviews.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'reviewFrm'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
                @else
                    {{Form::open(['url' => route('admin.reviews.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'reviewFrm'])}}
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
                                  <label>Product Name</label>
                                  {{$obj->product->name}}
                              </div>
                          </div>
                      </div>
                      @if($obj->user)
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>User Name</label>
                                  {{$obj->user->first_name.' '.$obj->user->last_name}}
                              </div>
                          </div>
                      </div>
                      @endif
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>Rating</label>
                                  <div class="ratings" data-rating="{{$obj->rating}}"></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>Title</label>
                                  {{ Form::text("title", $obj->title, array('class'=>'form-control', 'id' => 'title','required' => true)) }}
                                  <span class="error"></span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>Review</label>
                                  {{ Form::textarea("review", $obj->review, array('class'=>'form-control', 'id' => 'review','required' => true)) }}
                                  <span class="error"></span>
                              </div>
                          </div>
                      </div>
                </div>
                <div class="row">
                    <div class="col-md-12 padding-10" align="right">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    @include('admin.product_filter_modal')
@endsection
@section('bottom')
    <script src="{{asset('assets/js/jquery.star-rating-svg.min.js')}}"></script>
    <script>
      $(function(){
    var validator = $("#reviewFrm").validate({
          ignore: [],
          //errorElement : 'span',
          errorPlacement: function(error, element){
              $(element).each(function (){
                  $(this).parent('div').find('span.error').html(error);
              });
          },
          rules: {
            title: {
              required: true,
            },
          },
          messages: {
            title: {
              required: "Title cannot be blank",
            },
          },
        });

    $(".ratings").starRating({
                        starSize: 25,
                        readOnly: true
                    });
  });
    </script>
    @parent
@endsection