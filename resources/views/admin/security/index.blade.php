@extends('layouts.admin')

@section('content')
    <section class="block">
        @include('admin.partials.password')
    </section>
    
    <hr />

    <section class="block">
        @include('admin.partials.two-factor-auth')
    </section>
@endsection
