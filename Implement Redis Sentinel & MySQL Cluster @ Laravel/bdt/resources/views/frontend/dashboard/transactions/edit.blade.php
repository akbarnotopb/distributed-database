@extends('frontend.dashboard.layout')

@section('title', 'Edit Transaction | ')

@section('content')
<div class="card">
    <div class="card-body">

      <div style="margin-bottom: 20px">
          <div class="row">
            <div class="col-md-6">
              <h4 class="card-title mb-0">Edit Transaction</h4>
            </div>
          </div>
        </div>

        @if($errors->any())
        <div class="col-md-12 alert alert-danger">
          <p>{{ $errors->first() }}</p>
        </div>
        @endif

        <form class="form-horizontal" action="{{route('transaction.agent.update',[$transaction->id])}}" method="post" style="{{session('success') ? 'display: none;' : ''}}" id="form-add-property" @submit="insertDesc">
          @method('PUT')
          @csrf
              <div class="form-group row">
                  <div class="col-md-6 required">
                      <label>Nama Properti</label>
                      <select required name="property_id" data-placeholder="---" class="form-control">
                          @foreach($properties as $property)
                          <option value="{{$property->id}}" {{($transaction->property_id == $property->id) ? 'selected' : '' }}>{{$property->name}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-6 required">
                    <label>Status</label>
                    <select required name="status" data-placeholder="---" class="form-control">
                        <option value="0" {{($transaction->status == 0) ? 'selected' : '' }}>In Review</option>
                        <option value="1" {{($transaction->status == 1) ? 'selected' : '' }}>In Progress</option>
                        <option value="2" {{($transaction->status == 2) ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
              </div>
              <div class="form-group row" style="display:block">
                <div class="col-md-12 required">
                  <label for='keterangan' class="control-label">Keterangan</label>
                  <input type="hidden" name="keterangan">
                  <div id="quil-editor" style="height: 100px">
                          {!!$transaction->keterangan!!}
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
	.has-error .select2-selection {
    border-color: rgb(185, 74, 72) !important;
}
.required label:after{
      content: "*";
      color: red;
    }
</style>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection



@section('additional-scripts')
<script src="https://unpkg.com/vue-swal@1.0.0/dist/vue-swal.js"></script>
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
      $(this.$el).empty().select2({ data: this.options }).val("{{ (is_null(old('property_id'))?$transaction->property_id:old('property_id')) }}").trigger('change')
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  }
});

var quileditor;

  var form = new Vue({
    el: '#form-add-property',
    methods: {
      insertDesc(){
        document.querySelector('input[name=keterangan]').value=quileditor.root.innerHTML;

        return true;
      }
    }
  });

  quileditor = new Quill("#quil-editor",{
    theme:'snow'
  });

</script>
@stop
