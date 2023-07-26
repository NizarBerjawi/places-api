<div class="tabs is-centered is-boxed">
    <ul>
        <li @class(['is-active' => Route::is('admin.tokens.*')])>
            <a href="{{ route('admin.tokens.index') }}">
                <i data-feather="key"></i>
                <span>API Access Tokens</span>
            </a>
        </li>
        <li @class(['is-active' => Route::is('admin.password')])>
            <a href="{{ route('admin.password') }}">
                <i data-feather="lock"></i>
                <span>Password</span>
            </a>
        </li>
        <li @class([
            'is-active' =>
                Route::is('admin.authentication') ||
                Route::is('admin.recovery-codes') ||
                request()->is('user/confirm-password'),
        ])>
            <a href="{{ route('admin.authentication') }}">
                <i data-feather="shield"></i>
                <span>Authentication</span>
            </a>
        </li>
    </ul>
</div>
