@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">All Customers</span>
              <div >
                  <div class="btn-group">
                      <a href="{{url('admin/customers/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                  </div>
              </div>
            </div>
            <!-- START card -->
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="{{ url('admin/customers') }}" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10">ID</th>
                            <th class="table-width-120">Name</th>
                            <th class="table-width-120">Email</th>
                            <th class="table-width-120">Phone Number</th>
                            <th class="table-width-120">Created On</th>
                            <th class="nosort nosearch table-width-10">Status</th>
                            <th class="nosort nosearch table-width-10">Edit</th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="table-width-10 searchable-input">Name</th>
                            <th class="table-width-120 searchable-input">Email</th>
                            <th class="table-width-120 searchable-input">Phone Number</th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
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

    <script>
        var my_columns = [
            {data: null, name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'banned_at', name: 'banned_at'},
            {data: 'action_edit', name: 'action_edit'},
        ];
        var slno_i = 0;
        var order = [4, 'desc'];
    </script>
    @parent
@endsection