@extends('admin._layouts.dt')

@section('head-assets')
    @parent
@endsection

@section('content-area')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Menu
      <a href="{{ url('admin/menus/create') }}" class="btn btn-primary btn-add"><i class="glyphicon glyphicon-plus-sign"></i> Add New</a>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('admin._partials.notifications') 

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Menu List</h3>
        <div class="box-tools pull-right">
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary dropdown-toggle admin-bulk-actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
              Actions
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="javascript:void(0)" data-ajax-url="{{ url('admin/menus/bulk-delete') }}" data-type="bulk-delete" class="bulk-action">Delete Selected</a></li>
              <li><a href="javascript:void(0)" data-ajax-url="{{ url('admin/menus/bulk-enable') }}" data-type="bulk-enable" class="bulk-action">Enable Selected</a></li>
              <li><a href="javascript:void(0)" data-ajax-url="{{ url('admin/menus/bulk-disable') }}" data-type="bulk-disable" class="bulk-action">Disable Selected</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="box-body">
        <table id="datatable" data-datatable-ajax-url="{{ url('admin/menus') }}" class="display table table-bordered table-striped dataTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="nosort nosearch span1" width="30">Slno</th>
                    <th>Name</th>
                    <th>Menu Position</th>
                    <th>Last Updated</th>
                    <th class="nosort">Status</th>
                    <th class="nosort nosearch" width="30">Edit</th>
                    <th class="nosort nosearch" width="30">Delete</th>
                </tr>
            </thead>
            <tfoot>
                    <tr>
                      <td ></td>
                      <td class="searchable-input">Name</td>
                      <td class="searchable-input">Menu Position</td>
                      <td class="searchable-input date" data-id="updated-date">Date</td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tfoot>       
        </table>
      </div><!-- /.box-body -->
      <div class="box-footer">
      </div><!-- /.box-footer-->
    </div><!-- /.box -->

  </section><!-- /.content -->  

@endsection

@section('footer-assets')
  <script type="text/javascript">
      var my_columns = [
          {data: null, name: 'slno'},
          {data: 'name', name: 'name'},
          {data: 'menu_position', name: 'menu_position'},
          {data: 'updated_at', name: 'updated_at'},
          {data: 'status', name: 'status'},
          {data: 'action_edit', name: 'action_edit'},
          {data: 'action_delete', name: 'action_delete'}
      ];
      var slno_i = 0;
      var order = [3, 'desc'];
  </script>
  @parent
@endsection