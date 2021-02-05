@extends('admin.layout')

@section('title','Data Transactions | ')

@section('additional-styles')
  <style type="text/css">
    #users-table_wrapper.container-fluid{
      padding: 0px 0px;
    }
  </style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('transactions.index')}}">Transaction</a></li>
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<div style="margin-bottom: 20px">
			<div class="row">
		        <div class="col-md-6">
		          <h4 class="card-title mb-0">Data Transactions</h4>
		        </div>
		        <div class="col-md-6">
		          <div class="text-right">
		          	<button class="btn btn-primary float-right" type="button" onclick="window.location.href='{{route('transactions.create')}}'">
                      Add New Transaction
                    </button>
		          </div>
		        </div>
	      	</div>
		</div>

		@if (session()->has('message'))
    	<div class="alert alert-primary">
      		{{session('message')}}
    	</div>
    	@endif

    	<div style="overflow-x:auto">
	    	<table class="table table-bordered table-striped" id="users-table">
		        <thead>
		          <tr>
		            <th>Id</th>
		            <th>Nama Properti</th>
		            <th>Nama Agen</th>
		            <th>Status</th>
		            <th>Keterangan</th>
		            <th>Aksi</th>
		          </tr>
		        </thead>
	      	</table>
	    </div>

	</div>
</div>
@stop

@section('additional-scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$(function () {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var tableUsers = $('#users-table').DataTable({
        processing:true,
        serverSide:true,
        ajax:'{{ route('transactions.getDatatablesTransactions') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'property_name', name: 'property_name' },
            { data: 'agent_name', name: 'agent_name' },
            { data: 'status', name: 'status'},
            { data: 'keterangan', name: 'keterangan' },
            { data: 'action', name: 'action',orderable: false, searchable: false }
        ],
        responsive: {
          breakpoints: [
              { name: 'desktop', width: Infinity },
              { name: 'tablet',  width: 1024 },
              { name: 'fablet',  width: 768 },
              { name: 'phone',   width: 480 }
          ]
        },
        pagingType: "numbers",
        columnDefs: [
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 2, targets: -1 },
        ]

      });
    });
    function deletetransaction(that)
    {
    	swal({
		  title: "Apakah Anda Yakin?",
		  text: "Anda akan menghapus data transaksi!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
		  	$(that).next().submit();
		  }
		});
    }
</script>
@stop
