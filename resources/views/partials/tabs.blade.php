{{ \Request::route()->getName() }}
<div class="tabs is-centered is-boxed">
    <ul>
        <li @class(['is-active' => Route::is('admin.password')])>
            <a href={{ route('admin.password') }}>
                <i data-feather="key"></i>
                <span>Password</span>
            </a>
        </li>
        <li @class([
            'is-active' =>
                Route::is('admin.authentication') ||
                Route::is('admin.recovery-codes') ||
                Route::is('password.confirm'),
        ])>
            <a href={{ route('admin.authentication') }}>
                <i data-feather="shield"></i>
                <span>Authentication</span>
            </a>
        </li>
        <li @class(['is-active' => Route::is('admin.keys')])>
            <a>
                <i data-feather="key"></i>
                <span>API Keys</span>
            </a>
        </li>
    </ul>
</div>
