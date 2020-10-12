<div class="col-md-6 first-form-row">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default form-group-default-select2">
                                  <label>Status</label>
                                  {!! Form::select('is_active', array('1'=>'Enabled', '0'=>'Disabled'), $obj->is_active, array('class'=>'full-width select2_input', 'id'=>'inputStatus','data-placeholder'=>'Choose status','data-init-plugin'=>'select2')); !!}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default form-group-default-select2 required">
                                  <label>Category</label>
                                  @php
                                    $categories = [];
                                    if($obj->category_id)
                                      $categories = [$obj->category_id => $obj->category->category_name];
                                  @endphp

                                  {!! Form::select('category_id',$categories, $obj->category_id, array('data-placeholder'=>'Choose a category','data-init-plugin'=>'select2','data-select2-url'=>route('select2.categories'),'class'=>'full-width select2_input', 'id'=>'category_id')); !!}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>Product Name</label>
                                  {{ Form::text("product_name", $obj->product_name, array('class'=>'form-control', 'id' => 'product_name','required' => true)) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>Slug</label>
                                  {{ Form::text("slug", $obj->slug, array('class'=>'form-control', 'id' => 'slug','required' => true)) }}
                              </div>
                              <p class="hint-text small">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>Page Heading</label>
                                  {{ Form::text("page_heading", $obj->page_heading, array('class'=>'form-control', 'id' => 'page_heading')) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Tag Line</label>
                                  {{ Form::text("tagline", $obj->tagline, array('class'=>'form-control', 'id' => 'tagline')) }}
                              </div>
                          </div>
                      </div>
                      
                      <div class="col-md-12">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default required">
                                  <label>Summary</label>
                                  {{ Form::textarea("summary", $obj->summary, array('class'=>'form-control richtext', 'id' => 'summary')) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Top Description</label>
                                  {{ Form::textarea("top_description", $obj->top_description, array('class'=>'form-control richtext', 'id' => 'top_description')) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default">
                                  <label>Bottom Description</label>
                                  {{ Form::textarea("bottom_description", $obj->bottom_description, array('class'=>'form-control richtext', 'id' => 'sale_price')) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default form-group-default-select2">
                                  <label class="">Brand</label>
                                  @php
                                    $brands = [];
                                    if($obj->brand_id)
                                      $brands = [$obj->brand_id => $obj->brand->brand_name];
                                  @endphp
                                  {!! Form::select('brand_id',$brands, $obj->brand_id, array('data-placeholder'=>'Choose a brand','data-init-plugin'=>'select2','data-select2-url'=>route('select2.brands'),'class'=>'full-width select2_input', 'id'=>'brand_id')); !!}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default form-group-default-select2">
                                  <label class="">Vender</label>
                                  @php
                                    $venders = [];
                                    if($obj->vender_id)
                                      $venders = [$obj->vender_id => $obj->vendor->vendor_name];
                                  @endphp
                                  {!! Form::select('vender_id',$venders, $obj->vender_id, array('data-placeholder'=>'Choose a vender','data-init-plugin'=>'select2','data-select2-url'=>route('select2.venders'),'class'=>'full-width select2_input', 'id'=>'vender_id')); !!}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default disabled">
                                  <label>Quantity</label>
                                  {{ Form::text("quantity", $obj->quantity, array('class'=>'form-control numeric', 'id' => 'quantity', 'readonly'=>true)) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default disabled">
                                  <label>MRP</label>
                                  {{ Form::text("retail_price", $obj->mrp, array('class'=>'form-control amount', 'id' => 'mrp', 'readonly'=>true)) }}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row column-seperation padding-5">
                              <div class="form-group form-group-default disabled">
                                  <label>Sale Price</label>
                                  {{ Form::text("sale_price", $obj->sale_price, array('class'=>'form-control amount', 'id' => 'sale_price', 'readonly'=>true)) }}
                              </div>
                          </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                          <div class="form-group form-group-default">
                            <label>New product?</label>
                            <div class="pull-right">
                                {{ Form::checkbox('is_featured_in_home_page', 1, $obj->is_featured_in_home_page, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                          <div class="form-group form-group-default">
                            <label>Is featured in category?</label>
                            <div class="pull-right">
                                {{ Form::checkbox('is_featured_in_category', 1, $obj->is_featured_in_category, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                          <div class="form-group form-group-default">
                            <label>Is top rated product?</label>
                            <div class="pull-right">
                                {{ Form::checkbox('is_new', 1, $obj->is_new, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                          <div class="form-group form-group-default">
                            <label>Is top seller?</label>
                            <div class="pull-right">
                                {{ Form::checkbox('is_top_seller', 1, $obj->is_top_seller, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 last-form-row">
                        <div class="row column-seperation padding-5">
                          <div class="form-group form-group-default">
                            <label>Is product with special offer?</label>
                            <div class="pull-right">
                                {{ Form::checkbox('is_today_deal', 1, $obj->is_today_deal, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
                            </div>
                          </div>
                        </div>
                      </div>


