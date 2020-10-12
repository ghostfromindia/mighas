@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">Attributes</span>
                <div >
                    <div class="btn-group">
                        <a href="{{route('admin.category.attribute.create')}}" class="btn btn-success open-ajax-confirm" title="Create New Attribute"><i class="fa fa-pencil"></i> Create new
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                        @include('admin.category.attributes.list')
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
            {data: 'group_name', name: 'product_cateory_attribute_groups.group_name'},
            {data: 'attribute_name', name: 'attribute_name'},
            {data: 'show_as_variant', name: 'show_as_variant'},
            {data: 'value_count', name: 'value_count'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [4, 'desc'];

        function validate()
        {
            $('#AttributeFrm').validate({
                ignore: [],
                rules: {
                    category_id: "required",
                    attribute_name: "required",
                  },
                  messages: {
                    category_id: "Category cannot be blank",
                    attribute_name: "Attribute name cannot be blank",
                  },
            });
        }
    </script>
    @parent
@endsection