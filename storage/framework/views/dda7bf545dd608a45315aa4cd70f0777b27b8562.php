<div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Browser Title</label>
                                  <?php echo e(Form::text("browser_title", $obj->browser_title, array('class'=>'form-control', 'id' => 'browser_title'))); ?>

                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Meta Tags</label>
                                  <?php echo e(Form::textarea("meta_keywords", $obj->meta_keywords, array('class'=>'form-control', 'id' => 'meta_keywords'))); ?>

                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Meta Description</label>
                                  <?php echo e(Form::textarea("meta_description", $obj->meta_description, array('class'=>'form-control', 'id' => 'meta_description'))); ?>

                              </div>
                          </div>
                      </div><?php /**PATH /home/works/public_html/hykon-beta/resources/views/admin/products/form/seo.blade.php ENDPATH**/ ?>