@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">All Warranties</span>
                <div >
                    <div class="btn-group">
                        <a href="{{route($route.'.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
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
                                <th class="table-width-120">Name</th>
                                <th class="table-width-120">Category</th>
                                <th class="table-width-120">Value</th>
                                <th class="table-width-120">Years</th>
                                <th class="nosort nosearch table-width-10">Status</th>
                                <th class="nosort nosearch table-width-10">Edit</th>
                                <th class="nosort nosearch table-width-10">Delete</th>
                            </tr>

                            <tr>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-10 searchable-input">Name</th>
                                <th class="table-width-10 searchable-input">Category</th>
                                <th class="table-width-120 searchable-input">Value</th>
                                <th class="table-width-120 searchable-input">Years</th>
                                <th class="nosort nosearch table-width-10"></th>
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
            {data: 'product_name', name: 'products.product_name'},
            {data: 'category_name', name: 'categories.category_name'},
            {data: 'warranty_price', name: 'extended_warranties.warranty_price'},
            {data: 'year', name: 'extended_warranties.year'},
            {data: 'status', name: 'extended_warranties.status'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];
    </script>
    @parent
@endsection