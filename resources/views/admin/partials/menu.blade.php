@foreach($items as $key=>$item)
	<li @if($item->id == $parent) class="open active" @elseif($cur_url == $item->slug) class="active" @endif>
		<a href="{{url($item->slug)}}"  class="detailed">
			<span class="title">{{$item->title}}</span>
			@if(isset($item->children))
				<span class="arrow"></span>
			@endif
		</a>
		<span class="icon-thumbnail"><i class="{{$item->icon}}"></i></span>
		@if(isset($item->children))
			<ul class="sub-menu">
		    	@include('admin.partials.menu', ['items'=>$item->children, 'parent'=>$parent, 'cur_url'=>$cur_url])
		    </ul>
		@endif
	</li>
@endforeach
