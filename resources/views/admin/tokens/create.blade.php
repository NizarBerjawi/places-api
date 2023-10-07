@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        {{ __('tokens.headers.create') }}
    </h1>

    @includeWhen(request()->user()->hasWarning(),
        'partials.message',
        [
            'classes' => ['is-danger'],
            'message' => __('tokens.limit'),
        ]
    )

    @if ($errors->has('token_count'))
        @includeWhen(
            !request()->user()->hasWarning(),
            'partials.message',
            [
                'classes' => ['is-danger'],
                'message' => $errors->first('token_count'),
            ]
        )
    @endif

    <form method="post" action="{{ route('admin.tokens.store') }}" novalidate>
        @csrf
        <div class="block">
            <div class="field">
                <label class="label">Token name</label>
                <div class="control">
                    <input @class([
                        'input',
                        'is-danger' => $errors->has('token_name'),
                        'is-medium',
                    ]) type="text" name="token_name" placeholder="My token"
                        value="{{ old('token_name') }}" @disabled(request()->user()->hasWarning()) autofocus>
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
                        type="date" name="expires_at" value="{{ old('expires_at') }}" @disabled(request()->user()->hasWarning())>
                </div>
                <p class="help is-danger">{{ $errors->first('expires_at') }}</p>
            </div>
        </div>

        <div class="is-flex is-justify-content-flex-end is-align-items-center">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Cancel</a>
                </p>
                <p class="control">
                    @include('component.button', [
                        'classes' => ['button', 'is-primary', 'is-medium', 'is-responsive'],
                        'label' => 'Continue',
                        'disabled' => request()->user()->hasWarning(),
                    ])
                </p>
            </div>
        </div>
    </form>
@endsection
