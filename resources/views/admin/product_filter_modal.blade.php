<div id="filterModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter Product</h4>
      </div>
      <div class="modal-body">
        <div class="settings-item w-100 confirm-wrap">
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Category</label>
                    @php
                        $category_url = url('select2/categories');
                    @endphp
                    {{ Form::select("category[]", [], null, array('class'=>'form-control select2_input full-width', 'id' => 'category', 'data-select2-url'=>$category_url, 'data-placeholder'=>'Choose category', 'multiple'=>true, 'data-parent'=>'#filterModal')) }}
                </div>
            </div>
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Brand</label>
                    {!! Form::select('brand[]',[], null, array('data-placeholder'=>'Choose a brand','data-init-plugin'=>'select2','data-select2-url'=>route('select2.brands'),'class'=>'full-width select2_input', 'id'=>'brand', 'multiple'=>true, 'data-parent'=>'#filterModal')); !!}
                </div>
            </div>
            <div class="column-seperation padding-5 text-field">
                <div class="form-group form-group-default required">
                    <label>Keyword</label>
                    {{ Form::text("keyword", null, array('class'=>'form-control', 'id' => 'keyword')) }}
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="filterBtn">Filter</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>