<div class="tabs is-centered is-boxed is-small">
    <ul>
        <li @class(['is-active' => Route::is('admin.tokens*')])>
            <a href="{{ route('admin.tokens.index') }}">
                <i class="icon is-small" data-feather="key"></i>
                <span>Tokens</span>
            </a>
        </li>

        <li @class(['is-active' => Route::is('admin.security.*')])>
            <a href="{{ route('admin.security.index') }}">
                <i class="icon is-small" data-feather="lock"></i>
                <span>Security</span>
            </a>
        </li>

        <li @class([
            'is-active' =>
                Route::is('admin.account*') ||
                request()->is('user/confirm-password'),
        ])>
            <a href="{{ route('admin.account.index') }}">
                <i class="icon is-small" data-feather="shield"></i>
                <span>Account</span>
            </a>
        </li>
    </ul>
</div>