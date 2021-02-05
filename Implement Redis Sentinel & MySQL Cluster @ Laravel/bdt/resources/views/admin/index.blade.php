@extends('admin.layout')

@section('title', 'Dashboard | ')

@section('breadcrumb')
<li class="breadcrumb-item">Home</li>
<li class="breadcrumb-item"><a href="#">Admin</a></li>
<li class="breadcrumb-item active">Dashboard</li>
@stop

@section('additional-styles')
	<style type="text/css">
		.text-right{
			display:inline-block;
			float:right;
		}

		.big-size-text{
			font-size: 72px;
			/*font-weight: bold;*/
		}
	</style>
@endsection

@section('content')
<div class="row" style="margin-bottom: 20px;">
  <div class="col"></div>
  <div class="col-sm-3 d-none d-md-block float-right">
    <form id="form-range">
      <select name="range" class="form-control" onchange="changeRange()">
        <option value="today">Hari ini</option>
        <option value="last-7-days">7 hari terakhir</option>
        <option value="last-30-days">30 hari terakhir</option>
        <option value="this-month">Bulan ini</option>
        <option value="all-the-time">Setiap Waktu</option>
      </select>
    </form>
  </div>
</div>
<div class="row">
	<div class="col-sm-6 col-md-3">
	    <div class="card bg-info text-white">
	      <div class="card-body">
	        <div class="h1 text-muted text-right mb-4">
	          <i class="icon-user"></i>
	        </div>
	        <div class="mb-0"><p class="big-size-text">{{ $total_agents }}</p></div>
	        <small class="text-muted text-uppercase font-weight-bold">Total Agent</small>
	      </div>
	    </div>
  	</div>
  	<div class="col-sm-6 col-md-3">
	    <div class="card bg-success text-white">
	      <div class="card-body">
	        <div class="h1 text-muted text-right mb-4" style="">
	          <i class="icon-home"></i>
	        </div>
	        <div class="mb-0"><p class="big-size-text">{{ $total_properties }}</p></div>
	        <small class="text-muted text-uppercase font-weight-bold">Total Properties</small>
	      </div>
	    </div>
  	</div>
  	<div class="col-sm-6 col-md-3">
	    <div class="card bg-warning text-white">
	      <div class="card-body">
	        <div class="h1 text-muted text-right mb-4" style="">
	          <i class="fa fa-credit-card"></i>
	        </div>
	        <div class="mb-0"><p class="big-size-text">{{ $total_transactions }}</p></div>
	        <small class="text-muted text-uppercase font-weight-bold">Total Transactions</small>
	      </div>
	    </div>
  	</div>
</div>
@stop

@section('additional-scripts')

<!-- Custom scripts required by this view -->
<script src="{{url('assets/js/views/main.js')}}"></script>

<script type="text/javascript">

  function changeRange() {
    $('#form-range').submit()
  }
</script>
@stop
