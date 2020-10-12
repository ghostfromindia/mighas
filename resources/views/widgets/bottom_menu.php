@foreach($menu_items as $key=>$item)
    <li class="footer-links__item"><a href="{{$item->slug}}" class="footer-links__link">{{$item->title}}</a></li>
@endforeach