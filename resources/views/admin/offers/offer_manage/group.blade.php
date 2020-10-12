@php
    $group_id = $how_many_to_buy = $how_many_to_get_free = null;
    $group_offer_type = 'Another Product';
    if($obj->group_offer)
    {
        $group_id = $obj->group_offer->groups_id;
        $how_many_to_buy = $obj->group_offer->how_many_to_buy;
        $how_many_to_get_free = $obj->group_offer->how_many_to_get_free;
        if($obj->id && !$obj->group_offer->how_many_to_get_free)
            $group_offer_type = 'Price';
    }
@endphp
<div class="col-md-6 no-padding group_wrapper" id="group-group-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            @php
                $groups = [];
                $group_id = null;
                if($obj->id && $obj->group_offer)
                {
                    $group_id = $obj->group_offer->groups_id;
                    $groups[$obj->group_offer->groups_id] = $obj->group_offer->group->group_name;
                }
            @endphp
            <label>Group</label>
            {!! Form::select('groups_id',$groups, $group_id, array('data-placeholder'=>'Choose  group','data-init-plugin'=>'select2','data-select2-url'=>route('select2.groups'),'class'=>'full-width select2_input', 'id'=>'group_id')); !!}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 no-padding" id="group-offer-howmany-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Minimum number of products to avail this offer</label>
            {{ Form::text("how_many_to_buy", $how_many_to_buy, array('class'=>'form-control numeric', 'id' => 'how_many_to_buy')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 no-padding" id="group-offer-type-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Offer Type</label>        
            {!! Form::select('group_offer_type', array('Another Product'=>'Another Product', 'Price'=>'Price'), $group_offer_type, array('class'=>'full-width select2-dropdown', 'id'=>'group_offer_type')); !!}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 no-padding" id="group-offer-howmany-free-sec" @if($group_offer_type !='Another Product') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Number of free products</label>
            {{ Form::text("how_many_to_get_free", $how_many_to_get_free, array('class'=>'form-control numeric', 'id' => 'how_many_to_get_free')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 group-offer-price-wrapper no-padding" id="group-discount-type-sec" @if($group_offer_type !='Price') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default form-group-default-select2 required">
            <label>Discount Type</label>
            @php
                $group_discount_type = ($obj->id && $obj->discount_type == 'Discount Price')? 'Discount Price':'Discount Percentage';
            @endphp
            {!! Form::select('group_discount_type', array('Discount Percentage'=>'Discount Percentage', 'Discount Price'=>'Discount Price'), $group_discount_type, array('class'=>'full-width select2-dropdown', 'id'=>'group_discount_type')); !!}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 group-offer-price-wrapper no-padding" id="group-offer-amount-sec" @if($group_offer_type !='Price' || ($group_offer_type =='Price' && $group_discount_type !='Discount Price')) style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Amount</label>
            {{ Form::text("group_amount", $obj->amount, array('class'=>'form-control amount', 'id' => 'group_amount')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 group-offer-price-wrapper no-padding" id="group-offer-percentage-sec" @if($group_offer_type !='Price' || ($group_offer_type =='Price' && $group_discount_type !='Discount Percentage')) style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Percentage</label>
            {{ Form::text("group_percentage", $obj->percentage, array('class'=>'form-control numeric', 'id' => 'group_percentage')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 group-offer-price-wrapper no-padding" id="group-maximum-discount-amount-sec" @if($group_offer_type !='Price') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default">
            <label>Maximum Discount Amount</label>
            {{ Form::text("group_max_discount_amount", $obj->max_discount_amount, array('class'=>'form-control amount', 'id' => 'group_max_discount_amount')) }}
        </div>
        <span class="error"></span>
    </div>
</div>