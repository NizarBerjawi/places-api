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

    <div class="section">
        @if (count($tokens) === 0)
            <span>You have not issued any tokens yet.</span>
        @else
            @foreach ($tokens as $token)
                <div class="card is-success mb-4">
                    <div class="card-content">
                        <div class="content">
                            <div class="is-flex is-justify-content-space-between">
                                <div>
                                    <div class="title is-size-4"><a href="#">{{ $token->name }}</a></div>
                                    @if ($token->last_used_at)
                                        <div class="subtitle is-size-6">
                                            Last used {{ now()->diffForHumans($token->last_used_at) }}
                                        </div>
                                    @else
                                        <div class="subtitle is-size-6">Never used</div>
                                    @endif
                                </div>

                                <div class="is-flex is-align-content-center is-flex-wrap-wrap">
                                    <a href="{{ route('admin.tokens.destroy.confirm', $token->id) }}" class="button is-small">
                                        <span class="icon has-text-danger">
                                            <i data-feather="trash-2"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
