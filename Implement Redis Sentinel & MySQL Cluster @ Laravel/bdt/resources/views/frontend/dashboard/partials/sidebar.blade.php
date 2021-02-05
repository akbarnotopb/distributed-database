<!-- BEGIN SIDEBAR-->
<div class="sidebar sidebar--dashboard">
<div class="widget js-widget widget--sidebar-dashboard widget--collapsing">
  <div class="widget__header"><a class="widget__btn js-widget-btn widget__btn--toggle">Dashboard</a>
  </div>
  <div class="widget__content">
    <nav class="nav nav--sidebar">
      <ul class="nav__list">
        <li class="nav__item">
          <a href="{{ route('dashboard.index') }}" class="nav__link active">
              <img src="{{ asset('assets/img/logo-upi-cropped.png') }}" width="100%" alt="">
          </a>
        </li>
        <li class="nav__item"><a href="{{route('dashboard.index')}}" class="nav__link active">
            <svg class="nav__icon">
              <use xlink:href="#icon-dashboard"></use>
            </svg>Dashboard</a></li>
        <li class="nav__item">
          <hr class="nav__separator">
        </li>
        <li class="nav__item"><a href="{{route('dashboard.profile')}}" class="nav__link">
            <svg class="nav__icon">
              <use xlink:href="#icon-user-admin"></use>
            </svg>Profile</a></li>
        <li class="nav__item"><a href="{{route('listings.property.index')}}" class="nav__link">
            <svg class="nav__icon">
              <use xlink:href="#icon-property-edit"></use>
            </svg>Property management</a></li>
        <li class="nav__item"><a href="{{route('transaction.agent.index')}}" class="nav__link">
            <svg class="nav__icon">
              <use xlink:href="#icon-news"></use>
            </svg>Transaction</a></li>
        <li class="nav__item"><a href="{{ route('favorites.property.index') }}" class="nav__link">
            <svg class="nav__icon">
              <use xlink:href="#icon-favorite-listings"></use>
            </svg>Favorite</a></li>
        <li class="nav__item"><a href="{{ route('contacts.index') }}" class="nav__link">
            <svg class="nav__icon">
              <use xlink:href="#icon-news"></use>
            </svg>Contact</a></li>
        <li class="nav__item">
          <hr class="nav__separator">
        </li>
      </ul>
    </nav>
  </div>
</div>
</div>
<!-- END SIDEBAR-->
