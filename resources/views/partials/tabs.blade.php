<div class="tabs is-centered is-boxed is-small">
    <ul>
        <li @class(['is-active' => Route::is('admin.tokens.*')])>
            <a href="{{ route('admin.tokens.index') }}">
                <i class="icon is-small" data-feather="key"></i>
                <span>Tokens</span>
            </a>
        </li>

        <li @class(['is-active' => Route::is('admin.password')])>
            <a href="{{ route('admin.password') }}">
                <i class="icon is-small" data-feather="lock"></i>
                <span>Security</span>
            </a>
        </li>

        <li @class([
            'is-active' =>
                Route::is('admin.account') ||
                Route::is('admin.recovery-codes') ||
                request()->is('user/confirm-password'),
        ])>
            <a href="{{ route('admin.account') }}">
                <i class="icon is-small" data-feather="shield"></i>
                <span>Account</span>
            </a>
        </li>
    </ul>
</div>