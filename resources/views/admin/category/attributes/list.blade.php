<table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="@if(isset($is_category)) {{ url('admin/category/attributes', [$is_category]) }} @else {{ url('admin/category/attributes') }} @endif" >
                            <thead id="column-search">
                            <tr>
                                <th class="table-width-10 text-center">ID</th>
                                <th class="table-width-120">Group</th>
                                <th class="table-width-120">Attribute name</th>
                                <th class="table-width-120">Variant Level</th>
                                <th class="nosort nosearch table-width-10 text-center">Values</th>
                                <th class="nosort nosearch table-width-10 text-center">Edit</th>
                                <th class="nosort nosearch table-width-10 text-center">Delete</th>
                            </tr>

                            <tr>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-10 searchable-input">Group</th>
                                <th class="table-width-120 searchable-input">Attribute Name</th>
                                <th class="table-width-120">{!! Form::select('category', array(''=>'All', '0'=>'None', '1'=>'Level1', '2'=>'Level2', '3'=>'Level3', '4'=>'Level4'), null, array('class'=>'select-box-input select2-dropdown')); !!}</th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
                            </tr>

                            </thead>

                            <tbody>
                            </tbody>

                        </table>