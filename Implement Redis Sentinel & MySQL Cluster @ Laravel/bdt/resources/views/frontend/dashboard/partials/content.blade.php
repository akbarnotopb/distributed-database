<div class="box js-box">

	@include('frontend.landing-page.partials.navbar')

	<div class="site-wrap js-site-wrap">
	<!-- BEGIN CENTER SECTION-->
	<div class="center">
	  <div class="container">
	    <div class="row">
{{-- 	      <header class="site__header">
	        <h1 class="site__title site__title--center">Dashboard</h1>
	      </header> --}}
	      <!-- BEGIN LISTING-->
	      <div class="site site--dashboard">
	        <div class="site__main">
	          @yield('content')
	        </div>
	      </div>
	      <!-- END LISTING-->
	      @include('frontend.dashboard.partials.sidebar')
	      <div class="clearfix"></div>
	    </div>
	  </div>
	</div>
	<!-- END CENTER SECTION-->
	@include('frontend.landing-page.partials.footer')
	</div>

</div>