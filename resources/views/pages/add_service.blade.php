@extends('dashboard')
@section('content')

<div class="x_content">
  
  <br />
  <form id="form" class="form-horizontal form-label-left" method="post" action="{{ route('save_service') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Service Name <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="service_name" name="service_name" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Duration <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select id="duration" name="duration" class="form-control col-md-7 col-xs-12">
            <option value="">-- Select Duration --</option>
            <option value="15">15 Minutes</option>
            <option value="30">30 Minutes</option>
            <option value="45">45 Minutes</option>
            <option value="60">1 Hour</option>
            <option value="75">1 Hour 15 Minutes</option>
            <option value="90">1 Hour 30 Minutes</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Price <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="number" id="price" name="price" class="form-control col-md-7 col-xs-12">
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
    var service_name = $('#service_name').val()
    var duration = $('#duration').val()
    var price = $('#price').val()
    if(service_name == ''){
      success = false
      $('#service_name').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(duration == ''){
      success = false
      $('#duration').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(price == ''){
      success = false
      $('#price').after("<span class='error' style='color:red'>Field is required</span>")
    }

    if(success == false){
      e.preventDefault()
    }
  })
</script>
@endsection