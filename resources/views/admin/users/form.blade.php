@extends('admin.common.base')

@section('head')
  <link href="{{asset('public/assets/css/intlTelInput.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">@if($obj->id)Edit User @else Add new User @endif</span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/users')}}" class="btn btn-success"><i class="fa fa-list"></i> List Users</a>
                  @if($obj->id)
                    <a href="{{url('admin/users/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                    <a href="{{url('admin/users/destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{url('admin/users')}}"><i class="fa fa-trash"></i> Delete</a>
                  @endif
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.users.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'UserFrm'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
                @else
                    {{Form::open(['url' => route('admin.users.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'UserFrm'])}}
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
                        href="#" aria-selected="true">User Info</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Status</label>
                                        {!! Form::select('status', array('1'=>'Enabled', '0'=>'Disabled'), ($obj->id && $obj->banned_at)?0:1, array('class'=>'full-width select2-dropdown', 'id'=>'inputStatus')); !!}

                                    </div>
                                </div>
                            </div>
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
                    <div class="tab-pane" id="tab2Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Phone Number</label>
                                        {!! Form::text('phone_number', $obj->phone_number, array('class'=>'form-control', 'id' => 'phone')) !!}
                                        <?php
                                        $phone_code = ($obj->country_code)?$obj->phone_code->sortname:'IN';
                                        ?>
                                        <input type="hidden" name="country_code" value="{{$obj->country_code}}" id="country_code">
                                        <input type="hidden" name="phone_code" value="{{$phone_code}}" id="phone_code">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label>Country</label>
                                        <?php
                                          $country_url = url('select2/country');
                                          $countries = [];
                                          if($obj->country_id)
                                            $countries = [$obj->country_id => $obj->country->name];
                                        ?>
                                        {{ Form::select("country_id", $countries, $obj->country_id, array('class'=>'form-control select2_input full-width', 'id' => 'country', 'data-select2-url'=>$country_url, 'data-placeholder'=>'Choose country')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <?php
                                      $disabled = '';
                                      $place_holder = "Choose state";
                                      $state_url = url('select2/state', $obj->country_id);
                                      $states = [];
                                      if(!$obj->country_id)
                                      {
                                        $disabled = "disabled";
                                        $place_holder = "Choose a country first";
                                      }
                                      if($obj->state_id)
                                        $states = [$obj->state_id => $obj->state->name];
                                    ?>
                                    <div class="form-group form-group-default form-group-default-select2 {{$disabled}}" >
                                        <label>State</label>
                                        {{ Form::select("state_id", $states, $obj->state_id, array('class'=>'form-control select2_input full-width', 'id' => 'state', 'data-select2-url'=>$state_url, 'placeholder'=>$place_holder, $disabled)) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Pincode</label>
                                        {!! Form::text('pin_code', $obj->pin_code, array('class'=>'form-control', 'id'=>'pincode')); !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Address</label>
                                        {!! Form::textarea('address', $obj->address, array('class'=>'form-control', 'id' => 'address')) !!}

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
  <script src="{{asset('public/assets/js/intlTelInput.min.js')}}" type="text/javascript"></script>

    <script>
      var country_code = $('#phone_code').val();

      var input = document.querySelector("#phone");
      
      window.intlTelInput(input,{
        dropdownContainer: document.body,
        initialCountry: country_code,
      });

      input.addEventListener("countrychange", function() {
        var iti = window.intlTelInputGlobals.getInstance(input);
        var data = iti.getSelectedCountryData();
        $('#country_code').val(data.dialCode);
      });

      $(document).ready(function(){
        $(document).on('change', '#country', function(){
          var id = $(this).val();
          var state_url = "{{url('select2/state')}}/"+id;
          $('#state').removeAttr('disabled');
          $("#state").val("");
          var $select = $("#state").select2({
                placeholder: "Choose state",
                allowClear: true,
                ajax: {
                    url: state_url,
                    dataType: 'json',
                    method: 'get',
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });

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
              required: true,
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
              digits : true,
              maxlength : 10,
            },
          },
          messages: {
            first_name: "First name cannot be blank",
            last_name: "Last name cannot be blank",
            email: {
              required: "Email address cannot be blank",
              remote: "Email is already in use",
            },
            password: "Password cannot be blank",
          },
        });
      });
    </script>
    @parent
@endsection