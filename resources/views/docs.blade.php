@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="{{ webpack('documentation', 'css') }}" type="text/css">
@endsection

@section('content')
    <div id='swagger'></div>

    @if (config('app.env') === 'production')
        <article class="media is-justify-content-flex-end">
            <figure class="media-left">
                <p class="image ">
                    <img src="https://validator.swagger.io/validator?url={{ url('openApi.json') }}">
                </p>
            </figure>
        </article>
    @endif
@endsection

@section('scripts')
    <script src="{{ webpack('documentation', 'js') }}"></script>
@endsection
