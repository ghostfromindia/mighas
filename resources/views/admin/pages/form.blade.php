@extends('admin.common.datatable')

@section('head')
        <link rel="stylesheet" type="text/css" href="{{asset('assets/keditor/css/keditor.css')}}" data-type="keditor-style" />
        <link rel="stylesheet" type="text/css" href="{{asset('assets/keditor/css/keditor-components.css')}}" data-type="keditor-style" />
        <!-- End of KEditor styles -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/keditor/css/prettify.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('assets/keditor/css/keditor-custom.css')}}" />

        <style>
            .block-li{
                padding-left: 0px;
            }
            .block-li li{
                list-style: none;
                border: 1px solid darkgrey;
                margin-top: 5px;
            }
            .block-li li div{
                padding-right: 5px;
            }
            .block-li li div{
                color: red;
                cursor: pointer;
                float: right;
            }
        </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT PAGE</span>
            @else
                <span class="page-heading">CREATE NEW PAGE</span>
            @endif
            <div >
                <div class="btn-group">
                    <a href="{{route($route.'.index')}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    @if($obj->id)
                    <a href="{{route($route.'.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                    </a>
                    <a href="{{route($route.'.destroy', [encrypt($obj->id)])}}" class="btn btn-success btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.index')}}"><i class="fa fa-trash"></i> Delete</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="PageFrm" data-validate=true>
                @else
                    <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="PageFrm" data-validate=true>
                @endif
                @csrf
                <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">

                <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active show" data-toggle="tab" role="tab"
                           data-target="#tab1Basic"
                        href="#" aria-selected="true">Basic Details</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab2Content"
                        class="" aria-selected="false">Content</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab3SEO"
                        class="" aria-selected="false">SEO</a>
                    </li>

                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab4Media"
                           class="" aria-selected="false">Extra</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-12">
                                <div data-keditor="html">
                                    <div id="content-area"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Type</label>
                                        {!! Form::select('type', array('Career'=>'Career','Page'=>'Page', 'Blog'=>'Blog', 'News'=>'News', 'Landing'=>'Landing', 'Events'=>'Events','History'=>'History'), $obj->type, array('class'=>'full-width select2_input', 'id'=>'inputStatus', 'data-placeholder'=>'Choose a type','data-init-plugin'=>'select2',)); !!}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Title</label>
                                        <input type="text" name="name" class="form-control" value="{{$obj->name}}" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Slug (for url)</label>
                                        <input type="text" name="slug" class="form-control" value="{{$obj->slug}}" id="slug">
                                    </div>
                                    <p class="hint-text small">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label class="">Parent</label>
                                        <select name="parent_id" class="full-width select2_input" data-select2-url="{{route('select2.pages')}}" data-placeholder="Select Parent Page" data-init-plugin="select2">
                                            
                                         </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Primary Heading</label>
                                        <input type="text" name="primary_heading" class="form-control" value="{{$obj->primary_heading}}" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" @if($obj->type != 'Events' && $obj->type != 'History') style="display: none"  @endif>
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>@if($obj->type== 'History') History date @else Event Date and Time @endif</label>
                                        <input type="datetime-local" name="event_date_time" class="form-control" value="{{$obj->event_date_time}}" >
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="3" id="short_description">{{$obj->short_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Content</label>
                                        <textarea name="content" class="form-control richtext" id="content" data-image-url="{{route('admin.summernote.image')}}">{{$obj->content}}</textarea>
                                    </div>
                                </div>
                            </div>


                            @if($obj->type == 'Landing')
                                <div class="col-md-12" style="background: #e0e0e0;margin: 20px;padding-right: 20px;" id="block1">
                                    <div class="row">


                                        <div class="col-md-12">
                                            <h4>Block 1 - Group of products</h4>
                                            <span id="block-1-reponse"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default required">
                                                            <label>Block 1 Heading</label>
                                                            <input type="text" name="block-1-heading" class="form-control" value="{{$obj->block_1_title}}">
                                                        </div>
                                                    </div>

                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default">
                                                            <label>Block 1 Summary</label>
                                                            <textarea name="block-1-summary" class="form-control" rows="3" id="summary">{{$obj->block_1_summary}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default required">
                                                            <label>Block 1 Products</label>
                                                            <select name="block-1-products" class="full-width select2_input" data-select2-url="{{route('select2.products')}}" data-placeholder="Select Products" data-init-plugin="select2" multiple="true"></select>



                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div id="html"></div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary block-1-submit">Update blocks</button>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-md-12" style="background: #e0e0e0;margin: 20px;padding-right: 20px;" id="block2">
                                    <div class="row">


                                        <div class="col-md-12">
                                            <h4>Block 2 - Group of products</h4>
                                            <span id="block-2-response"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default required">
                                                            <label>Block 2 Heading</label>
                                                            <input type="text" name="block-2-heading" class="form-control" value="{{$obj->block_2_title}}">
                                                        </div>
                                                    </div>

                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default">
                                                            <label>Block 2 Summary</label>
                                                            <textarea name="block-2-summary" class="form-control" rows="3" id="summary1">{{$obj->block_2_summary}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default required">
                                                            <label>Block 2 Products</label>
                                                            <select name="block-2-products" class="full-width select2_input" data-select2-url="{{route('select2.products')}}" data-placeholder="Select Products" data-init-plugin="select2" multiple="true"></select>



                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div id="html2"></div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary block-2-submit">Update blocks</button>
                                        </div>


                                    </div>
                                </div>



                                <div class="col-md-12" style="background: #e0e0e0;margin: 20px;padding-right: 20px;" id="block3">
                                    <div class="row">


                                        <div class="col-md-12">
                                            <h4>Block 3 - Single products</h4>
                                            <span id="block-3-reponse"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default required">
                                                            <label>Block 3 Heading</label>
                                                            <input type="text" name="block-3-heading" class="form-control" value="{{$obj->block_3_title}}">
                                                        </div>
                                                    </div>

                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default">
                                                            <label>Block 3 Summary</label>
                                                            <textarea name="block-3-summary" class="form-control" rows="3" id="summary3">{{$obj->block_3_summary}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="row column-seperation padding-5">
                                                        <div class="form-group form-group-default required">
                                                            <label>Block 3 Products</label>
                                                            <select name="block-3-products" class="full-width select2_input" data-select2-url="{{route('select2.products')}}" data-placeholder="Select Products" data-init-plugin="select2" multiple="true"></select>



                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div id="html3"></div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary block-3-submit">Update blocks</button>
                                        </div>


                                    </div>
                                </div>


                            @endif



                        </div>
                    </div>
                    <div class="tab-pane" id="tab2Content">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default required">
                                            <label>Top content</label>
                                            <textarea name="top_description" class="form-control richtext" id="top_description" data-image-url="{{route('admin.summernote.image')}}">{{$obj->top_description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default required">
                                            <label>Bottom content</label>
                                            <textarea name="bottom_description" class="form-control richtext" id="bottom_description" data-image-url="{{route('admin.summernote.image')}}">{{$obj->bottom_description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label class="">Extra Css</label>
                                            <textarea name="extra_css" class="form-control" rows="3" id="extra_css">{{$obj->extra_css}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label class="">Extra Js</label>
                                            <textarea name="extra_js" class="form-control" rows="3" id="extra_js">{{$obj->extra_js}}</textarea>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3SEO">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Browser title</label>
                                        <input type="text" class="form-control" name="browser_title" id="browser_title" value="{{$obj->browser_title}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Meta Keywords</label>
                                        <textarea name="meta_keywords" class="form-control" rows="3" id="meta_keywords">{{$obj->meta_keywords}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Meta description</label>
                                        <textarea name="meta_description" class="form-control" rows="3" id="meta_description">{{$obj->meta_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab4Media">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Featured Image</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId0"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'0', 'related_id'=>$obj->id])}}" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-0">
                                          @if($obj->media_id && $obj->featured_image)
                                            <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->featured_image->thumb_file_path) }}">
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="media_id" id="mediaId0" value="{{$obj->media_id}}">
                                    </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Banner Image</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId1"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'1', 'related_id'=>$obj->id])}}" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-1">
                                          @if($obj->banner_id && $obj->banner_image)
                                            <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->banner_image->thumb_file_path) }}">
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="banner_id" id="mediaId1" value="{{$obj->banner_id}}">
                                    </div>
                              </div>
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
        </div>
    </div>
@endsection
@section('bottom')
        <script type="text/javascript" src="{{asset('assets/keditor/js/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/keditor/js/form-builder.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/keditor/js/form-render.min.js')}}"></script>
        <!-- Start of KEditor scripts -->
        <script type="text/javascript" src="{{asset('assets/keditor/js/keditor.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/keditor/js/keditor-components.js')}}"></script>
        <!-- End of KEditor scripts -->
        <script type="text/javascript" src="{{asset('assets/keditor/js/prettify.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/keditor/js/beautify.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/keditor/js/beautify-html.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/keditor/js/keditor-custom.js')}}"></script>
        <script type="text/javascript" data-keditor="script">
            $(function () {
                $('#content-area').keditor();
            });
        </script>
    <script type="text/javascript">
        var csrf = $('meta[name=csrf-token]').attr("content");

        $('input[name=name]').change(function () {
            $('input[name=slug]').val(slugify($(this).val()))
        });

        $('input[name=name]').change(function () {
            $('input[name=primary_heading]').val($(this).val())
        });



        $('.block-1-submit').click(function () {
            var products = $('select[name=block-1-products]').val();
            var title = $('input[name=block-1-heading]').val();
            var summary = $('#summary').val();


            var data = {
                products : products,
                title : title,
                type : 'block-1',
                landing_id : '{{$obj->id}}',
                summary : summary,
                _token : csrf
            }

            $.post('{{url('admin/landing-page-blocks')}}',data).done(function (data) {
                data = JSON.parse(data);
                $('#block-1-reponse').html(data.status);
                console.log(data);
                update_block_1();
            })

        })

        setTimeout(function () {
            update_block_1();
        },2000)

        function update_block_1(){

            var data = {
                type : 'block-1',
                landing_id : '{{$obj->id}}',
                _token : csrf
            }



            $.post('{{url('admin/landing-page-blocks/get')}}',data).done(function (data) {
                data = JSON.parse(data);
                $('#block-1-reponse').html(data.status);
                console.log(data);
                $('input[name=block-1-heading]').val(data.title);
                $('#summary').val(data.summary);

                var html = "<div><ul class='block-li'>";
                data.products.forEach(function (item, index) {
                    console.log(item[1])
                    html += '<li>'+item[1]+'<div class="destroy-this-'+item[0]+'" onclick="destroy_it('+item[0]+')" data-id="'+item[0]+'">Remove</div></li>';
                })
                html += '</ul></div>';
                $('#html').html(html)
            })
        }



        var validator = $('#PageFrm').validate({
            ignore: [],
            rules: {
                "name": "required",
                slug: {
                  required: true,
                  remote: {
                      url: "{{route('validate.unique.page-slug')}}",
                      data: {
                        id: function() {
                          return $( "#inputId" ).val();
                      }
                    }
                  }
                },
                content: {
                  required: function(textarea) {
                     return $('#'+textarea.id).summernote('isEmpty');
                  }
                },
              },
              messages: {
                "name": "Page title cannot be blank",
                slug: {
                  required: "Slug cannot be blank",
                  remote: "Slug is already in use",
                },
                "description": "Page content cannot be blank",
              },
            });
    </script>

        <script type="text/javascript">


            $('.block-2-submit').click(function () {
                var products = $('select[name=block-2-products]').val();
                var title = $('input[name=block-2-heading]').val();
                var summary = $('#summary1').val();


                var data = {
                    products : products,
                    title : title,
                    type : 'block-2',
                    landing_id : '{{$obj->id}}',
                    summary : summary,
                    _token : csrf
                }

                $.post('{{url('admin/landing-page-blocks')}}',data).done(function (data) {
                    data = JSON.parse(data);
                    $('#block-2-response').html(data.status);
                    console.log(data);
                    update_block_2();
                })

            })

            setTimeout(function () {
                update_block_2();
            },2000)

            function update_block_2(){

                var data = {
                    type : 'block-2',
                    landing_id : '{{$obj->id}}',
                    _token : csrf
                }



                $.post('{{url('admin/landing-page-blocks/get')}}',data).done(function (data) {
                    data = JSON.parse(data);
                    $('#block-2-response').html(data.status);
                    console.log(data);
                    $('input[name=block-2-heading]').val(data.title);
                    $('#summary2').val(data.summary);

                    var html = "<div><ul class='block-li'>";
                    data.products.forEach(function (item, index) {
                        console.log(item[1])
                        html += '<li>'+item[1]+'<div class="destroy-this-'+item[0]+'" onclick="destroy_it('+item[0]+')" data-id="'+item[0]+'">Remove</div></li>';
                    })
                    html += '</ul></div>';
                    $('#html2').html(html)
                })
            }




        </script>



        <script type="text/javascript">


            $('.block-3-submit').click(function () {
                var products = $('select[name=block-3-products]').val();
                var title = $('input[name=block-3-heading]').val();
                var summary = $('#summary3').val();


                var data = {
                    products : products,
                    title : title,
                    type : 'block-3',
                    landing_id : '{{$obj->id}}',
                    summary : summary,
                    _token : csrf
                }

                $.post('{{url('admin/landing-page-blocks')}}',data).done(function (data) {
                    data = JSON.parse(data);
                    $('#block-3-reponse').html(data.status);
                    console.log(data);
                    update_block_3();
                })

            })

            setTimeout(function () {
                update_block_3();
            },2000)

            function update_block_3(){

                var data = {
                    type : 'block-3',
                    landing_id : '{{$obj->id}}',
                    _token : csrf
                }



                $.post('{{url('admin/landing-page-blocks/get')}}',data).done(function (data) {
                    data = JSON.parse(data);
                    $('#block-3-reponse').html(data.status);
                    console.log(data);
                    $('input[name=block-3-heading]').val(data.title);
                    $('#summary3').val(data.summary);

                    var html = "<div><ul class='block-li'>";
                    data.products.forEach(function (item, index) {
                        console.log(item[1])
                        html += '<li>'+item[1]+'<div class="destroy-this-'+item[0]+'" onclick="destroy_it('+item[0]+')" data-id="'+item[0]+'">Remove</div></li>';
                    })
                    html += '</ul></div>';
                    $('#html3').html(html)
                })
            }




        </script>

        <script>
            $('.destroy-this').click(function () { alert(1);
                var id = $(this).data('id');

                var data = {
                    id : 'id',
                    _token : csrf
                }

                $.post('{{url('admin/landing-page-blocks/destroy')}}',data).done(function (data){
                    data = JSON.parse(data);
                    $(this).fadeOut();
                    $('#block-1-reponse').html(data.status);
                })


            })

            function destroy_it(id) {

                var data = {
                    id : id,
                    _token : csrf
                }

                $.post('{{url('admin/landing-page-blocks/destroy')}}',data).done(function (data){
                    data = JSON.parse(data);
                    $('.destroy-this-'+id).parent().fadeOut();
                    $('#block-1-reponse').html(data.status);
                    update_block_1();
                })

            }
        </script>
@parent
@endsection