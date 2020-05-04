@extends('dashboard')
@section('content')

<div class="x_content">
  
  <br />
  <form  class="form-horizontal form-label-left" method="post" action="{{ route('save_schedule') }}" enctype="multipart/form-data">
    @csrf
    <div class="row form-group">
        <div class="col-md-4">
            <label>Day</label>
            <input type="text" class="form-control" readonly value="Monday"></input>
        </div>
        <div class="col-md-4">
            <label>Start Time</label>
                <input class="form-control timepicki" type="text" id="mon_start_time"   value="{{ $data->mon_start_time ?? '' }}"  name="mon_start_time"></input>
        </div>
        <div class="col-md-4">
            <label>End Time</label>
            <input class="form-control timepicki" type="text" id="mon_end_time" value="{{ $data->mon_end_time ?? '' }}" name="mon_end_time" ></input>
        </div>
    </div>
    
    <div class="row form-group">
        <div class="col-md-4">
            <input class="form-control" readonly value="Tuesday"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="tue_start_time" value="{{ $data->tue_start_time ?? '' }}"  name="tue_start_time"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="tue_end_time" value="{{ $data->tue_end_time ?? '' }}" name="tue_end_time" ></input>
        </div>
    </div>
    
    <div class="row form-group">
        <div class="col-md-4">
            <input class="form-control" readonly value="Wednesday"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="wed_start_time" value="{{ $data->wed_start_time ?? '' }}"  name="wed_start_time"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="wed_end_time" value="{{ $data->wed_end_time ?? '' }}" name="wed_end_time" ></input>
        </div>
    </div>
    
    <div class="row form-group">
        <div class="col-md-4">
            <input class="form-control" readonly value="Thursday"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="thu_start_time" value="{{ $data->thu_start_time ?? '' }}"  name="thu_start_time"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="thu_end_time" value="{{ $data->thu_end_time ?? '' }}" name="thu_end_time" ></input>
        </div>
    </div>
    
    <div class="row form-group">
        <div class="col-md-4">
            <input class="form-control" readonly value="Friday"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="fri_start_time" value="{{ $data->fri_start_time ?? '' }}"  name="fri_start_time"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="fri_end_time" value="{{ $data->fri_end_time ?? '' }}" name="fri_end_time" ></input>
        </div>
    </div>
    
    <div class="row form-group">
        <div class="col-md-4">
            <input class="form-control" readonly value="Saturday"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="sat_start_time" value="{{ $data->sat_start_time ?? '' }}"  name="sat_start_time"></input>
        </div>
        <div class="col-md-4">
            <input class="form-control timepicki" type="text" id="sat_end_time" value="{{ $data->sat_end_time ?? '' }}" name="sat_end_time" ></input>
        </div>
    </div>
    <div class="row form-group">
      <div class="col-md-offset-11">
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </div>
    
  </form>
</div>
<!-- time piki js -->
<script src="assets/build/js/timepicki.js"></script>
<script type="text/javascript">
  $('.timepicki').timepicki();


</script>
@endsection