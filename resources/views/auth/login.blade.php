<!doctype html>
<html class="no-js" lang=""> 
<head>
@include('layouts.head')
<title>Login</title>
</head>

<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                
                <div class="login-form">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf <!-- CSRF token for security -->

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                            <label class="pull-right">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Forgotten Password?</a>
                                @endif
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>

                        <!-- Register Link -->
                        <div class="register-link m-t-15 text-center">
                            <p>Don't have an account? <a href="{{ route('register') }}"> Sign Up Here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.scripts')
</body>

</html>

