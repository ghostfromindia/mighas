<form method="POST" action="{{ url('admin/banners/update-photo', ['id'=>$photo->id]) }}" class="p-t-15" id="sliderModalFrm" data-validate=true>
                  @csrf

<input type="hidden" name="type" value="{{$type}}">

<div class="row">

	<div class="box-body col-md-12">

    <div class="form-group required">

      <label class="control-label" for="inputLabelEn">Title</label>
      <input type="text" name="title" class="form-control" value="{{$photo->title}}" id="titleInput" >
    </div>
    @if($crop_ratio)
    <div class="form-group required row nopadding">

      <div class="col-md-9 nopadding img-container-edit" data-crop-ratio="{{$crop_ratio}}" data-crop-details="{{$photo->crop_data}}">

        <img src="{{ asset('public/'.$photo->media->file_path) }}" id="image">

      </div>

      <div class="col-md-3 img-details-edit">

        <div class="img-details">

          <p><label>File Name: </label> {{$photo->media->file_name}}</p>

          <p><label>Created On: </label> <?php echo date('d M, Y h:i A', strtotime($photo->media->created_at));?></p>

          <p><label>File Type: </label> {{$photo->media->file_type}}</p>

          <p><label>File Dimensions: </label> {{$photo->media->dimensions}}</p>

        </div>
        @php
        $dataX = null; $dataY = null; $dataHeight = null; $dataWidth = null;
        if($photo->crop_data)
        {
          $crop_data = (array) json_decode($photo->crop_data);
          $dataX = $crop_data['x'];
          $dataY = $crop_data['y'];
          $dataHeight = $crop_data['height'];
          $dataWidth = $crop_data['width'];
        }
        @endphp

        <div class="docs-preview clearfix">

          <div class="img-preview preview-lg"></div>

          <input type="hidden" name="dataX" id="dataX" value="{{$dataX}}">

          <input type="hidden" name="dataY" id="dataY" value="{{$dataY}}">

          <input type="hidden" name="dataHeight" id="dataHeight" value="{{$dataHeight}}">

          <input type="hidden" name="dataWidth" id="dataWidth" value="{{$dataWidth}}">
          <input type="hidden" name="crop_data" id="cropData">

        </div>

  </div>

    </div>
    @else
      <img src="{{ asset('public/'.$photo->media->file_path) }}">
    @endif

    <div class="form-group required">

      <label class="control-label" for="inputLabelEn">Alt Text</label>

      <input type="text" name="alt_text" class="form-control" value="{{$photo->alt_text}}" id="altInput" >

    </div>
    <div class="form-group required">

      <label class="control-label" for="inputLabelEn">Link</label>

      <input type="text" name="link" class="form-control" value="{{$photo->link}}" id="linkInput" >

    </div>

    <div class="form-group col-md-12 pull-right">

            <button type="submit" class="btn btn-primary">Save</button>

    </div>

  </div>

</div>

</form>