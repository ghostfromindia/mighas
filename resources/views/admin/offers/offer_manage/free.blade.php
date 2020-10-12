<div class="col-md-6 no-padding free_category_wrapper" id="free-offer-applicable-to-sec">
    <div class="row column-seperation padding-5">
        <div class="form-group form-group-default required">
            <label>Offer Applicable To</label>
            @php
                $free_offer_applicable_to = 'Products';
                if($obj->id && $obj->applicable_for_full_order == 1)
                    $free_offer_applicable_to = 'All Products';
                elseif($obj->categories && count($obj->categories)>0)
                    $free_offer_applicable_to = 'Categories';
            @endphp      
            {!! Form::select('free_offer_applicable_to', array('Products'=>'Products', 'Categories'=>'Categories', 'All Products'=>'All Products'), $free_offer_applicable_to, array('class'=>'full-width select2-dropdown', 'id'=>'free_offer_applicable_to')); !!}
        </div>
        <span class="error"></span>
    </div>
</div>
<div class="col-md-6 no-padding free_category_wrapper" id="free-category-sec" @if($free_offer_applicable_to != 'Categories') style="display: none;" @endif>
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
            {!! Form::select('free_categories[]',$categories, $selected_categories, array('data-placeholder'=>'Choose  categories','data-init-plugin'=>'select2','data-select2-url'=>route('select2.categories'),'class'=>'full-width select2_input', 'id'=>'free_categories', 'multiple'=>true)); !!}
        </div>
        <span class="error"></span>
    </div>
</div>