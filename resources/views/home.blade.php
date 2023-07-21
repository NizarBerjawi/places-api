@extends('layouts.base')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-size-1">
                    {{ config('app.name') }}
                </h1>
                
                <a href="{{ route('intro') }}" class="button is-large">
                    Introduction
                </a>

                <a href="{{ route('docs') }}" class="button is-large is-primary">
                    API Reference
                </a>
            </div>
        </div>
    </section>
@endsection
