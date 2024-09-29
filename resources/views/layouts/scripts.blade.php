<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
{{-- <script src="//js.pusher.com/7.0/pusher.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.2/echo.iife.min.js"></script> --}}

@vite('resources/js/app.js')

<script src="{{ asset('assets/js/main.js') }}"></script>
{{-- <script src="{{ resource_path('js/app.js') }}"></script> --}}

<!-- Include Prism.js for code syntax highlighting -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Highlight all code blocks on page load
        hljs.highlightAll();
    });
  
</script>
