@extends('layouts.admin')

@section('content')
    <h1 class="title">API Token</h1>

    @if (session()->has('textToken'))
        <article class="message is-info">
            <div class="message-body">
                Make sure to copy your personal access token now. <span class="has-text-weight-bold">You won’t be able to see
                    it again!</span>
            </div>
        </article>

        <div class="block">
            <div class="box has-text-centered is-size-6-widescreen has-background-success has-text-white">
                <span class="has-text-weight-bold">{{ session('textToken') }}</span>
            </div>
        </div>
    @else
        <div class="buttons has-addons is-centered">
            <a class="button has-text-primary is-rounded">
                <i class="icon is-small" data-feather="edit"></i>

                <span class="has-text-weight-bold">Edit</span>
            </a>

            <a href="{{ route('admin.tokens.confirm', ['id' => $token->id, 'action' => 'regenerate']) }}"
                class="button has-text-warning is-rounded">
                <i class="icon is-small" data-feather="refresh-cw"></i>

                <span>Regenerate</span>
            </a>

            <a href="{{ route('admin.tokens.confirm', ['id' => $token->id, 'action' => 'delete']) }}"
                class="button has-text-danger is-rounded">
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
                <div class="is-size-7"><span class="has-text-weight-bold">Created at: </span>{{ $token->created_at }}</div>
                <div class="is-size-7"><span class="has-text-weight-bold">Expires at: </span>
                    @if ($token->expires_at)
                        {{ now()->diffForHumans($token->expires_at) }}
                    @else
                        This token has no expiration date.
                    @endif
                </div>
                <div class="is-size-7"><span class="has-text-weight-bold">Last used: </span>
                    @if ($token->last_used_at)
                        Last used {{ now()->diffForHumans($token->last_used_at) }}
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
                <a href={{ route('admin.tokens.index') }} class="button is-large is-responsive">Back</a>
            </p>
        </div>
    </div>
@endsection
