@extends('frontend.dashboard.layout')

@section('title', 'Favorite Properties | ')

@section('content')

<!-- BEGIN LISTING-->

<div class="widget js-widget widget--dashboard">
  <div class="widget__header">
    <h2 class="widget__title">Favorite Listings</h2>
  </div>
  <div class="widget__content"  id="props">
    <!-- BEGIN Favorites-->
    <div class="listing--items listing--favorites">
      <div class="listing__actions">
        <div class="listing__actions-border"></div>
        <form v-on:submit="confirmme" method="POST" action="{{ route('favorites.property.delete') }}">
          @csrf
          <input type="hidden" name="deletefav[]" v-model="selectedList">
          <input id="deletebuttonconfim" type="submit" class="btn--link js-tags-rename" value="Delete Selected"></input>
        </form>
      </div>
    </div>

    <div class="listing--items listing--grid listing--favorites listing--lg-4">
      <div v-if="fetching" class="widget__footer">
        <div style="margin: 0 auto">
          <img src="{{ asset('assets/frontend/img/ajax-loader.gif') }}">
        </div>
        <div style="height: 100vh">
          
        </div>
      </div>
      <div v-else>
        <div class="listing__item js-listing-item" v-for="(favs,index) in properties" v-if="morebutton > index">
          <div class="listing__thumb">
            <button class="listing__select js-listing-select" v-on:click="addToogleActive($event,favs.id)"></button>
            <a v-bind:href="favs.property.detail_url" class="item-photo item-photo--static"><img v-bind:src="favs.property.image" alt=""/>
            <figure class="item-photo__hover"><span class="item-photo__more">View</span></figure></a>
          </div>
          <!-- end of block .listing__thumb-->
          <div class="listing__info" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"  >
            <div class="listing__categories"><a class="listing__category">@{{ favs.property.property_type_name }}</a>
            </div><a v-bind:href="favs.property.detail_url" class="listing__title">@{{ favs.property.name }}</a>
          </div>
          <!-- end of block .listing__info-->
        </div>       
      </div>

      <!-- end of block .listing__item-->
      {{-- @endforeach --}}
    </div>

    <div v-if="pagin.total>8">
      <div class="widget__footer" v-if="(pagin.total > morebutton) && !loading" ><a class="widget__more" v-on:click="get(pagin.next_page_url)" style="cursor: pointer;">Show more listings</a></div>
      <div class="widget__footer" v-else-if="!loading"><a class="widget__more" v-on:click="morebutton=8" style="cursor: pointer;">Show less listings</a></div>   
    </div>
    <div class="widget__footer" id="loading" style="display: none">
        <div style="margin:auto;">
          <img src="{{ asset('assets/frontend/img/ajax-loader.gif') }}">
        </div>
    </div>
    <div v-if="pagin.total==0">
          <div class="listing__empty">
            <svg class="listing__empty-icon">
              <use xlink:href="#icon-info"></use>
            </svg>
            <h4 class="listing__empty-title">Daftar properti favorit tidak ditemukan.</h4><span class="listing__empty-headline">
              Silahkan menambah properti favorit kamu!</span>
          </div>
    </div>

  </div>
</div>
<!-- END LISTING-->

@stop

@section('additional-styles')
  <style type="text/css">
    .danger-color{
      background-color: #f74c4c;
      color:white;
      font-weight: bold;
    }
    .custombutton{
      border-bottom: 4px solid #d99221;
      background-color: #f3bc65;
      color:#222;
      font-size:15px;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 10px;
      outline:#f3bc65;
    }

    .col-md-3{
      padding: 0;
      margin:0 10px;
    }

    .btn-choosen{
      background-color: #efc37c;
      border-bottom: 4px solid #efc37c;      
    }


    .custombutton:hover{
      border-bottom: 4px solid #f3bc65;
    }

    .props-mag-header{
      margin:20px 0;
      padding: 0;
    }

    .listing__category{

    }

    #deletebuttonconfim:hover{
      color:black;
    }
  </style>
@endsection

@section('additional-scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>
<script src="https://unpkg.com/vue-swal@1.0.0/dist/vue-swal.js"></script>
<script type="text/javascript">
  var _vm = new Vue({
    el:"#props",
    data:{
      morebutton:8,
      selectedList:[],
      properties:[],
      pagin:[],
      fetching:true,
      loading:false
    },
    created(){
      this.fetch();
    },
    methods:{
      get(url){
        if(url!=null){
         $("#loading").css('display','flex');
         this.loading=true;
         axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
         axios.get(url+'&ajax=1').then(response=>{
          this.pagin=response.data;
          this.properties=this.properties.concat(this.pagin.data);
          this.morebutton+=12;
          $("#loading").css('display','none');
          this.loading=false;
         });
        }else{
          this.morebutton+=12;
        }
      },
      fetch(){
        this.fetching=true;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.get("{{route('favorites.property.index')}}?ajax=1").then(response=>{
          this.properties=response.data.data;
          this.pagin=response.data;
          this.fetching=false;
        });
      },
      addToogleActive(event,id){
        var $btn = $(event.target);
        var $item = $btn.closest('.js-listing-item');
        if(!$btn.hasClass("active")){
          this.selectedList.push(id);
        }
        else{
          var index = this.selectedList.indexOf(id);
          this.selectedList.splice(index,1);
        }
        $item.toggleClass('listing__item--selected');
        $btn.toggleClass('active');
      },
      confirmme(event){
        event.preventDefault();
        if(this.selectedList.length!=0){
          this.$swal({title: 'Apakah anda yakin menghapusnya?',
            text: "Anda tidak akan bisa mengembalikannya setelah anda menghapusnya!",
            icon: 'warning',
            buttons: true,
            reverseButtons: true
          }).then((result) => {
           if(result){
              // alert(this.selectedList);
              axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
              axios.post("{{route('favorites.property.delete')}}",{deletefav:this.selectedList}).then(response=>{
                  if(response.status==200){
                    location.reload();
                  }
              });
           }
          });
        }else{
          this.$swal({
            title:'Daftar tidak ditemukan!',
            text:'Pilihlah daftar properti favorit yang anda ingin hapus!',
            icon:'error'
          });
        }
      }
    }
  });

</script>
@endsection