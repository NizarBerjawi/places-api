<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ webpack('vendor', 'css') }}" type="text/css">

    @yield('styles')
</head>

<body>
    <header>
        @include('partials.navbar')
    </header>

    <main>
        <div class="container">
            <div class="column is-10 is-offset-1">
                @yield('content')
            </div>
        </div>
    </main>

    @yield('scripts')

    <footer class="footer">
        @include('partials.footer')
    </footer>
</body>

</html>
