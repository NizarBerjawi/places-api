@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Access Token
    </h1>

    @if (session()->has('textToken'))
        <article class="message is-warning">
            <div class="message-body">
                {!! __('tokens.copy') !!}
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
            <a href="{{ route('admin.tokens.edit', ['uuid' => $token->uuid]) }}"
                class="button has-text-primary is-normal is-responsive">
                <i class="icon is-small" data-feather="edit"></i>

                <span class="has-text-weight-bold">Edit</span>
            </a>

            <a href="{{ route('admin.tokens.confirm', ['uuid' => $token->uuid, 'action' => 'regenerate']) }}"
                class="button has-text-warning is-normal is-responsive">
                <i class="icon is-small" data-feather="refresh-cw"></i>

                <span>Regenerate</span>
            </a>

            <a href="{{ route('admin.tokens.confirm', ['uuid' => $token->uuid, 'action' => 'delete']) }}"
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
                        <span class="tag is-danger">Expired {{ $token->expires_at->diffForHumans() }}</span>
                    </div>
                @elseif ($token->expires_at && $token->expires_at->isAfter(now()))
                    <div class="ml-1">
                        <span class="tag is-success">Expires {{ $token->expires_at->diffForHumans() }}</span>
                    </div>
                @else
                    <div class="ml-1">
                        <span class="tag is-warning">No expiry</span>
                    </div>
                @endif

            </div>

            <div>
                <div class="is-size-7">
                    <span class="has-text-weight-bold">Created at: </span>
                    {{ $token->created_at->isoFormat('MMMM Do, YYYY') }} at {{ $token->created_at->format('g:i A') }}
                </div>
                <div class="is-size-7"><span class="has-text-weight-bold">Expires on: </span>
                    @if ($token->expires_at)
                        {{ $token->expires_at->isoFormat('MMMM Do, YYYY') }}
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
