
@extends('dashboard')
@section('content')

<div class="x_content">
  <div id="table_content"></div>
  <table id="zero_config" class="responsive-table display" style="width:100%"></table>

</div>
<script src="assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $("#table_content").html('<table class="responsive-table display" id="zero_config" style="width:100%"><thead><tr><th>#</th><th>Style Name</th><th>Price</th><th>Image</th><th>Action</th></tr></thead></table>');

    $(document).ready( function () {
        oTable = $('#zero_config').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 100,
            "ajax": {    
              "url": "{{ route('manage_hairstyle_list') }}",
            },
            "columns": [
                {data: 'id',  name: 'id'},
                {data: 'style_name',  name: 'style_name'},
                {data: 'price',  name: 'price'},
                {data: 'image',  name: 'image'},
                {data: 'action',  name: 'action'},
            ],


        });  
} );
</script>
@endsection