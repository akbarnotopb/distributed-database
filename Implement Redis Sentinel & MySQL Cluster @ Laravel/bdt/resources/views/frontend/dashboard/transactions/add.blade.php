@extends('frontend.dashboard.layout')

@section('title', 'Add New Transaction | ')

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

        <form class="form-horizontal" action="{{route('transaction.agent.store')}}" method="post" style="{{session('success') ? 'display: none;' : ''}}" id="form-add-property" @submit="insertDesc">
          @csrf

              <div class="form-group row">
                  <div class="col-md-6 required">
                      <label>Nama Properti</label>
                      <select required name="property_id" data-placeholder="---" class="form-control">
                          @foreach($properties as $property)
                          <option value="{{$property->id}}">{{$property->name}}</option>
                          @endforeach
                      </select>
                  </div>
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
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script src="{{url('assets/js/dropzone.js')}}"></script>
<script type="text/javascript">

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
