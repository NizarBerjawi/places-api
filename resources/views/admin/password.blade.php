@extends('layouts.admin')

@section('content')
    <section>
        <h1 class="title">Change password</h1>

        <form action="{{ route('user-password.update') }}" method="post">
            @method('PUT')
            @csrf

            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input @class(['input', 'is-danger' => $errors->has('email'), 'is-large']) type="email" name="email" value={{ auth()->user()->email }}
                        disabled>
                </div>
                <p class="help is-danger">{{ $errors->first('email') }}</p>
            </div>

            <div class="field">
                <label class="label">Current password</label>
                <div class="control">
                    <input @class([
                        'input',
                        'is-danger' => $errors->has('current_password'),
                        'is-large',
                    ]) type="password" name="current_password" placeholder="********">
                </div>
                <p class="help is-danger">{{ $errors->first('current_password') }}</p>
            </div>

            <div class="field">
                <label class="label">New password</label>
                <div class="control">
                    <input @class(['input', 'is-danger' => $errors->has('password'), 'is-large']) type="password" name="password" placeholder="********">
                </div>
                <p class="help is-danger">{{ $errors->first('password') }}</p>
            </div>

            <div class="field">
                <label class="label">Confirm new password</label>
                <div class="control">
                    <input @class([
                        'input',
                        'is-danger' => $errors->has('password_confirmation'),
                        'is-large',
                    ]) type="password" name="password_confirmation" placeholder="********">
                </div>
                <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
            </div>

            <div class="is-flex is-justify-content-flex-end">
                <button class="button is-primary is-large is-responsive" href="{{ route('password.confirm') }}">Update
                    password</button>
            </div>
        </form>

        @if (session('status') === \Laravel\Fortify\Fortify::PASSWORD_UPDATED)
            <article class="message is-success mt-4">
                <div class="message-body">
                    {{ __('passwords.updated') }}
                </div>
            </article>
        @endif
    </section>
@endsection
