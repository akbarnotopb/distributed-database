@extends('frontend.dashboard.layout')

@section('title', 'Pengaturan Akun | ')

@section('content')
<div class="widget js-widget widget--dashboard">
  <div class="widget__header">
    <h2 class="widget__title">Profile</h2>
  </div>
  <div class="widget__content">
    @if (session()->has('warning'))
      <div class="alert alert-warning">
        {{session('warning')}}
      </div>
    @endif
    @if (session()->has('success'))
      <div class="alert alert-success">
        {{session('success')}}
      </div>
    @endif

    @if (session()->has('failed'))
      <div class="alert alert-danger">
        {{session('failed')}}
      </div>
      @endif

  @php

    $splitName = explode(' ', old('name') ? old('name') : $agent->name, 2); 
    // Restricts it to only 2 values, for names like Billy Bob Jones

    $first_name = $splitName[0];
    $last_name = !empty($splitName[1]) ? $splitName[1] : '';
  
  @endphp
    <form class="form form--flex form--profile js-form" method="post" action="{{route('settings.account.update')}}" enctype="multipart/form-data">
      {{csrf_field()}}
    {{method_field('put')}}
      <div id="form-block-2" class="form__block js-form-block">
        <div class="row">
          <div class="form-group {{$errors->has('firstname') ? 'has-error':''}}">
            <label for="in-7" class="control-label">First name</label>
            <input id="in-7" type="text" placeholder="First name" required value="{{$first_name}}" name="firstname" class="form-control">
            @if ($errors->has('firstname'))
            <div class="help-block filled" id="parsley-id-15"><div class="parsley-required">{{ $errors->first('firstname') }}</div></div>
            @endif
          </div>
          <div class="form-group">
            <label for="in-8" class="control-label">Last name</label>
            <input id="in-8" type="text" placeholder="Last name" required class="form-control" value="{{$last_name}}" name="lastname">
          </div>

          <div class="form-group {{$errors->has('username') ? 'has-error':''}}">
            <label for="in-6" class="control-label">Username</label>
            <input id="in-6" type="text" placeholder="Username.." {{ (isset($agent->username))?'disabled':'' }} required name="username" value="{{old('username') ? old('username') : $agent->username}}" class="form-control">
            @if ($errors->has('username'))
            <div class="help-block filled"><div class="parsley-required">{{ $errors->first('username') }}</div></div>
            @endif
          </div>


          <div class="form-group {{$errors->has('email') ? 'has-error':''}}">
            <label for="in-9" class="control-label">Email</label>
            <input id="in-9" type="text" placeholder="Email" required name="email" value="{{old('email') ? old('email') : $agent->email}}" class="form-control">
            @if ($errors->has('email'))
            <div class="help-block filled"><div class="parsley-required">{{ $errors->first('email') }}</div></div>
            @endif
          </div>
          <div class="form-group {{$errors->has('phone_number') ? 'has-error':''}}">
            <label for="in-10" class="control-label">Phone</label>
            <input id="in-10" type="text" placeholder="Phone" required name="phone_number" value="{{old('phone_number') ? old('phone_number') : $agent->phone_number}}" class="form-control">
            @if ($errors->has('phone_number'))
            <div class="help-block filled"><div class="parsley-required">{{ $errors->first('phone_number') }}</div></div>
            @endif
          </div>

          <div class="form-group {{$errors->has('whatsapp') ? 'has-error':''}}">
            <label for="in-13" class="control-label">Whatsapp</label>
            <input id="in-13" type="text" placeholder="Nomor whatsapp.." name="whatsapp" value="{{old('whatsapp') ? old('whatsapp') : $agent->whatsapp}}" class="form-control">
            @if ($errors->has('whatsapp'))
            <div class="help-block filled"><div class="parsley-required">{{ $errors->first('whatsapp') }}</div></div>
            @endif
          </div>

          <div class="form-group {{$errors->has('nik') ? 'has-error':''}}">
            <label for="in-11" class="control-label">NIK</label>
            <input id="in-11" type="text" placeholder="NIK" required name="nik" value="{{old('nik') ? old('nik') : $agent->nik}}" class="form-control">
            @if ($errors->has('nik'))
            <div class="help-block filled"><div class="parsley-required">{{ $errors->first('nik') }}</div></div>
            @endif
          </div>
          <div class="form-group {{$errors->has('address') ? 'has-error':''}}">
            <label for="in-12" class="control-label">Address</label>
            <input id="in-12" type="text" placeholder="Address" required name="address" value="{{old('address') ? old('address') : $agent->address}}" class="form-control">
            @if ($errors->has('address'))
            <div class="help-block filled"><div class="parsley-required">{{ $errors->first('address') }}</div></div>
            @endif
          </div>
          <div class="form-group {{$errors->has('upline') ? 'has-error':''}}">
              <label for="upline-list" class="control-label">Upline</label>
              <select id="upline-list" class="form-control select2-searchable" name="upline" {{ (is_null($agent->upline)?'':'disabled') }}>
                @foreach($_agents as $_agent)
                  <option value="{{$_agent->id}}" {{ $_agent->id == $agent->upline? 'selected' : '' }}>{{$_agent->name}}</option>
                @endforeach
              </select>
            @if ($errors->has('upline'))
            <div class="help-block filled"><div class="parsley-required">{{ $errors->first('upline') }}</div></div>
            @endif
          </div>
        </div>
      </div>
      <header class="form__header">
        <h3 data-rel="#form-block-4" class="form__title js-form-title">Bank Account</h3>
      </header>
      <hr>
      <div id="form-block-4" class="form__block js-form-block">
        <div class="row">
          <div class="form-group form-group--social">
            <label for="bank-account-field" class="control-label">Bank Account</label>
            <input id="bank-account-field" type="text" placeholder="Bank Account" name="bank_account" value="{{old('bank_account') ? old('bank_account') : $agent->bank_account}}" class="form-control">
          </div>
          <div class="form-group form-group--social">
            <label for="bank-name-field" class="control-label">Bank Name</label>
            <input id="bank-name-field" type="text" placeholder="Bank Name" name="bank_name" value="{{old('bank_name') ? old('bank_name') : $agent->bank_name}}" class="form-control">
          </div>
          <div class="form-group form-group--social">
            <label for="bank-customer-field" class="control-label">Bank Customer</label>
            <input id="bank-customer-field" type="text" placeholder="Bank Customer" name="bank_customer" value="{{old('bank_customer') ? old('bank_customer') : $agent->bank_customer}}" class="form-control">
          </div>
        </div>
      </div>
      <header class="form__header">
        <h3 data-rel="#form-block-4" class="form__title js-form-title">Photo Profile</h3>
      </header>
      <hr>
      <div id="form-block-4" class="form__block js-form-block">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <label>Foto Profil</label>
            <input id="profilphoto" type="file" class="form-control {{$errors->has('avatar') ? 'is-invalid' : ''}}" name="avatar" value="{{old('avatar') ? old('avatar') : $agent->photo}}">
            @if ($errors->has('avatar'))
            <span class="invalid-feedback">
              <strong>{{ $errors->first('avatar') }}</strong>
            </span>
            @endif
          </div>
          <div class="col-sm-12 col-md-6">
            <label>Preview <small>ukuran sebenarnya</small></label>
            <div>
              <img id="targetphoto" src="{{old('avatar') ? old('avatar') : $agent->photo}}" alt="profilphoto" height="180px" width="180px">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <button class="form__submit">Save changes</button>
      </div>
    </form>
    <hr>
    <form class="form form--flex js-form" method="post" action="{{route('settings.security.update')}}">
      {{csrf_field()}}
      {{method_field('put')}}
      <header class="form__header">
        <h3 data-rel="#form-block-5" class="form__title js-form-title">Change your password</h3>
      </header>
      <div id="form-block-5" class="form__block js-form-block">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="row">
              <div class="form-group {{$errors->has('password_baru') ? 'has-error':''}}">
                <label for="in-15" class="control-label">New Password</label>
                <input type="password" id="in-15" required data-placeholder="---" class="form-control" value="{{old('password_baru')}}" name="password_baru">
                @if ($errors->has('password_baru'))
                <div class="help-block filled"><div class="parsley-required">{{ $errors->first('password_baru') }}</div></div>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="form-group {{$errors->has('password_baru2') ? 'has-error':''}}">
                <label for="in-16" class="control-label">Confirm New Password</label>
                <input type="password" id="in-16" required name="password_baru2" data-placeholder="---" value="{{old('password_baru2')}}" class="form-control">
                @if ($errors->has('password_baru2'))
                <div class="help-block filled"><div class="parsley-required">{{ $errors->first('password_baru2') }}</div></div>
                @endif
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-8">
            <h5>HINT</h5>
            <p>Password hint. A reminder to you of how you made up your password. Some systems let you enter a password hint so that if you forget your password, the hint will be displayed to help jog your memory. For example, if your password is your child's birthday, you might use "Alfred" or "Nicole" as a reminder.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <button class="form__submit">Save password</button>
      </div>
    </form>
  </div>
</div>
@stop

@section('additional-scripts')
<script type="text/javascript">
  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#targetphoto').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#profilphoto").on("change", function () {
    readURL(this);
  });

  $(".select2-searchable").select2({
  width: '100%',
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
@endsection