@extends('layouts.admin')

@section('content')
    <h1 class="title">Confirm Password</h1>

    <article class="message is-info">
        <div class="message-body">
            <span class="has-text-weight-bold">Keep your recovery codes safe.</span> These codes are
            the last resort for accessing your account in case you lose your password and second
            factors.
        </div>
    </article>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input @class([
                    'input',
                    'is-danger' => $errors->confirmPassword->has('password'),
                    'is-large',
                ]) type="password" name="password" placeholder="********"
                    {{ $errors->confirmPassword->has('password') ? 'autofocus' : '' }}>
            </div>
            <p class="help is-danger">{{ $errors->confirmPassword->first('password') }}</p>
        </div>

        <div class="is-flex is-justify-content-flex-end">
            <div class="field is-grouped">
                <p class="control">
                    <button class="button is-primary is-large" type="submit">Confirm</button>
                </p>
            </div>
        </div>
    </form>
@endsection
