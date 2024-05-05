<!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>@yield('title')</title>
       <script src="{{ asset('js/cookiecheck.js') }}"></script>
       <!--<link href="{{ asset('css/default.css') }}" rel="stylesheet"> -->
       <!-- Additional CSS and meta tags -->
   </head>
   <body>
        <!-- Common header, navigation, or other components -->
        <header>
            @yield('header')
        </header>

       <main>
            @yield('content')
       </main>
       <!-- Common footer, scripts, or other components -->
        <footer>
            @yield('footer')
        </footer>
   </body>
   </html>
