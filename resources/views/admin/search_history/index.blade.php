@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">Search History</span>
                <div >
                  <div class="btn-group">
                        <a href="{{url('admin/search-history/export')}}" class="btn btn-success"><i class="fa fa-arrow-up"></i> Export</a>
                        <a href="{{url('admin/search-history/create')}}" class="btn btn-success"><i class="fa fa-arrow-down"></i> Import</a>
                  </div>
              </div>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                        <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="{{ route($route.'.index') }}" >
                            <thead id="column-search">
                            <tr>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-120">Term</th>
                                <th class="nosearch table-width-10" >Search Count</th>
                                <th class="table-width-120">User</th>
                                <th class="table-width-120 nosearch">Date</th>
                                <th class="nosort nosearch table-width-10">Delete</th>
                            </tr>

                            <tr>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-10 searchable-input">Term</th>
                                <th class="nosort nosearch table-width-10">Search Count</th>
                                <th class="table-width-120 searchable-input">User</th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
                            </tr>

                            </thead>

                            <tbody>
                            </tbody>

                        </table>
                </div>
            </div>
            <!-- END card -->
        </div>
    </div>
@endsection
@section('bottom')

    <script>
        var my_columns = [
            {data: null, name: 'id'},
            {data: 'search_term', name: 'search_term'},
            {data: 'count', name: 'count'},
            {data: 'name', name: 'name'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];
    </script>
    @parent
@endsection