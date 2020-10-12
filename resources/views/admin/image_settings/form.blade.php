@extends('admin.common.base')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Add new Image Settings </span>
          <div >
              <div class="btn-group">
                  <a href="{{url('admin/image-settings')}}" class="btn btn-success"><i class="fa fa-list"></i> List Image Settings</a>
              </div>
          </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                {{Form::open(['url' => route('admin.image-settings.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'MediaSettingsFrm'])}}

                <div class="padding-20">
                        <div class="settings-item row">
                            <div class="col-md-3">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Type</label>
                                        {!! Form::select('type[]', App\Models\MediaTypes::listForSelect(), null, array('class'=>'form-control select2_input full-width select2-dropdown input_type', 'id'=>'type_1')); !!}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Width (px)</label>
                                        {{ Form::text("width[]", null, array('class'=>'form-control', 'id' => 'width_1')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5 text-field">
                                    <div class="form-group form-group-default required">
                                        <label>Height (px)</label>
                                        {{ Form::text("height[]", null, array('class'=>'form-control', 'id' => 'height_1')) }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 center-block">
                                
                            </div>
                          </div>
                          <div class="row bottom-btn">
                            <div class="col-md-12" align="right">
                                <a href="javascript:void(0);" class="btn btn-success btn-addnew">Add New</a>
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
      var idInc = 2;
      $(document).ready(function(){

        $(document).on('click', '.btn-addnew', function(){
          var html ='<div class="settings-item row"><div class="col-md-3"><div class="row column-seperation padding-5"><div class="form-group form-group-default form-group-default-select2 required"><label>Type</label><div id="type_clone_'+idInc+'"></div></div></div></div><div class="col-md-4"><div class="row column-seperation padding-5"><div class="form-group form-group-default required"><label>Width</label><input type="text" name="width[]" class="form-control" id="width_'+idInc+'"/></div></div></div><div class="col-md-4"><div class="row column-seperation padding-5 text-field"><div class="form-group form-group-default required"><label>Height</label><input type="text" name="height[]" class="form-control" id="height_'+idInc+'"/></div></div></div><div class="col-md-1 center-block"><div class="form-group"><a href="javascript:void(0);" class="btn btn-danger remove-row">X</a></div></div></div>';
          $(html).insertBefore('.bottom-btn');
          $('#type_clone_'+idInc).append($("#type_1").clone().attr('id', 'type_' + idInc));
          $('.select2_input').select2();
          idInc++;
        });

        $(document).on('click', '.remove-row', function(){
          $(this).parents('.settings-item').remove();
        })

        $.extend( $.validator.prototype, {
          checkForm: function () {
            this.prepareForm();
            for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
              if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
                for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                this.check(this.findByName(elements[i].name)[cnt]);
                }
              } else {
                this.check(elements[i]);
              }
            }
            return this.valid();
          },
          showErrors: function( errors ) {
          if ( errors ) {
            var validator = this;

            // Add items to error list and map
            $.extend( this.errorMap, errors );
            this.errorList = $.map( this.errorMap, function( message, name ) {
              return {
                message: message,
                element: validator.findById(name)[0]
              };
            });

            // Remove items from success list
            this.successList = $.grep( this.successList, function( element ) {
              return !( element.name in errors );
            } );
          }
          if ( this.settings.showErrors ) {
            this.settings.showErrors.call( this, this.errorMap, this.errorList );
          } else {
            this.defaultShowErrors();
          }
        },
        findById: function( id ) {
          // select by name and filter by form for performance over form.find(“[id=…]”)
          var form = this.currentForm;
          return $(document.getElementById(id)).map(function(index, element) {
          return element.form == form && element.id == id && element || null;
          });
        },
      });

       var validator = $('#MediaSettingsFrm').validate({
          rules: {
            "type[]": "required",
            "width[]": {
              required: true,
              number: true,
            },
            "height[]": {
              required: true,
              number: true,
            }
          },
          messages: {
            "type[]": "Type cannot be blank",
            "width[]": {
              required: "Width cannot be blank",
              number: "Invalid number",
            },
            "height[]": {
              required: "Height cannot be blank",
              number: "Invalid number",
            }
          },
        });
      });
    </script>
    @parent
@endsection