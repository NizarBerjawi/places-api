<nav class="navbar">
    <div class="navbar-brand">
        <a class="navbar-item is-size-4" href={{ route('home') }}>
            Places API
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a href={{ route('intro') }} class="navbar-item {{ request()->routeIs('intro') ? 'is-active' : '' }}">
                Introduction
            </a>

            <a href={{ route('docs') }} class="navbar-item {{ request()->routeIs('docs') ? 'is-active' : '' }}">
                API Docs
            </a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button"
                                        data-slug="placesApi" data-color="#FFDD00" data-emoji="" data-font="Cookie"
                                        data-text="Buy me a coffee" data-outline-color="#000000" data-font-color="#000000"
                                        data-coffee-color="#ffffff"></script>
                </div>
            </div>
        </div>
    </div>
</nav>