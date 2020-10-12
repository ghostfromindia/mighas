<div class="settings-item w-100 confirm-wrap">
    @if($obj->id)
        {{Form::open(['url' => route('admin.category.attribute.groups.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'AttributeGroupFrm'])}}
        <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
    @else
        {{Form::open(['url' => route('admin.category.attribute.groups.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'AttributeGroupFrm'])}}
    @endif
        <input type="hidden" name="category_id" value="@if($obj->id) {{$obj->category_id}} @else {{$category_id}} @endif" id="inputCategoryId">
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Name</label>
                {{ Form::text("group_name", $obj->group_name, array('class'=>'form-control', 'id' => 'group_name')) }}

            </div>
        </div>
    {{Form::close()}}
</div>