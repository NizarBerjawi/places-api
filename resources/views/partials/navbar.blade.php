<nav class="navbar">
    <div class="navbar-brand">
        @if (!request()->routeIs('home'))
            <a class="navbar-item is-size-4" href={{ route('home') }}>
                <span class="icon-text">
                    <span class="has-text-primary ">
                        <i class="icon is-medium is-clickable" data-feather="home"></i>
                    </span>
                </span>
            </a>
        @endif

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="mainNavbar">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="mainNavbar" class="navbar-menu">
        @if (Auth::check() && Route::is('admin.*'))
            <div class="navbar-start">

                <a href="{{ route('admin.tokens.index') }}" @class([
                    'is-active' => Route::is('admin.tokens*'),
                    'navbar-item',
                    'icon-text',
                ])>
                    <span>Tokens</span>
                </a>

                <a href="{{ route('admin.security.index') }}" @class([
                    'is-active' =>
                        Route::is('admin.security.*') ||
                        (isset($intended) && $intended === route('admin.security.index')),
                    'navbar-item',
                    'icon-text',
                ])>
                    <span>Security</span>
                </a>

                <a href="{{ route('admin.account.index') }}" @class([
                    'is-active' =>
                        Route::is('admin.account.*') ||
                        (isset($intended) &&
                            $intended ===
                                route('admin.account.confirm', [
                                    'id' => request()->user()->id,
                                    'action' => 'delete',
                                ])),
                    'navbar-item',
                    'icon-text',
                ])>
                    <span>Account</span>
                </a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        API
                    </a>

                    <div class="navbar-dropdown">
                        <a href="{{ route('admin.api.gettingStarted') }}" @class([
                            'is-active' => Route::is('admin.api.gettingStarted'),
                            'navbar-item',
                            'icon-text',
                        ])>
                            <span>Getting Started</span>
                        </a>

                        <a href="{{ route('admin.api.docs') }}" @class([
                            'is-active' => Route::is('admin.api.docs'),
                            'navbar-item',
                            'icon-text',
                        ])>
                            <span>API Reference</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    @auth
                        @if (request()->user()->hasVerifiedEmail() &&
                            !request()->routeIs('admin.*') &&
                                request()->route()->uri() !== 'user/confirm-password')
                            <a href="{{ home() }}" class="button is-small is-rounded">Dashboard</a>
                        @endif

                        <form method="post" action="/logout">
                            @csrf
                            @include('component.button', [
                                'classes' => ['button', 'is-primary', 'is-small', 'is-responsive', 'is-rounded'],
                                'type' => 'submit',
                                'label' => 'Log out'
                            ])
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="button is-small is-rounded">Log in</a>
                        <a href="{{ route('register') }}" class="button is-primary is-small is-rounded">Register</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>
