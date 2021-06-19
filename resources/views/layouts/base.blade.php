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
            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>

</html>
