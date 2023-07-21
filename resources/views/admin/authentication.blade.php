@extends('layouts.admin')

@section('content')
    <section>
        <h1 class="title">Two-factor authentication</h1>

        {{-- STEP ONE: CONFIRM PASSWORD --}}
        {{-- @if (!session()->has('auth.password_confirmed_at'))
            <article class="message is-info">
                <div class="message-body">
                    Please confirm your password to be able to <span class="has-text-weight-bold">enable/disable</span>
                    two-factor authentication.
                </div>
            </article>

            <div class="is-flex is-justify-content-flex-end">
                <a href="{{ route('password.confirm') }}" class="button is-primary is-large" type="submit">Confirm</a>
            </div>
        @endif --}}

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
                    <button class="button is-primary is-large">
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
                                'is-large',
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
                                <button class="button is-primary is-large" type="submit">Verify</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        {{-- STEP FOUR: DISABLE TWO_FACTOR AUTHENTICATION --}}
        @if (session()->has('auth.password_confirmed_at') &&
                request()->user()->hasEnabledTwoFactorAuthentication())
            <article class="message is-success">
                <div class="message-body">
                    Two-factor authentication is enabled for your account.
                </div>
            </article>

            <a class="is-size-6 has-text-link" href="{{ route('admin.recovery-codes') }}">Get recovery keys</a>

            <div class="mt-4">
                <form action="{{ route('two-factor.disable') }}" method="post">
                    @csrf
                    @method('delete')

                    <div class="is-flex is-justify-content-flex-end">
                        <button class="button is-large is-warning">Disable 2FA</button>
                    </div>
                </form>
            </div>
        @endif

    </section>
@endsection
