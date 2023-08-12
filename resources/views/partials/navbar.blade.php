<nav class="navbar is-fixed-top">
    <div class="navbar-brand">
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="mainNavbar">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="mainNavbar" class="navbar-menu">
        <div class="navbar-start">
            @if (!request()->routeIs('home'))
                <a class="navbar-item is-size-4" href={{ route('home') }}>
                    <span class="icon-text">
                        <span class="has-text-primary ">
                            <i class="icon is-medium is-clickable" data-feather="arrow-left-circle"></i>
                        </span>
                    </span>
                </a>
            @endif
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    @auth
                        @if (
                            !request()->routeIs('admin.*') &&
                                request()->route()->uri() !== 'user/confirm-password')
                            <a href="{{ home() }}" class="button is-small is-rounded">Dashboard</a>
                        @endif

                        <form method="post" action="/logout">
                            @csrf
                            <button class="button is-primary is-small is-rounded">Log out</button>
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
