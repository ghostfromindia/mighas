@extends('admin.common.base')

@section('head')
    @parent
    <link href="{{URL::asset('/')}}/assets/plugins/jquery-datatable/package/css/datatables.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/fileupload/css/jquery.fileupload.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/fileupload/css/jquery.fileupload-ui.css')}}">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="{{ asset('public/assets/plugins/fileupload/css/jquery.fileupload-noscript.css')}}"></noscript>
    <noscript><link rel="stylesheet" href="{{ asset('public/assets/plugins/fileupload/css/jquery.fileupload-ui-noscript.css')}}"></noscript>
    <style type="text/css">
        .d-none{
            display: none;
        }
    </style>
@endsection

@section('bottom')
    @parent
    <script src="{{URL::asset('/')}}/assets/plugins/jquery-datatable/package/js/datatables.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{URL::asset('/')}}/assets/js/datatables.js"></script>

    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/load-image.all.min.js')}}"></script> 
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/canvas-to-blob.min.js')}}"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/jquery.iframe-transport.js')}}"></script>
    <!-- The basic File Upload plugin -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/jquery.fileupload.js')}}"></script>
    <!-- The File Upload processing plugin -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/jquery.fileupload-process.js')}}"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/jquery.fileupload-image.js')}}"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/jquery.fileupload-audio.js')}}"></script>
    <!-- The File Upload video preview plugin -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/jquery.fileupload-video.js')}}"></script>
    <!-- The File Upload validation plugin -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/jquery.fileupload-validate.js')}}"></script>
    <!-- The File Upload user interface plugin -->
    <script src="{{ asset('public/assets/plugins/fileupload/js/jquery.fileupload-ui.js')}}"></script>

    <script>

        var $table = $('#datatable');
        var ajaxUrl = $table.data('datatable-ajax-url');
        console.log(ajaxUrl)
        //var order = '';
        dt_table = $table.DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "processing": true,
            "serverSide": true,
            responsive: true,
            ajax: {
                url: ajaxUrl,
                data: function(d) {
                    var advanced_search = {};
                    $('.datatable-advanced-search').each(function(i, obj) {
                            advanced_search[$(this).attr('name')] = $(this).val();
                    });
                    d.data = advanced_search;
                }
            },
            columns: my_columns,
          
            'aoColumnDefs': [
                { 'bSortable': false, 'sClass': "text-center table-width-10", 'aTargets': ['nosort'] },
                { "bSearchable": false, 'sClass': "text-center", "aTargets": [ 'nosearch' ] },
                { "bVisible": false, 'sClass': "d-none", "aTargets": ['nodisplay'] }
            ],
            errMode: 'throw',
            "order": [order],
            "language": {
                "search": "",
                'searchPlaceholder': 'Search...'
            },
            initComplete: function(settings, json) {
                $(this).trigger('initComplete', [this]);
                $(window).trigger('resize');
                this.api().columns().every( function () {

                });
                if($('.ratings').length)
                {
                    $(".ratings").starRating({
                        starSize: 25,
                        readOnly: true
                    });
                }
            },
            fnRowCallback : function(nRow, aData, iDisplayIndex, iDisplayIndexFull){
                updateDtSlno(this, slno_i);
            }
        });

        $('#datatable #column-search tr th').each( function () {
            var title = $(this).text();
            var columnClass = $(this).attr('class');
            if($(this).hasClass('searchable-input')){
                if($(this).hasClass('date'))
                {
                    var id = $(this).attr('data-id');
                    $(this).html( '<input type="text" placeholder="Search '+title+'" class="form-control input-sm daterange" name="updated_at" id="'+id+'" />' );
                    $('.daterange').daterangepicker({
                        timePicker: true,
                        autoUpdateInput: false,
                        drops: "up",
                        locale: {
                            cancelLabel: 'Clear',
                            format: 'MM/DD/YYYY HH:mm'
                        }
                    });
                }
                else if($(this).hasClass('date_time'))
                {
                    var id = $(this).attr('data-id');
                    $(this).html( '<input type="text" placeholder="Search '+title+'" class="form-control input-sm daterange" name="date_time" id="'+id+'" />' );
                    $('#'+id).daterangepicker({
                        timePicker: true,
                        autoUpdateInput: false,
                        drops: "up",
                        locale: {
                            cancelLabel: 'Clear',
                            format: 'MM/DD/YYYY HH:mm'
                        }
                    });
                }
                else
                    $(this).html(  '<input type="text" placeholder="Search '+title+'" class="form-control input-sm search-input" />' );
            }
        });

        $( '#datatable thead').on( 'keyup change', ".search-input",function () {
   
                dt_table
                    .column( $(this).parent().index() )
                    .search( this.value )
                    .draw();
            });

            $( '#datatable thead').on( 'change', ".select-box-input",function () {
   
                dt_table
                    .column( $(this).parent().index() )
                    .search( this.value )
                    .draw();
            });


        function updateDtSlno(dt, slno_i) {
            if (typeof dt != "undefined") {
                if(typeof slno_i == 'undefined')
                    slno_i = 0;
                table_rows = dt.fnGetNodes();
                var oSettings = dt.fnSettings();
                $.each(table_rows, function(index){
                    $("td:eq(" + slno_i + ")", this).html(oSettings._iDisplayStart+index+1);
                });
            }
        }

        function dt(){
            dt_table.ajax.reload();
        }
    </script>

@endsection
