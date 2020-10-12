<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/plugins/bootstrap-timepicker/glyphicon.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            <?php if($obj->id): ?>
                <span class="page-heading">EDIT Branch</span>
            <?php else: ?>
                <span class="page-heading">Create Branch</span>
            <?php endif; ?>
            <div >
                <div class="btn-group">
                    <a href="<?php echo e(route('admin.branch.home')); ?>"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    <?php if($obj->id): ?>
                    <a href="<?php echo e(route('admin.branch.create')); ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                    </a>
                    <button type="button" class="btn btn-success"><i class="fa fa-trash-o"></i> Delete
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                <?php if($obj->id): ?>
                    <?php echo e(Form::open(['url' => route('admin.branch.update'), 'method' => 'post','enctype' => 'multipart/form-data'])); ?>

                    <input type="hidden" name="id" value="<?php echo e(encrypt($obj->id)); ?>">
                <?php else: ?>
                    <?php echo e(Form::open(['url' => route('admin.branch.save'), 'method' => 'post','enctype' => 'multipart/form-data'])); ?>

                <?php endif; ?>
                <?php echo csrf_field(); ?>

                <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active show" data-toggle="tab" role="tab"
                           data-target="#tab1Basic"
                        href="#" aria-selected="true">Mandatory Details</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab2CONTACT"
                        class="" aria-selected="false">Contact Person</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab5Location"
                        class="" aria-selected="false">Location</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab3SEO"
                        class="" aria-selected="false">SEO</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab4Media"
                           class="" aria-selected="false">Media</a>
                    </li>
                </ul>
                <div class="nav-tab-dropdown cs-wrapper full-width d-lg-none d-xl-none d-md-none"><div class="cs-select cs-skin-slide full-width" tabindex="0"><span class="cs-placeholder">Hello World</span><div class="cs-options"><ul><li data-option="" data-value="#tab2hellowWorld"><span>Hello World</span></li><li data-option="" data-value="#tab2FollowUs"><span>Hello Two</span></li><li data-option="" data-value="#tab2Inspire"><span>Hello Three</span></li></ul></div><select class="cs-select cs-skin-slide full-width" data-init-plugin="cs-select"><option value="#tab2hellowWorld" selected="">Hello World</option><option value="#tab2FollowUs">Hello Two</option><option value="#tab2Inspire">Hello Three</option></select><div class="cs-backdrop"></div></div></div>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Branch name</label>
                                        <?php echo e(Form::text("branch_name", $obj->branch_name, array('class'=>'form-control', 'id' => 'branch_name','required' => true))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Page heading</label>
                                        <?php echo e(Form::text("page_heading", $obj->page_heading, array('class'=>'form-control', 'id' => 'page_heading','required' => true))); ?>


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Branch type</label>
                                        <?php echo Form::select('type', array('dealer'=>'Dealer', 'branch'=>'Branch', 'factory'=>'Factory'), $obj->type, array('class'=>'full-width select2_input', 'id'=>'inputStatus', 'data-placeholder'=>'Choose a type','data-init-plugin'=>'select2',));; ?>


                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Branch address</label>
                                        <?php echo e(Form::textarea("address", $obj->address, array('class'=>'form-control update-map', 'id' => 'address','required' => true))); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Branch slug (for url)</label>
                                        <?php echo e(Form::text("slug", $obj->slug, array('class'=>'form-control', 'id' => 'slug','required' => true))); ?>


                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Branch Location</label>
                                        <?php echo e(Form::text("location", $obj->location, array('class'=>'form-control', 'id' => 'location','required' => true))); ?>


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">State</label>
                                        <select class="full-width select2_input update-map" placeholder="Select Districts" id="district_id" name="state_id" required="true">
                                            <option value="">Select State</option>
                                            <?php if(count($states)>0): ?>
                                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($o->id); ?>" <?php if($o->id == $obj->state_id): ?> selected="selected" <?php endif; ?>><?php echo e($o->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">District</label>
                                        <select class="full-width select2_input update-map" placeholder="Select Districts" id="district_id" name="district_id" required="true">
                                            <option value="">Select District</option>
                                            <?php if(count($districts)>0): ?>
                                                <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($district->id); ?>" <?php if($district->id == $obj->district_id): ?> selected="selected" <?php endif; ?>><?php echo e($district->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Opening Time</label>
                                        <?php
                                            $opening_time = null;
                                            if($obj->opening_time)
                                                $opening_time = date('h:i A', strtotime($obj->opening_time));
                                        ?>
                                        <?php echo e(Form::text("opening_time", $opening_time, array('class'=>'form-control datetimepicker', 'id' => 'opening_time', 'readOnly'=>true,'required' => true))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Closing Time</label>
                                        <?php
                                            $closing_time = null;
                                            if($obj->closing_time)
                                                $closing_time = date('h:i A', strtotime($obj->closing_time));
                                        ?>
                                        <?php echo e(Form::text("closing_time", $closing_time, array('class'=>'form-control datetimepicker', 'id' => 'closing_time', 'readOnly'=>true,'required' => true))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5">
                                  <div class="form-group form-group-default">
                                    <label>Open on sundays?</label>
                                    <div class="pull-right">
                                        <?php echo e(Form::checkbox('sunday_open', 1, $obj->sunday_open, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch'])); ?>

                                    </div>
                                  </div>
                                </div>
                              </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Landline Number</label>
                                        <?php echo e(Form::text("landline_number", $obj->landline_number, array('class'=>'form-control', 'id' => 'landline_number'))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Mobile Number</label>
                                        <?php echo e(Form::text("mobile_number", $obj->mobile_number, array('class'=>'form-control', 'id' => 'mobile_number'))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Email</label>
                                        <?php echo e(Form::email("email", $obj->email, array('class'=>'form-control', 'id' => 'email'))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Branch description</label>
                                        <?php echo e(Form::textarea("description", $obj->description, array('class'=>'form-control', 'id' => 'description'))); ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" id="tab2CONTACT">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Full Name</label>
                                        <?php echo e(Form::text("contact_person", $obj->contact_person, array('class'=>'form-control', 'id' => 'contact_person'))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Phone Number</label>
                                        <?php echo e(Form::text("contact_person_number", $obj->contact_person_number, array('class'=>'form-control', 'id' => 'contact_person_number'))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Photo</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId2"><i class="fa  fa-times-circle"></i></a>
                                        <a href="<?php echo e(route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'2', 'related_id'=>$obj->id])); ?>" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-2">
                                          <?php if($obj->contact_person_image && $obj->contact_person_photo): ?>
                                            <img class="card-img-top padding-20" src="<?php echo e(asset('public/'.$obj->contact_person_photo->thumb_file_path)); ?>">
                                          <?php else: ?>
                                            <img class="card-img-top padding-20" src="<?php echo e(asset('assets/img/add_image.png')); ?>">
                                          <?php endif; ?>
                                        </a>
                                        <input type="hidden" name="contact_person_image" id="mediaId2" value="<?php echo e($obj->contact_person_image); ?>">
                                    </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab5Location">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Lattitude</label>
                                        <?php echo e(Form::text("lattitude", $obj->lattitude, array('class'=>'form-control', 'id' => 'latitudeInput'))); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Longitude</label>
                                        <?php echo e(Form::text("longitude", $obj->longitude, array('class'=>'form-control', 'id' => 'longitudeInput'))); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row column-seperation padding-5">
                                    <button type="button" class="btn btn-default" id="mapUpdateBtn">Update Map</button>
                                </div>
                            </div>
                            <div class="embed-responsive embed-responsive-16by9">
                                <div id="map" class="embed-responsive-item"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3SEO">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Meta title</label>
                                        <?php echo e(Form::text("browser_title", $obj->browser_title, array('class'=>'form-control', 'id' => 'browser_title'))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Meta Keywords</label>
                                        <?php echo e(Form::text("meta_keywords", $obj->meta_keywords, array('class'=>'form-control', 'id' => 'meta_keywords'))); ?>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Meta description</label>
                                        <input type="text" class="form-control" name="meta_description">
                                        <?php echo e(Form::text("meta_description", $obj->meta_description, array('class'=>'form-control', 'id' => 'meta_description'))); ?>


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
                                        <a href="<?php echo e(route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'0', 'related_id'=>$obj->id])); ?>" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-0">
                                          <?php if($obj->media_id && $obj->media): ?>
                                            <img class="card-img-top padding-20" src="<?php echo e(asset('public/'.$obj->media->thumb_file_path)); ?>">
                                          <?php else: ?>
                                            <img class="card-img-top padding-20" src="<?php echo e(asset('assets/img/add_image.png')); ?>">
                                          <?php endif; ?>
                                        </a>
                                        <input type="hidden" name="media_id" id="mediaId0" value="<?php echo e($obj->media_id); ?>">
                                    </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Banner Image</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId1"><i class="fa  fa-times-circle"></i></a>
                                        <a href="<?php echo e(route('admin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'1', 'related_id'=>$obj->id])); ?>" class="open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder-1">
                                          <?php if($obj->banner_id && $obj->banner): ?>
                                            <img class="card-img-top padding-20" src="<?php echo e(asset('public/'.$obj->banner->thumb_file_path)); ?>">
                                          <?php else: ?>
                                            <img class="card-img-top padding-20" src="<?php echo e(asset('assets/img/add_image.png')); ?>">
                                          <?php endif; ?>
                                        </a>
                                        <input type="hidden" name="banner_id" id="mediaId1" value="<?php echo e($obj->banner_id); ?>">
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
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
    <script type="text/javascript" src="<?php echo e(asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')); ?>"></script>
    <script type="text/javascript">

        $('input[name=branch_name]').change(function () {
            $('input[name=slug]').val(slugify($(this).val()))
        });

        $('input[name=branch_name]').change(function () {
            $('input[name=page_heading]').val($(this).val())
        });



        $(function(){
            // $(document).on('change', '#district_id', function(){
            //     var type_id = $(this).val();
            //     var target = $('#landmark_id');
            //     var options = '<option value="">[ Select a district first ]</option>';
            //     if(parseInt(type_id)>0){
            //         target.html('<option value="">Loading...</option>');
            //         $.getJSON(base_url  + '/ajax/locations/' + type_id, function(jsonData){
            //             if ( jsonData.length != 0 ) {
            //                 options = '<option value="">--- Select a location ---</option>';
            //                 $.each(jsonData, function(i,data) {
            //                     options +='<option value="'+data.id+'">'+data.text+'</option>';
            //                 });
            //             } else {
            //                 options = '<option value="">[No locations listed in this district]</option>';
            //             }
            //             target.html(options).change();
            //         });
            //     } else {
            //         target.html(options).change();
            //     }
            // })

            $('.datetimepicker').timepicker();
        });

            var marker;
    var map;  // global map variable

    function placeMarker(location) {
      if (marker && marker.setPosition) {
        marker.setMap(null);

      }
        //create a marker
        marker = new google.maps.Marker({
          position: location,
          map: map,
          draggable: true
        });
      
      google.maps.event.addListener(marker, 'dragend', function (event){
        $('#latitudeInput').val(event.latLng.lat());
        $('#longitudeInput').val(event.latLng.lng());
      });
    }

    var change_latlong = 0;

    function initMap() {
      var latitude = parseFloat($('#latitudeInput').val());
      var longitude = parseFloat($('#longitudeInput').val());

      if(!latitude)
        latitude = 0;
      if(!longitude)
        longitude = 0;
      // no "var" here, initialize the global map variable
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: latitude, lng: longitude}
      });

      var geocoder = new google.maps.Geocoder();
      if(latitude!=0 && longitude!=0)
        geocodeAddress(geocoder, map);

      $(document).on('change blur', '.update-map', function(){
          change_latlong = 1;
            geocodeAddress(geocoder, map);
      });
    }

    $(document).on('click', '#mapUpdateBtn', function(){
      change_latlong = 0;
      initMap();
    })

    function geocodeAddress(geocoder, resultsMap) {
        var address = '';
        if($('#address').val()!='')
            {
              address += $('#address').val();
            }
            if($('#landmark_id').val()!='')
            {
              if(address != '')
                address += '+';
              address += $('#landmark_id :selected').text();
            }
            if($('#district_id').val()!='')
            {
              if(address != '')
                address += '+';
              address += $('#district_id :selected').text();
            }
      geocoder.geocode({
        'address': address
      }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          if(change_latlong == 1)
          {
              resultsMap.setCenter(results[0].geometry.location);
              placeMarker(results[0].geometry.location);
              $('#latitudeInput').val(results[0].geometry.location.lat());
              $('#longitudeInput').val(results[0].geometry.location.lng());
          }
          else
          {
            var latitude = parseFloat($('#latitudeInput').val());
            var longitude = parseFloat($('#longitudeInput').val());

            if(!latitude)
                latitude = 0;
            if(!longitude)
                longitude = 0;

            resultsMap.setCenter({lat: latitude, lng: longitude});
            placeMarker({lat: latitude, lng: longitude});
          }
        } 
      });
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkuoACWyj3tYwfe13vb2aR5wgl1xiAr2E&callback=initMap"></script>
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.common.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/admin/branch/form.blade.php ENDPATH**/ ?>