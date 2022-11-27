@extends('layouts.base')

@section('content')
    <section class="hero is-fullheight-with-navbar">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-1">
                    {{ config('app.name') }}
                </h1>
            </div>
        </div>
    </section>
@endsection
