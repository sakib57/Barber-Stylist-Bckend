
@extends('dashboard')
@section('content')

<div class="x_content">
  <div id="table_content"></div>
  <table id="zero_config" class="responsive-table display" style="width:100%"></table>

</div>
<script src="assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $("#table_content").html('<table class="responsive-table display" id="zero_config" style="width:100%"><thead><tr><th>#</th><th>Cusromer Name</th><th>Time</th><th>Cost</th><th>Date</th><th>Status</th><th>Action</th></tr></thead></table>');

    $(document).ready( function () {
        oTable = $('#zero_config').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 100,
            "ajax": {    
              "url": "{{ route('manage_booking_list') }}",
            },
            "columns": [
                {data: 'id',  name: 'id'},
                {data: 'first_name',  name: 'first_name'},
                {data: 'schedule_start',  name: 'schedule_start'},
                {data: 'total_price',  name: 'total_price'},
                {data: 'date',  name: 'date'},
                {data: 'is_confirmed',  name: 'is_confirmed'},
                {data: 'action',  name: 'action'},
            ],


        });  
} );
</script>
@endsection