
<!doctype html>

    
    <html class="no-js" lang="">
<head>
    @include('layouts.head')
    <title>Confirm Password</title>
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
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf <!-- CSRF token for security -->

                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autofocus autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="btn btn-primary btn-flat m-b-15">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@include('layouts.script')
</body>
