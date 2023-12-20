<!DOCTYPE html>
<html lang="en"> 
<head>
@include('common.head') 
</head>
    <body>
        <!-- Content Wrapper -->
        <div class="login-wrapper">
             
            <div class="container-center">
            <div class="login-area">
                <div class="panel panel-bd panel-custom">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Login</h3>
                                <small><strong>Please enter your credentials to login.</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('login') }}">
						 @csrf
                            <div class="form-group">
                                <label class="control-label" for="username">Email</label>
								
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
								 
								
								 @error('email')
                                    <span class="invalid-feedback help-block small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
								
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div> 
								<button type="submit" class="btn btn-add">
                                    {{ __('Login') }}
                                </button>
								
                             <!---   <a class="btn btn-warning" href="{{ route('register') }}">Register</a> ---->
								
								@if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
								
                            </div>
                        </form>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <!-- jQuery -->
		
		
		
		
        <script src="{{ asset('assets/plugins/jQuery/jquery-1.12.4.min.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    </body>

 
</html>