@extends('admin.layout')

@section('title', 'Edit Agent | ')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('agents.index')}}">Agent</a></li>
<li class="breadcrumb-item"><a href="#">Edit Agent</a></li>
@stop

@section('content')
<div class="card">
	<div class="card-body">
	    <div class="alert alert-{{ ($agent->approved)? 'info' : 'warning' }}">
	    	{{ ($agent->approved)? 'Agen telah aktif!' : 'Agen belum aktif!' }}

	    </div>
    	<div style="float:right; margin-top: 0" id="activation">
    		<button class="btn btn-success" v-on:click="setstatus(1)" {{ $agent->approved? 'disabled':'' }}>Activate</button>
	    	<button class="btn btn-danger" v-on:click="setstatus(0)" {{ $agent->approved? '' : 'disabled' }}>Deactivate</button>
    	</div>
		<div style="margin-bottom: 20px">
	      <div class="row">
	        <div class="col-md-6">
	          <h4 class="card-title mb-0">Edit Agent</h4>
	        </div>
	      </div>
	    </div>
	    <div class="row">
		    <div class="col-md-7 col-sm-7">
		    	<form method="post" action="{{route('agents.update', [$agent->id])}}" enctype="multipart/form-data">
		    		{{csrf_field()}}
	        		{{method_field('put')}}
	        		<div class="row">
	        			<div class="col-md-12 col-sm-12">
	        				<div class="form-group">
			                    <label>Nama</label>
			                    <input name="name" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" type="text" placeholder="Nama" value="{{old('name') ?: $agent->name}}" required>
			                    @if ($errors->has('name'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('name') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                <div class="form-group">
			                    <label>Email</label>
			                    <input name="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" type="email" placeholder="email" value="{{old('email') ?: $agent->email}}"></input required>
			                    @if ($errors->has('email'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('email') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                <div class="form-group">
			                    <label>Telepon</label>
			                    <input name="phone_number" class="form-control {{$errors->has('phone_number') ? 'is-invalid' : ''}}" type="text" placeholder="Nomor Telepon" value="{{old('phone_number') ?: $agent->phone_number}}" required></input>
			                    @if ($errors->has('phone_number'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('phone_number') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                <div class="form-group">
			                    <label>Username</label>
			                    <input name="username" class="form-control {{$errors->has('username') ? 'is-invalid' : ''}}" {{ isset($agent->username)?'disabled':'' }} type="text" placeholder="Username" value="{{ old('username')?: $agent->username }}" required></input>
			                    @if ($errors->has('username'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('username') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                <div class="form-group">
			                    <label>Whatsapp</label>
			                    <input name="whatsapp" class="form-control {{$errors->has('whatsapp') ? 'is-invalid' : ''}}"  type="text" placeholder="whatsapp" value="{{ old('whatsapp')?: $agent->whatsapp }}" ></input>
			                    @if ($errors->has('whatsapp'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('whatsapp') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                @if(is_null($upline_name))
						          <div class="form-group {{$errors->has('upline') ? 'has-error':''}}">
						              <label for="upline-list" class="control-label">Upline</label>
						              <select id="upline-list" class="form-control select2-searchable" name="upline">
						                @foreach($_agents as $_agent)
						                  <option value="{{$_agent->id}}">{{$_agent->name}}</option>
						                @endforeach
						              </select>
						            @if ($errors->has('upline'))
					                    <span class="invalid-feedback">
					                        <strong>{{ $errors->first('upline') }}</strong>
					                    </span>						            
						            @endif
						        </div>
			                @else
			                <div class="form-group">
			                    <label>Upline</label>
			                    <input name="upline" class="form-control" disabled type="text" placeholder="Upline" value="{{ $upline_name->name }}"></input>
			                </div>
			                @endif
			                <div class="form-group">
			                    <label>Alamat</label>
			                    <input name="address" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" type="text" placeholder="Alamat" value="{{old('address') ?: $agent->address}}"></input>
			                    @if ($errors->has('address'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('address') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                <div class="form-group">
			                    <label>NIK</label>
			                    <input name="nik" class="form-control {{$errors->has('nik') ? 'is-invalid' : ''}}" type="text" placeholder="NIK" value="{{old('nik') ?: $agent->nik}}"></input>
			                    @if ($errors->has('nik'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('nik') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                <div class="form-group">
			                    <label>Nama Bank</label>
			                    <input name="bank_name" class="form-control {{$errors->has('bank_name') ? 'is-invalid' : ''}}" type="text" placeholder="Nama Bank" value="{{old('bank_name') ?: $agent->bank_name}}"></input>
			                    @if ($errors->has('bank_name'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('bank_name') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                <div class="form-group">
			                    <label>Nomor Rekening</label>
			                    <input name="bank_account" class="form-control {{$errors->has('bank_account') ? 'is-invalid' : ''}}" type="text" placeholder="Nomor Rekening" value="{{old('bank_account') ?: $agent->bank_account}}"></input>
			                    @if ($errors->has('bank_account'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('bank_account') }}</strong>
			                    </span>
			                    @endif
			                </div>
			                <div class="form-group">
			                    <label>Nama Pemilik Rekening</label>
			                    <input name="bank_customer" class="form-control {{$errors->has('bank_account') ? 'is-invalid' : ''}}" type="text" placeholder="Nama Pemilik Rekening" value="{{old('bank_customer') ?: $agent->bank_customer}}"></input>
			                    @if ($errors->has('bank_customer'))
			                    <span class="invalid-feedback">
			                        <strong>{{ $errors->first('bank_customer') }}</strong>
			                    </span>
			                    @endif
			                </div>
	        			</div>
	        		</div>
	        		<div class="text-right">
	          			<button class="btn btn-primary">Update</button>
	        		</div>
		    	</form>
		    </div>
		    <div class="col-md-5 col-sm-5 border-lefts">
		    	<h2>Daftar Mitra</h2>
			      	<table class="table table-bordered table-striped" id="users-table">
			        <thead>
			          <tr>
			            <th>Id</th>
			            <th>Nama</th>
			            <th>Telepon</th>
			          </tr>
			        </thead>
			      </table>
		      </div>
		    </div>	    	
	    </div>

	</div>
</div>
@stop


@section('additional-styles')
	<style type="text/css">
		@media screen and (min-width: 768px){

			.border-lefts{
				border-left:1px solid #dbdbdb;	
			}	

		}	

		@media screen and (min-width: 576px){
			.border-lefts{
				border-left:1px solid #dbdbdb;	
			}	

		}			
	</style>
@endsection


@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script src="https://unpkg.com/vue-swal@1.0.0/dist/vue-swal.js"></script>
<script type="text/javascript">

$(function () {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
  });
  var tableUsers = $('#users-table').DataTable({
    processing:true,
    serverSide:true,
    lengthMenu:[[5,10,20],[5,10,20]],
    ajax:{
    	url:'{{ route('agent.getDatatablesDownline') }}',
    	type:'POST',
    	data:{
    			'id':{{ $agent->id }}
    		 }
    },
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'phone_number', name: 'phone_number' }
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

var _vm = new Vue({
	el:'#activation',
	methods : {
		setstatus(status){
		  var text=(status==1)?'Apakah anda yakin untuk mengaktifkannya?' : 'Apakah anda yakin untuk menonaktifkannya?';
          this.$swal({title: text,
            text: "Anda dapat mengubahnya lagi kembali nanti!",
            icon: 'warning',
            buttons: true,
            reverseButtons: true
          }).then((result) => {
           if(result){
              axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
              axios.post("{{route('agent.verification')}}",{id:{{ $agent->id }},stat:status}).then(response=>{
                  if(response.status==200){
                    location.reload();
                  }
              });
           }
          });
		}
	}
});


$(".select2-searchable").select2({
  width: '100%',
  matcher: function(params,data){
        if ($.trim(params.term) === '') {
          return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
          return null;
        }

        key = (params.term).split(" ");

        for (var i=0 ; i<key.length;++i){
            if (((data.text).toUpperCase()).indexOf((key[i]).toUpperCase()) == -1) 
            return null;
        }

        return data;
  },
});


</script>

@endsection