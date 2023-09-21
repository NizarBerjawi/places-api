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
        !in_array(session('status'), [
            \Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED,
            \Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_CONFIRMED,
        ]) &&
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
        <input type="hidden" name="two-factor">
        <div class="is-flex is-justify-content-flex-end">
            @include('component.button', [
                'classes' => ['button', 'is-primary', 'is-medium', 'is-responsive'],
                'type' => 'submit',
                'label' => session()->has('auth.password_confirmed_at') ? 'Enable 2FA' : 'Confirm password',
            ])
        </div>
    </form>
@endif

{{-- STEP THREE: SCAN QR CODE AND VERIFY --}}
@if (session('status') == \Laravel\Fortify\Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED ||
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
                        @include('component.button', [
                            'classes' => ['button', 'is-primary', 'is-medium', 'is-responsive'],
                            'type' => 'submit',
                            'label' => 'Verify',
                        ])
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

        <a class="is-size-6 has-text-link" href="{{ route('admin.security.recovery-codes') }}">Get recovery keys</a>
    @endif
    <div class="mt-4">
        <form action="{{ route('two-factor.disable') }}" method="post">
            @csrf
            @method('DELETE')

            <div class="is-flex is-justify-content-flex-end">
                @include('component.button', [
                    'classes' => [
                        'button',
                        'is-medium',
                        'is-responsive',
                        'is-danger' => session()->has('auth.password_confirmed_at'),
                        'is-primary' => !session()->has('auth.password_confirmed_at'),
                    ],
                    'type' => 'submit',
                    'label' => session()->has('auth.password_confirmed_at') ? 'Disable 2FA' : 'Confirm password'
                ])
            </div>
        </form>
    </div>
@endif
