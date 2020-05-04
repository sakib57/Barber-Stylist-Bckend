@extends('dashboard')
@section('content')

<div class="x_content">
  
  <br />
  <form id="form" class="form-horizontal form-label-left" method="post" action="{{ route('save_employee') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="first_name" name="first_name" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="last_name" name="last_name" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Designation <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="designation" name="designation" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="phone" name="phone" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea name="address" id="address" class="form-control col-md-7 col-xs-12"></textarea>
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
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  $('#form').submit(function(e){
    $('.error').remove()
    var success = true
    var first_name = $('#first_name').val()
    var last_name = $('#last_name').val()
    var designation = $('#designation').val()
    var phone = $('#phone').val()
    var address = $('#address').val()
    var image = $('#image').val()
    if(first_name == ''){
      success = false
      $('#first_name').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(last_name == ''){
      success = false
      $('#last_name').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(designation == ''){
      success = false
      $('#designation').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(phone == ''){
      success = false
      $('#phone').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(address == ''){
      success = false
      $('#address').after("<span class='error' style='color:red'>Field is required</span>")
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