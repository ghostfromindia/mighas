<div class="settings-item w-100 confirm-wrap">
    <?php
    if($obj->type != 'Image')
        $validate = true;
    else
        $validate = false;
    ?>
        {{Form::open(['url' => route('admin.settings.update'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'SettingsFrm', 'data-validate'=>$validate])}}
            <input type="hidden" name="id" value="{{encrypt($obj->id)}}">
            <input type="hidden" name="type" value="{{$obj->type}}">
                                @if($obj->type != 'Image')
                                <div class="column-seperation padding-5 text-field">
                                    <div class="form-group form-group-default required">
                                        <label>Value</label>
                                        {{ Form::text("value", $obj->value, array('class'=>'form-control', 'id' => 'value_1')) }}

                                    </div>
                                </div>
                                @else
                                <div class="column-seperation padding-5 image-field">
                                    <div class="fileinput fileupload-exists center-block" data-provides="fileupload" >
                                      <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 100px; height: 100px;">
                                        <img src="{{ asset('public/'.$obj->media->file_path) }}"  alt="{{$obj->value}}"/>
                                      </div>
                                      <div>
                                        <span class="btn-file">
                                            <input type="file" name="image" id="image_1" >
                                        </span>
                                      </div>
                                    </div>
                                    <p class="help-block text-info text-center">Click on the image to change</p>
                                </div>
                                @endif
        {{Form::close()}}                
</div>
