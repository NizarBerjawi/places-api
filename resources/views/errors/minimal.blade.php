<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ webpack('vendor', 'css') }}" type="text/css">

    @yield('styles')
</head>

<body>
    <main>
        <section class="hero is-fullheight-with-navbar">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h1 class="title is-size-1">
                        @yield('code')
                    </h1>

                    <p class="subtitle">
                        <i class="icon is-small" data-feather="terminal"></i>
                        @yield('message')
                    </p>

                    <div class="field is-grouped is-justify-content-center">
                        <p class="control">
                            <a href="{{ home() }}" class="button is-medium is-responsive">
                                Back
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ webpack('app', 'js') }}"></script>
</body>

</html>
