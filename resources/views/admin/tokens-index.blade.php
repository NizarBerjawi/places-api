@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Access Tokens
    </h1>

    <article class="message is-info">
        <div class="message-body">
            <span class="has-text-weight-bold">Personal access tokens function like ordinary OAuth access tokens.</span>
            They can be used to authenticate to the API over Basic Authentication.
        </div>
    </article>

    <div class="block">
        @if (count($tokens) === 0)
            <span>You have not issued any tokens yet.</span>
        @else
            @foreach ($tokens as $token)
                <div class="card is-success mb-4">
                    <div class="card-content">
                        <div class="content">
                            <div class="is-flex is-justify-content-space-between">
                                <div>
                                    <div class="title is-size-4">
                                        <a href="{{ route('admin.tokens.show', $token->id) }}">{{ $token->name }}</a>

                                        <a
                                            href="{{ route('admin.tokens.confirm', ['id' => $token->id, 'action' => 'regenerate']) }}">
                                            <span class="icon is-clickable">
                                                <i class="icon is-small" data-feather="refresh-cw"></i>
                                            </span>
                                        </a>
                                    </div>
                                    @if ($token->last_used_at)
                                        <div class="subtitle is-size-6">
                                            Last used {{ $token->last_used_at->diffForHumans() }}
                                        </div>
                                    @else
                                        <div class="subtitle is-size-6">Never used</div>
                                    @endif
                                </div>

                                <div class="is-flex is-align-content-center is-flex-wrap-wrap">
                                    <a href="{{ route('admin.tokens.confirm', ['id' => $token->id, 'action' => 'delete']) }}"
                                        class="button is-small is-danger is-light">
                                        <i class="icon is-small" data-feather="trash-2"></i>
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
                <a href="{{ route('admin.tokens.create') }}" class="button is-primary is-large is-responsive">Issue access
                    token</a>
            </div>
        </div>
    </div>
@endsection
