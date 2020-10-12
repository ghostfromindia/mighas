@foreach($menu_items as $mMenu)
	@include('client.includes.menu', ['items'=>$mMenu['menu'], 'depth'=>0, 'type'=>$mMenu['type']])
@endforeach