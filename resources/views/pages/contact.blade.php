@extends('dashboard')
@section('content')

<div class="x_content">
  
  <br />
  <form id="form" class="form-horizontal form-label-left" method="post" action="{{ route('save_message') }}">
    @csrf
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Subject <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="subject" name="subject" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Message <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea name="message" id="message" class="form-control col-md-7 col-xs-12"></textarea>
      </div>
    </div>
    <div class="ln_solid"></div>
    <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button type="submit" class="btn btn-success">Send</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  $('#form').submit(function(e){
    $('.error').remove()
    var success = true
    var subject = $('#subject').val()
    var message = $('#message').val()
    if(subject == ''){
      success = false
      $('#subject').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(message == ''){
      success = false
      $('#message').after("<span class='error' style='color:red'>Field is required</span>")
    }
    

    if(success == false){
      e.preventDefault()
    }
  })
</script>
@endsection