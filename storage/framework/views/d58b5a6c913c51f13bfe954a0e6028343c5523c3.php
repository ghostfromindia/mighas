<form method="POST" action="<?php echo e(url('admin/banners/update-photo', ['id'=>$photo->id])); ?>" class="p-t-15" id="sliderModalFrm" data-validate=true>
                  <?php echo csrf_field(); ?>

<input type="hidden" name="type" value="<?php echo e($type); ?>">

<div class="row">

	<div class="box-body col-md-12">

    <div class="form-group required">

      <label class="control-label" for="inputLabelEn">Title</label>
      <input type="text" name="title" class="form-control" value="<?php echo e($photo->title); ?>" id="titleInput" >
    </div>
    <?php if($crop_ratio): ?>
    <div class="form-group required row nopadding">

      <div class="col-md-9 nopadding img-container-edit" data-crop-ratio="<?php echo e($crop_ratio); ?>" data-crop-details="<?php echo e($photo->crop_data); ?>">

        <img src="<?php echo e(asset('public/'.$photo->media->file_path)); ?>" id="image">

      </div>

      <div class="col-md-3 img-details-edit">

        <div class="img-details">

          <p><label>File Name: </label> <?php echo e($photo->media->file_name); ?></p>

          <p><label>Created On: </label> <?php echo date('d M, Y h:i A', strtotime($photo->media->created_at));?></p>

          <p><label>File Type: </label> <?php echo e($photo->media->file_type); ?></p>

          <p><label>File Dimensions: </label> <?php echo e($photo->media->dimensions); ?></p>

        </div>
        <?php
        $dataX = null; $dataY = null; $dataHeight = null; $dataWidth = null;
        if($photo->crop_data)
        {
          $crop_data = (array) json_decode($photo->crop_data);
          $dataX = $crop_data['x'];
          $dataY = $crop_data['y'];
          $dataHeight = $crop_data['height'];
          $dataWidth = $crop_data['width'];
        }
        ?>

        <div class="docs-preview clearfix">

          <div class="img-preview preview-lg"></div>

          <input type="hidden" name="dataX" id="dataX" value="<?php echo e($dataX); ?>">

          <input type="hidden" name="dataY" id="dataY" value="<?php echo e($dataY); ?>">

          <input type="hidden" name="dataHeight" id="dataHeight" value="<?php echo e($dataHeight); ?>">

          <input type="hidden" name="dataWidth" id="dataWidth" value="<?php echo e($dataWidth); ?>">
          <input type="hidden" name="crop_data" id="cropData">

        </div>

  </div>

    </div>
    <?php else: ?>
      <img src="<?php echo e(asset('public/'.$photo->media->file_path)); ?>">
    <?php endif; ?>

    <div class="form-group required">

      <label class="control-label" for="inputLabelEn">Alt Text</label>

      <input type="text" name="alt_text" class="form-control" value="<?php echo e($photo->alt_text); ?>" id="altInput" >

    </div>
    <div class="form-group required">

      <label class="control-label" for="inputLabelEn">Link</label>

      <input type="text" name="link" class="form-control" value="<?php echo e($photo->link); ?>" id="linkInput" >

    </div>

    <div class="form-group col-md-12 pull-right">

            <button type="submit" class="btn btn-primary">Save</button>

    </div>

  </div>

</div>

</form><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/banners/photo_edit.blade.php ENDPATH**/ ?>