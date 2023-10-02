@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        {{ __('tokens.headers.edit') }}
    </h1>

    @includeWhen(!request()->user()->hasWarning(), 'partials.message', [
        'classes' => ['is-info'],
        'message' => __('tokens.edit', [
            'regenerateLink' => route('admin.tokens.confirm', [
                'uuid' => $token->uuid,
                'action' => 'regenerate',
            ]),
        ]),
    ])

    @includeWhen(request()->user()->hasWarning(), 'partials.message', [
        'classes' => ['is-danger'],
        'message' => __('tokens.limit'),
    ])

    <form method="post"
        action="{{ route('admin.tokens.update', [
            'uuid' => $token->uuid,
            'action' => 'update',
        ]) }}">
        @method('PUT')
        @csrf

        <div class="field">
            <label class="label">Token name</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->has('token_name'),
                    'is-medium',
                ]) type="token_name" name="token_name" placeholder="My token"
                    value="{{ $token->name }}" @disabled(request()->user()->hasWarning()) autofocus>
            </div>
            <p class="help is-danger">{{ $errors->first('token_name') }}</p>
        </div>

        <div class="field">
            <label class="label">Expiration date</label>
            <div class="control">
                <input @class(['input', 'is-medium']) type="text"
                    value="{{ $token->expires_at?->isoFormat('MMMM Do, YYYY') ?? 'No Expiry' }}" disabled>
            </div>
        </div>

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Back</a>
                </p>
                <p class="control">
                    @include('component.button', [
                        'classes' => ['button', 'is-primary', 'is-medium', 'is-responsive'],
                        'type' => 'submit',
                        'label' => 'Update token',
                        'disabled' => request()->user()->hasWarning()
                    ])
                </p>
            </div>
        </div>
    </form>
@endsection
