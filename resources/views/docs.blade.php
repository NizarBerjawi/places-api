@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="{{ webpack('documentation', 'css') }}" type="text/css">
@endsection

@section('content')
    <div id='swagger'></div>

    <!-- @if (config('app.env') === 'production')
        <img src="https://validator.swagger.io/validator?url={{ url('openApi.json') }}">
    @endif -->
@endsection

@section('scripts')
    <script src="{{ webpack('documentation', 'js') }}"></script>
@endsection