@php
  $trackings = $obj->tracking_history->pluck('order_status_labels_master_id')->toArray();
@endphp
<div class="settings-item w-100 confirm-wrap">
  <div class="row">
    <div class="col-md-6">
      <h6>{{$obj->product_variants->name}}</h6>
      <p>Order Id: <b>{{$obj->order->transaction_id}}</b></p>
      <p>Order created by: <b>{{$obj->order->user->full_name}}</b></p>
      <p>Quantity: {{$obj->quantity}}</p>
      <p>MRP: {{$obj->mrp}}</p>
      <p>Sale Price: {{$obj->sale_price}}</p>
      <p>Discount: {{$obj->discount}}</p>
      <p>Payment Method: {{$obj->order->payment_method}}</p>
      <p>Payment Status: @if($obj->order->payment_method == 'Online Payment') @if($obj->order->payment_receive_status == 1) <span class="badge badge-success">Received</span> @else <span class="badge badge-danger">Pending</span> @endif @else <span class="badge badge-info">On Delivery</span> @endif</p>
    </div>
    <div class="col-md-6">
      <h6>{{$obj->order->delivery_address->full_name}}</h6>
      <p>
          {{$obj->order->delivery_address->address1}}, 
          @if($obj->order->delivery_address->address2)
              {{$obj->order->delivery_address->address2}}, 
          @endif
          @if($obj->order->delivery_address->landmark)
              {{$obj->order->delivery_address->landmark}}, 
          @endif
          {{$obj->order->delivery_address->city}}, 
          {{$obj->order->delivery_address->state_details->name}},
          {{$obj->order->delivery_address->pincode}}
      </p>
      <p>Phone Number {{$obj->order->delivery_address->phone}}</p>
      @if($obj->order->delivery_instructions)
          <p>Delivery Instructions: {{$obj->order->delivery_instructions}}</p>
      @endif
      <p>Address Type: @if($obj->order->delivery_address->type == 1) Home @else Work @endif</p>
    </div>
  </div>
  @if(isset($response['success']) && $response['success'] == false)
    <div class="alert alert-danger" role="alert">
      {{$response['message']}}
    </div>
  @endif
  <div class="row w-100">
    <ol class="progtrckr w-100" data-progtrckr-steps="{{count($tracking_statuses)}}">
      @foreach($tracking_statuses as $key=>$item)
        @php
          $status = 'progtrckr-todo';
          if(in_array($item->id, $trackings))
            $status = 'progtrckr-done';
        @endphp
        <li class="{{$status}}">{{$item->name}}</li>
      @endforeach
    </ol>
  </div>
  <div class="row">
    <div class="col-md-12">
     <table class="table table-hover demo-table-search table-responsive-block">
        <thead>
          <th>Status</th>
          <th>Note</th>
          <th>Updated By</th>
          <th>Updated On</th>
        </thead>
        <tbody>
          @foreach($obj->tracking_history as $key=>$item)
          <tr>
            <td>{{$item->status->name}}</td>
            <td>{{$item->notes}}</td>
            <td>{{$item->user->username}}</td>
            <td>{{date('d M, Y h:i A', strtotime($item->updated_at))}}</td>
          </tr>
          @endforeach
        </tbody>
     </table>
    </div>
  </div>
  @if($obj->order->delivery_instructions)
  <div class="row">
    <div class="col-md-12">
      <p class="mt-2"><b>Delivery Instructions: </b> <span class="text-danger">{{$obj->order->delivery_instructions}}</span></p>
    </div>
  </div>
  @endif
  @if($canceled_status != $obj->status)
  <div class="row">
    <div class="card card-borderless">
      <div class="card-body" id="update-order-status" @if($order_processing_type != 'N') style="display:none" @endif>
          <h5 class="card-title">Update Status</h5>
          {{Form::open(['url' => route('admin.orders.change-status'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'orderStatudFrm', 'class'=>'col-md-12'])}}
          <input type="hidden" name="id" value="{{$obj->id}}">
          <div class="col-md-12 first-form-row">
                            <div class="row column-seperation padding-5">
                                <div class="form-group w-100" id="status-parent">
                                    <label>Status</label>
                                    {!! Form::select('status', $tracking_statuses->pluck('name', 'id')->toArray(), $obj->status, array('class'=>'full-width select2_input', 'id'=>'inputStatus', 'data-parent'=>'#status-parent')); !!}
                                </div>
                            </div>
                        </div>
          <div class="col-md-12 first-form-row">
                            <div class="row column-seperation padding-5">
                                <div class="form-group w-100">
                                    <label>Note</label>
                                    {{ Form::textarea("note", $obj->group_name, array('class'=>'form-control', 'id' => 'name', 'rows'=>'3')) }}
                                </div>
                            </div>
                        </div>
          <div class="col-md-12 padding-10" align="right">
                        <a href="javascript:void(0)" id="cancel-link">Cancel this order</a>
                          <button type="button" class="btn btn-primary" id="order-status-update-btn">Update</button>
                      </div>
        {{Form::close()}}
        </div>
        <div class="card-body" id="cancel-order" @if($order_processing_type != 'C') style="display:none" @endif>
          <h5 class="card-title">Cancel Order</h5>
          {{Form::open(['url' => route('admin.orders.change-status'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'cancelOrderFrm', 'class'=>'col-md-12'])}}
          <input type="hidden" name="id" value="{{$obj->id}}">
          <input type="hidden" name="is_cancel" value="1">
              <div class="col-md-12 first-form-row">
                            <div class="row column-seperation padding-5">
                                <div class="form-group w-100">
                                    <label>Note</label>
                                    {{ Form::textarea("note", null, array('class'=>'form-control', 'id' => 'name', 'rows'=>'3')) }}
                                </div>
                            </div>
                        </div>
              <div class="col-md-12 padding-10" align="right">
                        @if($order_processing_type == 'N')
                        <a href="javascript:void(0)" id="change-status-link">Change order status</a>
                        @endif
                          <button type="button" class="btn btn-primary" id="cancel-order-btn">Cancel Order</button>
                      </div>
        {{Form::close()}}
        </div>
    </div>
  </div>
  @endif
</div>