<div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Browser Title</label>
                                  {{ Form::text("browser_title", $obj->browser_title, array('class'=>'form-control', 'id' => 'browser_title')) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Meta Tags</label>
                                  {{ Form::textarea("meta_keywords", $obj->meta_keywords, array('class'=>'form-control', 'id' => 'meta_keywords')) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Meta Description</label>
                                  {{ Form::textarea("meta_description", $obj->meta_description, array('class'=>'form-control', 'id' => 'meta_description')) }}
                              </div>
                          </div>
                      </div>