@extends('layouts.admin')

@section('content')
    <h1 class="title">Create API Token</h1>

    <article class="message is-info">
        <div class="message-body">
            <span class="has-text-weight-bold">Personal access tokens function like ordinary OAuth access tokens.</span>
            They can be used to authenticate to the API over Basic Authentication. 
        </div>
    </article>

    <form method="POST" action="{{ route('admin.tokens.create') }}">
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
