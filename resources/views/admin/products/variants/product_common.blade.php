<div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default @if(!isset($from_product)) required @endif">
                                        <label>SKU</label>
                                        {{ Form::text("sku", $obj->sku, array('class'=>'form-control', 'id' => 'sku')) }}
                                    </div>
                                </div>
                            </div>
                            @php
                                $retail_price = isset($obj->inventory->retail_price)?$obj->inventory->retail_price:null;
                                $sale_price = isset($obj->inventory->sale_price)?$obj->inventory->sale_price:null;
                                $landing_price = isset($obj->inventory->landing_price)?$obj->inventory->landing_price:null;
                                $available_quantity = isset($obj->inventory->available_quantity)?$obj->inventory->available_quantity:null;
                            @endphp


                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default @if(!isset($from_product)) required @endif">
                                        <label>Retail Price</label>
                                        {{ Form::text("retail_price", $retail_price, array('class'=>'form-control amount', 'id' => 'retail_price')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default @if(!isset($from_product)) required @endif">
                                        <label>Sale Price</label>
                                        {{ Form::text("sale_price", $sale_price, array('class'=>'form-control amount', 'id' => 'sale_price')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Landing Price</label>
                                        {{ Form::text("landing_price", $landing_price, array('class'=>'form-control amount', 'id' => 'landing_price')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default @if(!isset($from_product)) required @endif">
                                        <label>Quantity</label>
                                        {{ Form::text("quantity", $available_quantity, array('class'=>'form-control numeric', 'id' => 'quantity')) }}
                                    </div>
                                </div>
                            </div>
<div class="col-md-6 last-form-row">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default">
            <label>Is new?</label>
            <div class="pull-right">
                {{ Form::checkbox('is_new', 1, $obj->is_new, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 last-form-row">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default">
            <label>Is it a top seller?</label>
            <div class="pull-right">
                {{ Form::checkbox('is_topseller', 1, $obj->is_topseller, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 last-form-row">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default">
            <label>Product status</label>
            <div class="pull-right">
                {{ Form::checkbox('is_active', 1, $obj->is_active, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
            </div>
        </div>
    </div>
</div>

                            <div class="col-md-6 last-form-row">
                                  <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                      <label>Is Offer Enabled?</label>
                                      <div class="pull-right">
                                          {{ Form::checkbox('offer_status', 1, $obj->offer_status, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            <div class="col-md-6 last-form-row">
                                  <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                      <label>Is Combo Offer Enabled?</label>
                                      <div class="pull-right">
                                          {{ Form::checkbox('combo_offer_status', 1, $obj->combo_offer_status, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @if(!isset($from_product))
                                <div class="col-md-6 last-form-row">
                                  <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                      <label>Is Default?</label>
                                      <div class="pull-right">
                                          {{ Form::checkbox('is_default', 1, $obj->is_default, ['data-init-plugin' => 'switchery', 'data-size'=>'small', 'data-color'=>'primary', 'class'=>'js-switch']) }}
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @endif
                            <div class="col-md-6 last-form-row">
                              <div class="row">
                                <div class="default-image-holder padding-5">
                                    <a href="javascript:void(0);" class="image-remove"><i class="fa  fa-times-circle"></i></a>
                                    <a href="{{url('admin/media/popup', ['popup_type'=>'single_image', 'type'=>'Products', 'holder_attr'=>'0', 'related_id'=>$product->id])}}" class="open-ajax-popup" title="Product Images" data-popup-size="large" id="image-holder-0">
                                      @if($obj->image_id && $obj->media)
                                        <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->media->thumb_file_path) }}">
                                      @else
                                        <img class="card-img-top padding-20" src="{{asset('assets/img/add_image.png')}}">
                                      @endif
                                    </a>
                                    <input type="hidden" name="image_id" id="mediaId0" value="{{$obj->image_id}}">
                                </div>
                              </div>
                            </div>


