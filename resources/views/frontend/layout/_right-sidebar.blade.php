@if (Auth::check())
    <aside class="main-sidebar right-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            </ul>
        </section>
    </aside>
@endif
