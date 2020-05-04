@extends('dashboard')
@section('content')

<div class="x_content">
  
  <br />
  <form id="form" class="form-horizontal form-label-left" method="post" action="{{ route('save_hairstyle') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Style Name <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="style_name" name="style_name" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Style Price <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="price" name="price" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Image <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="image" class="form-control col-md-7 col-xs-12" name="image"  type="file">
      </div>
    </div>
    <div class="ln_solid"></div>
    <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button id="submit" type="submit" class="btn btn-success">Submit</button>
      </div>
    </div>

  </form>
</div>

<script type="text/javascript">
  $('#form').submit(function(e){
    $('.error').remove()
    var success = true
    var style_name = $('#style_name').val()
    var price = $('#price').val()
    var image = $('#image').val()
    if(style_name == ''){
      success = false
      $('#style_name').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(price == ''){
      success = false
      $('#price').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(image == ''){
      success = false
      $('#image').after("<span class='error' style='color:red'>Field is required</span>")
    }

    if(success == false){
      e.preventDefault()
    }
  })
</script>
@endsection