@extends('dashboard')
@section('content')

<div class="x_content">
    <table class="table">
        
        <tr>
            <td>#</td>
            <td>Image</td>
            <th style="float:right">Action</th>
        </tr>
        
        
        @foreach($data as $v)
            <tr>
                <td>{{ $v->emp_id }}</td>
                <td>
                    <img style="width:60px" src="public/images/thumb_{{ $v->image }}">
                </td>
                <td style="float:right"><button class="btn btn-danger">Delete</button></td>
            </tr>
        @endforeach
    </table>
</div>

@endsection