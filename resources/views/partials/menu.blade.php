<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('users_manage')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-briefcase nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-user nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('auth.change_password') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-key">

                    </i>
                    Change password
                </a>
            </li>
			<li class="nav-item">
                <a href="{{ route('admin.slider.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-picture-o">

                    </i>
                    {{ 'Sliders' }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-shopping-bag">

                    </i>
                    {{ 'Products' }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.brands.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-archive">

                    </i>
                    {{ 'Brands' }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.category.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-briefcase">

                    </i>
                    {{ 'Category' }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.attributes.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-window-restore">

                    </i>
                    {{ 'Attributes' }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.customer.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-users">

                    </i>
                    {{ 'Customers' }}
                </a>
            </li>
			<li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-shopping-basket">

                    </i>
                    {{ 'Orders' }}
                </a>
            </li>
			<li class="nav-item">
                <a href="{{ route('admin.testimonial.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-comments">

                    </i>
                    {{ 'Testimonials' }}
                </a>
            </li>
			<li class="nav-item">
                <a href="{{ route('settings.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-cog">

                    </i>
                    {{ 'Settings' }}
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>