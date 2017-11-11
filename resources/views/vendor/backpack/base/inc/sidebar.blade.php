@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          @role('Super Admin')
            <li class="header">{{ trans('backpack::base.administration') }}</li>

            <!-- ================================================ -->
            <!-- ==== Recommended place for admin menu items ==== -->
            <!-- ================================================ -->
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/categories') }}"><i class="fa fa-list"></i> <span>Categories</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/statuses') }}"><i class="fa fa-flag"></i> <span>Statuses</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/teams') }}"><i class="fa fa-users"></i> <span>Teams</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/models') }}"><i class="fa fa-users"></i> <span>Models</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/summarized-equipments') }}"><i class="fa fa-users"></i> <span>Equipments</span></a></li>

            <li class="header">Payments</li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/plans') }}"><i class="fa fa-cc-stripe"></i> <span>Plans</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/coupons') }}"><i class="fa fa-usd"></i> <span>Coupons</span></a></li>

            <!-- ======================================= -->
            <li class="header">{{ trans('backpack::base.user') }}</li>
            <li class="treeview">
              <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
              </ul>
            </li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
          @endrole

          @hasanyrole(['User', 'Admin'])
            <li class="treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Account</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-key"></i> <span>Change Password</span></a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> <span>Change Email</span></a></li>
                </ul>
            </li>
          @endrole

          @hasanyrole(['Admin'])
            <li><a href="#"><span>Company</span></a></li>
            <li><a href="#"><span>Users</span></a></li>
            <li><a href="#"><span>Invoices</span></a></li>
          @endrole
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
