<div class="tabs is-centered">
    <ul>
        <li>
            <a href={{ route('home') }} class="navbar-item  {{ request()->routeIs('home') ? 'is-active' : '' }}">
                Home
            </a>
        </li>
        <li>
            <a href={{ route('intro') }} class="navbar-item {{ request()->routeIs('intro') ? 'is-active' : '' }}">
                Introduction
            </a>
        </li>
        <li>
            <a href={{ route('docs') }} class="navbar-item {{ request()->routeIs('docs') ? 'is-active' : '' }}">
                Documentation
            </a>
        </li>
        <li>
            <a href={{ env('GITHUB_URL') }} class="navbar-item" target="_blank">
                Github
            </a>
        </li>
    </ul>
</div>
