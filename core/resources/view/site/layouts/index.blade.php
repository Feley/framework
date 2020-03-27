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
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </main>
    <footer>
    <h3>Voom Framework</h3>
</footer>
    </body>
</html>
