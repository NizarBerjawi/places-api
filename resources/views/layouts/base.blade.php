<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ webpack('vendor', 'css') }}" type="text/css">

    @yield('styles')

    <style>
        .github-ribbon {
            position: fixed;
            right: 0px;
            width: 150px;
            height: 150px;
            overflow: hidden;
            z-index: 99999;
            bottom: 0px;
        }

        .github-ribbon a {
            display: inline-block;
            width: 200px;
            overflow: hidden;
            padding: 6px 0px;
            text-align: center;
            transform: rotate(-45deg);
            text-decoration: none;
            color: rgb(255, 255, 255);
            position: inherit;
            right: -40px;
            border-width: 1px 0px;
            border-style: dotted;
            border-color: rgba(255, 255, 255, 0.7);
            font: 700 13px "Helvetica Neue", Helvetica, Arial, sans-serif;
            box-shadow: rgba(0, 0, 0, 0.5) 0px 2px 3px 0px;
            background-color: rgb(170, 0, 0);
            background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.15));
            bottom: 45px;
        }

    </style>
</head>

<body>
    <header>
        @include('partials.navbar')
    </header>


    <main>

        <div class="container">
            <section class="section">

                <div class="columns">

                    <div class="column is-10 is-offset-1">
                        <div class="content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @yield('scripts')

    <div class="github-ribbon">
        <a target="_blank" href="{{ env('GITHUB_URL') }}">Fork me on GitHub</a>
    </div>
</body>

</html>
