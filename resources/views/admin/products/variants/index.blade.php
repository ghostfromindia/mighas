@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">All Products</span>
              <div >
                  <div class="btn-group">
                      <a href="{{url('admin/products/create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new</a>
                  </div>
              </div>
            </div>
            <!-- START card -->
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="{{ url('admin/products') }}" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10">ID</th>
                            <th class="table-width-120">Category</th>
                            <th class="table-width-120">Name</th>
                            <th class="table-width-120">Page Heading</th>
                            <th class="table-width-120">Updated On</th>
                            <th class="nosort nosearch table-width-10">Varients</th>
                            <th class="nosort nosearch table-width-10">Edit</th>
                            <th class="nosort nosearch table-width-10">Delete</th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="table-width-10 searchable-input">Category</th>
                            <th class="table-width-120 searchable-input">Name</th>
                            <th class="table-width-120 searchable-input">Page Heading</th>
                            <th class="nosort nosearch table-width-10"></th>
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
            {data: 'category_name', name: 'categories.category_name'},
            {data: 'product_name', name: 'product_name'},
            {data: 'page_heading', name: 'page_heading'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'varients', name: 'varients'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [4, 'desc'];
    </script>
    @parent
@endsection