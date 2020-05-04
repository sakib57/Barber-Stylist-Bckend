
@extends('dashboard')
@section('content')

<div class="x_content">
  <div id="table_content"></div>
  <table id="zero_config" class="responsive-table display" style="width:100%"></table>

</div>
<script src="assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $("#table_content").html('<table class="responsive-table display" id="zero_config" style="width:100%"><thead><tr><th>#</th><th>Employee Name</th><th>Designation</th><th>Address</th><th>Phone</th><th>Image</th><th>Action</th></tr></thead></table>');

    $(document).ready( function () {
        oTable = $('#zero_config').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 100,
            "ajax": {    
              "url": "{{ route('manage_employee_list') }}",
            },
            "columns": [
                {data: 'id',  name: 'id'},
                {data: 'employee_name',  name: 'employee_name'},
                {data: 'designation',  name: 'designation'},
                {data: 'address',  name: 'address'},
                {data: 'phone',  name: 'phone'},
                {data: 'image',  name: 'image'},
                {data: 'action',  name: 'action'},
            ],


        });  
} );
</script>
@endsection