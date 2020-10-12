@php
  $product_attributes = array();
  if($obj->attributes)
    $product_attributes = $obj->attributes->pluck('attribute_value_id')->toArray();
@endphp
<div class=" container container-fixed-lg">
  <div class="row">
    @if(count($attributes)>0)
      @foreach($attributes as $attribute)
      <div class="col-lg-4">
        <h5>{{$attribute->attribute_name}}</h5>
        @if($attribute->attribute_type == 'Selectable')
          @foreach($attribute->values as $value)
            <div class="radio radio-success">
                <input type="radio" value="{{$value->id}}" name="attribute_{{$attribute->id}}"  id="value{{$value->id}}" {{ in_array($value->id, $product_attributes) ? "checked" : "" }}>
                <label for="value{{$value->id}}">{{$value->value}}</label>     
            </div>
          @endforeach
        @else
          <div class="row column-seperation padding-5">
              <div class="form-group form-group-default">
                  @php
                    $attr_value = null;
                    if($obj->attributes)
                    {
                      foreach($obj->attributes as $pAttr){
                        if($pAttr->attribute_id == $attribute->id)
                          $attr_value = $pAttr->attribute_value;
                      }
                    }
                  @endphp
                  {{ Form::textarea('attribute_'.$attribute->id, $attr_value, array('class'=>'form-control')) }}
              </div>
          </div>
        @endif
      </div>
      @endforeach
    @else
      <div class="no-result">
        <p>No specifications added for this category!</p>
      </div>
    @endif
  </div>
</div>