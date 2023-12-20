<!DOCTYPE html>
<html lang="en">
     
<head>
@include('common.head')
</head>
    <body>
        <!-- Content Wrapper -->
        <div class="login-wrapper">
             
            <div class="container-center lg">
             <div class="login-area">
                <div class="panel panel-bd panel-custom">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Register</h3>
                                <small><strong>Please enter your data to register.</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                      
						<form method="POST" action="{{ route('register') }}">
                        @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>{{ __('Name') }}</label>
                                    
									<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
									
									@error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
									@enderror
									
									
                                </div>
								
								 <div class="form-group col-lg-6">
                                    <label>{{ __('Email Address') }}</label>
                                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
									  
									    @error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									  
									  
                                </div>
								
								
								
                                <div class="form-group col-lg-6">
                                    <label>{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
									@error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
									@enderror
									
                                </div>
								
								
								
                                <div class="form-group col-lg-6">
                                    <label>{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                               
                            </div>
                            <div>
                                
								<button type="submit" class="btn btn-warning">
                                    {{ __('Register') }}
                                </button>
                                <a class="btn btn-add" href="{{ route('login') }}">Login</a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
	
        <script src="{{ asset('assets/plugins/jQuery/jquery-1.12.4.min.js') }}" type="text/javascript"></script> 
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    </body>
 
</html>