@extends('admin.common.base')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">@if($obj->id)Edit Customer @else Add new Customer @endif</span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/customers')}}" class="btn btn-success"><i class="fa fa-list"></i> List Customers</a>
                  @if($obj->id)
                    <a href="{{url('admin/customers/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                    <a href="{{url('admin/customers/destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{url('admin/customers')}}"><i class="fa fa-trash"></i> Delete</a>
                  @endif
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.customers.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'UserFrm'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
                @else
                    {{Form::open(['url' => route('admin.customers.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'UserFrm'])}}
                @endif
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
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>First Name</label>
                                        {{ Form::text("first_name", $obj->first_name, array('class'=>'form-control', 'id' => 'first_name','required' => true)) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Last Name</label>
                                        {{ Form::text("last_name", $obj->last_name, array('class'=>'form-control', 'id' => 'last_name')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Phone Number</label>
                                        {!! Form::text('phone_number', $obj->username, array('class'=>'form-control', 'id' => 'phone_number')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Email</label>
                                        {{ Form::text("email", $obj->email, array('class'=>'form-control', 'id' => 'email')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Password</label>
                                        {!! Form::password('password', array('class'=>'form-control', 'id'=>'password')); !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Confirm Password</label>
                                        {!! Form::password('password_confirmation', array('class'=>'form-control', 'id' => 'password_confirmation')) !!}

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
@endsection
@section('bottom')

    <script>
      

      $(document).ready(function(){

       var validator = $('#UserFrm').validate({
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
            first_name: "required",
            last_name: "required",
            email: {
              required: function(element){
                  return $("#phone").val() == '';
              },
              email: true,
              remote: {
                  url: "{{url('validation/user')}}",
                  data: {
                    id: function() {
                      return $( "#inputId" ).val();
                  }
                }
              }
            },
            password: {
              required: function(element){
                  return $("#inputId").length<=0;
              }
            },
            password_confirmation: {
              equalTo: "#password",
            },
            phone_number: {
              required: function(element){
                  return $("#email").val() == '';
              },
              remote: {
                  url: "{{url('validation/customer-phone')}}",
                  data: {
                    id: function() {
                      return $( "#inputId" ).val();
                  }
                }
              },
              digits : true,
              maxlength : 10,
            },
          },
          messages: {
            first_name: "First name cannot be blank",
            last_name: "Last name cannot be blank",
            email: {
              required: "Email or phone number required",
              remote: "Email is already in use",
            },
            phone_number: {
              required: "Email or phone number required",
              remote: "Email is already in use",
            },
            password: "Password cannot be blank",
          },
        });
      });
    </script>
    @parent
@endsection