@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">Group</span>
                <div >
                    <div class="btn-group">
                        <a href="{{route('admin.category.attribute.groups.index')}}" class="btn btn-success"><i class="fa fa-list"></i> List groups
                        </a>
                        <a href="{{route('admin.category.attribute.groups.create')}}" class="btn btn-success open-ajax-confirm" title="Create New Group"><i class="fa fa-pencil"></i> Create new
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                        <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="{{ url('admin/category/attribute/groups') }}" >
                            <thead id="column-search">
                            <tr>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-200">Name</th>
                                <th class="nosort nosearch table-width-10 text-center">Edit</th>
                                <th class="nosort nosearch table-width-10 text-center">Delete</th>
                            </tr>

                            <tr>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-200 searchable-input">Name</th>
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
            {data: 'group_name', name: 'group_name'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [0, 'asc'];

        function validate()
        {
            $('#AttributeGroupFrm').validate({
                ignore: [],
                rules: {
                    group_name: "required",
                  },
                  messages: {
                    group_name: "Attribute group name cannot be blank",
                  },
            });
        }
    </script>
    @parent
@endsection