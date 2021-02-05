@extends('frontend.dashboard.layout')

@section('title', 'Detail Properti | '.$property->name)

@section('content')

<div class="widget js-widget widget--dashboard" >
	<div class="property" style="width:-webkit-fill-available;">
		
		<h1 class="property__title">{{$property->name}}<span class="property__city" style="font-size:2.5rem">{{$property->City->name.', '.$property->Subdistrict->name}}</span></h1>
		
		<div class="property__header" id="Property">
            <div class="property__price"><strong class="property__price-value">{{'Rp'.number_format($property->price,0,',','.')}}</strong></div>
            {{-- apakah ini di favoritkan olleh agent ini --}}
            @if(!$isFavorite)
            <div class="property__actions">
              	<button type="button" class="btn--default" v-on:click="AddToFavorites" v-if="added == false"><i class="fa fa-star"></i>Add to favorites</button>
            </div>
            @endif
      	</div>

      	<div class="clearfix"></div>

      	<div class="property__slider">


          @if($property->sold)
          <div class="property__ribon property__ribon--done danger-color">Telah terjual</div>
          @else
          <div class="property__ribon">{{$property->listing_type == "sale" ? "Dijual":"Disewa"}}</div>         
          @endif
      		<div id="properties-thumbs" class="slider slider--small js-slider-thumbs">
      			<div class="slider__block js-slick-slider">
      				
      				@foreach($property->PropertyImages as $key => $property_image)

              <div class="slider__item slider__item--{{$key % 4}}">
                <a href="{{ asset($property_image->name) }}" data-size="1740x960" data-gallery-index='{{$key}}' class="slider__img js-gallery-item"><img data-lazy="{{(!is_null($property_image->tumbnail))?asset($property_image->tumbnail):asset($property_image->name)}}" src="{{(!is_null($property_image->tumbnail))?asset($property_image->tumbnail):asset($property_image->name)}}" alt=""><span class="slider__description"></span></a>
                <a href="{{ asset($property_image->name) }}" download>
                  <div class="property__ribon property__ribon--done download-color" style="margin-top:44%; font-size:15px">
                    <i class="fa fa-download" title="Download Gambar"></i>
                  </div>
                  
                </a>
              </div>

      				@endforeach

              @if(count($property->PropertyImages)==0)

              <div class="slider__item slider__item--0"><a href="{{asset($property->image)}}" data-size="1740x960" data-gallery-index='0' class="slider__img js-gallery-item"><img data-lazy="{{asset($property->image)}}" src="{{asset($property->image)}}" alt="" style="width: 100%"><span class="slider__description"></span></a></div>
              
              @endif

            </div>
            {{-- <div class="property__ribon property__ribon--done info-color" style="margin-top:40%; font-size:10px">
              Download Gambar
            </div> --}}
      		</div>

      		@if(count($property->PropertyImages)>1)
      		<div class="slider slider--thumbs">
      			<div class="slider__wrap">
      				<div class="slider__block js-slick-slider">
      					
      					@foreach($property->PropertyImages as $key => $property_image)

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
            <div class="property__info-item">Tipe: <strong> {{$property->PropertyType->name}}</strong></div>
            @if($property->built_up)
            <div class="property__info-item">Luas Bangunan: <strong> {{$property->built_up}}m<sup>2</sup></strong></div>
            @endif
            <div class="property__info-item">Tanggal: <strong> {{$property->created_at->format('d/m/Y')}}</strong></div>
            @if($property->land_size)
            <div class="property__info-item">Luas Tanah: <strong> {{$property->land_size}}m<sup>2</sup></strong></div>
            @endif
      	</div>

      	<div class="property__plan">
      		@if($property->bedrooms)
            <dl class="property__plan-item">
              <dt class="property__plan-icon property__plan-icon--window">
                <svg>
                  <use xlink:href="#icon-window"></use>
                </svg>
              </dt>
              <dd class="property__plan-title">Kamar Tidur</dd>
              <dd class="property__plan-value">{{$property->bedrooms}}</dd>
            </dl>
            @endif

            @if($property->bathrooms)
            <dl class="property__plan-item">
              <dt class="property__plan-icon property__plan-icon--bathrooms">
                <svg>
                  <use xlink:href="#icon-bathrooms"></use>
                </svg>
              </dt>
              <dd class="property__plan-title">Kamar Mandi</dd>
              <dd class="property__plan-value">{{$property->bathrooms}}</dd>
            </dl>
            @endif

            @if($property->garages)
            <dl class="property__plan-item">
              <dt class="property__plan-icon property__plan-icon--garage">
                <svg>
                  <use xlink:href="#icon-garage"></use>
                </svg>
              </dt>
              <dd class="property__plan-title">Garasi</dd>
              <dd class="property__plan-value">{{$property->garages}}</dd>
            </dl>
            @endif

            @if($property->maid_bedrooms)
            <dl class="property__plan-item">
              <dt class="property__plan-icon property__plan-icon--window">
                <svg>
                  <use xlink:href="#icon-window"></use>
                </svg>
              </dt>
              <dd class="property__plan-title">K. Tidur Pembantu</dd>
              <dd class="property__plan-value">{{$property->maid_bedrooms}}</dd>
            </dl>
            @endif

            @if($property->maid_bathrooms)
            <dl class="property__plan-item">
              <dt class="property__plan-icon property__plan-icon--bathrooms">
                <svg>
                  <use xlink:href="#icon-bathrooms"></use>
                </svg>
              </dt>
              <dd class="property__plan-title">K. Mandi Pembantu</dd>
              <dd class="property__plan-value">{{$property->maid_bathrooms}}</dd>
            </dl>
            @endif

      	</div>

      	<div class="property__params">
            <h4 class="property__subtitle">Alamat</h4>
            
            <ul class="property__params-list">
              <li>Provinsi:<strong>{{ $property->City->Province->name }}</strong></li>

              <li>Kabupaten / Kota: <strong>{{ $property->City->name }}</strong></li>

              <li>Kecamatan:<strong>{{ $property->Subdistrict->name }}</strong></li>
            </ul>

      	</div>
        <div class="property__params">
            <hr>
            <h4 class="property__subtitle">Spesifikasi</h4>
            
            <ul class="property__params-list">
              @if($property->year_built)
                <li>Tahun Dibangun:<strong>{{$property->year_built}}</strong></li>
              @endif
              @if($property->certificate)
              <li>Sertifikat:<strong>{{$property->certificate}}</strong></li>
              @endif
              @if($property->electrical_power)
              <li>Daya Listrik:<strong>{{$property->electrical_power}} watt</strong></li>
              @endif
              @if($property->number_of_floors)
              <li>Jumlah Lantai:<strong>{{$property->number_of_floors}}</strong></li>
              @endif
              @if($property->amount_of_down_payment)
              <li>Jumlah DP:<strong>{{'Rp'. number_format($property->amount_of_down_payment,0,',','.')}}</strong></li>
              @endif
              @if($property->estimated_installments)
              <li>Jumlah Cicilan:<strong>{{$property->estimated_installments}} Kali</strong></li>
              @endif
              @if($property->floor_number)
              <li>Nomor Lantai:<strong>{{$property->floor_number}}</strong></li>
              @endif
              @if($property->parking_amount)
              <li>Jumlah Parkir:<strong>{{$property->parking_amount}}</strong></li>
              @endif
            </ul>

        </div>
      	<div class="property__description js-unhide-block">
                    <h4 class="property__subtitle">Deskripsi</h4>
                    <div class="property__description-wrap" style="display:contents">
                      <p>{!!$property->description!!}</p>
                    </div>
                    <button type="button" class="property__btn-more js-unhide">More information ...</button>
      	</div>

        <div class="property__params">
            <hr>
            <h4 class="property__subtitle">Hubungi Agent :</h4>
                  @if($property->agent_type!='admin')
                    <div class="worker worker--profile">
                      <div class="worker__item">
                        <div class="worker__photo"><a href="#" class="item-photo item-photo--static"><img src="{{$property->Agent->photo}}" alt="{{ $property->Agent->name }}" class="photo"></a></div>
                        <div class="worker__intro">
                          <h3 class="worker__name fn">{{$property->Agent->name}}</h3>
                          <div class="worker__post">{{ ($property->Agent->downline!=null)? count($property->Agent->downline):0 }} Orang mitra</div>
                          <button type="button" class="worker__show js-unhide">Contact agent</button><a class="worker__company"><img src="{{asset('assets/img/logo-upi-icon.png') }}" width="15%"></a><span class="worker__company-name">Unlimited Properties</span>
                          <div class="clearfix"></div>
                          <div class="worker__contacts">
                            <div class="worker__intro-col">
                              <div class="tel"><span class="type">Telephone</span><a href="tel:{{$property->Agent->phone_number}}" class="uri value">{{$property->Agent->phone_number}}</a></div>
                            </div>
                            <div class="worker__intro-col">
                              <div class="email"><span class="type">Email</span><a href="mailto:{{$property->Agent->email}}" class="uri value">{{$property->Agent->email}}</a></div>
                            </div>
                            <div class="worker__intro-col">
                              <div class="email"><span class="type">Whatsapp</span><a href="Whatsapp:{{$property->Agent->whatsapp==null?'-':$property->Agent->whatsapp}}" class="uri value">{{$property->Agent->whatsapp==null?'-':$property->Agent->whatsapp}}</a></div>
                            </div>
                            <!-- end of block .worker__contacts-->
                          </div>
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="worker worker--profile">
                      <div class="worker__item">
                        <div class="worker__photo"><a href="#" class="item-photo item-photo--static"><img src="{{ url('/assets/img/user-placeholder.png') }}" alt="Admin" class="photo"></a></div>
                        <div class="worker__intro">
                          <h3 class="worker__name fn">Admin</h3>
                          {{-- <div class="worker__post"> - Orang mitra</div> --}}
                          <button type="button" class="worker__show js-unhide">Contact agent</button><a class="worker__company"><img src="{{asset('assets/img/logo-upi-icon.png') }}" width="15%"></a><span class="worker__company-name">Unlimited Properties</span>
                          <div class="clearfix"></div>
                          <div class="worker__contacts">
                            <div class="worker__intro-col">
                              <div class="tel"><span class="type">Telephone</span><a href="tel:088888888888" class="uri value">telpon kantor</a></div>
                            </div>
                            <div class="worker__intro-col">
                              <div class="email"><span class="type">Email</span><a href="mailto:emailkantor" class="uri value">emailkantor</a></div>
                            </div>
                            <div class="worker__intro-col">
                              <div class="email"><span class="type">Whatsapp</span><a href="Whatsapp:088888888888" class="uri value">Wa kantor</a></div>
                            </div>
                            <!-- end of block .worker__contacts-->
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
        </div>

        @if(!is_null($property->colisting))
        <div class="property__params">
            <hr>
            {{-- <h4 class="property__subtitle"> :</h4> --}}
                    <div class="worker worker--profile">
                      <div class="worker__item">
                        <div class="worker__intro" style="text-align: right;">
                          <h3 class="worker__name fn">{{$colisting->name}}</h3>
                          <div class="worker__post">{{ ($colisting->downline!=null)? count($colisting->downline):0 }} Orang mitra</div>
                          <button type="button" class="worker__show js-unhide" style="float: right;">Contact agent</button><a class="worker__company" style="float: right;text-align: right;"><img src="{{url('assets/frontend/media-demo/partners/logo-company-proera.png')}}"></a><span class="worker__company-name" style="float:right; margin-right: 15px">Unlimited Properties</span>
                          <div class="clearfix"></div>
                          <div class="worker__contacts">
                            <div class="worker__intro-col">
                              <div class="tel"><span class="type">Telephone</span><a href="tel:{{$colisting->phone_number}}" class="uri value">{{$colisting->phone_number}}</a></div>
                            </div>
                            <div class="worker__intro-col">
                              <div class="email"><span class="type">Email</span><a href="mailto:{{$colisting->email}}" class="uri value">{{$colisting->email}}</a></div>
                            </div>
                            <div class="worker__intro-col">
                              <div class="email"><span class="type">Whatsapp</span><a href="Whatsapp:{{$colisting->whatsapp==null?'-':$colisting->whatsapp}}" class="uri value">{{$colisting->whatsapp==null?'-':$colisting->whatsapp}}</a></div>
                            </div>
                            <!-- end of block .worker__contacts-->
                          </div>
                        </div>
                        <div class="worker__photo"><a href="#" class="item-photo item-photo--static"><img src="{{$colisting->photo}}" alt="{{ $colisting->name }}" class="photo"></a></div>
                      </div>
                    </div>
        </div>
        @endif

	</div>
