@foreach($menu_items as $mMenu)
	@include('client.includes.mobile_display_menu', ['items'=>$mMenu['menu'], 'depth'=>0])
@endforeach