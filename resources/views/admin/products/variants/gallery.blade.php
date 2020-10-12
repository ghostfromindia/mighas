<div class="product-gallery">
                          <div id="dropzone" class="dropzone-wrapper">
                                <input type="hidden" id="related_type" value="Products">
                                <input type="hidden" id="related_id" value="{{$product->id}}">
                                  <i>Drop files here</i>
                                  <i class="sm-text">or</i>
                                  <!-- upload button -->
                                  <span class="button btn-blue input-file">
                                      Browse Files <input type="file" id="fileupload" name="files[]" data-url="{{ url('admin/products/media-save')}}" multiple />
                                  </span>
                          </div>
                          <div class="col-md-12 clearfix padding-10">
                            <a href="{{url('admin/media/popup', ['popup_type'=>'product_gallery', 'type'=>'Products', 'holder_attr'=>'0', 'related_id'=>$product->id])}}" class="btn btn-success btn-sm pull-right open-ajax-popup" data-popup-size="large" title="Product Images"><i class="fa fa-plus"></i> &nbsp;Add new</a>
                          </div>
                          <div class="row" id="productGalleryList">
                            @if(count($gallery)>0)
                              @foreach($gallery as $key=> $item)
                                <div class="col-md-3 item-img default-padding">
                                  <div class="card">
                                    <a href="{{url('admin/media/popup', ['popup_type'=>'single_image', 'type'=>'Products', 'holder_attr'=>'edit'.$key, 'related_id'=>$product->id])}}" class="open-ajax-popup" title="Product Images" data-popup-size="large" id="image-holder-edit{{$key}}">
                                      @if($item->thumb_file_path)
                                        <img class="card-img-top padding-20" src="{{ asset('public/'.$item->thumb_file_path) }}">
                                      @else
                                        <img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}">
                                      @endif
                                    </a>
                                    <div class="card-body">
                                      <input type="hidden" name="media_id[]" id="mediaIdedit{{$key}}" value="{{$item->id}}">
                                      <div class="form-group">
                                        <input type="text" name="title[]" class="form-control" placeholder="Title" value="{{$item->title}}">
                                      </div>
                                      <div class="form-group">
                                        <input type="text" name="alt[]" class="form-control" placeholder="Alt" value="{{$item->alt}}">
                                      </div>
                                      <a href="javascript:void(0)" class="product-img-item-remove">Remove</a>
                                    </div>
                                  </div>
                                </div>
                              @endforeach
                            @else
                              @for ($i=1; $i<5; $i++)
                              <div class="col-md-3 item-img default-padding">
                                <div class="card">
                                  <a href="{{url('admin/media/popup', ['popup_type'=>'single_image', 'type'=>'Products', 'holder_attr'=>'new'.$i, 'related_id'=>$product->id])}}" class="open-ajax-popup" title="Product Images" data-popup-size="large" id="image-holder-new{{$i}}"><img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}"></a>
                                  <div class="card-body">
                                    <input type="hidden" name="media_id[]" id="mediaIdnew{{$i}}">
                                    <div class="form-group">
                                      <input type="text" name="title[]" class="form-control" placeholder="Title">
                                    </div>
                                    <div class="form-group">
                                      <input type="text" name="alt[]" class="form-control" placeholder="Alt">
                                    </div>
                                    <a href="javascript:void(0)" class="product-img-item-remove">Remove</a>
                                  </div>
                                </div>
                              </div>
                              @endfor
                            @endif
                          </div>
                        </div>