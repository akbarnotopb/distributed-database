@extends('frontend.dashboard.layout')

@section('title', 'Dashboard | ')

@section('content')

<div class="widget js-widget widget--dashboard">
  
  <div class="widget__header">
    <h2 class="widget__title">Cari Properti</h2>
  </div>

  <div class="widget__content">
    <div class="listing--items listing--list" id="PropertyResult">
      <div class="site__panel">
        
        <form action="{{route('listings.property.search')}}">
          <div class="site__filter">
            <div class="form-group">
              <div class="form-control--select">
                <select id="in-listing-category" class="form-control" name="category">
                  <option></option>
                  @foreach($PropertyTypees as $PropertyType)
                  <option value="{{$PropertyType->id}}">{{$PropertyType->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="form-control--select">
                <select2 id="in-listing-city" class="form-control select2-searchable" name="city" v-model='citySelected' :options="options">
                  <option></option>
                </select2>
              </div>
            </div>
            <div class="form-group">
              <div class="form-control--select">
                <select id="in-listing-subdistrict" class="form-control select2-searchable" name="subdistrict">
                  <option></option>
                </select>
              </div>
              <button class="button__default active button__default--large ui__button ui__button--7">Search</button>
            </div>
            <div style="margin-top: 5px">
                <div class="second-filter dropdown-wis">
                  <span><p><span id="in-listing-name">Dijual</span><span class="glyphicon glyphicon-chevron-down glyphicon-sm"></span></p></span> 
                  <ul id="sale-option" class="option-wis" style="height: unset">
                    <li value="1">Dijual</li>
                    <li value="2">Disewa</li>
                    <input type="hidden" name="type" value="sale" id="in-listing-name-input">
                  </ul>      
                </div>
                <div class="second-filter dropdown-wis">
                  <span><p><span id="min-price">Harga Minimal   </span><span class="glyphicon glyphicon-chevron-down glyphicon-sm"></span></p></span>
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
        </form>

      </div>

      <div class="listing__list" style="margin-top: 30px;">

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
          
          <div class="listing__item" v-for="(property,index) of filteredProperties" v-if="index < amountshowed">
            <div class="properties properties--list">
              <div class="properties__thumb">
                <a v-bind:href="property.detail_url" class="item-photo">
                  <img v-bind:src="property.image" alt="">
                  <figure class="item-photo__hover item-photo__hover--params">
                    <span class="properties__params">Luas Bangunan - @{{property.built_up}} m<sup>2</sup></span>
                    <span class="properties__params">Luas Tanah - @{{ (property.land_size)?property.land_size:0 }} m<sup>2</sup></span>
                    <span class="properties__time">Added date: @{{ property.created_at_for_human}}</span>
                  </figure>
                </a>
                <span class="properties__ribon">@{{ property.property_type_name }}</span>
                <span v-if="property.sold==1" class="property__ribon property__ribon--status property__ribon--done danger-color" style="top:56px">Telah terjual</span>
              </div>
              <!-- end of block .properties__thumb-->
              <div class="properties__details">
                <div class="properties__info">
                  <a v-bind:href="property.detail_url" class="properties__address">
                    <span class="properties__address-street">@{{property.name}}</span>
                    <span class="properties__address-city">@{{property.city_name}}</span>
                  </a>
                  <div class="properties__offer">
                    <div class="properties__offer-column">
                      <div class="properties__offer-label"></div>
                      <div class="properties__offer-value"><strong> </strong>
                      </div>
                    </div>
                    <div class="properties__offer-column">
                      <div class="properties__offer-value"><span style="font-size: large;">Rp. @{{ formatPrice(property.price) }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="properties__params--mob"><a v-bind:href="property.detail_url" class="properties__more">View details</a><span class="properties__params">Built-Up - @{{property.built_up}} m <sup>2</sup></span><span class="properties__params">Land Size - @{{ (property.land_size)?property.land_size:0 }} m<sup>2</sup></span></div>
                </div>
                <div class="properties__intro" v-html="property.description">
                  {{-- @{{property.description}} --}}
                </div>
                <div>
                  <a v-bind:href="property.detail_url" class="properties__more">View details</a>
                  <a v-bind:id="`addfav`+property.id" v-if="property.favorite.length==0" v-on:click="addToFavorites(property.id)" class="properties__more" style="cursor: pointer;">Add to favorite!</a>
                  <a href="#" class="properties__more lister_name_right">By @{{property.agent_name}}</a>
                </div>
              </div>
              <!-- end of block .properties__info-->
            </div>
            <!-- end of block .properties__item-->
          </div>

        </div>

      </div>

      <div class="widget__footer" v-if="filteredProperties.length>5">
        <a class="widget__more " v-on:click="get(pagin.next_page_url)" v-if="amountshowed<filteredProperties.length && !loading" >Tampilkan Lebih Banyak</a>
        <a class="widget__more " v-on:click="reset" v-else-if="!loading">Tampilkan Lebih Sedikit</a>

      </div>

    </div>
  </div>
  <div class="widget__footer" id="loading" style="display: none">
        <div style="margin:auto;">
          <img src="{{ asset('assets/frontend/img/ajax-loader.gif') }}">
        </div>
  </div>
</div>

@stop

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
    cursor: pointer;
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
Vue.component('select2', { //city
  props: ['options','value'],
  template: "<select><slot></slot></select>",
  mounted: function () {
    var vm = this
    $(this.$el)
      // init select2
      .select2({ data: this.options })
      .val(this.value)
      .trigger('change')
      // emit event on change.
      .on('change', function () {
        vm.$emit('input', this.value)
      })
  },
  watch: {
    value: function (value) {
      // update value
      $(this.$el)
        .val(value)
        .trigger('change')
    },
    options: function (options) {
      // update options
      $(this.$el).empty().select2({ 
        data: this.options,
        placeholder:'Pilih kota/kabupaten..',
        allowClear:true,          
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
        }).val('{{ old('city') }}').trigger('change');
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  }
});
  var _vm=new Vue({
    el: '#PropertyResult',
    created() {
      this.fetchData(); 
      this.fetchCities();
      // this.fetchSubdistrict();
    },
    data: {
      properties: [],
      minprice: parseInt($("#min-price-input").val()),
      maxprice: parseInt($("#max-price-input").val()),
      finish: false,
      amountshowed:5,
      citySelected:'{{ old('city')?:1 }}',
      options : [],
      opdistrict :[],
      pagin:[],
      loading:false
    },
    methods: {
      reset(){
        this.amountshowed=5;
        window.scrollTo(0,0);
      },
      addToFavorites:function(xid){
        // console.log(xid);
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.post("{{route('listings.favorite.store')}}",{id:xid})
        .then(response => {
          this.added = true;
          this.$swal(response.data.rheader, ""+response.data.messages+"", response.data.status);
          if(response.data.status=="success"){
            $("#addfav"+String(xid)).hide();
          }
        })
        .catch(e => {
          this.$swal("Peringatan", ""+e.response.data.messages+"", "warning");
        });

        // $("#addfav"+String(xid)).hide();
      },
      get(url){
        if(url!=null){
         $("#loading").css('display','flex');
         this.loading=true;
         axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
         axios.get(url+'&ajax=1').then(response=>{
          this.pagin=response.data;
          this.properties=this.properties.concat(this.pagin.data);
          this.amountshowed+=10;
          $("#loading").css('display','none');
          this.loading=false;
         });
        }else{
          this.amountshowed+=10;
        }   
      },
      fetchData() {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.get('{{ route('dashboard.index') }}?ajax=1').then(response => {
            this.properties = response.data.data;
            this.pagin=response.data;
            this.finish = true;
            });
        },
        formatPrice(value) {
          let val = (value/1).toFixed(2).replace('.', ',')
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
      fetchCities(){
          axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
          axios.get('{{ Route('dashboard.index') }}?city=1&ajax=1').then(response => {
              this.options = response.data;
              // this.finish = true;
              });
      },
      fetchSubdistrict(city_id){
          axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
          axios.get('{{ Route('dashboard.index') }}?subdistrict=1&city_id='+city_id+'&ajax=1').then(response => {
              this.opdistrict = response.data;
              // this.finish = true;
              });      
      }
    },
    watch:{
      citySelected:function(){
        this.fetchSubdistrict(this.citySelected);
      },
      opdistrict:function(){
          $("#in-listing-subdistrict").empty().select2({width: '100%',
          placeholder:'Pilih kecamatan..',
          allowClear : true,
          data: this.opdistrict,
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
      if(evt.target.id!="min-price" || evt.target.id!="max-price" || evt.target.id=="in-listing-name"){
        $("#min-option").css("display","none");
        $("#max-option").css("display","none");
        $("#sale-option").css("display","none");
      }
      // alert($(evt.target).parent().attr("id"));
      // alert(evt.target.id);//salah disini

        var innerValue;
        var realValue;
        if($(evt.target).parent().attr("id")!="sale-option" ){
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
      }
      else{
        // alert(evt.target.value);
          value = (evt.target.value=='1')?'Dijual':'Disewa';
          $("#in-listing-name-input").val(evt.target.value);
          result=(evt.target.value=='1')?'Dijual':'Disewa';
          $("#in-listing-name").text(result);
        
      }
      if(evt.target.id=="in-listing-name"){
        $("#sale-option").css("display","block");
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


   // $("#in-listing-name").select2({width: '100%',placeholder:'Dijual / Sewa',minimumResultsForSearch: Infinity});

   $("#in-listing-category").select2({width: '100%',placeholder:'Pilih kategori properti..',minimumResultsForSearch: Infinity,allowClear:true});

    $("#in-listing-subdistrict").select2({
      width: '100%',
      placeholder:'Pilih kecamatan..',
      allowClear : true,
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