@extends('admin.common.datatable')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">Attribute Values of {{$attribute->attribute_name}}</span>
                <div >
                    <div class="btn-group">
                        <a href="{{route('admin.category.attribute.index')}}" class="btn btn-success"><i class="fa fa-list"></i> List attributes
                        </a>
                        <a href="{{route('admin.category.attribute.value.create', [encrypt($attribute->id)])}}" class="btn btn-success open-ajax-confirm" title="Create New Value for {{$attribute->attribute_name}}"><i class="fa fa-pencil"></i> Create new
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                        <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="{{ url('admin/category/attribute', [encrypt($attribute->id)]) }}" >
                            <thead id="column-search">
                            <tr>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-200">Slug</th>
                                <th class="table-width-200">Value</th>
                                <th class="nosort nosearch table-width-10 text-center">Edit</th>
                                <th class="nosort nosearch table-width-10 text-center">Delete</th>
                            </tr>

                            <tr>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-200 searchable-input">Slug</th>
                                <th class="table-width-200 searchable-input">Value</th>
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
            {data: 'value_slug', name: 'value_slug'},
            {data: 'value', name: 'value'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [4, 'desc'];

        function validate()
        {
            $('#AttributeValueFrm').validate({
                ignore: [],
                rules: {
                    value: "required",
                    value_slug: {
                        required: true,
                        pattern: /^[a-z0-9\-]+$/,
                        synchronousRemote: {
                                url: "{{url('validation/attribute-value-slug')}}",
                                data: {
                                id: function() {
                                    return $( "#inputId" ).val();
                                }
                            }
                        }
                    },
                  },
                  messages: {
                    value: "Attribute value cannot be blank",
                    value_slug: {
                        required : "Value slug cannot be blank",
                        pattern: "Only allow letters, numbers and dashes",
                        synchronousRemote: "Slug is already in use",
                    }
                  },
            });
        }
    </script>
    @parent
@endsection