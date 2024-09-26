<!doctype html>
<html class="no-js" lang="">

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

        <div class="breadcrumbs">
            @yield('breadcrumbs')
        </div>

        <div class="content">
            <div class="animated fadeIn">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <footer class="site-footer">
            @include('layouts.footer')
        </footer>

    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <!-- Scripts -->
    @include('layouts.scripts')
    @yield('scripts')
</body>

</html>