
<table class="table table-hover demo-table-search table-responsive-block" id="datatable1"
                               data-datatable-ajax-url="@if(isset($is_category)) {{ url('admin/category/attribute/groups', [$is_category]) }} @else {{ url('admin/category/attribute/groups') }} @endif" >
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