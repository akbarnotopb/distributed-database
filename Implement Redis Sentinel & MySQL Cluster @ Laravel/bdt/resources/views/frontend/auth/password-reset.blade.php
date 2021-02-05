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
          <h2 class="site__headline">Masukkan password baru anda!</h2>
        </header>
        <div class="site__main">
          <div class="widget js-widget widget--main widget--no-border ">
            <div class="widget__content">
              <div class="auth auth--inline">
                <div class="auth__wrap auth__wrap--restore" style="width: 300px">
                  <h5 class="auth__title">Reset password</h5>
                  <form action="{{ route('agents.auth.reset-process') }}" class="form form--flex form--auth form--restore js-restore-form js-parsley" method="POST">
                  	@csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="row">
                      <div class="form-group">
                        <label for="restore-email-inline" class="control-label">Password</label>
                        <input type="password" name="password" id="restore-email-inline" required class="form-control">
                        @if ($errors->has('password'))
                        <div class="help-block filled" id="parsley-id-9"><div class="parsley-required">{{ $errors->first('password') }}</div></div>
                        @endif
                      </div>
                    </div>
                      <div class="row">
                      <div class="form-group">
                        <label for="restore-email-inline" class="control-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="restore-email-inline" required class="form-control">
                        @if ($errors->has('password_confirmation'))
                        <div class="help-block filled" id="parsley-id-9"><div class="parsley-required">{{ $errors->first('password_confirmation') }}</div></div>
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