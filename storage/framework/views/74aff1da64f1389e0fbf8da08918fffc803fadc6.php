<table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="<?php echo e(url('admin/products/variants', [$obj->id])); ?>" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10 text-center">ID</th>
                            <th class="table-width-120">Name</th>
                            <th class="nosort nosearch table-width-10 text-center">Default</th>
                            <th class="nosort nosearch table-width-10 text-center">Edit</th>
                            <th class="nosort nosearch table-width-10 text-center">Delete</th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="table-width-120 searchable-input">Name</th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                        </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/products/variants/list.blade.php ENDPATH**/ ?>