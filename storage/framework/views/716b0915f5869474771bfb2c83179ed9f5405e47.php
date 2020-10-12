<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($slug,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($slug,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($slug,'keywords')); ?>
<?php $__env->startSection('extra_css',Key::page_meta($slug,'css')); ?>
<?php $__env->startSection('extra_js',Key::page_meta($slug,'js')); ?>
<?php $__env->startSection('head'); ?>
    <style>
        #googleMap{
            width:100%;
            height:100%;
        }
        .site-footer {
            margin-top: 0px;
        }
        .block {
            margin-bottom: 0px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(url('/')); ?>">Home</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="<?php echo e(asset('client')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Store Locator</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>Store Locator</h1>
            </div>
        </div>
    </div>
    <div class="block-map block " style="position: relative;">



   <div class="block locator-list" >
      <div class="container" >

        <div class="row">
                     <div class="col-12 col-lg-4 mb-4">
                         <div class="card"> 
   <div class="card-body">
      <div class="row no-gutters">
         <div class="col-12 col-lg-12 col-xl-12">
             <form action="<?php echo e(url('store-locator')); ?>" class="m-0" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <select class="form-control" placeholder="Select States" id="searchStates" name="state">
                                        <option value="">Select a State</option>
                                        <?php if(count($states)>0): ?>
                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($obj->id); ?>" <?php if(isset($selected_state)): ?> <?php if($obj->id == $selected_state): ?> selected="selected" <?php endif; ?> <?php endif; ?>><?php echo e($obj->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                    <select class="form-control" placeholder="Select City" id="searchLocation" name="district">
                                        <option value="">Select a District</option>
                                        <?php if(isset($district)): ?>
                                            <?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($obj->id); ?>" <?php if(isset($selected_district)): ?> <?php if($obj->id == $selected_district): ?>  selected="selected" <?php endif; ?> <?php endif; ?>><?php echo e($obj->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <option value="">[Select a district first]</option>
                                        <?php endif; ?>
                                    </select>
                              </div>
                           </div>
                          <div class="form-group   mb-0"> <button type="submit" class="btn btn-primary float-right">Search</button></div>
                        </form>

             
             
             
         </div>
      </div>
   </div>
</div>
                     </div>
                      
                     



                       <?php if(count($branches)>0): ?>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 col-lg-4 mb-4">
                                        <div class=" card address-card" style="min-height: 230px;">
                               <div class="address-card__body">
                                        <a href="<?php echo e(url('store-locator', [$branch->slug])); ?>" class="text-body">
                                            <div class="address-card__name">
                                                <span> <?php echo e($key+1); ?> </span>
                                            <strong class="title"><?php echo e($branch->page_heading); ?></strong>
                                        </div>
                                        <div class="address-card__row"><?php echo nl2br($branch->address); ?></div>
                                            
                                           
                                        </a>
                                        </div>
                                        </div>
                                    </div>
                                    <?php if(count($branches) != $key+1): ?>
                                        <hr/>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
 






                 </div>




 
      </div>
   </div>

      <div class="block-map__body locator-img">
      <div id="googleMap"></div>
   </div>


</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
<script>
    var markers = <?php echo json_encode($branches_json, 15, 512) ?>;
    markers = jQuery.parseJSON(markers);

    function initMap()
    {
        var mapOptions = {
            zoom: 9,
            center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
        var infoWindow = new google.maps.InfoWindow();
        var lat_lng = new Array();
        var latlngbounds = new google.maps.LatLngBounds();

        for (i = 0; i < markers.length; i++) {
            var data = markers[i];
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            lat_lng.push(myLatlng);
            var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            title: data.title,

            });

            latlngbounds.extend(marker.position);
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                });
            })(marker, data);
        }

        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);

    }

    $(function(){
        $('select[name=state]').change(function () {
            var state = $('select[name=state]').val();
            $.get('<?php echo e(url('/branch/states')); ?>/'+state).done(function (data) {
                data = JSON.parse(data)
                var op = '<option>Choose a district</option>';
                data.forEach(function (item) {
                    console.log(item.name)
                    op += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('select[name=district]').html(op);
            });
            fetch_branch(state);
        })
    })

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKNmMGKJYRzfsMF5Jom1Rj5-VPIoyLbak&libraries=places&callback=initMap" type="text/javascript"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/works/public_html/hykon-beta/resources/views/hykon/pages/outlet.blade.php ENDPATH**/ ?>