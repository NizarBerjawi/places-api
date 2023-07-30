@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Edit Access Token
    </h1>

    <form method="post" action="{{ route('admin.tokens.update', ['id' => $token->id, 'action' => 'update']) }}">
        @method('PUT')
        @csrf

        <div class="field">
            <label class="label">Token name</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->has('token_name'),
                    'is-large',
                ]) type="token_name" name="token_name" placeholder="My token"
                    value="{{ $token->name }}" autofocus>
            </div>
            <p class="help is-danger">{{ $errors->first('token_name') }}</p>
        </div>

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-large is-responsive">Back</a>
                </p>
                <p class="control">
                    <button class="button is-primary is-large is-responsive" type="submit">Update token</button>
                </p>
            </div>
        </div>
    </form>
@endsection
