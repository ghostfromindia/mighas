@extends('admin.common.datatable')

@section('head')
  @parent
  <link href="{{asset('public/assets/css/intlTelInput.css')}}" rel="stylesheet" type="text/css" />
  <style type="text/css">
 
.select2-container--default .select2-results>.select2-results__options {
    max-height: 150px;
    overflow-y: auto;
}
  </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">All @if($status) {{$status->name}} @endif Orders</span>
            </div>
            <!-- START card -->
            <div class="card card-borderless filter-wrap">
                <h5 class="card-header" style="padding: 0px 20px 0px 20px;">Advanced Search</h5>
                <div class="row m-2">
                        <div class="col-md-3 mb-2">
                            <input type="text" name="like-orders.order_reference_number" class="form-control datatable-advanced-search" placeholder="Filter By Order Ref. No.">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="text" name="orders.transaction_id" class="form-control datatable-advanced-search" placeholder="Filter By Transaction Id">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="text" name="address.mobile_number" class="form-control datatable-advanced-search" placeholder="Filter By Mobile No." id="phone-filter">
                            <input type="hidden" name="address.mobile_code" id="country_code" value="91">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select name="order_details.products_id" class="full-width select2_input datatable-advanced-search" data-placeholder="Filter By Product" data-select2-url="{{route('select2.products')}}">
                            </select>
                        </div>
                        @if(!$type)
                        <div class="col-md-3 mb-2">
                            <select name="order_details.status" class="full-width select2_input datatable-advanced-search" data-placeholder="Filter By Status" data-select2-url="{{route('select2.order-status')}}">
                            </select>
                        </div>
                        @endif
                        <div class="col-md-3 mb-2">
                            <input type="text" name="date_between-order_details.created_at" class="form-control datatable-advanced-search daterange" placeholder="Filter By Date">
                        </div>
                        <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-primary btn-block" id="filter-order-btn">Filter</button>
                        </div>
                    </div>
            </div>
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="{{ url('admin/orders', [$type]) }}" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10">ID</th>
                            <th class="table-width-120">Order Reference No.</th>
                            <th class="table-width-120">Mobile No.</th>
                            <th class="table-width-120">Product</th>
                            <th class="table-width-120">Sale Price</th>
                            <th class="table-width-120">Quantity</th>
                            <th class="table-width-120">Order Date</th>
                            <th class="nosort nosearch table-width-10">Payment Status</th>
                            <th class="nosort nosearch table-width-10">Status</th>
                            <th class="nodisplay"></th>
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
<script src="{{asset('public/assets/js/intlTelInput.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
      var my_columns = [
          {data: null, name: 'id'},
          {data: 'order_reference_number', name: 'orders.order_reference_number'},
          {data: 'mobile', name: 'mobile'},
          {data: 'name', name: 'product_variants.name'},
          {data: 'sale_price', name: 'order_details.sale_price'},
          {data: 'quantity', name: 'order_details.quantity'},
          {data: 'created_at', name: 'orders.created_at'},
          {data: 'payment_receive_status', name: 'orders.payment_receive_status'},
          {data: 'status', name: 'status'},
          {data: 'updated_at', name: 'orders.updated_at'},
      ];
      var slno_i = 0;
      var order = [9, 'desc'];

      var country_code = 'IN';

      var input = document.querySelector("#phone-filter");
      
      window.intlTelInput(input,{
        dropdownContainer: document.body,
        initialCountry: country_code,
      });

      input.addEventListener("countrychange", function() {
        var iti = window.intlTelInputGlobals.getInstance(input);
        var data = iti.getSelectedCountryData();
        $('#country_code').val(data.dialCode);
      });

      $(function(){
        $('.daterange').daterangepicker({
          autoUpdateInput: false,
        });

        $(document).on('click', '#filter-order-btn', function(){
          if($('#phone-filter').val() == '')
          {
            $('#country_code').val('');
          }
          dt();
        });

        $('input[name="date_between-order_details.created_at"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('input[name="date_between-order_details.created_at"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $(document).on('click', '#order-status-update-btn', function(){
          var url = $('#orderStatudFrm').attr('action');
          var data = $('#orderStatudFrm').serialize();
          $.post(url, data, function(data){
            $('.jconfirm-content').html(data);
            display_select2();
            dt();
          })
        });

        $(document).on('click', '#cancel-order-btn', function(){
          var url = $('#cancelOrderFrm').attr('action');
          var data = $('#cancelOrderFrm').serialize();
          $.post(url, data, function(data){
            $('.jconfirm-content').html(data);
            display_select2();
            dt();
          })
        });

        $(document).on('click', '#cancel-link', function(){
          $('#cancel-order').show();
          $('#update-order-status').hide();
        });

        $(document).on('click', '#change-status-link', function(){
          $('#cancel-order').hide();
          $('#update-order-status').show();
        });

      });
    </script>
    @parent
@endsection