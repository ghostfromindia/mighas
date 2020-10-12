@if(count($photos)>0)
	@foreach($photos as $photo)
		<div class="col-md-3 media-preview-wrap parent" style="background: #e8e9ea;margin: 5px 5px 10px 10px">
			<a href="{{url('admin/banners/photo-edit', array('id'=>$photo->id, 'slider_id'=>$slider, 'type'=>$type))}}" class="open-ajax-popup" title="update Image Details" data-popup-size="xlarge"><img src="{{ asset('public/'.$photo->media->thumb_file_path) }}"></a>
			<a href="{{url('admin/banners/photo-delete',['slider'=>$slider, 'media'=>$photo->id, 'type'=>$type])}}" class="btn btn-danger delete-btn slider-photo-delete">X</a>
		</div>
	@endforeach
@endif