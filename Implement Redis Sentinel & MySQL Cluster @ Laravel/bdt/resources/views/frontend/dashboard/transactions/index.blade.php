@extends('frontend.dashboard.layout')

@section('title', 'Transaction ')

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
		          	<button class="btn btn-primary float-right" type="button" onclick="window.location.href='{{route('transaction.agent.create')}}'">
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
		            {{-- <th>Id</th> --}}
		            <th>Nama Properti</th>
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

@section('additional-styles')
  <style type="text/css">
    .danger-color{
      background-color: #f74c4c;
      color:white;
      font-weight: bold;
    }
    .custombutton{
      border-bottom: 4px solid #d99221;
      background-color: #f3bc65;
      color:#222;
      font-size:15px;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 10px;
      outline:#f3bc65;
    }

    .col-md-3{
      padding: 0;
      margin:0 10px;
    }

    .btn-choosen{
      background-color: #efc37c;
      border-bottom: 4px solid #efc37c;
    }


    .custombutton:hover{
      border-bottom: 4px solid #f3bc65;
    }

    .props-mag-header{
      margin:20px 0;
      padding: 0;
    }
  </style>
@endsection

@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script src="https://unpkg.com/vue-swal@1.0.0/dist/vue-swal.js"></script>
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
        ajax:'{{ route('transaction.agent.getDatatablesTransactions') }}',
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'property_name', name: 'property_name' },
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
@endsection
