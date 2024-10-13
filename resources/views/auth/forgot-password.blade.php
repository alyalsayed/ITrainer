
<!doctype html>

    
    <html class="no-js" lang="">
<head>
    @include('layouts.head')
    <title>Forgot Password</title>
</head>
<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="{{ url('/') }}">
                        <img class="align-content" src="images/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form method="POST" action="{{ route('password.email') }}">
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

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-flat m-b-15">Submit</button>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mt-2" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.scripts')

</body>
