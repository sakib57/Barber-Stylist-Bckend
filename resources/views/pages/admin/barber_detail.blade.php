
@extends('admin_dashboard')
@section('content')
    <style>
        .schedule p{
            margin: 0px;
        }
        .pic img{
            width:120px;
            height:120px;
            border-radius: 50%;
            border:2px solid #ddd;
        }
    </style>
    <?php //dd($data)?>
    <div class="row">
        <div class="col-md-2">
            <div class="pic">
                <img src="public/images/thumb_{{$data->image}}" >
            </div>
        </div>
        <div class="col-md-4">
            <div clas="row">
                <div class="col"><h2>Name: {{ $data->first_name }} {{ $data->last_name }}</h2></div>
            </div>
            <div clas="row">
                <div class="col"><h2>Email: {{ $data->email }}</h2></div>
            </div>
            <div clas="row">
                <div class="col"><h2>Address: {{ $data->addr1.' '.$data->addr2 }}</h2></div>
            </div>
            <div clas="row">
                <div class="col"><h2>Designation: {{ $data->designation }}</h2></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row schedule">
                <div class="col"><p><b>Saturday:</b> {{ $schedule->sat_start_time ?? "N/A" }} - {{ $schedule->sat_end_time ?? 'N/A' }}</p></div>
                <div class="col"><p><b>Sunday:</b> {{ $schedule->sun_start_time ?? "N/A" }} - {{ $schedule->sun_end_time ?? 'N/A' }}</p></div>
                <div class="col"><p><b>Monday:</b> {{ $schedule->mon_start_time ?? "N/A" }} - {{ $schedule->mon_end_time ?? 'N/A' }}</p></div>
                <div class="col"><p><b>Tuesday:</b> {{ $schedule->tue_start_time ?? "N/A" }} - {{ $schedule->tue_end_time ?? 'N/A' }}</p></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row schedule">
                <div class="col"><p><b>Wednesday:</b> {{ $schedule->wed_start_time ?? "N/A" }} - {{ $schedule->wed_end_time ?? 'N/A' }}</p></div>
                <div class="col"></p><b>Thursday:</b> {{ $schedule->thu_start_time ?? "N/A" }} - {{ $schedule->thu_end_time ?? 'N/A' }}</p></div>
                <div class="col"><p><b>Friday:</b> {{ $schedule->fri_start_time ?? "N/A" }} - {{ $schedule->fri_end_time ?? 'N/A' }}</p></div>
            </div>
        </div>
        
    </div>
    <div class="row" style="margin-top:15px">
        <div class="col">
            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Service</th>
                    <th>Schedule</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
                @foreach($booking as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->name }}</td>
                    <td>{{ $v->service_name }}</td>
                    <td>{{ $v->schedule }}</td>
                    <td>{{ $v->price }}</td>
                    <td>Ok</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    

@endsection