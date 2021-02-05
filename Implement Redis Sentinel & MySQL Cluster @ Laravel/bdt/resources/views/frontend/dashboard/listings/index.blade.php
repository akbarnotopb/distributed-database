@extends('frontend.dashboard.layout')

@section('title', 'Listing Property | ')

@section('content')

<div class="widget js-widget widget--dashboard" id="props">
	<div class="widget__header">
    	<h2 class="widget__title">Property Management</h2>
	</div>
  <div class="props-mag-header row">
    <div class="col-md-3 col-sm-12">
      <button class="btn btn-block custombutton" style="float:left" v-on:click="fetch('all')" id="allistbutton">All Listing</button>
    </div>
    <div class="col-md-3 col-sm-12">
      <button class="btn btn-block custombutton btn-choosen" style="float:left" v-on:click="fetch('mine')" id="mylistbutton">My Listing</button>
    </div>
    <div class="col-md-3 col-sm-12">
      <button class="btn btn-block custombutton" style="float:left" v-on:click="fetch('sold')" id="soldbutton">Sold</button>
    </div>
  </div>
  	<div class="widget__content">
  		<div class="listing listing--grid">
        <div v-if="fetching" class="widget__footer">
          <div style="margin: 0 auto">
            <img src="{{ asset('assets/frontend/img/ajax-loader.gif') }}">
          </div>
          <div style="height: 100vh">
            
          </div>
        </div>
        <div v-else>
          <div class="listing__item" v-for="(property,index) in properties" v-if="amountshowed>index">
            <div class="properties properties--management">
                    <div class="properties__item-header"><span class="properties__state properties__state--default danger">@{{ (property.approved)? 'Approved' : 'In-Review'}}</span>
                      <div class="properties__actions" v-if="property.agent_type=='agent' && property.agent_id==myid">
                        <button type="button" class="properties__link" v-on:click="redirect(property.detail_url+'/edit')">Edit</button>
                        <div class="dropdown properties__actions-dropdown">
                          <button data-toggle="dropdown" type="button" class="dropdown-toggle properties__dropdown-toggle">...</button>
                          <div class="dropdown__menu properties__dropdown-menu">
                            <button type="button" class="properties__link" v-on:click="deleteprop(property.id)">Delete</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="properties__thumb"><a v-bind:href='property.detail_url' class="item-photo item-photo--static"><img v-bind:src="property.image" alt="">
                        <figure class="item-photo__hover item-photo__hover--params"><span class="properties__params">Built-Up - @{{ (property.built_up)? property.built_up : 0 }} Sq Ft</span><span class="properties__params">Land Size - @{{ property.landsize? property.landsize : 0 }} Sq Ft</span><span class="properties__time">Added date: @{{ property.created_at_for_human }}</span><span class="properties__more">View details</span></figure></a><span class="properties__ribon">@{{ property.property_type_name }}</span>
                        <span class="properties__ribon properties__ribon--status properties__ribon--done danger-color" style="top:56px" v-if="property.sold==1">Telah Terjual</span>

                    </div>
                    <!-- end of block .properties__thumb-->
                    <div class="properties__details">
                      <div class="properties__info"><a href="#" class="properties__address"><span class="properties__address-street">@{{ property.name }}</span><span class="properties__address-city"> @{{ property.address }}</span></a>
                        <div class="properties__params--mob"><a href="#" class="properties__more">View details</a><span class="properties__params">Built-Up - @{{ (property.built_up)? property.built_up : 0 }} Sq Ft</span><span class="properties__params">Land Size - @{{ property.landsize? property.landsize : 0 }} Sq Ft</span></div>
                      </div>
                    </div>
                    <!-- end of block .properties__info-->
                  </div>
          </div>          
        </div>
  		</div>
      <div class="widget__footer" v-if="properties.length>6">
        <a class="widget__more " v-on:click="get(pagin.next_page_url)" v-if="amountshowed<properties.length && !loading" >Tampilkan Lebih Banyak</a>
        <a class="widget__more " v-on:click="reset" v-else-if="!loading">Tampilkan Lebih Sedikit</a>
      </div>
      <div class="widget__footer" id="loading" style="display: none">
        <div style="margin:auto;">
          <img src="{{ asset('assets/frontend/img/ajax-loader.gif') }}">
        </div>
      </div>
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
      pagin:[],
      properties:[],
      type:'mine',
      myid: {{ auth()->user()->id }},
      fetching:true,
      loading:false,
      amountshowed:6
    },
    created(){
      this.fetch('mine');
    },
    methods:{
      get(url){
        if(url!=null){
         $("#loading").css('display','flex');
         this.loading=true;
         axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
         axios.get(url+'&type='+this.type+'&ajax=1').then(response=>{
          this.pagin=response.data;
          this.properties=this.properties.concat(this.pagin.data);
          this.amountshowed+=9;
          $("#loading").css('display','none');
          this.loading=false;
         });
        }else{
          this.amountshowed+=9;
        }   
      },
      reset(){
        this.amountshowed=6;
        window.location.href="#props";
      },
      fetch(type){
        this.type=type
        this.fetching=true;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.get("{{route('listings.property.index')}}?type="+this.type+"&ajax=1").then(response=>{
          this.properties=response.data.data;
          this.pagin=response.data;
          this.fetching=false;
        });
      },
      deleteprop(id){
          this.$swal({title: 'Apakah anda yakin menghapusnya?',
            text: "Anda tidak akan bisa mengembalikannya setelah anda menghapusnya!",
            icon: 'warning',
            buttons: true,
            reverseButtons: true
          }).then((result) => {
           if(result){
              axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
              axios.post("{{route('listings.property.delete')}}",{deleteProp:id}).then(response=>{
                  if(response.status==200){
                    this.$swal('Terhapus','Berhasil dihapus!','success').then(function(){
                        location.reload();
                    });
                  }else{
                    this.$swal('Gagal', 'Mohon maaf, terjadi kesalahan. Properti gagal dihapus','error');
                  }
              });
           }
          });
        },
      redirect(url){
        window.location.href=url;
      }
    },
    watch:{
      type:function(){
        if(this.type=='all'){
          $("#allistbutton").addClass("btn-choosen");
          $("#mylistbutton").removeClass("btn-choosen");
          $("#soldbutton").removeClass("btn-choosen");
        }
        else if(this.type=="sold"){
          $("#allistbutton").removeClass("btn-choosen");
          $("#mylistbutton").removeClass("btn-choosen");
          $("#soldbutton").addClass("btn-choosen");         
        }
        else{
          $("#allistbutton").removeClass("btn-choosen");
          $("#mylistbutton").addClass("btn-choosen");
          $("#soldbutton").removeClass("btn-choosen");          
        }
      }
    }
  });
</script>
@endsection