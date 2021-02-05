@extends('frontend.dashboard.layout')

@section('title', 'Member | ')

@section('content')

<div class="widget js-widget widget--dashboard">
  <div class="widget__header">
    	<h2 class="widget__title">Member</h2>
  </div>
  <p>Berikut adalah daftar nama downline anda :</p>
  <hr style="height: 10px">
  <div class="widget__content">
  	<div class="col-md-12">
  		<div class="bs-example table-responsive">
          @if($downline->count()!=0)
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor HP</th>
                <th>Email</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
             @foreach ($downline as $key=> $element)
              <tr class="{{ ($element->approved)?:'warning' }}">
                <td>{{ $key+1 }}</td>
                <td>{{ $element->name }}</td>
                <td>{{ $element->phone_number }}</td>
                <td>{{ $element->email }}</td>
                <td>{{ ($element->approved)?'Aktif':'Belum Aktif' }}</td>
              </tr>
             @endforeach
            </tbody>
          </table>
          @else
            <p>Kamu belum memiliki mitra!</p>
          @endif
        </div>
  	</div>
  </div>
</div>

@endsection