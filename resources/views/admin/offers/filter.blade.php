<div class="settings-item w-100 confirm-wrap">
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Category</label>
                @php
                    $category_url = url('select2/categories');
                @endphp
                {{ Form::select("category_id", [], null, array('class'=>'form-control select2_input full-width', 'id' => 'category', 'data-select2-url'=>$category_url, 'data-placeholder'=>'Choose category', 'multiple'=>true)) }}
            </div>
        </div>
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Brand</label>
                {!! Form::select('brand_id',[], null, array('data-placeholder'=>'Choose a brand','data-init-plugin'=>'select2','data-select2-url'=>route('select2.brands'),'class'=>'full-width select2_input', 'id'=>'brand_id', 'multiple'=>true)); !!}
            </div>
        </div>
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Keyword</label>
                {{ Form::text("keyword", null, array('class'=>'form-control', 'id' => 'keyword')) }}
            </div>
        </div>
</div>