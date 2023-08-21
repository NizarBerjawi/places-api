@extends('layouts.base')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-size-1">
                    {{ config('app.name') }}
                </h1>

                <div class="field is-grouped is-justify-content-center">
                    <p class="control">
                        <a href="{{ route('gettingStarted') }}" class="button is-medium is-responsive">
                            Getting Started
                        </a>
                    </p>
                    <p class="control">
                        <a href="{{ route('docs') }}" class="button is-medium is-primary is-responsive">
                            API Reference
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
