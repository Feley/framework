<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="@asset('assets/css/style.css')">
    </head>
    <body>
        <main>
        <div class="flex-center position-ref full-height">
                <div class="top-right links">
                    @auth
                        <a href="">Home</a>
                    @else
                        <a href="">Login</a>
                    @endauth
                </div>

            <div class="content">
                <div class="title m-b-md">
                    Voom Framework
                </div>
                 @yield('content')
                <div class="links">
                    <a href="https://netesy.github.io/docs">Docs</a>
                    <a href="https://github.com/netesy/voom">GitHub</a>
                </div>
            </div>
        </div>
    </main>
    <footer>
    <h3>Voom Framework</h3>
</footer>
    </body>
</html>
