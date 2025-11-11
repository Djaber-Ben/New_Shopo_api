<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('admin-assets/img/shopo.jpg') }}" alt="Shopo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SHOPO</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>لوحة التحكم</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('sliders.index') }}" class="nav-link {{ request()->routeIs('sliders.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>الشرائح</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>الفئات</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('stores.index') }}" class="nav-link {{ request()->routeIs('stores.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-store"></i>
                            <p>المتاجر</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('offline-payments.index') }}" class="nav-link {{ request()->routeIs('offline-payments.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>معلومات الدفع</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('subscription-plans.index') }}" class="nav-link {{ request()->routeIs('subscription-plans.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>خطط الاشتراك</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('siteInfos.index') }}" class="nav-link {{ request()->routeIs('siteInfos.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>معلومات الموقع</p>
                        </a>
                    </li>
                    
                    {{-- <li class="nav-item has-treeview {{ request()->is('siteInfos/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('siteInfos/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Site Info
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('siteInfos.contact') }}" class="nav-link {{ request()->routeIs('siteInfos.contact') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Contact Us</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('siteInfos.faq') }}" class="nav-link {{ request()->routeIs('siteInfos.faq') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>FAQ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('siteInfos.about') }}" class="nav-link {{ request()->routeIs('siteInfos.about') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>About Us</p>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                    
                    {{-- <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li> --}}
                {{-- <li class="nav-item">
                    <a href="pages.html" class="nav-link">
                        <i class="nav-icon  far fa-file-alt"></i>
                        <p>Pages</p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
 </aside>