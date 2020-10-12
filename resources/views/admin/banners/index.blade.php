@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">All Banners</span>
            </div>
            <!-- START card -->
            <div class="card card-borderless filter-wrap">
                <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="DealerFrm" data-validate=true>
                  @csrf
                <div class="row m-2">
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Name</label>
                                <input type="text" name="banner_name" class="form-control" value="" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Link</label>
                                <input type="text" name="link" class="form-control" value="" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Banner Title</label>
                                <input type="text" name="title" class="form-control" value="" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Width</label>
                                <input type="text" name="width" class="form-control" value="" maxLength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default">
                                <label>Height</label>
                                <input type="text" name="height" class="form-control" value="" maxLength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="{{ route($route.'.index') }}" >
                        <thead id="column-search">
                        <tr>
                            <th class="nosort nosearch span1" width="30">Slno</th>
                            <th>Banner Name</th>
                            <th>Banner Code</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th class="nosort nosearch" width="30">Manage</th>
                            <th class="nosort nosearch" width="30">Delete</th>
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
          {data: null, name: 'slno'},
          {data: 'banner_name', name: 'banner_name'},
          {data: 'code', name: 'code'},
          {data: 'width', name: 'width'},
          {data: 'height', name: 'height'},
          {data: 'action_edit', name: 'action_edit'},
          {data: 'action_delete', name: 'action_delete'}
      ];
      var slno_i = 0;
      var order = [0, 'desc'];
    </script>
    @parent
@endsection