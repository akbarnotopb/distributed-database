@extends('admin.layout')

@section('title', 'Edit Property | ')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('properties.index')}}">Properties</a></li>
<li class="breadcrumb-item"><a href="#">Edit Property</a></li>
@stop

@section('content')
	<div class="card">
		<div class="card-body">
			
			<div style="margin-bottom: 20px">
	      		<div class="row">
	        		<div class="col-md-6">
	         			 <h4 class="card-title mb-0">Edit Property</h4>
	        		</div>
	      		</div>
	    	</div>

	      	  @if($errors->any())
		      <div class="col-md-12 alert alert-danger">
		        <p>{{ $errors->first() }}</p>
		      </div>
		      @endif

	    	<form class="form-horizontal" action="{{route('properties.update',[$property->id])}}" method="post" id="form-edit-property" @submit='insertDesc'>
	    		@csrf
	    		{{method_field('put')}}
	    		<div class="form-group row">
	                <div class="col-md-6 required">
	                	<label>Nama</label>
	                  	<input class="form-control" required name="name" type="text" value="{{$property->name}}" placeholder="Nama Properti"/>
	                </div>
	                <div class="col-md-6 required">
	                	<label>Tipe</label>
	                  	<select required name="listing_type" data-placeholder="---" class="form-control">
			                <option value="sale" {{($property->listing_type=="sale") ? 'selected' : ''}}>Sale</option>
			                <option value="rent" {{($property->listing_type=="rent") ? 'selected' : ''}}>Rent</option>
		              	</select>
	                </div>
	          	</div>

	          	<div class="form-group row">
	          		<div class="col-md-6 required">
	                	<label>Kategori</label>
	                  	<select required name="property_type" data-placeholder="---" class="form-control" v-model="CategorySelected">
			                @foreach($property_typees as $propertyType)
			                <option value="{{$propertyType->id}}" {{($propertyType->id == $property->property_type_id) ? 'selected' : '' }}>{{$propertyType->name}}</option>
			                @endforeach
		              	</select>
	                </div>
	                <div class="col-md-6 required" v-if="CategorySelected != '3'">
	                	<label>Luas Bangunan</label>
	                	<input name="built_up" type="number" min="0" placeholder="" value="{{$property->built_up}}" required class="form-control"/>
	                </div>
	          	</div>

	          	<div class="form-group row">
	          		<div class="col-md-6 required" v-if="CategorySelected != '2'">
	          			<label>Luas Tanah</label>
	          			<input name="land_size" type="number" min="0" placeholder="" value="{{$property->land_size}}" required class="form-control">
	          		</div>
	          		<div class="col-md-6 required">
	          			<label>Harga</label>
	          			<input name="price" type="number" min="0" placeholder="" required value="{{$property->price}}" class="form-control">
	          		</div>
	          	</div>

	            <div class="form-group row">
	              <div class="col-md-6 required">
	                <label>Alamat</label>
	                <input name="address" type="text" placeholder="" required class="form-control" value="{{ $property->address }}">
	              </div>
	              <div class="col-md-6 required">
	                <label>Provinsi</label>
	                  <select3 data-placeholder="Choose a province..." required class="form-control" name="provinces" :options="provinces_options" v-model="provinceSelected" id="provicesSelect">
	                    <option></option>
	                  </select3>                
	              </div>
	            </div>
	            <div class="form-group row">
	              <div class="col-md-6 required">
	                <label>Kota</label>
	                  <select2 data-placeholder="Choose a city..." required class="form-control" name="cities" :options="options" v-model="citySelected">
	                    <option></option>
	                  </select2>
	              </div>
	              <div class="col-md-6 required">
	                <label>Kecamatan</label>
	                <select data-placeholder="Choose a Sub-District..." required class="form-control" id="select2district" name="subdistrict">
	                  <option></option>
	                    </select>
	              </div>
	            </div>

	          	<div class="form-group row">
	          		<div class="col-md-6 required" v-if="CategorySelected == '1' || CategorySelected == '2' || CategorySelected == '6'">
	          			<label>Kamar Tidur</label>
	          			<input type="number" min="0" name="bedrooms" placeholder="" value="{{$property->bedrooms}}" required class="form-control">
	          		</div>
	          		<div class="col-md-6 required" v-if="CategorySelected != '3' && CategorySelected != '5'">
	          			<label>Kamar Mandi</label>
	          			<input type="number" min="0" name="bathrooms" placeholder="" value="{{$property->bathrooms}}" required class="form-control">
	          		</div>
	          	</div>

	          	<div class="form-group row">
	              <div class="col-md-6" v-if="CategorySelected == '1'">
	                <label>Kamar Tidur Pembantu</label>
	                <input type="number" name="maid_bedrooms" value="{{$property->maid_bedrooms}}" placeholder="" class="form-control">
	              </div>
	              <div class="col-md-6" v-if="CategorySelected == '1'">
	                <label>Kamar Mandi Pembantu</label>
	                <input type="number" name="maid_bathrooms" value="{{$property->maid_bathrooms}}" placeholder="" class="form-control">
	              </div>
	          	</div>

	          	<div class="form-group row">
	              <div class="col-md-6 required" v-if="CategorySelected != '6'">
	                <label>Sertifikat</label>
	                <input type="text" name="certificate" value="{{$property->certificate}}"  placeholder="" required class="form-control">
	              </div>
	              <div class="col-md-6 required" v-if="CategorySelected != '3'">
	                <label>Tahun Dibangun</label>
	                <select data-placeholder="Pilih Tahun" required class="form-control" name="year_built">
	                    @for($th=\Carbon\carbon::now()->format('Y');$th>=1970;$th--)
	                    <option value="{{$th}}" {{($th == $property->year_built) ? 'selected' : ''}}>{{$th}}</option>
	                    @endfor
	                </select>
	              </div>
	            </div>

	          	<div class="form-group row">
	          		<div class="col-md-6" v-if="CategorySelected == '1' || CategorySelected == '6'">
	          			<label>Garasi</label>
	          			<input type="number" name="garages" placeholder="" value="{{$property->garages}}" class="form-control">
	          		</div>
	          	</div>

	          	<div class="form-group row">
	              <div class="col-md-6 required" v-if="CategorySelected != '3'">
	                <label>Daya Listrik</label>
	                <input type="number" min="0" name="electrical_power" value="{{$property->electrical_power}}" placeholder="" required class="form-control">
	              </div>
	              <div class="col-md-6 required" v-if="CategorySelected == '1' || CategorySelected == '4'">
	                <label>Jumlah Lantai</label>
	                <input type="number" min="0" name="number_of_floors" value="{{$property->number_of_floors}}" placeholder="" required class="form-control">
	              </div>
	            </div>

	            <div class="form-group row">
	              <div class="col-md-6" v-if="CategorySelected != '3' && CategorySelected != '5'">
	                <label>Jumlah DP</label>
	                <input type="number" name="amount_of_down_payment" value="{{$property->amount_of_down_payment}}" placeholder="" class="form-control">
	              </div>
	              <div class="col-md-6" v-if="CategorySelected != '3' && CategorySelected != '5'">
	                <label>Estimasi Cicilan</label>
	                <input type="number" name="estimated_installments" value="{{$property->estimated_installments}}" placeholder="" class="form-control">
	              </div>
	            </div>

	            <div class="form-group row">
	              <div class="col-md-6 required">
	                <label>Alamat Lengkap</label>
	                <input type="text" name="complete_address" value="{{$property->complete_address}}" placeholder="" required class="form-control">
	              </div>
	              <div class="col-md-6 required">
	                <label>Nama Pemilik</label>
	                <input type="text" name="owner_name" value="{{$property->owner_name}}" placeholder="" required class="form-control">
	              </div>
	            </div>

	            <div class="form-group row">
	              <div class="col-md-6 required">
	                <label>Telepon Pemilik</label>
	                <input type="text" name="owner_phone" value="{{$property->owner_phone}}" placeholder="" required class="form-control">
	              </div>
	              <div class="col-md-6 required" v-if="CategorySelected == '2'">
	                <label>No Lantai</label>
	                <input type="text" name="floor_number" value="{{$property->floor_number}}"  placeholder="" required class="form-control">
	              </div>
	              <div class="col-md-6 required" v-if="CategorySelected == '4'">
	                <label>Jumlah Parkir</label>
	                <input type="number" name="parking_amount" value="{{$property->parking_amount}}" placeholder="" required class="form-control">
	              </div>
	            </div>

		            <div class="form-group row">
		              <div class="col-md-6">
		                <label>Colisting</label>
		                <select id="colisting-select" data-placeholder="Pilih Colisting" class="form-control" name="colisting">
		                    <option></option>
		                    @foreach($agents as $agent)
		                    <option value="{{$agent->id}}" {{ $property->colisting == $agent->id? 'selected' :'' }}>{{$agent->name}}</option>
		                    @endforeach
		                </select>
		              </div>
		            </div>

	          	<div class="form-group row">
	          		<div class="col-md-12 required">
          				<label for='description' class="control-label">Deskripsi</label>
                		<input type="hidden" name="description">
		                <div id="quil-editor" style="height: 100px">
		                  {!!$property->description!!}
		                </div>
	                </div>
	          	</div>

	          	<div class="form-group row">
	          		<div class="col-md-6">
	          			<label class="control-label">Status Property</label>
                        <div class="col-md-9 col-form-label">
                          <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio1" type="radio" value="2" name="approved" {{($property->sold == 1) ? 'checked' : ''}}>
                            <label class="form-check-label" for="inline-radio1">Terjual</label>
                          </div>
                          <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio2" type="radio" value="1" name="approved" {{($property->approved == 1 and $property->sold==0) ? 'checked' : ''}}>
                            <label class="form-check-label" for="inline-radio2">Aktif</label>
                          </div>

                          <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio3" type="radio" value="0" name="approved" {{($property->approved == 0 and $property->sold==0 ) ? 'checked' : ''}}>
                            <label class="form-check-label" for="inline-radio3">Belum Aktif</label>
                          </div>

                        </div>
	          		</div>
	          	</div>

	          	<div class="form-actions row">
          		<div class="col-md-12">
	            	<button class="btn btn-primary" type="submit">Submit</button>
	            </div>
          	</div>

	    	</form>

		</div>

		<div class="card-body">
			<div class="row">
			  	@foreach($property->PropertyImages as $image)
			  		<div class="col-lg-3">
			  			<div class="card">
			  				<img class="card-img-top" src="{{asset($image->name)}}" alt="Card image cap" style="height:162px;object-fit: cover;">
						  	<div class="card-body">
						    	<button class="btn btn-primary" image="{{route('properties.images.delete',[$image->id])}}" onclick="deleteimage(this)">Delete</button>
						  	</div>
			  			</div>
					</div>
			  	@endforeach
			</div>
		</div>

		<div class="card-body">
			<div class="form-horizontal">
		    	<div class="col-md-12">
		    		<div class="form-group">
		    			<label>Add Images for this property</label>
		    			<form action="{{route('properties.images.store')}}" class="dropzone">
		    				@csrf
		                  	@method('PUT')
		    			</form>
		    		</div>
		    		<div class="form-actions">
	                    <button class="btn btn-primary" type="button" onclick="window.location.href='{{route('properties.index')}}'">Save changes</button>
	                    <button class="btn btn-secondary" type="button" onclick="window.location.href='{{route('properties.index')}}'">Cancel</button>
	                </div>
		    	</div>
	      	</div>
		</div>
	</div>
