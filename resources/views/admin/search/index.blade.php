@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
                <span class="page-heading">All Search Keywords</span>
                <div >
                    <div class="btn-group">
                        <a href="{{url('admin/search/create')}}" class="btn btn-success"><i class="fa fa-file-export"></i> Manage keywords</a>
                    </div>

                </div>
            </div>
            <!-- START card -->
            <div class="card card-borderless padding-15" style="padding: 30px !important;">
                <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                       data-datatable-ajax-url="{{ url('admin/search') }}" >
                    <thead id="column-search">
                    <tr>
                        <th class="table-width-10">ID</th>
                        <th class="table-width-120">Name</th>
                        <th class="nosort nosearch table-width-10">Keyword</th>
                        <th class="nosort nosearch table-width-10">Delete</th>
                    </tr>

                    <tr>
                        <th class="table-width-10 nosort nosearch"></th>
                        <th class="table-width-120 searchable-input">Name</th>
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
    <script type="text/javascript">
        var my_columns = [
            {data: null, name: 'slno'},
            {data: 'name', name: 'name'},
            {data: 'keyword', name: 'status'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [1, 'desc'];
    </script>
    @parent
@endsection