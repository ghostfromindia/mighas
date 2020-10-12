@extends('admin.common.base')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
          <span class="page-heading">Add Images for products</span>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless">
                {{Form::open(['url' => route('admin.products.browse-images-save'), 'method' => 'post','enctype' => 'multipart/form-data', 'id'=>'SettingsFrm'])}}

                <div class="padding-20">
                        <div class="settings-item row">
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Select a Category</label>
                                        <select class="form-control select2_input full-width select2-dropdown" id="search-product">
                                          <option value="">Select a Category</option>
                                          @foreach($all_categories as $item)
                                            <option value="{{$item->id}}" @if($category == $item->id) selected="selected" @endif>{{$item->category_name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                          </div>
                          @if($category)
                          <div>
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">Product</th>
                                  <th scope="col">Primary Image</th>
                                  <th scope="col">Gallery1</th>
                                  <th scope="col">Gallery2</th>
                                  <th scope="col">Gallery3</th>
                                  <th scope="col">Gallery4</th>
                                </tr>
                              </thead>
                              @if(count($products)>0)
                              <tbody>
                                @foreach($products as $product)
                                <tr>
                                  <td>{{$product->product_name}}<input type="hidden" name="products[]" value="{{$product->id}}"></td>
                                  <td style="text-align: center;">
                                    @if($product->variant->image_id && $product->variant->media)
                                      <a href="javascript:void(0);" data-src="{{asset($product->variant->media->file_path)}}" data-title="{{$product->variant->media->file_name}}" class="view-image"><img src="{{asset($product->variant->media->file_path)}}" style="height:100px;"></a>
                                    @endif
                                    <input type="file" name="primary_image[]" class="form-control">
                                  </td>
                                  <td style="text-align: center;"><input type="file" name="gallery1[]" class="form-control"></td>
                                  <td style="text-align: center;"><input type="file" name="gallery2[]" class="form-control"></td>
                                  <td style="text-align: center;"><input type="file" name="gallery3[]" class="form-control"></td>
                                  <td style="text-align: center;"><input type="file" name="gallery4[]" class="form-control"></td>
                                </tr>
                                @endforeach
                              </tbody>
                              @endif
                            </table>
                          </div>
                          
                          <div class="row bottom-btn">
                            <div class="col-md-12" align="right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        @endif
                        </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('bottom')
    <script>
      $(function(){
        $(document).on('change', '#search-product', function(){
          var id = $(this).val();
          window.location.href = "{{url('admin')}}/browse-images/"+id;
        })
      })
    </script>
    @parent
@endsection