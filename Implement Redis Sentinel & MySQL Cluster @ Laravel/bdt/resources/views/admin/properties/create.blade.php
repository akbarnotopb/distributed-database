@extends('admin.layout')


@section('title','Add New Properties | ')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('properties.index')}}">Properties</a></li>
<li class="breadcrumb-item"><a href="#">Add New Property</a></li>
@stop

@section('content')
<div class="card">
  <div class="card-body">

    <div style="margin-bottom: 20px">
        <div class="row">
          <div class="col-md-6">
            <h4 class="card-title mb-0">Add New Property</h4>
          </div>
        </div>
      </div>

      @if($errors->any())
      <div class="col-md-12 alert alert-danger">
        <p>{{ $errors->first() }}</p>
      </div>
      @endif

      <form class="form-horizontal" action="{{route('properties.store')}}" method="post" style="{{session('success') ? 'display: none;' : ''}}" id="form-add-property" @submit="insertDesc">
        @csrf

            <div class="form-group row">
                <div class="col-md-6 required">
                  <label>Nama</label>
                    <input class="form-control" required name="name" type="text" placeholder="Nama Properti"/>
                </div>
                <div class="col-md-6 required">
                  <label>Tipe</label>
                    <select required name="listing_type" data-placeholder="---" class="form-control">
                    <option value="sale">Sale</option>
                    <option value="rent">Rent</option>
                  </select>
                </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6 required">
                  <label>Kategori</label>
                  <select required name="property_type" data-placeholder="---" class="form-control" v-model="CategorySelected">
                    @foreach($property_typees as $propertyType)
                    <option value="{{$propertyType->id}}">{{$propertyType->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 required" v-if="CategorySelected != '3'">
                  <label>Luas Bangunan</label>
                  <input name="built_up" type="number" min="0" placeholder="" required class="form-control"/>
                </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6 required" v-if="CategorySelected != '2'">
                <label>Luas Tanah</label>
                <input name="land_size" type="number" min="0" placeholder="" required class="form-control">
              </div>
              <div class="col-md-6 required">
                <label>Harga</label>
                <input name="price" type="number" min="0" placeholder="" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6 required">
                <label>Alamat</label>
                <input name="address" type="text" placeholder="" required class="form-control">
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
                <input type="number" min="0" name="bedrooms" placeholder="" required class="form-control">
              </div>
              <div class="col-md-6 required" v-if="CategorySelected != '3' && CategorySelected != '5'">
                <label>Kamar Mandi</label>
                <input type="number" min="0" name="bathrooms" placeholder="" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6" v-if="CategorySelected == '1'">
                <label>Kamar Tidur Pembantu</label>
                <input type="number" min="0" name="maid_bedrooms" placeholder=""  class="form-control">
              </div>
              <div class="col-md-6" v-if="CategorySelected == '1'">
                <label>Kamar Mandi Pembantu</label>
                <input type="number" min="0" name="maid_bathrooms" placeholder=""  class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6 required" v-if="CategorySelected != '6'">
                <label>Sertifikat</label>
                <input type="text" name="certificate" placeholder="" required class="form-control">
              </div>
              <div class="col-md-6 required" v-if="CategorySelected != '3'">
                <label>Tahun Dibangun</label>
                <select data-placeholder="Pilih Tahun" required class="form-control" name="year_built">
                    @for($th=\Carbon\carbon::now()->format('Y');$th>=1970;$th--)
                    <option value="{{$th}}">{{$th}}</option>
                    @endfor
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6" v-if="CategorySelected == '1' || CategorySelected == '6'">
                <label>Garasi</label>
                <input type="number" min="0" name="garages" placeholder=""  class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6 required" v-if="CategorySelected != '3'">
                <label>Daya Listrik</label>
                <input type="number" min="0" name="electrical_power" placeholder="" required class="form-control">
              </div>
              <div class="col-md-6 required" v-if="CategorySelected == '1' || CategorySelected == '4'">
                <label>Jumlah Lantai</label>
                <input type="number" min="0" name="number_of_floors" placeholder="" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6" v-if="CategorySelected != '3' && CategorySelected != '5'">
                <label>Jumlah DP</label>
                <input type="number" min="0" name="amount_of_down_payment" placeholder=""  class="form-control">
              </div>
              <div class="col-md-6" v-if="CategorySelected != '3' && CategorySelected != '5'">
                <label>Estimasi Cicilan</label>
                <input type="number" min="0" name="estimated_installments" placeholder=""  class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6 required">
                <label>Alamat Lengkap</label>
                <input type="text" name="complete_address" placeholder="" required class="form-control">
              </div>
              <div class="col-md-6 required">
                <label>Nama Pemilik</label>
                <input type="text" name="owner_name" placeholder="" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6 required">
                <label>Telepon Pemilik</label>
                <input type="text" name="owner_phone" placeholder="" required class="form-control">
              </div>
              <div class="col-md-6 required" v-if="CategorySelected == '2'">
                <label>No Lantai</label>
                <input type="text" name="floor_number" placeholder="" required class="form-control">
              </div>
              <div class="col-md-6 required" v-if="CategorySelected == '4'">
                <label>Jumlah Parkir</label>
                <input type="number" min="0" name="parking_amount" placeholder="" required class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <label>Colisting</label>
                <select id="colisting-select" data-placeholder="Pilih Colisting" class="form-control" name="colisting">
                    <option></option>
                    @foreach($agents as $agent)
                    <option value="{{$agent->id}}">{{$agent->name}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row" style="display:block">
              <div class="col-md-12 required">
                <label for='description' class="control-label">Deskripsi</label>
                <input type="hidden" name="description">
                <div id="quil-editor" style="height: 100px">
                  
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
    <div class="form-horizontal" style="{{session('success') ? '' : 'display: none;'}}">
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
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="{{url('assets/js/dropzone.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script type="text/javascript">
Vue.component('select2', { //city
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
      $(this.$el).empty().select2({ data: this.options }).val('').trigger('change')
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  }
});

Vue.component('select3', { //provinsi
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
      $(this.$el).empty().select2({ data: this.options }).val('{{is_null(old('provinces'))?11:old('provinces')}}').trigger('change')
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  }
});

var quileditor;

  var form = new Vue({
    el: '#form-add-property',
    data: {
      CategorySelected:'1',
      citySelected:'',
      subdistrictSelected:'',
      options: [], //this is for city
      oplist:[], //this is for subdistrict
      provinceSelected:'{{ (is_null(old('provinces'))==true)?11:old('provinces') }}',
      provinces_options:[]
    },
    created(){
    this.fetchProvincesData();
    this.fetchCitiesData(this.provinceSelected);
    // this.fetchDistrictData(this.citySelected);
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
            axios.get('{{ Route('properties.create') }}?province_id='+province_id+'&ajax=1').then(response => {
                this.options = response.data;
                this.finish = true;
                });
      },
      fetchDistrictData(city_id){
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.get('{{ Route('properties.create') }}?city_id='+city_id+'&ajax=1').then(response => {
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
        if(city_id!="")
        this.fetchDistrictData(city_id);
      },
      oplist:function(){
        if(this.oplist.length==0||this.citySelected==""){
          $("#select2district").empty().select2({placeholder:"You must choose a city first!"}).val(null).trigger('change').prop('disabled',true);
        }else{
        $("#select2district").empty().select2({placeholder:"Choose a Sub District...",data:this.oplist}).prop("disabled",false).val(null).trigger('change');
        }
      }
    }
  });

  quileditor = new Quill("#quil-editor",{
    theme:'snow'
  });

  $("#select2district").select2({
  width: '100%',
  placeholder:"You must choose a city first!",
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
  }).css("width",'100%').prop('disabled',true);;


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
<script type="text/javascript">
</script>
@stop