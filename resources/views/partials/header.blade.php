<header class="px-4 c-header c-header-light c-header-fixed justify-content-end">
    <ul class="c-header-nav d-md-down-none">
        
        <li class="c-header-nav-item pr-4">
           <a class="c-header-nav-link" href="/">{{ ucfirst(auth()->user()->username) }}</a>
        </li>
        
        <li class="c-header-nav-item">
            <a class="c-header-nav-link"  href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
            {{ __('Logout') }}</a>
        </li>
    </ul>
</header>