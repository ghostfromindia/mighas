<div class="">
  <div class="col-md-12">
	   <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                        <li class="nav-item">
                            <a <?php if(count($files)==0): ?> class="active show" <?php endif; ?> data-toggle="tab" role="tab"
                               data-target="#tab1Media"
                            href="#" aria-selected="true">Upload Files</a>
                        </li>
                        <li class="nav-item">
                            <a <?php if(count($files)>0): ?> class="active show" <?php endif; ?> data-toggle="tab" role="tab"
                               data-target="#tab2Media"
                            href="#" aria-selected="true">Media Library</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <input type="hidden" id="popupType"  <?php if($popup_type == 'banner' || $popup_type == 'mobile_banner'): ?> value="single_image" <?php else: ?> value="<?php echo e($popup_type); ?>" <?php endif; ?>>
                        <input type="hidden" id="holder_attr" value="<?php echo e($holder_attr); ?>">
                        <input type="hidden" id="related_type" value="<?php echo e($type); ?>">
                        <input type="hidden" id="related_id" value="<?php echo e($related_id); ?>">
                        <?php
                          $data_url = url('admin/media/save');
                          if($type == 'Products')
                            $data_url = url('admin/products/media-save')
                        ?>
                        <div class="tab-pane <?php if(count($files)==0): ?> active show <?php endif; ?>" id="tab1Media">
                          <div class="col-md-12">
                            <div class="upload-wrapper">
                              <div id="error_output"></div>
                                  <!-- file drop zone -->
                              <div id="dropzone" class="dropzone-wrapper">
                                      <i>Drop files here</i>
                                      <i class="sm-text">or</i>
                                      <!-- upload button -->
                                      <span class="button btn-blue input-file">
                                          Browse Files <input type="file" id="mediafileupload" name="files[]" data-url="<?php echo e($data_url); ?>" multiple />
                                      </span>
                              </div>
                              <p class="warning"><b>Avoid multiple uploads of same files</b></p>
                                  <!-- The container for the uploaded files -->
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane <?php if(count($files)>0): ?> active show <?php endif; ?>" id="tab2Media">
                          <div class="media-list-head row padding-10">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-right">
                              <label>
                                <input class="form-control input-sm" placeholder="Search..." aria-controls="datatable" type="search" id="mediaPopupSearchInput">
                              </label>
                            </div>
                          </div>
                          <div class="row media-list-modal" id="mediaList">
                            <?php echo $__env->make('admin.media.ajax_index_popup', ['files'=>$files, 'holder_attr'=>$holder_attr], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                          </div>
                          <div class="text-right">
                              <?php if($popup_type == 'single_image'): ?>
                                <button class="btn btn-primary" id="setSingleImage"><i class="glyphicon glyphicon-plus-sign"></i> Add Image</button>
                              <?php elseif($popup_type == 'banner'): ?>
                                <button class="btn btn-primary" id="setBannerImage"><i class="glyphicon glyphicon-plus-sign"></i> Change Banner</button>
                              <?php elseif($popup_type == 'mobile_banner'): ?>
                                <button class="btn btn-primary" id="setMobileBannerImage"><i class="glyphicon glyphicon-plus-sign"></i> Change Mobile Banner</button>
                              <?php elseif($popup_type == 'product_gallery'): ?>
                                <button class="btn btn-primary" id="setProductGallery" data-product="<?php echo e($related_id); ?>"><i class="glyphicon glyphicon-plus-sign"></i> Add Images</button>
                              <?php else: ?>
                                <button class="btn btn-primary" id="addPhotos" <?php if($popup_type == 'photos'): ?> data-url="<?php echo e(url('admin/photos/save')); ?>" <?php elseif($popup_type == 'sliders'): ?> data-url="<?php echo e(url('admin/sliders/update', ['id'=>encrypt($id)])); ?>" <?php elseif($popup_type == 'banners'): ?> data-url="<?php echo e(url('admin/banners/update', ['id'=>encrypt($id)])); ?>" <?php endif; ?>><i class="glyphicon glyphicon-plus-sign"></i> Add Photos</button>
                              <?php endif; ?>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/media/popup.blade.php ENDPATH**/ ?>