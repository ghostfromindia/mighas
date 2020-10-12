@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">Image Settings</span>
              <div >
                  <div class="btn-group">
                      <a href="{{url('admin/image-settings/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Add new</a>
                  </div>
              </div>
            </div>
            <!-- START card -->
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="{{ url('admin/image-settings') }}" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10">ID</th>
                            <th class="table-width-120">Type</th>
                            <th class="table-width-120">Width (px)</th>
                            <th class="table-width-120">Height (px)</th>
                            <th class="nosort nosearch table-width-10">Delete</th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="table-width-10 searchable-input">Type</th>
                            <th class="table-width-10 searchable-input">Width</th>
                            <th class="table-width-120 searchable-input">Height</th>
                            <th class="nosort nosearch table-width-10"></th>
                        </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>
            </div>
            <!-- END card -->
        </div>
    </div>
@endsection
@section('bottom')
    <script type="text/javascript" src="{{asset('public/js/fileinput.js')}}"></script>
    <script>
        var my_columns = [
            {data: null, name: 'id'},
            {data: 'type', name: 'media_types.type'},
            {data: 'width', name: 'width'},
            {data: 'height', name: 'height'},
            {data: 'action_delete', name: 'action_delete'},
        ];
        var slno_i = 0;
        var order = [3, 'desc'];

        function validate()
        {
            $('#SettingsFrm').validate({
                ignore: [],
                rules: {
                    value: "required",
                  },
                  messages: {
                    value: "Value cannot be blank",
                  },
            });
        }
    </script>
    @parent
@endsection