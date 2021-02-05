@extends('frontend.layout')

@section('title', 'Login | Agen')

@section('content')
	<div class="site-wrap js-site-wrap">
  <div class="widget js-widget">
    <div class="widget__content">
      <div class="banner js-banner-slider banner--slider">
        <!-- BEGIN SLIDER-->
        <div class="slider slider--dots slider--auth">
          <div class="slider__block js-slick-slider">
            <div class="slider__item">
              <div class="slider__preview">
                <div class="slider__img"><img data-lazy="https://i.ytimg.com/vi/1wtjyv1lmKc/maxresdefault.jpg" src="assets/frontend/img/lazy-image.jpg" alt="" width="100%"></div>
                <div class="slider__container">
                  <div class="container">
                    <div class="row">
                      <div class="slider__caption">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end of block .slider__block-->
        </div>
        <!-- END SLIDER-->
        <div class="banner__container banner__container--auth">
          <div class="container">
            <div class="row">
              <div class="banner__sidebar">
                <h4 class="banner__sidebar-title banner__sidebar-title--visible">Login Agen.</h4>
                <form id="search-form" method="POST" action="{{ route('agents.auth.login-process') }}" class="form form--flex form--banner-sidebar js-parsley">
                  @csrf
                  @if (session()->has('warning'))
                  <div class="alert alert-warning">
                    {{session('warning')}}
                  </div>
                  @endif
                  @if ($errors->any())
                  <div class="alert alert-danger text-left">
                    <strong>Failed</strong>
                    @if ($errors->has('message'))
                      <p>{{ $errors->first('message') }}</p>
                    @endif
                  </div>
                  @endif
                  <div class="row">
                    <div class="form-group">
                      <label for="register-name" class="control-label">Email</label>
                      <input type="text" id="register-name" name="email" value="{{ old('email') }}" required class="form-control">
                      @if ($errors->has('email'))
                        <div class="help-block filled" id="parsley-id-9"><div class="parsley-required">{{ $errors->first('email') }}</div></div>
                        @endif
                    </div>
                    <div class="form-group">
                      <label for="register-password" class="control-label">Password</label>
                      <input type="password" name="password" id="register-password" required class="form-control">
                    </div>
                    <div class="form__buttons">
                      <button type="submit" class="form__submit">Sign In</button>
                    </div>
                    <div class="form__buttons">
                      <div class="form__options" style="color: #fff;">Belum punya akun? Klik di <a href="{{route('agents.auth.register')}}">sini</a> untuk mendaftar.
                      </div>
                      <div class="form__options" style="color: #fff;"><a href="{{route('agents.auth.restore')}}">Lupa Password?</a>
                      </div>
                    </div>
                  </div>
                </form>
                <!-- end of block-->
                <div class="social social--join">Join with:<a class="social__item">
                    <div class="fa fa-facebook"></div></a><a class="social__item">
                    <div class="fa fa-twitter"></div></a><a class="social__item">
                    <div class="fa fa-google-plus"></div></a></div>
              </div>
              <!-- end of block .banner__form-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop