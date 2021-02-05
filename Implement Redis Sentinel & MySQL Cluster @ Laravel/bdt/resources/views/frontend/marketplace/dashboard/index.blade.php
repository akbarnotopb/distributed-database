@extends('frontend.marketplace.layout')

@section('content')
	<div class="center">
		<div class="container">
			<div class="row">
<!--STARY SLIDER-->
<div class="widget js-widget">
<div class="widget__content">
<div id="slider-wide" class="slider slider--wide">
              <div class="slider__block js-slick-slider" style="height: 50vh">
                @foreach ($slider_props as $slider_prop)
                <div class="slider__item" style="height: 50vh">
                  <div class="slider__preview">
                    <div class="slider__img slider__img--lg"><img data-lazy="{{$slider_prop->image }}" src="{{$slider_prop->image }}" height="100%" width="100%" alt=""></div>
                    <div class="slider__img slider__img--sm"><img data-lazy="{{$slider_prop->image }}"  alt=""></div>
                  </div>
                  <div class="slider__caption" style="margin:-30px 0 0 -550px; padding: 40px 40px 20px 40px">
                    <div class="slider__price" style="border:1px solid rgba(0, 187, 170, 0.8)"><strong style="font-size:20px">Rp.{{ $slider_prop->price }}</strong>
                    </div>
                    <!-- end of block .slider__price--><a href="property_details.html" class="slider__address" style="font-size: 20px">{{ $slider_prop->address }}<span class="slider__address-city" style="font-size:15px;"> {{ $slider_prop->Subdistrict->name }} ,{{ $slider_prop->City->name }}</span></a>
                    <!-- end of block .slider__address-->
                    <div class="slider__params" style="font-size: 15px">
                      <dl>
                        <dt>Tipe:</dt>
                        <dd>{{ $slider_prop->property_type_name }}</dd>
                        <dt>Area:</dt>
                        <dd>{{ $slider_prop->built_up }}m2</dd>
                        <dt>Sertifikat:</dt>
                        <dd>{{ $slider_prop->certificate }}</dd>
                      </dl>
                      <dl>
                        <dt>Kamar Tidur:</dt>
                        <dd>{{ $slider_prop->bedrooms }}</dd>
                        <dt>Kamar Mandi:</dt>
                        <dd>{{ $slider_prop->bathrooms }}</dd>
                        <dt>Listrik :</dt>
                        <dd>{{ $slider_prop->electrical_power }} Watt</dd>
                      </dl>
                    </div>
                    <!-- end of block .slider__params-->
                    <a href="{{ isset($refered)?Route('marketplace.show.ck',['agentid'=>$refered,'id'=>$slider_prop->id]):Route('marketplace.show',['id'=>$slider_prop->id])}}" class="slider__more">Details</a>
                  </div>
                  <!-- end of block .slider__caption-->
                </div>
                @endforeach
              </div>
              <div class="slider__controls">
                <button class="slider__control slider__control--prev js-banner-prev"></button>
                <button class="slider__control slider__control--next js-banner-next"></button>
              </div>
</div>
</div>
</div>
        <!-- END SLIDER-->
				<header class="site__header">
					<h1 class="site__title">Daftar Properti</h1>
				</header>
				<div class="site__panel container-fluid">
					{{-- searchnya ntar disini --}}
		        	<form class="col-md-12" action="{{(isset($refered)?Route('marketplace.search.ck',['agentid'=>$refered]):Route('marketplace.search'))}}">
                <div class="col-md-10">
				          <div class="form-group col-md-3">
				              <select id="in-listing-name" class="form-control select2-unsearchable" name="type">
                        <option></option>
				                <option value="sale">Dijual</option>
				                <option value="rent">Disewa</option>
				              </select>
				          </div>
				          <div class="form-group col-md-4">
				              <select id="in-listing-category" class="form-control select2-unsearchable" name="category">
                        <option></option>
				                @foreach($PropertyTypees as $PropertyType)
				                <option value="{{$PropertyType->id}}">{{$PropertyType->name}}</option>
				                @endforeach
				              </select>
				          </div>
				          <div class="form-group col-md-5">
				              <select id="in-listing-city" class="form-control select2-searchable" name="city">
                        <option></option>
				                @foreach($Cities as $City)
				                <option value="{{$City->id}}">{{$City->name}}</option>
				                @endforeach
				              </select>
				          </div>
				          <div class="col-md-9" style="margin-top: 5px;">
				              <div class="second-filter dropdown-wis">
				                <span><p><span id="min-price">Harga Minimal</span> <span class="glyphicon glyphicon-chevron-down glyphicon-sm"></span></p></span>
				                <ul id="min-option" class="option-wis">
                          <li value="1">Berapapun</li>
                          <li value="2">50Jt</li>
                          <li value="3">100Jt</li>
                          <li value="4">200Jt</li>
                          <li value="5">500Jt</li>
                          <li value="6">1M</li>
                          <li value="7">2M</li>
                          <li value="8">5M</li>
                          <li value="9">10M</li>
                          <li value="10">20M</li>
                          <li value="11">50M</li>
                          <li value="12">100M</li>
                          <li value="13">200M</li>
                          <li value="14">500M</li>
                          <li value="15">1T</li>
                          <li value="16">2T</li>
                          <li value="17">5T</li>
                          <li value="18">10T</li>
                          <li value="19">20T</li>
				                  <input type="hidden" name="minprice" value="0" id="min-price-input">           
				                </ul>
				              </div>
				              <div  class="second-filter dropdown-wis">
				                <span><p><span id="max-price">Harga Maksimal</span> <span class="glyphicon glyphicon-chevron-down glyphicon-sm"></span></p></span>
				                <ul id="max-option" class="option-wis">
                          <li value="1">Berapapun</li>
                          <li value="2">50Jt</li>
                          <li value="3">100Jt</li>
                          <li value="4">200Jt</li>
                          <li value="5">500Jt</li>
                          <li value="6">1M</li>
                          <li value="7">2M</li>
                          <li value="8">5M</li>
                          <li value="9">10M</li>
                          <li value="10">20M</li>
                          <li value="11">50M</li>
                          <li value="12">100M</li>
                          <li value="13">200M</li>
                          <li value="14">500M</li>
                          <li value="15">1T</li>
                          <li value="16">2T</li>
                          <li value="17">5T</li>
                          <li value="18">10T</li>
                          <li value="19">20T</li>
				                  <input  type="hidden" name="maxprice" value="99999999999999999999" id="max-price-input">
				                </ul>
				              </div>
				          </div>
                </div>
                <div class="col-md-2 container-fluid">
                   <div class="form-group col-md-12">
                      <button class="button__default active button__default--large ui__button ui__button--4">Search</button>
                  </div>                   
                </div>
			       
			        </form>
				</div>
				<div class="site__main" id="PropertyResult">
					<div class="widget js-widget widget--main">
	                    <div class="widget__content">
	                      <div class="listing listing--grid js-properties-list">
                            <div v-if="properties.length == 0 && finish==false">
                              <div class="skeleton"></div>
                            </div>
                            <div v-else-if="(properties.length == 0 && finish==true) || (filteredProperties.length==0)">
                              
                              <div class="listing__empty">
                                <svg class="listing__empty-icon">
                                  <use xlink:href="#icon-info"></use>
                                </svg>
                                <h4 class="listing__empty-title">Properti tidak ditemukan.</h4><span class="listing__empty-headline">
                                  Belum ada properti untuk kategori ini.</span>
                              </div>
                            </div>
                            <div v-else> 
	                             <div v-for="(property,index) in filteredProperties" class="listing__item" v-if="index<amountshowed">
      	                          <div class="properties properties--grid">
      	                            <div class="properties__thumb">
      	                            	<a v-bind:href="property.marketplace_url" class="item-photo">
      	                            		<img v-bind:src="property.image" alt=""/>
      		                                <figure class="item-photo__hover item-photo__hover--params">
      		                                	<span class="properties__params">Luas Bangunan : @{{ property.built_up }} m <sup>2</sup>
      		                                	</span>
      		                                	<span class="properties__params"> Luas Tanah : @{{(property.land_size)?property.land_size:0}} m <sup>2</sup>
      		                                	</span>
      		                                	<span class="properties__intro">@{{ property.description }}
      		                                	</span>
      		                                	<span class="properties__time">
      		                                		Added date: @{{ property.created_at_for_human}}
      		                                	</span>
      		                                	<span class="properties__more">View details
      		                                	</span>
      		                                </figure>
      	                            	</a>
      	                            	<span class="properties__ribon">
      	                            		@{{ property.property_type_name }}
      	                            	</span>
                                      <span v-if="property.sold==0" class="property__ribon property__ribon--status property__ribon--done" style="top:56px;padding: 5px;">
                                        @{{ (property.listing_type==`rent`)?`Disewa`:`Dijual` }}
                                      </span>
                                      <span v-if="property.sold==1" class="property__ribon property__ribon--status property__ribon--done danger-color" style="top:56px;padding: 5px;">
                                        Telah Terjual
                                      </span>
      	                            </div>
      	                            <!-- end of block .properties__thumb-->
      	                            <div class="properties__details">
      	                              <div class="properties__info">
      	                              	<a v-bind:href="property.marketplace_url" class="properties__address">
      	                              		<span class="properties__address-street">@{{property.address}}</span>
      	                              		<span class="properties__address-city">@{{ property.city_name }}</span>
      	                              	</a>
      	                                <div class="properties__offer">
      	                                  <div class="properties__offer-column">
      	                                    <div class="properties__offer-value"><strong>Rp. @{{ formatPrice(property.price) }}</strong>
      	                                    </div>
      	                                  </div>
      	                                </div>
      	                                <div class="properties__params--mob"><a href="#" class="properties__more">View details</a><span class="properties__params">Luas Bangunan : @{{ property.built_up }} m <sup>2</sup></span><span class="properties__params">Luas Tanah : @{{  (property.land_size)?property.land_size:0}} m <sup>2</sup></span></div>
      	                              </div>
      	                            </div>
      	                          </div>
	                             </div>
                            </div>
	                      </div>
	                    </div>
              		</div>
              		<div class="widget__footer" v-if="filteredProperties.length>9">
                    <a v-if="amountshowed<filteredProperties.length && !loading" class="widget__more" v-on:click="get(pagin.next_page_url)">More listings</a>
                    <a v-else-if="!loading" class="widget__more" v-on:click="amountshowed=9">Less listings</a>
                  </div>
				</div>
        <div class="widget__footer" style="display: none" id="loading">
          <div style="margin: auto">
            <img src="{{ asset('assets/frontend/img/ajax-loader.gif') }}">
          </div>
        </div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
@endsection


@section('additional-styles')
<style type="text/css">
  .skeleton:empty {
    margin: auto;
    width: 790px;
    height: 800px; /* change height to see repeat-y behavior */
    
    background-image:
      linear-gradient( #f7f7f7 147px, transparent 0 ),
      linear-gradient( 100deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5) 50%, rgba(255, 255, 255, 0) 80% ),
      linear-gradient( #f7f7f7 20px, transparent 0 ),
      linear-gradient( #f7f7f7 20px, transparent 0 ),
      linear-gradient( #f7f7f7 20px, transparent 0 ),
      linear-gradient( #f7f7f7 20px, transparent 0 );

    background-repeat: repeat-y;

    background-size:
      263px 200px, /* circle */
      50px 200px, /* highlight */
      150px 200px,
      450px 200px,
      450px 200px,
      450px 200px;

    background-position:
      0 0, /* circle */
      0 0, /* highlight */
      300px 0,
      300px 40px,
      300px 80px,
      300px 120px;

    animation: shine 1s infinite;
  }

  @keyframes shine {
    to {
      background-position:
        0 0,
        100% 0, /* move highlight to right */
        300px 0,
        300px 40px,
        300px 80px,
        300px 120px;
    }
  }
  .pad-bot-zero{
    padding-bottom: 0;
  }

  .second-filter p{
    margin-bottom :0;margin-right: 10px; display: inline; color: white; font-size: 16px; font-weight: normal; cursor: pointer;
  }

  .dropdown-wis{
    display: inline-block;
  }

  .glyphicon-sm{
    font-size: 10px;
  }

  .dropdown-wis ul{
      display: none;
      margin: 0;
      padding: 0;
      background-color: white;
      position: absolute;
      height: 200px;
      width: 150px;
      overflow: auto;
      z-index: 100;
  }

  .dropdown-wis li{
    padding: 5px;
    padding-right: 0;
    padding-left: 20px;
    list-style: none;
  }

  .dropdown-wis li:hover{
    background-color: #00bbaa;
  }

  .danger-color{
    background-color: #f74c4c;
    color:white;
    font-weight: bold;
  }
</style>
@stop



@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script src="https://unpkg.com/vue-swal@1.0.0/dist/vue-swal.js"></script>
<script type="text/javascript"> 

var $indexBanner = $('#simple-slider');

$indexBanner
        .find('.js-slick-slider')
        .slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true,
            prevArrow: $indexBanner.find('.js-banner-prev'),
            nextArrow: $indexBanner.find('.js-banner-next'),
            responsive: [
                {
                    breakpoint: 1300,
                    settings: {
                        centerMode: false,
                        variableWidth: false,
                        arrows: true
                    }
                }
            ]
        }
);

  var _vm=new Vue({
    el: '#PropertyResult',
    created() {
      this.fetchData(); 
    },
    data: {
      properties: [],
      minprice: parseInt($("#min-price-input").val()),
      maxprice: parseInt($("#max-price-input").val()),
      finish: false,
      amountshowed:9,
      props_uri : "{{ isset($refered)?Route('marketplace.show.ck',['agentid'=>$refered,'id'=>0]):Route('marketplace.show',['id'=>0]) }}",
      refered : {{ (isset($refered))?1:0 }},
      pagin:[],
      loading:false
    },
    methods: {
      get(url){
        if(url!=null){
          this.loading=true;
          $("#loading").css('display','flex');
          axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
          axios.get(url+'&ajax=1').then(response =>{
            this.pagin=response.data;
            this.properties=this.properties.concat(this.pagin.data);
            if(this.refered){
              for(var i=this.pagin.from-1 ; i<this.properties.length; ++i){
                this.properties[i].marketplace_url=this.props_uri+this.properties[i].id;
              }
            }
          this.loading=false;
          $("#loading").css('display','none');
          this.amountshowed+=9;
         });
        }else{
          this.amountshowed+=9;
        }
      },
      fetchData() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.get('{{ route('marketplace.index') }}?ajax=1').then(response => {
            this.properties = response.data.data;
            this.pagin=response.data;
            if(this.refered){
              for (var i=0; i<this.properties.length;++i){
                this.properties[i].marketplace_url=this.props_uri+this.properties[i].id;
              }
            }
            this.finish = true;
            });
        },
        formatPrice(value) {
          let val = (value/1).toFixed(2).replace('.', ',')
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }
    },
    computed:{
      filteredProperties(){
        var minprices=this.minprice;
        var maxprices=this.maxprice;
        return this.properties.filter(function(data){
          if(parseInt(data.price) <= maxprices  && parseInt(data.price)>= minprices ){
            return true;
          }
          return false;
        })
      }
    }
  });

 var minprice=0;
    var maxprice=false;
    $("body").click(function(evt){
      if(evt.target.id!="min-price" || evt.target.id!="max-price"){
        $("#min-option").css("display","none");
        $("#max-option").css("display","none");
      }
      // alert($(evt.target).parent().attr("id"));
      var innerValue;
      var realValue;
      switch(evt.target.value){
        case 1:
          innerValue="Berapapun";
          realValue=0;
          break;
        case 2:
          innerValue="50Jt";
          realValue=50000000;
          break;
        case 3:
          innerValue="100Jt";
          realValue=100000000;
          break;
        case 4:
          innerValue="200Jt";
          realValue=200000000;
          break;
        case 5:
          innerValue="500Jt";
          realValue=500*1000*1000;
          break;
        case 6:
          innerValue="1M";
          realValue=1000*1000*1000;
          break;
        case 7:
          innerValue="2M";
          realValue=2*1000*1000*1000;
          break;
        case 8:
          innerValue="5M";
          realValue=5*1000*1000*1000;
          break;
        case 9:
          innerValue="10M";
          realValue=10*1000*1000*1000;
          break;
        case 10:
          innerValue="20M";
          realValue=20*1000*1000*1000;
          break;
        case 11:
          innerValue="50M";
          realValue=50*1000*1000*1000;
          break;
        case 12:
          innerValue="100M";
          realValue=100*1000*1000*1000;
          break;
        case 13:
          innerValue="200M";
          realValue=200*1000*1000*1000;
          break;
        case 14:
          innerValue="500M";
          realValue=500*1000*1000*1000;
          break;
        case 15:
          innerValue="1T";
          realValue=1000*1000*1000*1000;
          break;
        case 16:
          innerValue="2T";
          realValue=2*1000*1000*1000*1000;
          break;
        case 17:
          innerValue="5T";
          realValue=5*1000*1000*1000*1000;
          break;
        case 18:
          innerValue="10T";
          realValue=10*1000*1000*1000*1000;
          break;
        case 19:
          innerValue="20T";
          realValue=20*1000*1000*1000*1000;
          break;
      }
      if($(evt.target).parent().attr("id")=="min-option"){
        if(innerValue=="Berapapun"){
          innerValue="Harga Minimal";
        }
        minprice=realValue;
        if(maxprice && minprice>maxprice){
          $("#min-price").text($("#max-price").text());
          minprice=maxprice;
          $("#min-price-input").val(minprice);
          _vm.minprice=minprice;

          $("#max-price").text(innerValue);
          maxprice=realValue;
          $("#max-price-input").val(maxprice);
          _vm.maxprice=maxprice;

          return;
        }
        else if(maxprice && minprice==maxprice){
          $("#min-price").text(innerValue);
          minprice=realValue;
          $("#min-price-input").val(minprice);
          _vm.minprice=minprice;

          maxprice=false;
          $("#max-price").text("Harga Maksimal");
          $("#max-price-input").val(99999999999999999999);
          _vm.maxprice=99999999999999999999;

          return;
        }
        $("#min-price").text(innerValue);
        $("#min-price-input").val(realValue);
        _vm.minprice=minprice;
        return;
      }

      if($(evt.target).parent().attr("id")=="max-option"){
        if(innerValue=="Berapapun"){
          innerValue="Harga Maksimal";
          realValue=99999999999999999999;
        }
        
        maxprice=realValue;

        if(maxprice<minprice){

          $("#max-price").text($("#min-price").text());
          $("#max-price-input").val(minprice);
          $("#min-price").text(innerValue);
          $("#min-price-input").val(maxprice);
          _vm.minprice=maxprice;
          _vm.maxprice=minprice;
          return;
        }
        else if(maxprice==minprice){
          maxprice=realValue;
          $("#max-price").text(innerValue);
          $("#max-price-input").val(maxprice); 
          _vm.maxprice=(maxprice); 

          $("#min-price").text("Harga Minimal");
          minprice=0;
          $("#min-price-input").val(minprice);
          _vm.minprice=minprice;
          return;
        }

        $("#max-price").text(innerValue);
        $("#max-price-input").val(realValue);
        _vm.maxprice=realValue;
        return;
      }

      if(evt.target.id=="min-price"){
        $("#min-option").css("display","block");
        return;
      }
      if(evt.target.id=="max-price"){
        $("#max-option").css("display","block");
        return;
      }
    });


    var $inWidgetsSelect = $('.select2-unsearchable');
    if ($inWidgetsSelect.length) $inWidgetsSelect.select2({width: '100%',minimumResultsForSearch: Infinity});

    $("#in-listing-category").select2({placeholder:"Pilih jenis properti..",width: '100%',minimumResultsForSearch: Infinity});
    $("#in-listing-name").select2({placeholder:"Pilih jenis transaksi..",width: '100%',minimumResultsForSearch: Infinity});

    $(".select2-searchable").select2({
      width: '100%',
      placeholder:'Pilih Kota..',
      matcher: function(params,data){
            if ($.trim(params.term) === '') {
              return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
              return null;
            }

            key = (params.term).split(" ");

            for (var i=0 ; i<key.length;++i){
                if (((data.text).toUpperCase()).indexOf((key[i]).toUpperCase()) == -1) 
                return null;
            }

            return data;
      }
    });
</script>
@stop