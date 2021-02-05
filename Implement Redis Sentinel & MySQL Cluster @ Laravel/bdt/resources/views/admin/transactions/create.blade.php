@extends('admin.layout')


@section('title','Add New Transaction | ')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('transactions.index')}}">Transactions</a></li>
<li class="breadcrumb-item"><a href="#">Add New Transaction</a></li>
@stop

@section('content')
<div class="card">
  <div class="card-body">

    <div style="margin-bottom: 20px">
        <div class="row">
          <div class="col-md-6">
            <h4 class="card-title mb-0">Add New Transaction</h4>
          </div>
        </div>
      </div>

      @if($errors->any())
      <div class="col-md-12 alert alert-danger">
        <p>{{ $errors->first() }}</p>
      </div>
      @endif

      <form class="form-horizontal" action="{{route('transactions.store')}}" method="post" style="{{session('success') ? 'display: none;' : ''}}" id="form-add-property" @submit="insertDesc">
        @csrf

            <div class="form-group row">
                <div class="col-md-6 required">
                    <label>Nama Agen</label>
                    <select required name="agent_id" data-placeholder="---" class="form-control" @change="onChange()"  v-model="key">
                        <option value="0">ADMIN</option>
                        @foreach($agents as $agent)
                        <option value="{{$agent->id}}">{{$agent->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 required">
                    <label>Nama Properti</label>
                    <select3 data-placeholder="---" required class="form-control" name="property_id" :options="properties_options" v-model="propertySelected">
                    <option></option>
                    </select3>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 required">
                    <label>Status</label>
                    <select required name="status" data-placeholder="---" class="form-control">
                        <option value="0">In Review</option>
                        <option value="1">In Progress</option>
                        <option value="2">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="form-group row" style="display:block">
              <div class="col-md-12 required">
                <label for='keterangan' class="control-label">Keterangan</label>
                <input type="hidden" name="keterangan">
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

Vue.component('select3', { //properties
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
      $(this.$el).empty().select2({ data: this.options }).eq(0).val().trigger('change')
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
      propertySelected:"{{ (is_null(old('property_id'))==true)?0:old('property_id') }}",
      properties_options:[],
      key:"{{ (is_null(old('agent_id'))==true)?0:old('agent_id') }}"
    },
    created(){
    this.fetchPropertiesData(this.key);
    },
    methods: {
      fetchPropertiesData(agent_id){
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.get('{{ Route('transactions.create') }}?agent_id='+agent_id+'&ajax=1').then(response => {
                this.properties_options = response.data;
                this.finish = true;
                });
      },
      insertDesc(){
        document.querySelector('input[name=keterangan]').value=quileditor.root.innerHTML;

        return true;
      },
      onChange: function() {
    	// console.log(this.key)
        this.fetchPropertiesData(this.key)
        }
    }
  });

  quileditor = new Quill("#quil-editor",{
    theme:'snow'
  });

</script>
<script type="text/javascript">
</script>
@stop
