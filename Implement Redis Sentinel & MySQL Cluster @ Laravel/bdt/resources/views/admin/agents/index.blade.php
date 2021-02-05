@extends('admin.layout')

@section('title','Data Agents | ')

@section('additional-styles')
  <style type="text/css">
    #users-table_wrapper.container-fluid{
      padding: 0px 0px;
    }
  </style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('agents.index')}}">Agent</a></li>
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<div style="margin-bottom: 20px">
	      <div class="row">
	        <div class="col-md-6">
	          <h4 class="card-title mb-0">Data Agent</h4>
	        </div>
	        <div class="col-md-6">
	          <div class="text-right">
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
	            <th>Nama</th>
	            <th>Email</th>
	            <th>Telepon</th>
	            <th>Status</th>
              <th>Upline</th>
              <th>Downline</th>
	            <th>Aksi</th>
	          </tr>
	        </thead>
	      </table>
	    </div>
	</div>
</div>
@stop
@section('additional-scripts')
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
        ajax:'{{ route('agent.getDatatablesAgents') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'approved', name: 'approved', orderable: false, searchable: false },
            { data: 'upline' , name:'upline', orderable:false, searchable:true},
            { data: 'downline' , name:'downline' , orderable:false, searchable:false},
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
</script>
@stop