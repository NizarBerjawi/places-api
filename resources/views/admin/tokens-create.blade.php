@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Create Access Token
    </h1>

    <form method="post" action="{{ route('admin.tokens.store') }}">
        @csrf

        <div class="field">
            <label class="label">Token name</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->has('token_name'),
                    'is-large',
                ]) type="token_name" name="token_name" placeholder="My token" autofocus>
            </div>
            <p class="help is-danger">{{ $errors->first('token_name') }}</p>
        </div>

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <a href={{ route('admin.tokens.index') }} class="button is-large is-responsive">Back</a>
                </p>
                <p class="control">
                    <button class="button is-primary is-large is-responsive" type="submit">Create token</button>
                </p>
            </div>
        </div>
    </form>
@endsection
