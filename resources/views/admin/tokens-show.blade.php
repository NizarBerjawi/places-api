@extends('layouts.admin')

@section('content')
    <h1 class="title">API Token</h1>

    <article class="message is-info">
        <div class="message-body">
            <span class="has-text-weight-bold">This is where you view all your API tokens.</span> These codes are
            the last resort for accessing your account in case you lose your password and second
            factors.
        </div>
    </article>


    @if (session()->has('textToken'))
        <div class="mb-4">
            <div class="box has-text-centered is-size-5-widescreen is-size-6-tablet has-background-primary has-text-white">
                <span class="has-text-weight-bold">{{ session('textToken') }}</span>
            </div>
        </div>
    @endif

    <div class="card is-success">
        {{-- <header class="card-header">
            <p class="card-header-title">
            </p>
        </header> --}}


        <div class="card-content">
            <div class="content">
                <div class="title is-size-4">{{ $token->name }}</div>
                <div class="subtitle is-size-6">{{ $token->created_at }}</div>
                {{-- <div><time class="subtitle is-size-6" datetime="2016-1-1">{{ $token->created_at }}</time></div> --}}
            </div>
        </div>

        <footer class="card-footer">
            <a href="#" class="card-footer-item">Regenerate</a>
            <a href="#" class="card-footer-item">Edit</a>
            <a href="#" class="card-footer-item">Delete</a>
        </footer>
    </div>
    <div>{{ $token->name }}</div>
    <div>{{ $token->created_at }}</div>
    <div>{{ $token->last_used }}</div>
    <div>{{ $token->expires_at }}</div>




    <div class="is-flex is-justify-content-flex-end">
        <div class="field is-grouped">
            <p class="control">
                <a href={{ route('admin.tokens.index') }} class="button is-large is-responsive">Back</a>
            </p>
        </div>
    </div>
@endsection
