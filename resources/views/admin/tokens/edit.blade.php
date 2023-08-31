@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Edit Access Token
    </h1>

    <article class="message is-info">
        <div class="message-body">
            {!! __('tokens.edit', ['regenerateLink' => route('admin.tokens.confirm', ['uuid' => $token->uuid, 'action' => 'regenerate'])]) !!}
        </div>
    </article>
    <form method="post" action="{{ route('admin.tokens.update', ['uuid' => $token->uuid, 'action' => 'update']) }}">
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
                    value="{{ $token->name }}" autofocus>
            </div>
            <p class="help is-danger">{{ $errors->first('token_name') }}</p>
        </div>

        <div class="field">
            <label class="label">Expiration date</label>
            <div class="control">
                <input @class(['input', 'is-medium']) type="text"
                    value="{{ $token->expires_at?->isoFormat('MMMM Do, YYYY') ?? 'No Expiry' }}"
                    disabled>
            </div>
        </div>

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Back</a>
                </p>
                <p class="control">
                    <button class="button is-primary is-medium is-responsive" type="submit">Update token</button>
                </p>
            </div>
        </div>
    </form>
@endsection
