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

    {{-- @if (count(request()->user()->tokens) === 0)
        <p>You have not issued any API tokens yet.</p>
    @endif --}}

    <div class="mb-4">
        @if (count($tokens) === 0)
            <span>You have not issued any tokens yet.</span>
        @else
            @foreach ($tokens as $token)
                <div class="card is-success m-6">
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
            @endforeach
        @endif
    </div>

    <div class="is-flex is-justify-content-flex-end">
        <div class="field is-grouped">
            <div class="control">
                <a href="{{ route('admin.tokens.create') }}" class="button is-primary is-large is-responsive">Issue API
                    Token</a>
            </div>
        </div>
    </div>
@endsection
