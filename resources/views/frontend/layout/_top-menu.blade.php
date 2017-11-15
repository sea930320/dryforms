<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <li><a href="{{ url('/') }}"><span>Projects</span></a></li>
        <li><a href="{{ url('/') }}"><span>Settings</span></a></li>
        <li><a href="{{ url('/') }}"><span>Standards</span></a></li>
        <li><a href="{{ url('/') }}"><span>Equipment</span></a></li>
        <li><a href="{{ url('/') }}"><span>Training</span></a></li>

    </ul>
</div>

<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- ========== Top menu right items (ordered left) ========== -->
        @if (Auth::guest())
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.login') }}</a></li>
            @if (config('backpack.base.registration_open'))
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/register') }}">{{ trans('backpack::base.register') }}</a></li>
            @endif
        @else
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
    @endif
    </ul>
</div>
