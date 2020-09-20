
<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CoreUI CSS -->
 <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" crossorigin="anonymous">
 <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">

 <title>{{ config('app.name', 'Laravel') }}</title>

 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" defer></script>

 <!-- Fonts -->
 <link rel="dns-prefetch" href="//fonts.gstatic.com">
 <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


 </head>
 <body class="c-app c-dark-theme">

    @include('partials.menu')

    <div class="c-wrapper">
        <header class="px-4 c-header c-header-light c-header-fixed justify-content-end">
            <ul class="c-header-nav d-md-down-none">
                <li class="c-header-nav-item">
                    <a class="c-header-nav-link"  href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}</a>
                </li>
            </ul>
        </header>
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
        </div>
        <footer class="c-footer">
            <div><a href="https://coreui.io">CoreUI</a> © 2020 creativeLabs.</div>
            <div class="mfs-auto">Powered by&nbsp;<a href="https://coreui.io/pro/">CoreUI Pro</a></div>
        </footer>
    </div>
 

 <!-- Optional JavaScript -->
 <!-- Popper.js first, then CoreUI JS -->
 <script src="https://unpkg.com/@popperjs/core@2"></script>
 <script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
 </body>
</html>
