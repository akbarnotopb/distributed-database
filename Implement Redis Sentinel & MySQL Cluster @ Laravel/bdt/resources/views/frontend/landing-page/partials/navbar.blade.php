@if (session()->has('warning-not-approved'))
<div class="alert ui-pnotify-container alert-warning ui-pnotify-shadow">
  <h4 class="ui-pnotify-title">
    <svg class="notify-icon">
      <use xlink:href="#icon-error"></use>
    </svg>{{session('warning-not-approved')}}.
  </h4>
  <div style="display: none;" class="ui-pnotify-text"></div>
</div>
@endif
<!-- BEGIN HEADER-->
<header class="header header--brand">
  <div class="container">
    <div class="header__row">
      <div class="header__social">
        <div class="social social--header social--circles"><a href="#" class="social__item"><i class="fa fa-facebook"></i></a><a href="#" class="social__item"><i class="fa fa-twitter"></i></a><a href="#" class="social__item"><i class="fa fa-google-plus"></i></a></div>
      </div>
      <div class="auth auth--header">
        <ul class="auth__nav">
          @if(Auth::check())
          <li class="dropdown auth__nav-item">
            
            @if(!is_null(auth()->user()->photo))
            <button data-toggle="dropdown" type="button" class="dropdown-toggle js-auth-nav-btn auth__nav-btn"><img src="{{ asset(auth()->user()->photo)}}" alt="" class="auth__avatar"><span class="auth__name"> Hi {{ auth()->user()->name}}</span></button>
            @else
            <button data-toggle="dropdown" type="button" class="dropdown-toggle js-auth-nav-btn auth__nav-btn"><img src="{{url('assets/frontend/media-demo/avatars/01.jpg')}}" alt="" class="auth__avatar"><span class="auth__name"> Hi {{auth()->user()->name}}</span></button>
            @endif            
            
            <div class="dropdown__menu auth__dropdown--logged-in js-user-logged-in">
              <nav class="nav nav--auth">
                <ul class="nav__list">
                  <li class="nav__item"><a href="{{route('dashboard.index')}}" class="nav__link active">Dashboard</a></li>
                  <li class="nav__item"><a href="{{ route('listings.property.add') }}" class="nav__link">Add Listing</a></li>
                  <li class="nav__item"><a href="{{route('settings.account.edit')}}" class="nav__link">Profile</a></li>
                  <li class="nav__item"><a href="{{route('agents.auth.logout')}}" class="nav__link">Log out</a></li>
                </ul>
              </nav>
            </div>
          </li>
          
          @endif
        </ul>
        <!-- end of block .auth header-->
      </div>
      <button type="button" class="header__navbar-toggle js-navbar-toggle">
        <svg class="header__navbar-show">
          <use xlink:href="#icon-menu"></use>
        </svg>
        <svg class="header__navbar-hide">
          <use xlink:href="#icon-menu-close"></use>
        </svg>
      </button>
      <!-- end of block .header__navbar-toggle-->
    </div>
  </div>
</header>
<!-- END HEADER-->
<!-- BEGIN NAVBAR-->
<div id="header-nav-offset"></div>
<nav id="header-nav" class="navbar navbar--header">
</nav>
<!-- END NAVBAR-->