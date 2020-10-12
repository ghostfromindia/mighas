@extends('admin.common.base')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">@if($obj->id)Edit Role @else Add new Role @endif</span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/roles')}}" class="btn btn-success"><i class="fa fa-list"></i> List Roles</a>
                  @if($obj->id)
                    <a href="{{url('admin/roles/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                    <a href="{{url('admin/roles/destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{url('admin/roles')}}"><i class="fa fa-trash"></i> Delete</a>
                  @endif
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    {{Form::open(['url' => route('admin.roles.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'rolesFrm'])}}
                    <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
                @else
                    {{Form::open(['url' => route('admin.roles.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'rolesFrm'])}}
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
                                  <label>Role Name</label>
                                  {{ Form::text("name", $obj->name, array('class'=>'form-control', 'id' => 'name','required' => true)) }}
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
@endsection
@section('bottom')
    <script>
    var validator = $("#rolesFrm").validate({
          ignore: [],
          //errorElement : 'span',
          errorPlacement: function(error, element){
              $(element).each(function (){
                  $(this).parent('div').find('span.error').html(error);
              });
          },
          rules: {
            name: {
              required: true,
              remote: {
                  url: base_url+"admin/roles/slug-ajax",
                  data: {
                    id: function() {
                      return $( "#inputId" ).val();
                  }
                }
              }
            },
          },
          messages: {
            name: {
              required: "Enter unique name for new role",
              remote: "Role {0} is already in use",
            },
          },
        });
    </script>
    @parent
@endsection