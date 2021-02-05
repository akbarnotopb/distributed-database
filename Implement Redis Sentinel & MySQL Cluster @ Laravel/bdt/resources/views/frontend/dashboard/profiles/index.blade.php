{{-- @php
  dd($downline);
@endphp --}}


@extends('frontend.dashboard.layout')

@section('title', 'Dashboard | ')

@section('additional-styles')
  <style type="text/css">
    .pad-bot-zero{
      padding-bottom: 0;
    }
  </style>
@endsection



@section('content')
<div class="widget js-widget widget--dashboard">
  <div class="widget__header">
    <h2 class="widget__title">Profile</h2>
    <div>
      <a href="{{ route('listings.property.add') }}" class="widget__btn js-widget-btn">Add New Property</a>
      <a  href="{{route('dashboard.profile.member')}}" class="widget__btn js-widget-btn">Mitra</a>
      <a href="{{route('settings.account.edit')}}" class="widget__btn js-widget-btn">Edit Profile</a>
    </div>
  </div>
  <div class="widget__content">
    <div class="worker worker--profile">
      <div class="worker__item">
        <div class="worker__photo"><a href="#" class="item-photo item-photo--static"><img src="{{$agent->photo}}" alt="Mariusz Ciesla" class="photo">
            <figure class="item-photo__hover"><span class="item-photo__more">View Details</span></figure></a></div>
        <div class="worker__intro">
          <div class="col-md-7">
            <h3 class="worker__name fn">{{$agent->name}}</h3>
            <div class="worker__post">Professional Agent</div>
            <button type="button" class="worker__show js-unhide">Contact agent</button><a class="worker__company"><img src="{{asset('assets/img/logo-upi-icon.png') }}" width="15%"></a><span class="worker__company-name">Unlimited Properties</span>            
          </div>
          <div class="col-md-5">
             <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate('marketplace.unlimitedproperties.com/'.$agent->username)) !!}">         
          </div>
          <div class="clearfix"></div>
          <div class="worker__contacts">
            <div class="worker__intro-col">
              <div class="tel"><span class="type">Telephone</span><a href="tel:{{$agent->phone_number}}" class="uri value">{{$agent->phone_number}}</a></div>
            </div>
            <div class="worker__intro-col">
              <div class="email"><span class="type">Email</span><a href="mailto:{{$agent->email}}" class="uri value">{{$agent->email}}</a></div>
            </div>
            <!-- end of block .worker__contacts-->
          </div>
          <div class="social social--worker"><a href="#" class="social__item"><i class="fa fa-facebook"></i></a><a href="#" class="social__item"><i class="fa fa-linkedin"></i></a><a href="#" class="social__item"><i class="fa fa-twitter"></i></a><a href="#" class="social__item"><i class="fa fa-google-plus"></i></a></div>
        </div>
      </div>
    </div>
    <div>

    </div>
  </div>
</div>
{{-- <div class="widget js-widget widget--dashboard">
  <div class="widget__header">
    <h2 class="widget__title">Favorite Listings</h2><a href="#" class="widget__btn js-widget-btn">See more</a>
  </div>
  <div class="widget__content">
    <!-- BEGIN Favorites-->
    <div class="listing--items listing--grid listing--favorites listing--lg-4">
      <div class="listing__item js-listing-item">
        <div class="listing__thumb"><a href="" class="item-photo item-photo--static"><img src="{{url('assets/frontend/media-demo/properties/554x360/06.jpg')}}" alt=""/>
            <figure class="item-photo__hover"><span class="item-photo__more">View</span></figure></a>
        </div>
        <!-- end of block .listing__thumb-->
        <div class="listing__info">
          <div class="listing__categories"><a class="listing__category">Single-family home</a>
          </div><a href="" class="listing__title">1230 Martin Luther King</a>
        </div>
        <!-- end of block .listing__info-->
      </div>
      <!-- end of block .listing__item-->
      <div class="listing__item js-listing-item">
        <div class="listing__thumb"><a href="" class="item-photo item-photo--static"><img src="{{url('assets/frontend/media-demo/properties/554x360/07.jpg')}}" alt=""/>
            <figure class="item-photo__hover"><span class="item-photo__more">View</span></figure></a>
        </div>
        <!-- end of block .listing__thumb-->
        <div class="listing__info">
          <div class="listing__categories"><a class="listing__category">Entire home</a><a class="listing__category">Single-family home</a><a class="listing__category">Hotel</a>
          </div><a href="" class="listing__title">401 South Sycamore Street</a>
        </div>
        <!-- end of block .listing__info-->
      </div>
      <!-- end of block .listing__item-->
      <div class="listing__item js-listing-item">
        <div class="listing__thumb"><a href="" class="item-photo item-photo--static"><img src="{{url('assets/frontend/media-demo/properties/554x360/08.jpg')}}" alt=""/>
            <figure class="item-photo__hover"><span class="item-photo__more">View</span></figure></a>
        </div>
        <!-- end of block .listing__thumb-->
        <div class="listing__info">
          <div class="listing__categories"><a class="listing__category">Entire home</a><a class="listing__category">Single-family home</a><a class="listing__category">Hotel</a>
          </div><a href="" class="listing__title">649 West Adams Boulevard</a>
        </div>
        <!-- end of block .listing__info-->
      </div>
      <!-- end of block .listing__item-->
      <div class="listing__item js-listing-item">
        <div class="listing__thumb"><a href="" class="item-photo item-photo--static"><img src="{{url('assets/frontend/media-demo/properties/554x360/09.jpg')}}" alt=""/>
            <figure class="item-photo__hover"><span class="item-photo__more">View</span></figure></a>
        </div>
        <!-- end of block .listing__thumb-->
        <div class="listing__info">
          <div class="listing__categories"><a class="listing__category">Entire home</a><a class="listing__category">Hotel</a>
          </div><a href="" class="listing__title">958 Dewey Avenue</a>
        </div>
        <!-- end of block .listing__info-->
      </div>
      <!-- end of block .listing__item-->
      <div class="listing__item js-listing-item">
        <div class="listing__thumb"><a href="" class="item-photo item-photo--static"><img src="{{url('assets/frontend/media-demo/properties/554x360/10.jpg')}}" alt=""/>
            <figure class="item-photo__hover"><span class="item-photo__more">View</span></figure></a>
        </div>
        <!-- end of block .listing__thumb-->
        <div class="listing__info">
          <div class="listing__categories"><a class="listing__category">Hotel</a>
          </div><a href="" class="listing__title">1026 Ohio Avenue</a>
        </div>
        <!-- end of block .listing__info-->
      </div>
      <!-- end of block .listing__item-->
      <div class="listing__item js-listing-item">
        <div class="listing__thumb"><a href="" class="item-photo item-photo--static"><img src="{{url('assets/frontend/media-demo/properties/554x360/11.jpg')}}" alt=""/>
            <figure class="item-photo__hover"><span class="item-photo__more">View</span></figure></a>
        </div>
        <!-- end of block .listing__thumb-->
        <div class="listing__info">
          <div class="listing__categories"><a class="listing__category">Hotel</a>
          </div><a href="" class="listing__title">514 East Myrtle Street</a>
        </div>
        <!-- end of block .listing__info-->
      </div>
      <!-- end of block .listing__item-->
    </div>
  </div>
</div> --}}
<!-- END Favorites-->
@stop