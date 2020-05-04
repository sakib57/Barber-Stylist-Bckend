@extends('dashboard')
@section('content')

<div class="x_content">
    @if($errors->any())
        <div class="alert alert-danger" style="text-align:center">{{ $errors->first() }}</div>
    @endif
    @if($success ?? '')
        <div class="alert alert-success" style="text-align:center">{{ $success }}</div>
    @endif
  <br/>
  <form id="form" class="form-horizontal form-label-left" method="post" action="{{ route('update_pass') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Old Password <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="password" id="old_pass" name="old_pass" class="form-control col-md-7 col-xs-12">
        <input type="hidden" name="id" value="3"></input>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Password <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="password" id="new_pass" name="new_pass" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Confirm New Password <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="password" id="conf_pass" name="conf_pass" class="form-control col-md-7 col-xs-12">
      </div>
    </div>
    
    
    
    <!--<div class="form-group">-->
    <!--  <label class="control-label col-md-3 col-sm-3 col-xs-12">Image <span class="required">*</span>-->
    <!--  </label>-->
    <!--  <div class="col-md-6 col-sm-6 col-xs-12">-->
    <!--    <input id="image" class="form-control col-md-7 col-xs-12" name="image"  type="file">-->
    <!--  </div>-->
    <!--</div>-->
    <div class="ln_solid"></div>
    <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  $('#form').submit(function(e){
    $('.error').remove()
    var success = true
    var old_pass = $('#old_pass').val()
    var new_pass = $('#new_pass').val()
    var conf_pass = $('#conf_pass').val()
    if(new_pass == ''){
      success = false
      $('#new_pass').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(old_pass == ''){
      success = false
      $('#old_pass').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(conf_pass == ''){
      success = false
      $('#conf_pass').after("<span class='error' style='color:red'>Field is required</span>")
    }
    if(conf_pass != '' && new_pass != conf_pass){
      success = false
      $('#conf_pass').after("<span class='error' style='color:red'>Confirm Password missmatch</span>")
    }
    if(success == false){
      e.preventDefault()
    }
  })
</script>
@endsection