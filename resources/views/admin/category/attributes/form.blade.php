<div class="settings-item w-100 confirm-wrap">
    @if($obj->id)
        @php
            $category_id = $obj->category_id;
        @endphp
        {{Form::open(['url' => route('admin.category.attribute.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'AttributeFrm'])}}
        <input type="hidden" name="id" value="{{encrypt($obj->id)}}" id="inputId">
    @else
        {{Form::open(['url' => route('admin.category.attribute.store'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'AttributeFrm'])}}
    @endif

        @if(isset($category_id))
            <input type="hidden" name="category_id" value="{{$category_id}}">
        @else
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Category</label>
                    <?php
                        $category_url = url('select2/categories');
                        $categories = [];
                        if($obj->category_id)
                            $categories = [$obj->category_id => $obj->category->category_name];
                    ?>
                    {{ Form::select("category_id", $categories, $obj->category_id, array('class'=>'form-control select2_input full-width', 'id' => 'category', 'data-select2-url'=>$category_url, 'data-placeholder'=>'Choose category')) }}

                </div>
            </div>
        @endif
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Group</label>
                {{ Form::select("group_id", App\Models\Category\CategoryAttributeGroups::listForSelect('--- Select a Group ---', $category_id), $obj->group_id, array('class'=>'full-width select2-dropdown', 'id' => 'group_id')) }}
            </div>
        </div>
        <p class="text-right"><a href="javadcript:void(0)" id="create_new_group">Create New Group</a></p>
        <div class="column-seperation padding-5 text-field" id="new-group-sec" style="display: none;">
            <div class="form-group form-group-default required">
                <label>Group Name</label>
                {{ Form::text("group_name", null, array('class'=>'form-control', 'id' => 'group_name')) }}
            </div>
        </div>
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default required">
                <label>Name</label>
                {{ Form::text("attribute_name", $obj->attribute_name, array('class'=>'form-control', 'id' => 'attribute_name')) }}
            </div>
        </div>
        <div class="column-seperation padding-5 text-field">
            <div class="form-group form-group-default">
                <label>Attribute Type</label>
                {!! Form::select('attribute_type', array('Running Text'=>'Running Text', 'Selectable'=>'Selectable'), $obj->attribute_type, array('class'=>'full-width select2-dropdown', 'id'=>'inputAttributeType')); !!}
            </div>
        </div>
        <div class="column-seperation text-field addmore_holder" @if(!$obj->id || $obj->attribute_type == 'Running Text') style="display: none;" @endif>
            <label>Possible Values</label>
            <div class="input-group add-more-first">
                <input type="text" class="form-control" name="value[]">
                <div class="input-group-append">
                    <a href="javascript:void(0);" class="input-group-text primary addmore_text"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            @if($obj->id && $obj->values)
                @foreach($obj->values as $value)
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" name="value_edit[{{$value->id}}]" value="{{$value->value}}">
                        <div class="input-group-append">
                            <a href="javascript:void(0);" class="input-group-text danger addmore_text_remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="column-seperation padding-5 text-field variant-level-holder" @if(!$obj->id || $obj->attribute_type == 'Running Text') style="display: none;" @endif>
            <div class="form-group form-group-default">
                <label>Variant Level</label>
                {!! Form::select('show_as_variant', array('0'=>'None', '1'=>'Level1', '2'=>'Level2', '3'=>'Level3'), $obj->show_as_variant, array('class'=>'full-width select2-dropdown', 'id'=>'inputStatus')); !!}
            </div>
        </div>
    {{Form::close()}}
</div>