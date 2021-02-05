@extends('frontend.layout')

@section('additional-styles')
	<style type="text/css">
		.box{
			height: 100vh;
			background: #f6f6f6;
		}

		.success-footer{
			font-size: 12px;
		}

		.success-notif{
			font-weight: bold;
		}

		.auth__title{
			font-size: 20px;
		}
	</style>
@endsection

@section('content')

<div class="center">
  <div class="container">
    <div class="row">
      <section class="site" style="float:unset;">
        <header class="site__header">
          <h1 class="site__title">Restore</h1>
          <h2 class="site__headline">Enter your  Email to restore your password</h2>
        </header>
        <div class="site__main">
          <div class="widget js-widget widget--main widget--no-border ">
            <div class="widget__content">
              <div class="auth auth--inline">
                <div class="auth__wrap auth__wrap--restore" style="width: 300px">
                  <!-- BEGIN AUTH RESTORE-->
                  @if(isset($success))
                  <h5 class="auth__title">Sukses</h5>
                  <p class="success-notif">Sebuah link telah dikirimkan ke akun {{  $success }}!</p>
                  <p class="success-footer">Cobalah untuk mengecek spam apabila tidak menemukannya. Tidak ada? <a href="{{ route('agents.auth.restore') }}">Kirim ulang</a></p>
                  @else
                  <h5 class="auth__title">Reset password</h5>
                  <form action="{{ route('agents.auth.restore-process') }}" class="form form--flex form--auth form--restore js-restore-form js-parsley" method="post">
                  	@csrf
                    <div class="row">
                      <div class="form-group">
                        <label for="restore-email-inline" class="control-label">Enter your Email</label>
                        <input type="email" name="email" id="restore-email-inline" required class="form-control">
                        @if ($errors->has('email'))
                        <div class="help-block filled" id="parsley-id-9"><div class="parsley-required">{{ $errors->first('email') }}</div></div>
                        @endif
                      </div>
                    </div>
                    <div class="row">
                      <button type="submit" class="form__submit">Reset password</button>
                    </div>
                    <div class="row">
                      <div class="form__options">Back to<a href="{{ route('agents.auth.login') }}">Log In</a>or<a href="{{ route('agents.auth.register') }}">Registration</a>
                      </div>
                      <!-- end of block .auth__links-->
                    </div>
                  </form>
                  <!-- end of block .auth__form-->
                  <!-- END AUTH RESTORE-->
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

@endsection