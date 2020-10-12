<div class="col-md-6 no-padding category_wrapper" id="price-offer-applicable-to-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Offer Applicable To</label>
            @php
                $price_offer_applicable_to = 'Products';
                if($obj->id && $obj->applicable_for_full_order == 1)
                    $price_offer_applicable_to = 'All Products';
                elseif($obj->categories && count($obj->categories)>0)
                    $price_offer_applicable_to = 'Categories';
            @endphp   
            {!! Form::select('price_offer_applicable_to', array('Products'=>'Products', 'Categories'=>'Categories', 'All Products'=>'All Products'), $price_offer_applicable_to, array('class'=>'full-width select2-dropdown', 'id'=>'price_offer_applicable_to')); !!}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 price-offer-price-wrapper no-padding" id="price-discount-type-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default form-group-default-select2 required">
            <label>Discount Type</label>
            @php
                $price_discount_type = ($obj->id && $obj->discount_type == 'Discount Price')? 'Discount Price':'Discount Percentage';
            @endphp
            {!! Form::select('price_discount_type', array('Discount Percentage'=>'Discount Percentage', 'Discount Price'=>'Discount Price'), $price_discount_type, array('class'=>'full-width select2-dropdown', 'id'=>'price_discount_type')); !!}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 price-offer-price-wrapper no-padding" @if($price_discount_type !='Discount Price') style="display: none;" @endif id="price-offer-amount-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Amount</label>
            {{ Form::text("price_amount", $obj->amount, array('class'=>'form-control amount', 'id' => 'price_amount')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 price-offer-price-wrapper no-padding" id="price-offer-percentage-sec" @if($price_discount_type !='Discount Percentage') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Percentage</label>
            {{ Form::text("price_percentage", $obj->percentage, array('class'=>'form-control numeric', 'id' => 'price_percentage')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 price-offer-price-wrapper no-padding" id="price-minimum-purchase-amount-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default">
            <label>Minimum Purchase Amount</label>
            {{ Form::text("price_min_purchase_amount", $obj->min_purchase_amount, array('class'=>'form-control amount', 'id' => 'price_min_purchase_amount')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 price-offer-price-wrapper no-padding" id="price-maximum-discount-amount-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default">
            <label>Maximum Discount Amount</label>
            {{ Form::text("price_max_discount_amount", $obj->max_discount_amount, array('class'=>'form-control amount', 'id' => 'price_max_discount_amount')) }}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 no-padding price_category_wrapper" id="price-category-sec" @if($price_offer_applicable_to != 'Categories') style="display: none;" @endif>
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Categories</label>
            @php
                $categories = [];
                $selected_categories = null;
                if($obj->categories && count($obj->categories)>0)
                {
                    foreach($obj->categories as $category)
                    {
                        $categories[$category->categories_id] = $category->category->category_name;
                        $selected_categories[] = $category->categories_id;
                    }
                }
            @endphp
            {!! Form::select('price_categories[]',$categories, $selected_categories, array('data-placeholder'=>'Choose  categories','data-init-plugin'=>'select2','data-select2-url'=>route('select2.categories'),'class'=>'full-width select2_input', 'id'=>'price_categories', 'multiple'=>true)); !!}
        </div>
        <span class="error"></span>
    </div>
</div>