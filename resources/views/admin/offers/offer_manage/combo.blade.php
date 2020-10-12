<div class="col-md-6 no-padding" id="combo-offer-type-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Offer Type</label>
            @php
                $combo_offer_type = 'Price';
                if($obj->free_products && count($obj->free_products)>0)
                    $combo_offer_type = 'Another Product';
            @endphp
            {!! Form::select('combo_offer_type', array('Price'=>'Price', 'Another Product'=>'Another Product'), $combo_offer_type, array('class'=>'full-width select2-dropdown', 'id'=>'combo_offer_type')); !!}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 combo-offer-price-wrapper no-padding" id="combo-discount-type-sec" @if($combo_offer_type !='Price') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default form-group-default-select2 required">
            <label>Discount Type</label>
            @php
                $combo_discount_type = ($obj->id && $obj->discount_type == 'Discount Price')? 'Discount Price':'Discount Percentage';
            @endphp
            {!! Form::select('combo_discount_type', array('Discount Percentage'=>'Discount Percentage', 'Discount Price'=>'Discount Price'), $combo_discount_type, array('class'=>'full-width select2-dropdown', 'id'=>'combo_discount_type')); !!}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 combo-offer-price-wrapper no-padding" id="combo-offer-amount-sec" @if($combo_offer_type !='Price' || $combo_discount_type !='Discount Price') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Amount</label>
            {{ Form::text("combo_amount", $obj->amount, array('class'=>'form-control amount', 'id' => 'combo_amount')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 combo-offer-price-wrapper no-padding" id="combo-offer-percentage-sec" @if($combo_offer_type !='Price' || $combo_discount_type !='Discount Percentage') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Percentage</label>
            {{ Form::text("combo_percentage", $obj->percentage, array('class'=>'form-control numeric', 'id' => 'combo_percentage')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 combo-offer-price-wrapper no-padding" id="combo-maximum-discount-amount-sec" @if($combo_offer_type !='Price') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default">
            <label>Maximum Discount Amount</label>
            {{ Form::text("combo_max_discount_amount", $obj->max_discount_amount, array('class'=>'form-control amount', 'id' => 'combo_max_discount_amount')) }}
        </div>
        <span class="error"></span>
    </div>
</div>