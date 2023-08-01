@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Access Token
    </h1>

    @if (session()->has('textToken'))
        <article class="message is-warning">
            <div class="message-body">
                Make sure to copy your personal access token now. <span class="has-text-weight-bold">You won’t be able to see
                    it again!</span>
            </div>
        </article>

        <div class="block has-background-white-ter is-flex is-justify-content-space-between is-align-items-center">
            <pre id="token" class="has-text-weight-bold is-size-6-widescreen is-size-6-desktop is-size-7-mobile">{{ session('textToken') }}</pre>
            <div class="copy is-clickable m-2" data-clipboard-target="#token">
                <i class="icon" data-feather="copy"></i>
            </div>
        </div>
    @else
        <div class="buttons has-addons is-centered">
            <a href="{{ route('admin.tokens.edit', ['id' => $token->id]) }}"
                class="button has-text-primary is-normal is-responsive">
                <i class="icon is-small" data-feather="edit"></i>

                <span class="has-text-weight-bold">Edit</span>
            </a>

            <a href="{{ route('admin.tokens.confirm', ['id' => $token->id, 'action' => 'regenerate']) }}"
                class="button has-text-warning is-normal is-responsive">
                <i class="icon is-small" data-feather="refresh-cw"></i>

                <span>Regenerate</span>
            </a>

            <a href="{{ route('admin.tokens.confirm', ['id' => $token->id, 'action' => 'delete']) }}"
                class="button has-text-danger is-normal is-responsive">
                <i class="icon is-small" data-feather="trash-2"></i>

                <span>Delete</span>
            </a>
        </div>

        <div class="block box">
            <div class="is-flex is-justify-content-space-between is-align-items-center">
                <div class="is-size-4-tablet mr-1">
                    {{ $token->name }}
                </div>
                @if ($token->expires_at && $token->expires_at->isBefore(now()))
                    <div class="ml-1">
                        <span class="tag is-danger is-light">Expired</span>
                    </div>
                @endif

            </div>

            <div>
                <div class="is-size-7">
                    <span class="has-text-weight-bold">Created at: </span>
                    {{ $token->created_at->format('Y-m-d') }} at {{ $token->created_at->format('g:i A') }}
                </div>
                <div class="is-size-7"><span class="has-text-weight-bold">Expires at: </span>
                    @if ($token->expires_at)
                        {{ now()->diffForHumans($token->expires_at) }}
                    @else
                        This token has no expiration date.
                    @endif
                </div>
                <div class="is-size-7"><span class="has-text-weight-bold">Last used: </span>
                    @if ($token->last_used_at)
                        Last used {{ $token->last_used_at->diffForHumans() }}
                    @else
                        Never used
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="is-flex is-justify-content-flex-end">
        <div class="field is-grouped">
            <p class="control">
                <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Back</a>
            </p>
        </div>
    </div>
@endsection
