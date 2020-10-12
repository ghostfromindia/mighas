<?php if(isset($slug)): ?> <?php else: ?> <?php $slug = 'home'; ?> <?php endif; ?>
<?php $__env->startSection('title',Key::page_meta($obj->browser_title,'title')); ?>
<?php $__env->startSection('meta_description',Key::page_meta($obj->meta_description,'description')); ?>
<?php $__env->startSection('meta_keywords',Key::page_meta($obj->meta_keywords,'keywords')); ?>

<?php $__env->startSection('head'); ?>
    <style>
        #googleMap{
            width:100%;
            height:100%;
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
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(url('store-locator')); ?>">Store Locator</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="<?php echo e(asset('client')); ?>/images/sprite.svg#arrow-rounded-right-6x9"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e($obj->branch_name); ?></li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1><?php echo e($obj->page_heading); ?></h1>
            </div>
        </div>
    </div>
    <?php
        $no_image = asset('images/no_image_banner.jpg');
        $no_image_profile = asset('images/default.png');
    ?>
    <div class="block-map block " style="position: relative;">
        <div class="block " >
            <div class="container" >
                <div class="row">
                    <div class="col-12 col-lg-5 mb-4">
                        <div class="card mb-0" >
                            <div class="card-body contact-us">
                                <div class="contact-us__container">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 pb-4 pb-lg-0">
                                            <div class="contact-us__address store-det">
                                                <img src="<?php if($obj->contact_person_photo): ?> <?php echo e(asset($obj->contact_person_photo->file_path)); ?> <?php endif; ?>" class="img-fluid" />

                                                <?php if($obj->description): ?>
                                                    <p>
                                                        <?php echo $obj->description; ?>

                                                    </p>
                                                <?php endif; ?>
                                                <p><?php echo nl2br($obj->address); ?></p>
                                                <?php if($obj->email): ?>
                                                    <p>
                                                        Email : <?php echo e($obj->email); ?>

                                                    </p>
                                                <?php endif; ?>
                                                <?php
                                                    $phone_numbers = [];
                                                    if($obj->landline_number)
                                                        $phone_numbers[] = $obj->landline_number;
                                                    if($obj->mobile_number)
                                                        $phone_numbers[] = $obj->mobile_number;
                                                ?>
                                                <?php if($obj->phone_numbers): ?>
                                                    <p>
                                                        Phone(s) : <?php echo e(implode(', ', $phone_numbers)); ?>

                                                    </p>
                                                <?php endif; ?>
                                                <p>
                                                    <?php if($obj->sunday_open ==0 ): ?>Mon-Sat <?php endif; ?> <?php echo e(date('h:ia', strtotime($obj->opening_time))); ?> - <?php echo e(date('h:ia', strtotime($obj->closing_time))); ?>

                                                    <?php if($obj->contact_person_number): ?> Mobile : <a  href="tel:<?php echo e($obj->contact_person_number); ?>"><?php echo e($obj->contact_person_number); ?></a> <?php endif; ?>

                                                </p><br>
                                                <?php if($obj->contact_person_number): ?>
                                                <a class="btn btn-primary" href="tel:<?php echo e($obj->contact_person_number); ?>"><i class="fa fa-phone" style="margin-right: 10px"></i> <?php echo e($obj->contact_person_number); ?></a>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 mb-4">
                        <div class="block-map__body locator-det-mp">
                            <div id="googleMap"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom'); ?>
    ##parent-placeholder-c03e9099aad17cb58e4fff1d93d751105735c9c2##
    <script>
        var markers = <?php echo json_encode($branches_json, 15, 512) ?>;
        markers = jQuery.parseJSON(markers);
        console.log(markers);

        function initMap()
        {
            var mapOptions = {
                zoom: 7,
                center: new google.maps.LatLng(10.850516, 76.271080),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
            var infoWindow = new google.maps.InfoWindow();
            var lat_lng = new Array();
            var latlngbounds = new google.maps.LatLngBounds();

            var myLatlng = new google.maps.LatLng(markers.lat, markers.lng);
            console.log(myLatlng);
            lat_lng.push(myLatlng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: markers.title,

            });

            latlngbounds.extend(marker.position);
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(markers.description);
                    infoWindow.open(map, marker);
                });
            })(marker, marker);

            //map.setCenter(latlngbounds.getCenter());
            //map.fitBounds(latlngbounds);

        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKNmMGKJYRzfsMF5Jom1Rj5-VPIoyLbak&libraries=places&callback=initMap" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hykon.layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hykon\resources\views/hykon/pages/outlet_details.blade.php ENDPATH**/ ?>