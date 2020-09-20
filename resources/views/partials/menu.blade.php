<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-md-down-none">
        TrackMyPortfolio
    </div>
    <ul class="c-sidebar-nav ps ps--active-y">
        
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/">Dashboard</a>
        </li>
    </ul>
</div>




<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>