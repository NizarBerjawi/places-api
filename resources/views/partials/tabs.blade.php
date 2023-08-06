<div class="tabs is-centered is-boxed is-small">
    <ul>
        <li @class(['is-active' => Route::is('admin.tokens*')])>
            <a href="{{ route('admin.tokens.index') }}">
                <i class="icon is-small" data-feather="key"></i>
                <span>Tokens</span>
            </a>
        </li>

        <li @class([
            'is-active' => Route::is('admin.security.*') || (isset($intended) && $intended === route('admin.security.index'))
        ])>
            <a href="{{ route('admin.security.index') }}">
                <i class="icon is-small" data-feather="lock"></i>
                <span>Security</span>
            </a>
        </li>

        <li @class([
            'is-active' =>
                Route::is('admin.account.*') || (isset($intended) && $intended === route('admin.account.confirm', ['id' => request()->user()->id, 'action' => 'delete'])),
        ])>
            <a href="{{ route('admin.account.index') }}">
                <i class="icon is-small" data-feather="user"></i>
                <span>Account</span>
            </a>
        </li>
    </ul>
</div>