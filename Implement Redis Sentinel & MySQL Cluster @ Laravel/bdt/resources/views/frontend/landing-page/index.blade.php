@extends('frontend.layout')

@section('title', 'Unlimited Properties')

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
                <div class="slider__img"><img data-lazy="https://i.ytimg.com/vi/1wtjyv1lmKc/maxresdefault.jpg" src="assets/frontend/img/lazy-image.jpg" alt=""></div>
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
                <h4 class="banner__sidebar-title banner__sidebar-title--visible">Sign Up For Free.</h4>
                <form id="search-form" action="properties_listing_list.html" class="form form--flex form--banner-sidebar js-parsley">
                  <div class="row">
                    <div class="form-group">
                      <label for="register-name" class="control-label">First name</label>
                      <input type="text" id="register-name" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="register-lastname" class="control-label">Last name</label>
                      <input type="text" id="register-lastname" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="register-phone" class="control-label">Telephone</label>
                      <input type="text" id="register-phone" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="register-email" class="control-label">E-mail</label>
                      <input type="email" name="email" id="register-email" required class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="register-password" class="control-label">Password</label>
                      <input type="password" name="password" id="register-password" required class="form-control">
                    </div>
                    <div class="form__buttons">
                      <button type="submit" class="form__submit">Sign Up</button>
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