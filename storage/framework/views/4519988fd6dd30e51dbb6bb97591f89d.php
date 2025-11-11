<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand-link">
        <img src="<?php echo e(asset('admin-assets/img/shopo.jpg')); ?>" alt="Shopo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>لوحة التحكم</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('sliders.index')); ?>" class="nav-link <?php echo e(request()->routeIs('sliders.index') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-images"></i>
                            <p>الشرائح</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('categories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('categories.index') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>الفئات</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('stores.index')); ?>" class="nav-link <?php echo e(request()->routeIs('stores.index') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-store"></i>
                            <p>المتاجر</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('offline-payments.index')); ?>" class="nav-link <?php echo e(request()->routeIs('offline-payments.index') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>معلومات الدفع</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('subscription-plans.index')); ?>" class="nav-link <?php echo e(request()->routeIs('subscription-plans.index') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>خطط الاشتراك</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('siteInfos.index')); ?>" class="nav-link <?php echo e(request()->routeIs('siteInfos.index') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>معلومات الموقع</p>
                        </a>
                    </li>
                    
                    
                    
                    
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
 </aside><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>