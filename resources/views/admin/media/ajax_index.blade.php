@foreach($files as $file)

	<div class="col-md-2 media-previe-wrap parent">
		<input type="checkbox" name="ids[]" class="bulk-selet-media" style="display: none;" value="{{$file->id}}">
		@if($file->media_type == "Image")
			<a href="{{url('admin/media/edit', array('id'=>$file->id))}}" class="open-ajax-modal"><img src="{{ asset('public/'.$file->thumb_file_path) }}"></a>
		@else
			<div class="attachment-preview">
				<div class="thumbnail_new">
					<div class="centered">
						<a href="{{url('admin/media/edit', array('id'=>$file->id))}}" class="open-ajax-modal icon"><img src="{{ asset('public/'.$file->thumb_file_path) }}" class="icon"></a>
					</div>
					<div class="filename">
						<a href="{{url('admin/media/edit', array('id'=>$file->id))}}" class="open-ajax-modal">{{$file->file_name}}</a>
					</div>
				</div>
			</div>
		@endif
		<a href="javascript:void(0);" data-id="{{$file->id}}" class="btn btn-danger delete-btn media-delete">X</a>
	</div>
@endforeach
<div class="col-md-12 media-nav text-right">
	<input type="hidden" id="currentPage" value="{{$page}}">
	{{ $files->appends(['req' => $req])->links() }}
</div>