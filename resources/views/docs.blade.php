@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="{{ webpack('documentation', 'css') }}" type="text/css">
@endsection

@section('content')
    <div id='swagger'></div>
@endsection

@section('scripts')
    <script src="{{ webpack('documentation', 'js') }}"></script>
@endsection