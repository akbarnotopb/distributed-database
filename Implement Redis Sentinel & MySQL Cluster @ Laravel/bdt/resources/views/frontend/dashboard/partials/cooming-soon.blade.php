@extends('frontend.dashboard.layout')

@section('title')
  @yield('page-title')
@endsection



@section('additional-styles')
	<style type="text/css">
		.large-font{
			font-size:xx-large;
		}
	</style>
@endsection


@section('content')

<div class="widget js-widget widget--dashboard">
  <div class="widget__header">
    	<h2 class="widget__title">@yield('header-title')</h2>
  </div>
  <div class="widget__content">
  	<h3 class="large-font">COOMING SOON</h3>
  </div>
</div>

@endsection