@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <!-- START card -->
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">All Brands</span>
                <div >
                    <div class="btn-group">
                        <a href="{{route('admin.brand.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="{{ url('admin/brand/') }}" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10">ID</th>
                            <th class="table-width-120">Slug</th>
                            <th class="table-width-120">Brand name</th>
                            <th class="table-width-120">Website</th>
                            <th class="nosort nosearch table-width-10">Edit</th>
                            <th class="nosort nosearch table-width-10">Delete</th>
                            <th class="nodisplay"></th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="table-width-10 searchable-input">Slug</th>
                            <th class="table-width-120 searchable-input">Vendor name</th>
                            <th class="table-width-120 searchable-input">Website</th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nodisplay"></th>
                        </tr>

                        </thead>

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
            {data: 'slug', name: 'slug'},
            {data: 'brand_name', name: 'brand_name'},
            {data: 'website', name: 'website'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'},
            {data: 'updated_at', name: 'updated_at'}
        ];
        var slno_i = 0;
        var order = [6, 'desc'];
    </script>
    @parent
@endsection