@stop

@section('additional-styles')
<style type="text/css">
      .required label:after{
      content: "*";
      color: red;
    }
</style>
<link rel="stylesheet" href="{{url('assets/css/dropzone.css')}}">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('additional-scripts')
<script src="{{url('assets/js/dropzone.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	function deleteimage(that)
	{
		swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this imaginary file!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
		  	window.location.href=$(that).attr('image');
		  }
		});
	}
	@if (session()->has('success'))
	  swal("Success!", "{{session('success')}}", "success");
  	@endif
</script>
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script type="text/javascript">
Vue.component('select2', {
  props: ['options','value'],
  template: "<select><slot></slot></select>",
  mounted: function () {
    var vm = this
    $(this.$el)
      // init select2
      .select2({ data: this.options })
      .val('{{ $property->city_id }}')
      .trigger('change')
      // emit event on change.
      .on('change', function () {
        vm.$emit('input', this.value)
      })
      .css('width','100%')
  },
  watch: {
    value: function (value) {
      // update value
      $(this.$el)
      	.val(value)
      	.trigger('change')
    },
    options: function (options) {
      // update options
      $(this.$el).empty().select2({ data: this.options }).val('{{ (!is_null(old('cities')))? old('cities'): $property->city_id }}').trigger('change')
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  }
});

Vue.component('select3', {
  props: ['options','value'],
  template: "<select><slot></slot></select>",
  mounted: function () {
    var vm = this
    $(this.$el)
      // init select2
      .select2({ data: this.options })
      .val('')
      .trigger('change')
      // emit event on change.
      .on('change', function () {
        vm.$emit('input', this.value)
      })
      .css('width','100%')
  },
  watch: {
    value: function (value) {
      // update value
      $(this.$el)
        .val(value)
        .trigger('change')
    },
    options: function (options) {
      // update options
      $(this.$el).empty().select2({ data: this.options }).val('{{!is_null(old('provinces'))?old('provinces'):$property->City->Province->id}}').trigger('change')
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  }
});


var quileditor;

  var form = new Vue({
    el: '#form-edit-property',
    data: {
	  	CategorySelected:'{{$property->property_type_id}}',
		citySelected:'{{ (is_null(old('cities'))?$property->city_id:old('cities')) }}',
	  	subdistrictSelected:'{{ old('cities')?:$property->subdistrict_id }}',
	    options: [], //this is for city
		oplist:[], //this is for subdistrict
		provinceSelected:'{{ (is_null(old('provinces'))==true)?$property->City->Province->id:old('provinces') }}',
		provinces_options:[]
    },
    created(){
	    this.fetchProvincesData();
	    this.fetchCitiesData(this.provinceSelected);
		this.fetchDistrictData(this.citySelected);
  	},
    methods: {
    	      fetchProvincesData(){
           		axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            	axios.get('{{ Route('properties.create') }}?ajax=1').then(response => {
                this.provinces_options = response.data;
                this.finish = true;
                });        
     		 },
			fetchCitiesData(province_id){
		        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
		        axios.get('{{ Route('properties.edit',[$property->id]) }}?province_id='+province_id+'&ajax=1').then(response => {
		            this.options = response.data;
		            this.finish = true;
		            });
			},
			fetchDistrictData(city_id){
		        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
		        axios.get('{{ Route('properties.edit',[$property->id]) }}?city_id='+city_id+'&ajax=1').then(response => {
		        	this.oplist = [];
		            this.oplist = response.data;
		            console.log(response.data);
		            this.finish = true;
		            });
			},
      insertDesc(){
        document.querySelector('input[name=description]').value=quileditor.root.innerHTML;
        
        return true;
      }
    },
    watch:{
    	provinceSelected: function(){
        	var province_id = this.provinceSelected;
        	this.fetchCitiesData(province_id);
        	this.oplist=[];
      	},
    	citySelected :function(){
    		var city_id = this.citySelected;
    		if(city_id!=""){
    			this.fetchDistrictData(city_id);
    		}
    	},
    	oplist:function(){
    		if(this.oplist.length==0||this.citySelected==""){
    			$("#select2district").empty().select2({placeholder:"You must choose a city first!"}).val(null).trigger('change').prop('disabled',true);
    		}else{
    			$("#select2district").empty().select2({data:this.oplist}).val(this.subdistrictSelected).trigger('change');
    		}
    	}
    }
  });

  quileditor = new Quill("#quil-editor",{
    theme:'snow'
  });

	$("#select2district").select2({
	  width: '100%',
	  placeholder:"Choose a subdistrict..",
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
	}).css("width",'100%');

  $("#colisting-select").select2({
    width: '100%',
    allowClear:true,
    placeholder:"Pilih co-listing anda!",
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
    }
  });
</script>
@stop