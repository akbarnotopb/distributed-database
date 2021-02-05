<div class="box js-box">

	@include('frontend.landing-page.partials.navbar')

	<div class="site-wrap js-site-wrap">
	@yield('content')
	@include('frontend.landing-page.partials.footer')
	</div>

</div>