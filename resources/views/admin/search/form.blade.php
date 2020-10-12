@extends('admin.common.base')

@section('head')
    <link href="{{ asset('assets/css/star-rating-svg.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mb-20"  align="right" style="margin-bottom: 20px; ">
            <span class="page-heading">Add Keywords</span>
            <div >

            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-borderless" style="padding: 20px;">
                Add keywords by category wise
                <div class="row">
                    <div class="col-md-6">
                        <h4>Add keywords by category</h4>
                        <form action="{{url('admin/search/category/save')}}" method="post"> @csrf
                        <select class="form-control select2_input" name="category[]" data-select2-url="{{url('/select2/categories')}}" data-placeholder="Choose categories"  multiple="multiple" required></select>

                        <label for="keywords">Enter keywords separated by commas</label>
                        <textarea name="keywords" class="form-control" id="" cols="30" rows="10" required></textarea>

                        <label for="number">Enter keyword priority</label>
                        <input type="number" name="priority" class="form-control" value="2" required>

                            <br>
                        <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <h4>Add keywords by Products</h4>
                        <form action="{{url('admin/search/product/save')}}" method="post"> @csrf
                            <select class="form-control select2_input" name="products[]" data-select2-url="{{url('/select2/products')}}" data-placeholder="Choose products"  multiple="multiple" required></select>

                            <label for="keywords">Enter keywords separated by commas</label>
                            <textarea name="keywords" class="form-control" id="" cols="30" rows="10" required></textarea>

                            <label for="number">Enter keyword priority</label>
                            <input type="number" name="priority" class="form-control" value="2" required> <br>

                            <button type="submit" class="btn btn-success">Add</button>
                        </form>
                    </div>


                </div>

            </div>
        </div>
    </div>
    @include('admin.product_filter_modal')
@endsection
@section('bottom')
    <script src="{{asset('assets/js/jquery.star-rating-svg.min.js')}}"></script>
    <script>
        $(function(){
            var validator = $("#reviewFrm").validate({
                ignore: [],
                //errorElement : 'span',
                errorPlacement: function(error, element){
                    $(element).each(function (){
                        $(this).parent('div').find('span.error').html(error);
                    });
                },
                rules: {
                    title: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: "Title cannot be blank",
                    },
                },
            });

            $(".ratings").starRating({
                starSize: 25,
                readOnly: true
            });
        });
    </script>
    @parent
@endsection