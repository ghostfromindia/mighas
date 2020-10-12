@php
	$selected_items = isset($selected_items)?$selected_items:[];
@endphp
@if(count($products)>0)
                                    @foreach($products as $product)
                                      <li class="list-group-item @if(in_array($product->id, $selected_items)) disabled @else @if(isset($all_selected) && $all_selected) selected @endif selectable @endif" id="{{$product->id}}">
                                        <label>{{$product->product_name}}</label>
                                        <input type="hidden" name="product[]" value="{{$product->id}}">
                                      </li>
                                    @endforeach
                                    @if($products->hasMorePages())
                                    	<li id="load-more"><a href="javascript:void(0)">Load More</a></li>
                                    @endif
                                    <li id="pagination-ajax" style="display: none;">
                                    	{{$products->links()}}
                                    </li>
                                  @endif