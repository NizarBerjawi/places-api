@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Create Token
    </h1>

    <form method="post" action="{{ route('admin.tokens.store') }}">
        @csrf

        <div class="field">
            <label class="label">Token name</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->has('token_name'),
                    'is-medium',
                ]) type="text" name="token_name" placeholder="My token"
                    value="{{ old('token_name') }}" autofocus>
            </div>
            <p class="help is-danger">{{ $errors->first('token_name') }}</p>
        </div>

        <div class="field">
            <label class="label">Expiration date</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->has('expires_at'),
                    'is-medium',
                ]) min="{{ \Illuminate\Support\Carbon::tomorrow()->format('Y-m-d') }}"
                    type="date" name="expires_at" value="{{ old('expires_at') }}">
            </div>
            <p class="help">{{ __('tokens.expiry') }}</p>
            <p class="help is-danger">{{ $errors->first('expires_at') }}</p>
        </div>

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-medium is-responsive">Back</a>
                </p>
                <p class="control">
                    <button class="button is-primary is-medium is-responsive" type="submit">Generate token</button>
                </p>
            </div>
        </div>
    </form>
@endsection
