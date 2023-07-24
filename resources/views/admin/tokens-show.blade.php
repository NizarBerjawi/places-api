@extends('layouts.admin')

@section('content')
    <h1 class="title">API Tokens</h1>

    <article class="message is-info">
        <div class="message-body">
            <span class="has-text-weight-bold">This is where you view all your API tokens.</span> These codes are
            the last resort for accessing your account in case you lose your password and second
            factors.
        </div>
    </article>


    <div class="mb-4">
        <div class="box has-text-centered is-size-5-widescreen is-size-6-tablet has-background-link has-text-white">
            <span class="has-text-weight-bold">{{ session('textToken') }}</span>
        </div>
    </div>

    <div class="is-flex is-justify-content-flex-end">
        <div class="field is-grouped">
            <p class="control">
                <a href={{ route('admin.tokens.index') }} class="button is-large is-responsive">Back</a>
            </p>
        </div>
    </div>
@endsection
