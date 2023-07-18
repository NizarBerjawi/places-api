@extends('layouts.admin')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-6 is-offset-3">
                        @include('partials.tabs')

                        <section>
                            <h1>Change password</h1>

                            <form action="{{ route('user-password.update') }}" method="post">
                                @method('PUT')
                                @csrf

                                <div class="field">
                                    <label class="label">Email</label>
                                    <div class="control">
                                        <input @class(['input', 'is-danger' => $errors->has('email'), 'is-large']) type="email" name="email"
                                            value={{ auth()->user()->email }} disabled>
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
                                        ]) type="password" name="current_password"
                                            placeholder="********">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('current_password') }}</p>
                                </div>

                                <div class="field">
                                    <label class="label">New password</label>
                                    <div class="control">
                                        <input @class(['input', 'is-danger' => $errors->has('password'), 'is-large']) type="password" name="password"
                                            placeholder="********">
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
                                        ]) type="password" name="password_confirmation"
                                            placeholder="********">
                                    </div>
                                    <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                </div>

                                <div class="is-flex is-justify-content-flex-end">
                                    <button class="button is-primary is-large" href="{{ route('password.confirm') }}">Update
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

                        <hr />

                        <section>
                            <h1 class="title">Two-factor authentication</h1>

                            @if (!session()->has('auth.password_confirmed_at'))
                                <article class="message is-info">
                                    <div class="message-body">
                                        Please confirm your password to be able to enable two-factor authentication
                                    </div>
                                </article>

                                <form method="POST" action="{{ route('password.confirm') }}">
                                    @csrf

                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input @class(['input', 'is-danger' => $errors->has('password'), 'is-large']) type="password" name="password"
                                                placeholder="********">
                                        </div>
                                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                                    </div>

                                    <div class="is-flex is-justify-content-flex-end">
                                        <div class="field is-grouped">
                                            <p class="control">
                                                <button class="button is-primary is-large" type="submit">Confirm</button>
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            @endif

                            @if (session()->has('auth.password_confirmed_at') &&
                                    !in_array(session('status'), ['two-factor-authentication-enabled', 'two-factor-authentication-confirmed']))
                                <article class="message is-success">
                                    <div class="message-body">
                                        Start configuring two-factor authentication.
                                    </div>
                                </article>

                                <form action="{{ route('two-factor.enable') }}" method="post">
                                    @csrf
                                    <button class="button is-primary is-large">Enable 2FA</button>
                                </form>
                            @endif


                            @if (session('status') == 'two-factor-authentication-enabled')
                                <article class="message is-warning">
                                    <div class="message-body">
                                        You can finish configuring two factor authentication by scanning the below QR code
                                        using your preferred authenticator app.
                                    </div>
                                </article>

                                <div class="is-flex is-justify-content-center">
                                    {!! request()->user()->twoFactorQrCodeSvg() !!}
                                </div>

                                <div class="mt-4">
                                    <form action="{{ route('two-factor.confirm') }}" method="post">
                                        @csrf

                                        <div class="field">
                                            <label class="label">Authentication code</label>
                                            <div class="control">
                                                <input @class([
                                                    'input',
                                                    'is-danger' => $errors->has('code'),
                                                    'is-large',
                                                    'has-text-centered',
                                                ]) type="text" name="code"
                                                    placeholder="XXXXXX" maxlength="6">
                                            </div>
                                            <p class="help is-danger">{{ $errors->first('password') }}</p>
                                        </div>

                                        <div class="is-flex is-justify-content-flex-end">
                                            <div class="field is-grouped">
                                                <p class="control">
                                                    <button class="button is-primary is-large"
                                                        type="submit">Verify</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            @if (session('status') == 'two-factor-authentication-confirmed')
                                <article class="message is-success">
                                    <div class="message-body">
                                        Two factor authentication confirmed and enabled successfully.
                                    </div>
                                </article>

                                <form action="{{ route('two-factor.disable') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    
                                    <button class="button is-primary is-large">Disable 2FA</button>
                                </form>
                            @endif

                        </section>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
