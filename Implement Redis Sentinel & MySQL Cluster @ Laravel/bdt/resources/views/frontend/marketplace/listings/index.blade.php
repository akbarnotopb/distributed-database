@extends('frontend.marketplace.layout')

@section('content')
        <nav class="breadcrumbs">
          <div class="container">
            <ul>
              <li class="breadcrumbs__item"><a href="{{ Route('marketplace.index',[(isset($refered))?$refered:null]) }}" class="breadcrumbs__link">Marketplace</a></li>
              <li class="breadcrumbs__item"><a href="{{ route('marketplace.search.ck',[(isset($refered))?$refered:null]) }}?type={{ $props->listing_type }}&category=&city=&minprice=0&maxprice=99999999999999999999" class="breadcrumbs__link">{{ ($props->listing_type=='rent')?'Disewa':'Dijual' }}</a></li>
              <li class="breadcrumbs__item"><a href="{{ route('marketplace.search.ck',[(isset($refered))?$refered:null]) }}?type=&category={{ $props->property_type_id }}&city=&minprice=0&maxprice=99999999999999999999" class="breadcrumbs__link">{{ $props->PropertyType->name }}</a></li>
              <li class="breadcrumbs__item"><a href="" class="breadcrumbs__link">{{ $props->name }}</a></li>
            </ul>
          </div>
        </nav>
        <div class="center">
          <div class="container">
            <div class="row">
              <div class="site site--main">
                  	<div class="property" style="width:-webkit-fill-available;">
                  		
                  		<h1 class="property__title">{{$props->name}}<span class="property__city" style="font-size:2.5rem">{{$props->address.', '.$props->City->name.', '.$props->Subdistrict->name}}</span></h1>
                  		
                  		    <div class="property__header">
                              <div class="property__price">
                                <strong class="property__price-value">{{'Rp'.number_format($props->price,0,',','.')}}
                                </strong>
                              </div>
                        	</div>

                        	<div class="clearfix"></div>

                        	<div class="property__slider">


                            @if($props->sold)
                            <div class="property__ribon property__ribon--done danger-color">Telah terjual</div>
                            @else
                            <div class="property__ribon">{{$props->listing_type == "sale" ? "Dijual":"Disewa"}}</div>         
                            @endif
                        		<div id="properties-thumbs" class="slider slider--small js-slider-thumbs">
                        			<div class="slider__block js-slick-slider">
                        				
                        				@foreach($props->PropertyImages as $key => $property_image)

                        				<div class="slider__item slider__item--{{$key % 4}}"><a href="{{asset($property_image->name)}}" data-size="1740x960" data-gallery-index='{{$key}}' class="slider__img js-gallery-item"><img data-lazy="{{(!is_null($property_image->tumbnail))?asset($property_image->tumbnail):asset($property_image->name)}}" src="{{(!is_null($property_image->tumbnail))?asset($property_image->tumbnail):asset($property_image->name)}}" alt=""><span class="slider__description"></span></a></div>

                        				@endforeach

                        				@if(count($props->PropertyImages)==0)

                        				<div class="slider__item slider__item--0"><a href="{{asset($props->image)}}" data-size="1740x960" data-gallery-index='0' class="slider__img js-gallery-item"><img data-lazy="{{asset($props->image)}}" src="{{asset($props->image)}}" alt="" style="width: 100%"><span class="slider__description"></span></a></div>
                        				
                        				@endif

                        			</div>
                        		</div>

                        		@if(count($props->PropertyImages)>1)
                        		<div class="slider slider--thumbs">
                        			<div class="slider__wrap">
                        				<div class="slider__block js-slick-slider">
                        					
                        					@foreach($props->PropertyImages as $key => $property_image)

                                      <div data-slide-rel='{{$key}}' class="slider__item slider__item--{{$key % 4}}">
                                                <div class="slider__img"><img data-lazy="{{(!is_null($property_image->tumbnail))?asset($property_image->tumbnail):asset($property_image->name)}}" src="{{(!is_null($property_image->tumbnail))?asset($property_image->tumbnail):asset($property_image->name)}}" alt=""></div>
                                              </div>

                        					@endforeach
                        					
                        				</div>
                                      <button type="button" class="slider__control slider__control--prev js-slick-prev">
                                        <svg class="slider__control-icon">
                                          <use xlink:href="#icon-arrow-left"></use>
                                        </svg>
                                      </button>
                                      <button type="button" class="slider__control slider__control--next js-slick-next">
                                        <svg class="slider__control-icon">
                                          <use xlink:href="#icon-arrow-right"></use>
                                        </svg>
                                      </button>
                        			</div>
                        		</div>
                        		@endif

                        	</div>

                        	<div class="property__info">
                              <div class="property__info-item">Tipe: <strong> {{$props->PropertyType->name}}</strong></div>
                              @if($props->built_up)
                              <div class="property__info-item">Luas Bangunan: <strong> {{$props->built_up}} m<sup>2</sup></strong></div>
                              @endif
                              <div class="property__info-item">Tanggal: <strong> {{$props->created_at->format('d/m/Y')}}</strong></div>
                              @if($props->land_size)
                              <div class="property__info-item">Luas Tanah: <strong> {{$props->land_size}} m<sup>2</sup></strong></div>
                              @endif
                        	</div>

                        	<div class="property__plan">
                        		@if($props->bedrooms)
                              <dl class="property__plan-item">
                                <dt class="property__plan-icon property__plan-icon--window">
                                  <svg>
                                    <use xlink:href="#icon-window"></use>
                                  </svg>
                                </dt>
                                <dd class="property__plan-title">Kamar Tidur</dd>
                                <dd class="property__plan-value">{{$props->bedrooms}}</dd>
                              </dl>
                              @endif

                              @if($props->bathrooms)
                              <dl class="property__plan-item">
                                <dt class="property__plan-icon property__plan-icon--bathrooms">
                                  <svg>
                                    <use xlink:href="#icon-bathrooms"></use>
                                  </svg>
                                </dt>
                                <dd class="property__plan-title">Kamar Mandi</dd>
                                <dd class="property__plan-value">{{$props->bathrooms}}</dd>
                              </dl>
                              @endif

                              @if($props->garages)
                              <dl class="property__plan-item">
                                <dt class="property__plan-icon property__plan-icon--garage">
                                  <svg>
                                    <use xlink:href="#icon-garage"></use>
                                  </svg>
                                </dt>
                                <dd class="property__plan-title">Garasi</dd>
                                <dd class="property__plan-value">{{$props->garages}}</dd>
                              </dl>
                              @endif

                              @if($props->maid_bedrooms)
                              <dl class="property__plan-item">
                                <dt class="property__plan-icon property__plan-icon--window">
                                  <svg>
                                    <use xlink:href="#icon-window"></use>
                                  </svg>
                                </dt>
                                <dd class="property__plan-title">K. Tidur Pembantu</dd>
                                <dd class="property__plan-value">{{$props->maid_bedrooms}}</dd>
                              </dl>
                              @endif

                              @if($props->maid_bathrooms)
                              <dl class="property__plan-item">
                                <dt class="property__plan-icon property__plan-icon--bathrooms">
                                  <svg>
                                    <use xlink:href="#icon-bathrooms"></use>
                                  </svg>
                                </dt>
                                <dd class="property__plan-title">K. Mandi Pembantu</dd>
                                <dd class="property__plan-value">{{$props->maid_bathrooms}}</dd>
                              </dl>
                              @endif

                        	</div>

                        	<div class="property__params">

                              <h4 class="property__subtitle">Alamat</h4>
                              
                              <ul class="property__params-list">
                                <li>Provinsi:<strong>{{ $props->City->Province->name }}</strong></li>

                                <li>Kabupaten/Kota:<strong>{{ $props->City->name }}</strong></li>

                                <li>Kecamatan:<strong>{{ $props->Subdistrict->name }}</strong></li>
                              </ul>

                        	</div>
                          <div class="property__params">
                              <hr>
                              <h4 class="property__subtitle">Spesifikasi</h4>
                              
                              <ul class="property__params-list">
                                @if($props->year_built)
                                  <li>Tahun Dibangun:<strong>{{$props->year_built}}</strong></li>
                                @endif
                                @if($props->certificate)
                                <li>Sertifikat:<strong>{{$props->certificate}}</strong></li>
                                @endif
                                @if($props->electrical_power)
                                <li>Daya Listrik:<strong>{{$props->electrical_power}} watt</strong></li>
                                @endif
                                @if($props->number_of_floors)
                                <li>Jumlah Lantai:<strong>{{$props->number_of_floors}}</strong></li>
                                @endif
                                @if($props->amount_of_down_payment)
                                <li>Jumlah DP:<strong>{{'Rp'. number_format($props->amount_of_down_payment,0,',','.')}}</strong></li>
                                @endif
                                @if($props->estimated_installments)
                                <li>Jumlah Cicilan:<strong>{{$props->estimated_installments}} Kali</strong></li>
                                @endif
                                @if($props->floor_number)
                                <li>Nomor Lantai:<strong>{{$props->floor_number}}</strong></li>
                                @endif
                                @if($props->parking_amount)
                                <li>Jumlah Parkir:<strong>{{$props->parking_amount}}</strong></li>
                                @endif
                              </ul>

                          </div>
                        	<div class="property__description js-unhide-block">
                                      <h4 class="property__subtitle">Deskripsi</h4>
                                      <div class="property__description-wrap">
                                        <p>{{$props->description}}</p>
                                      </div>
                                      <button type="button" class="property__btn-more js-unhide">More information ...</button>
                        	</div>

                  	</div>
                <!-- end of block .property-->
              </div>
              <!-- BEGIN SIDEBAR-->
              <div class="sidebar">
                <div class="widget js-widget widget--sidebar widget--first-no-head">
                  <div class="widget__header"><a class="widget__btn js-widget-btn widget__btn--toggle">Show agent</a>
                  </div>
                  @if($agent!='admin')
                  <div class="widget__content">
                    <div data-sr="enter bottom move 80px, scale(0), over 0s" data-animate-end="animate-end" class="worker js-unhide-block vcard worker--sidebar-advanced">
                      <h3 class="worker__name fn">{{ $agent->name }}</h3>
                      <div class="worker__post">{{ $agent->address }}</div>
                      <div class="worker__photo"><a href="#" class="item-photo item-photo--static"><img src="{{ $agent->photo }}" alt="{{ $agent->name }}" class="photo"/>
                          <figure class="item-photo__hover"><span class="item-photo__more">View Details</span></figure></a></div>
                      <div class="worker__intro">
                        <button type="button" class="worker__show js-unhide">Contact agent</button>
                        {{-- <div class="worker__listings"><i class="worker__favorites worker__favorites--highlight"></i> My Listings -<a href="agent_profile.html">12 property</a></div> --}}
                        <!-- end of block .worker__listings-->
                        <div class="worker__intro-row">
                          <div class="worker__intro-col">
                            <div class="worker__contacts">
                              <div class="tel"><span class="type">Tel.</span><a href="#" class="uri value">{{ $agent->phone_number }}</a></div>
                              <div class="email"><span class="type">WA.</span><a href="#" class="uri value">{{ $agent->whatsapp }}</a></div>
                              <div class="email"><span class="type">Email</span><a href="#" class="uri value">{{ $agent->email }}</a></div>
                            </div>
                            <!-- end of block .worker__contacts-->
                          </div>
                          <div class="worker__intro-col">
                            <div class="social social--worker"><a href="#" class="social__item"><i class="fa fa-facebook"></i></a><a href="#" class="social__item"><i class="fa fa-linkedin"></i></a><a href="#" class="social__item"><i class="fa fa-twitter"></i></a><a href="#" class="social__item"><i class="fa fa-google-plus"></i></a></div>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <!-- end of block .worker-->
                  </div>
                  @else
                  <div class="widget__content">
                    <div data-sr="enter bottom move 80px, scale(0), over 0s" data-animate-end="animate-end" class="worker js-unhide-block vcard worker--sidebar-advanced">
                      <h3 class="worker__name fn">Unlimited Properties</h3>
                      <div class="worker__post">Alamat Kantor</div>
                      <div class="worker__photo"><a href="#" class="item-photo item-photo--static"><img src="{{ url('/assets/img/user-placeholder.png') }}" alt="Unlimited Properties" class="photo"/>
                          <figure class="item-photo__hover"><span class="item-photo__more">View Details</span></figure></a></div>
                      <div class="worker__intro">
                        <button type="button" class="worker__show js-unhide">Contact agent</button>
                        {{-- <div class="worker__listings"><i class="worker__favorites worker__favorites--highlight"></i> My Listings -<a href="agent_profile.html">12 property</a></div> --}}
                        <!-- end of block .worker__listings-->
                        <div class="worker__intro-row">
                          <div class="worker__intro-col">
                            <div class="worker__contacts">
                              <div class="tel"><span class="type">Tel.</span><a href="#" class="uri value">088888888</a></div>
                              <div class="email"><span class="type">WA.</span><a href="#" class="uri value">088888888</a></div>
                              <div class="email"><span class="type">Email</span><a href="#" class="uri value">upi@gmail.com</a></div>
                            </div>
                            <!-- end of block .worker__contacts-->
                          </div>
                          <div class="worker__intro-col">
                            <div class="social social--worker"><a href="#" class="social__item"><i class="fa fa-facebook"></i></a><a href="#" class="social__item"><i class="fa fa-linkedin"></i></a><a href="#" class="social__item"><i class="fa fa-twitter"></i></a><a href="#" class="social__item"><i class="fa fa-google-plus"></i></a></div>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <!-- end of block .worker-->
                  </div>
                  @endif
                </div>

                @if(isset($colisting) and !isset($refered))
                <div class="widget js-widget widget--sidebar widget--first-no-head">
                  <div class="widget__header"><a class="widget__btn js-widget-btn widget__btn--toggle">Show agent</a>
                  </div>
                  <div class="widget__content">
                    <div data-sr="enter bottom move 80px, scale(0), over 0s" data-animate-end="animate-end" class="worker js-unhide-block vcard worker--sidebar-advanced">
                      <h3 class="worker__name fn">{{ $colisting->name }}</h3>
                      <div class="worker__post">{{ $colisting->address }}</div>
                      <div class="worker__photo"><a href="#" class="item-photo item-photo--static"><img src="{{ $colisting->photo }}" alt="{{ $colisting->name }}" class="photo"/>
                          <figure class="item-photo__hover"><span class="item-photo__more">View Details</span></figure></a></div>
                      <div class="worker__intro">
                        <button type="button" class="worker__show js-unhide">Contact agent</button>
                        {{-- <div class="worker__listings"><i class="worker__favorites worker__favorites--highlight"></i> My Listings -<a href="agent_profile.html">12 property</a></div> --}}
                        <!-- end of block .worker__listings-->
                        <div class="worker__intro-row">
                          <div class="worker__intro-col">
                            <div class="worker__contacts">
                              <div class="tel"><span class="type">Tel.</span><a href="#" class="uri value">{{ $colisting->phone_number }}</a></div>
                              <div class="email"><span class="type">WA.</span><a href="#" class="uri value">{{ $colisting->whatsapp }}</a></div>
                              <div class="email"><span class="type">Email</span><a href="#" class="uri value">{{ $colisting->email }}</a></div>
                            </div>
                            <!-- end of block .worker__contacts-->
                          </div>
                          <div class="worker__intro-col">
                            <div class="social social--worker"><a href="#" class="social__item"><i class="fa fa-facebook"></i></a><a href="#" class="social__item"><i class="fa fa-linkedin"></i></a><a href="#" class="social__item"><i class="fa fa-twitter"></i></a><a href="#" class="social__item"><i class="fa fa-google-plus"></i></a></div>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <!-- end of block .worker-->
                  </div>
                </div>               
                @endif





              </div>
              <!-- END SIDEBAR-->
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        <!-- END CENTER SECTION-->
@endsection

@section('additional-styles')
  <style type="text/css">
    .danger-color{
      background-color: red;
      font-weight: bold;
    }
  </style>
@endsection