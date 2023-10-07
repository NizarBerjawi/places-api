@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        {{ __('tokens.headers.index') }}
    </h1>

    @includeWhen(!request()->user()->hasWarning(), 'partials.message', [
        'classes' => ['is-info'],
        'message' => __('tokens.index')
    ])
    
    @includeWhen(request()->user()->hasWarning(), 'partials.message', [
        'classes' => ['is-danger'],
        'message' => __('tokens.limit')
    ])

    <div class="block">
        @if (count($tokens) === 0)
            <span>You have not issued any tokens yet.</span>
        @else
            @foreach ($tokens as $token)
                <div class="card block">
                    <div class="card-content">
                        <div class="content">
                            <div class="is-flex is-justify-content-space-between">
                                <div>
                                    <div class="title is-size-4">
                                        <a href="{{ route('admin.tokens.show', $token->uuid) }}">{{ $token->name }}</a>
                                    </div>
                                    @if ($token->last_used_at)
                                        <div class="subtitle is-size-6">
                                            Last used {{ $token->last_used_at->diffForHumans() }}
                                        </div>
                                    @else
                                        <div class="subtitle is-size-6">Never used</div>
                                    @endif
                                </div>


                                @if (!$token->trashed())
                                    @if ($token->expired())
                                        <div class="ml-1">
                                            <span class="tag is-danger">Expired</span>
                                        </div>
                                    @elseif($token->forever())
                                        <div class="ml-1">
                                            <span class="tag is-warning">No expiry</span>
                                        </div>
                                    @elseif ($token->active())
                                        <div class="ml-1">
                                            <span class="tag is-success">Expires
                                                {{ $token->expires_at->diffForHumans(['parts' => 2]) }}
                                            </span>
                                        </div>
                                    @endif
                                @else
                                    <div class="ml-1">
                                        <span class="tag is-danger">Deleted</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $tokens->links('partials.pagination') }}
        @endif
    </div>

    <div class="is-flex is-justify-content-flex-end">
        <div class="field is-grouped">
            <div class="control">
                @include('component.link', [
                    'classes' => ['button', 'is-primary', 'is-medium', 'is-responsive'],
                    'href' => !request()->user()->hasWarning() ? route('admin.tokens.create') : null,
                    'label' => 'Generate access token',
                    'disabled' => request()->user()->hasWarning()
                ])
            </div>
        </div>
    </div>
@endsection
