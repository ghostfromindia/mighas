<div class="settings-item w-100 confirm-wrap">
    @if($obj->id)
        {{Form::open(['url' => route('admin.category.attribute.value.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'AttributeValueFrm'])}}
        <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
    @else
        {{Form::open(['url' => route('admin.category.attribute.value.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'AttributeValueFrm'])}}
        <input type="hidden" name="attribute_id" value="{{encrypt($attribute->id)}}" id="attributeId">
    @endif
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Value</label>
                {{ Form::text("value", $obj->value, array('class'=>'form-control', 'id' => 'value')) }}

            </div>
        </div>
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Slug</label>
                {{ Form::text("value_slug", $obj->value_slug, array('class'=>'form-control', 'id' => 'value_slug')) }}
            </div>
            <p class="hint-text small">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
        </div>
    {{Form::close()}}
</div>