</div>

@stop

@section('additional-styles')
  <style type="text/css">
    .danger-color{
      background-color: #f74c4c;
      color:white;
      font-weight: bold;
    }

    .info-color{
      background-color:#317ef9;
      color:white;
      cursor: pointer;
    }

    .info-color:hover{
      background-color:#7ba9f2;
      color:black;
    }

    .download-color{
      background-color:transparent;
      color:white;
      cursor: pointer;
    }

    .download-color:hover{
      background-color:transparent;
      color:#00bbaa;
    }

    .property__plan-item{
      height: 150px;
    }

    .property__params-list{
      display:contents;
    }
    
    @media only screen and (max-width:320px){
      .property__info-item{
        width: 100%;
      }
    }

    @media only screen and (max-width: 767px){
      .worker--profile .worker__contacts span{
        width: unset;
      }
    }

  </style>
@endsection

@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script src="https://unpkg.com/vue-swal@1.0.0/dist/vue-swal.js"></script>
<script type="text/javascript">
  new Vue({
    el: '#Property',
    data: {
      added:false,
      postBody:{
        id: {{$property->id}}
      }
    },
    methods: {
      AddToFavorites: function()
      {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.post("{{route('listings.favorite.store')}}",this.postBody)
        .then(response => {
          this.added = true;
          this.$swal(response.data.rheader, ""+response.data.messages+"", response.data.status);
        })
        .catch(e => {
          this.$swal("Peringatan", ""+e.response.data.messages+"", "warning");
        })
      }
    }
  });
</script>
@stop