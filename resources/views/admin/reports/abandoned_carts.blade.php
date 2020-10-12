@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">Abandoned Carts</span>
            </div>
            <!-- START card -->
            <div class="card card-borderless filter-wrap">
                <h5 class="card-header" style="padding: 0px 20px 0px 20px;">Export to Excel</h5>
                <form action="{{url('admin/reports/abandoned-carts/export')}}" method="POST" id="exportFrm">
                    @csrf
                    <div class="row m-2">
                        <div class="col-md-4 mb-2">
                            <select name="cart+product_id" class="full-width select2_input datatable-advanced-search" data-placeholder="Filter By Product" data-select2-url="{{route('select2.products')}}">
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <input type="text" name="date_between-cart+created_at" class="form-control datatable-advanced-search daterange" placeholder="Filter By Date">
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="button" class="btn btn-primary btn-block" id="filter-report-btn">Export</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                        <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="{{ route('admin.reports.abandoned-carts') }}" >
                            <thead id="column-search">
                            <tr>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-120">Product</th>
                                <th class="table-width-120">Quantity</th>
                                <th class="table-width-120">Amount</th>
                                <th class="table-width-120">Added Date</th>
                                <th class="nosort nosearch table-width-10">Delete</th>
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
            {data: 'name', name: 'product_variants.name'},
            {data: 'quantity', name: 'quantity'},
            {data: 'price', name: 'price'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];

        $(function(){
            $('.daterange').daterangepicker({
              autoUpdateInput: false,
            });

            $(document).on('click', '#filter-report-btn', function(){
              dt();
              $('#exportFrm').submit();
            });

            $('input[name="date_between-cart+created_at"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('input[name="date_between-cart+created_at"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    @parent
@endsection