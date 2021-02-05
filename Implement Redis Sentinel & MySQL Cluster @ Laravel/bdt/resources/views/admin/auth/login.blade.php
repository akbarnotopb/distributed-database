<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="CoreUI Bootstrap 4 Admin Template">
  <meta name="author" content="Lukasz Holeczek">
  <meta name="keyword" content="CoreUI Bootstrap 4 Admin Template">
  <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

  <title>Admin</title>

  <!-- Icons -->
  <link href="{{url('assets/node_modules/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
  <link href="{{url('assets/node_modules/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{url('assets/node_modules/simple-line-icons/css/simple-line-icons.css')}}" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="{{url('assets/css/style.css')}}" rel="stylesheet">

  <!-- Styles required by this views -->

</head>
<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">
              <form method="POST" action="{{ route('admin.auth.login') }}">
                @csrf
                <h1>Login</h1>
                <p class="text-muted">Sign In to your account</p>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-user"></i></span>
                  </div>
                  <input name="username" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-lock"></i></span>
                  </div>
                  <input name="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                  </label>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button type="submit" class="btn btn-primary px-4">Login</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>