@extends('layouts.admin')

@section('content')
    <section class="block">
        <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
            Change password
        </h1>

        @if (session('status') === \Laravel\Fortify\Fortify::PASSWORD_UPDATED)
            <article class="message is-success">
                <div class="message-body">
                    {{ __('passwords.updated') }}
                </div>
            </article>
        @endif

        <form action="{{ route('user-password.update') }}" method="post">
            @method('PUT')
            @csrf

            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input @class(['input', 'is-danger' => $errors->has('email'), 'is-medium']) type="email" name="email" value={{ auth()->user()->email }}
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
                        'is-medium',
                    ]) type="password" name="current_password" placeholder="********">
                </div>
                <p class="help is-danger">{{ $errors->first('current_password') }}</p>
            </div>

            <div class="field">
                <label class="label">New password</label>
                <div class="control">
                    <input @class([
                        'input',
                        'is-danger' => $errors->has('password'),
                        'is-medium',
                    ]) type="password" name="password" placeholder="********">
                </div>
                <p class="help is-danger">{{ $errors->first('password') }}</p>
            </div>

            <div class="field">
                <label class="label">Confirm new password</label>
                <div class="control">
                    <input @class([
                        'input',
                        'is-danger' => $errors->has('password_confirmation'),
                        'is-medium',
                    ]) type="password" name="password_confirmation" placeholder="********">
                </div>
                <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
            </div>

            <div class="is-flex is-justify-content-flex-end">
                <button class="button is-primary is-medium is-responsive" href="{{ route('password.confirm') }}">Update
                    password</button>
            </div>
        </form>
    </section>
    
    <hr />

    <section class="block">
        <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
            Two-factor authentication

            @if (request()->user()->hasEnabledTwoFactorAuthentication())
                <span class="tag is-success is-small">Enabled</span>
            @else
                <span class="tag is-danger is-small">Disabled</span>
            @endif
        </h1>
        {{-- STEP TWO: ENABLE TWO-FACTOR AUTHENTICATION --}}
        @if (
            !request()->user()->hasEnabledTwoFactorAuthentication() &&
                !in_array(session('status'), ['two-factor-authentication-enabled', 'two-factor-authentication-confirmed']) &&
                empty($errors->confirmTwoFactorAuthentication->first()))
            @if (!session()->has('auth.password_confirmed_at'))
                <article class="message is-info">
                    <div class="message-body">
                        Please confirm your password to be able to <span class="has-text-weight-bold">enable/disable</span>
                        two-factor authentication.
                    </div>
                </article>
            @else
                <article class="message is-success">
                    <div class="message-body">
                        Start configuring two-factor authentication.
                    </div>
                </article>
            @endif

            <form action="{{ route('two-factor.enable') }}" method="post">
                @csrf
                <div class="is-flex is-justify-content-flex-end">
                    <button class="button is-primary is-medium is-responsive">
                        {{ session()->has('auth.password_confirmed_at') ? 'Enable 2FA' : 'Confirm password' }}
                    </button>
                </div>
            </form>
        @endif

        {{-- STEP THREE: SCAN QR CODE AND VERIFY --}}
        @if (session('status') == 'two-factor-authentication-enabled' ||
                !empty($errors->confirmTwoFactorAuthentication->first()))
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
                                'is-danger' => $errors->confirmTwoFactorAuthentication->has('code'),
                                'is-medium',
                                'has-text-centered',
                            ]) type="text" name="code" placeholder="XXXXXX"
                                maxlength="6" autofocus>
                        </div>
                        <p class="help is-danger">
                            {{ $errors->confirmTwoFactorAuthentication->first('code') }}</p>
                    </div>

                    <div class="is-flex is-justify-content-flex-end">
                        <div class="field is-grouped">
                            <p class="control">
                                <button class="button is-primary is-medium is-responsive" type="submit">Verify</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        {{-- STEP FOUR: DISABLE TWO_FACTOR AUTHENTICATION --}}
        @if (request()->user()->hasEnabledTwoFactorAuthentication())
            @if (!session()->has('auth.password_confirmed_at'))
                <article class="message is-info">
                    <div class="message-body">
                        Please confirm your password to be able to <span class="has-text-weight-bold">enable/disable</span>
                        two-factor authentication.
                    </div>
                </article>
            @else
                <article class="message is-success">
                    <div class="message-body">
                        Two-factor authentication is enabled for your account.
                    </div>
                </article>

                <a class="is-size-6 has-text-link" href="{{ route('admin.recovery-codes') }}">Get recovery keys</a>
            @endif
            <div class="mt-4">
                <form action="{{ route('two-factor.disable') }}" method="post">
                    @csrf
                    @method('DELETE')

                    <div class="is-flex is-justify-content-flex-end">
                        <button @class([
                            'button',
                            'is-medium',
                            'is-responsive',
                            'is-danger' => session()->has('auth.password_confirmed_at'),
                            'is-primary' => !session()->has('auth.password_confirmed_at'),
                        ])>
                            {{ session()->has('auth.password_confirmed_at') ? 'Disable 2FA' : 'Confirm password' }}
                        </button>
                    </div>
                </form>
            </div>
        @endif

    </section>
@endsection
