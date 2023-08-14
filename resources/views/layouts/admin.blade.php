<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ webpack('app', 'css') }}" type="text/css">
    <link rel="stylesheet" href="{{ webpack('vendor', 'css') }}" type="text/css">

    @yield('styles')
</head>

<body>
    <header>
        @include('partials.navbar')
    </header>

    <main>
        <div class="container">
            <section class="section mt-2">
                @include('partials.tabs')
            </section>

            <section class="section">
                <div class="columns">
                    <div class="column is-6 is-offset-3">
                        @yield('content')
                    </div>
                </div>
            </section>
        </div>
    </main>

    @yield('scripts')

    {{-- <div class="github-ribbon">
        <a target="_blank" href="{{ env('GITHUB_URL') }}">Fork me on GitHub</a>
    </div> --}}

    <script src="{{ webpack('app', 'js') }}"></script>
</body>

</html>
