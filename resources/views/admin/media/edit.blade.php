<div class="row">
	<div class="col-md-8">
		<div class="img-container-edit">
      @if($file->media_type == 'Image')
        <img  src="{{ asset('public/'.$file->file_path) }}" alt="{{$file->file_name}}">
      @elseif($file->media_type == 'Video')
        <div class="embed-responsive embed-responsive-16by9">
          <video class="embed-responsive-item" controls>
            <source src="{{ asset('public/'.$file->file_path) }}" type="{{$file->file_type}}">
            Your browser does not support the video tag.
          </video>
        </div>
      @elseif($file->media_type == 'Audio')
        <div>
           <audio controls>
            <source src="{{ asset('public/'.$file->file_path) }}" type="{{$file->file_type}}">
            Your browser does not support the audio element.
          </audio> 
        </div>
      @else
        <div>
          <img  src="{{ asset('public/'.$file->thumb_file_path) }}" alt="{{$file->file_name}}">
        </div>
      @endif
    </div>
	</div>
	<div class="col-md-4 img-details-edit">
		    <div class="img-details">
          <p><label>File Path: </label> {{ asset('public/'.$file->file_path) }} </p>
          <p><label>File Name: </label> {{$file->file_name}}</p>
          <p><label>File Size: </label> {!! Helper::filesize($file->file_size) !!} </p>
          <p><label>Created On: </label> <?php echo date('d M, Y h:i A', strtotime($file->created_at));?></p>
          <p><label>File Type: </label> {{$file->file_type}}</p>
          @if($file->media_type == 'Image')
            <p><label>File Dimensions: </label> {{$file->dimensions}}</p>
          @endif
        </div>
        {!! Form::open(array('url' => url('admin/media/store-extra', ['id'=>$file->id]), 'files' => true, 'role' => 'form', 'id' => 'mediaExtraFrm')) !!} 
        <div class="image_details_edit">
          <div class="form-group required">
              {{ Form::text('title', $file->title, array('class'=>'form-control', 'id' => 'inputTitle', 'placeholder' => 'Title')) }}
          </div>
          <div class="form-group required">
              {{ Form::textarea('description', $file->description, array('class'=>'form-control', 'id' => 'inputDescription', 'rows'=>3, 'placeholder'=>'Description')) }}
          </div>
          @if($file->media_type == 'Image')
            <div class="form-group required">
                {{ Form::text('alt_text', $file->alt_text, array('class'=>'form-control', 'id' => 'inputAlt', 'placeholder'=>'Alt Text ')) }}
            </div>
          @endif
          <div class="form-group required">
              <button type="button" class="btn btn-primary" id="updateMediaBtn">Save</button> 
              <!--<a href="javascript:void(0);" data-id="{{$file->id}}" class="media-delete">Delete</a>-->
          </div>
          <div class="alert alert-success" style="display: none;" id="mediaExtraMsg">
          </div>
        </div>
        {!! Form::close() !!}
	</div>
</div>
<script type="text/javascript">
    var bd_id = '{{ Input::get('modal_id') }}';
    if(bd_id)
    {
      var bd = BootstrapDialog.getDialog(bd_id);
      bd.setTitle('');
      bd.setSize(BootstrapDialog.SIZE_WIDE); 
    }
</script>