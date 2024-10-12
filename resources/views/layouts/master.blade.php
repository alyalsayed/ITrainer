<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')
   

</head>

<body>
    <aside id="left-panel" class="left-panel">
        @include('layouts.aside')
    </aside>
    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
            @include('layouts.right-header')
        </header>
        @if (session('login_success'))
        <div id="login-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('login_success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    


        
        {{-- <div class="breadcrumbs">
            @yield('breadcrumbs')
        </div> --}}

        <div class="content">
            <div class="animated fadeIn">
                {{-- <div class="row"> --}}
                    @yield('content')
                {{-- </div> --}}
            </div>
        </div>

        <div class="clearfix bg-white"></div>

        {{-- <footer class="site-footer">
            @include('layouts.footer')
        </footer> --}}

    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <!-- Scripts -->
    @include('layouts.scripts')

    @yield('charts')
</body>

</html>