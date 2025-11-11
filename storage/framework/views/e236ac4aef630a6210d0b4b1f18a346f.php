<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>المتاجر</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <?php echo $__env->make('admin.message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 450px;">
                                <input value="<?php echo e(Request::get('keyword')); ?>" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                                
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="card-titel" style="margin-left: 5px">
                                    <button class="btn btn-dark" type="button" onclick="window.location.href='<?php echo e(route('stores.index')); ?>'">إعادة التعيين</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">رقم</th>
                                <th width="100">اسم</th>
                                
                                <th width="100">شعار</th>
                                <th width="100">حالة المتجر</th>
                                <th width="100">إسم الخطة</th>
                                <th width="100">حالة إشتراك المتجر</th>
                                <th width="50">تنفيذ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($stores->isNotEmpty()): ?>
                                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($store->id); ?></td>
                                        <td><?php echo e($store->store_name); ?></td>
                                        
                                        <td>
                                            <?php if(!empty($store->image)): ?>
                                                <div>
                                                    <img width="50" src="<?php echo e(asset('storage/'.$store->image)); ?>" alt="">
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($store->status == "active"): ?>
                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>                                        
                                            <?php else: ?>
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($store->latestSubscription?->subscriptionPlan?->name ?? 'No plan'); ?></td>
                                        <td>
                                            <?php if(!empty($store->latestSubscription->status)): ?>
                                                <?php if($store->latestSubscription->status == 'expired' ?? 'No Subscription'): ?>
                                                    <span class="bg-secondary p-1 rounded d-inline-block"><strong> منتهية الصلاحية </strong></span>
                                                <?php elseif($store->latestSubscription->status == 'cancelled' ?? 'No Subscription'): ?>
                                                    <span class="bg-info p-1 rounded d-inline-block"><strong> ملغات </strong></span>
                                                <?php elseif($store->latestSubscription->status == 'pending' ?? 'No Subscription'): ?>
                                                    <span class="bg-danger p-1 rounded d-inline-block"><strong> قيد الإنتظار </strong></span>
                                                <?php elseif($store->latestSubscription->status == 'active' ?? 'No Subscription'): ?>
                                                    <span class="bg-success p-1 rounded d-inline-block"><strong> نشطة </strong></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            
                                                <a href="<?php echo e(route('stores.edit',$store->id)); ?>" class="btn btn-sm btn-primary">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                            
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">لايوجد متاجر بعد</td>
                                </tr>
                            <?php endif; ?>                                                                                  
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    <?php echo e($stores->links()); ?>

                    
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('customJs'); ?>

<script>
    
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/store/list.blade.php ENDPATH**/ ?>