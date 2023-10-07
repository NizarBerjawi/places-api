@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        {{ __('tokens.headers.regenerate', ['name' => $token->name]) }}
    </h1>

    @includeWhen(
        !request()->user()->hasWarning(),
        'partials.message',
        [
            'classes' => ['is-warning'],
            'message' => __('tokens.regenerate'),
        ]
    )

    @includeWhen(request()->user()->hasWarning(),
        'partials.message',
        [
            'classes' => ['is-danger'],
            'message' => __('tokens.limit'),
        ]
    )

    <form method="post" action="{{ route('admin.tokens.update', ['uuid' => $token->uuid, 'action' => $action]) }}"
        novalidate>
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label">Token name</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->has('token_name'),
                    'is-medium',
                ]) type="text" name="token_name" placeholder="My token"
                    value="{{ $token->name }}" autofocus disabled>
            </div>
            <p class="help is-danger">{{ $errors->first('token_name') }}</p>
        </div>

        <div class="field">
            @php
                $min = \App\Models\Sanctum\PersonalAccessToken::minExpiry();
                $max = \App\Models\Sanctum\PersonalAccessToken::maxExpiry($subscription);
            @endphp
            <label class="label">Expiration date
                <span title="{{ __('tokens.expiry', ['expiryDuration' => $max->diffForHumans()]) }}"><i
                        class="icon is-small" data-feather="info"></i></span>
            </label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->has('expires_at'),
                    'is-medium',
                ]) min="{{ $min->format('Y-m-d') }}" max="{{ $max->format('Y-m-d') }}"
                    value="{{ old('expires_at', $token->expires_at?->format('Y-m-d')) }}" type="date" name="expires_at"
                    @disabled(request()->user()->hasWarning())>
            </div>
            <p class="help is-danger">{{ $errors->first('expires_at') }}</p>
        </div>

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Cancel</a>
                </p>
                <p class="control">
                    @include('component.button', [
                        'classes' => ['button', 'is-warning', 'is-medium', 'is-responsive'],
                        'type' => 'submit',
                        'label' => 'Regenerate token',
                        'disabled' => request()->user()->hasWarning(),
                    ])
                </p>
            </div>
        </div>
    </form>
@endsection
