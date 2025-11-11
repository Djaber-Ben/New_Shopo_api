<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>خطط الإشتراك</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?php echo e(route('subscription-plans.create')); ?>" class="btn btn-primary" style="float: left !important">إنشاء خطة إشتراك جديدة</a>
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
                                    <button class="btn btn-dark" type="button" onclick="window.location.href='<?php echo e(route('subscription-plans.index')); ?>'">إعادة التعيين</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>إسم</th>
                                <th>سعر</th>
                                <th>المدة</th>
                                <th>نوع الخطة</th>
                                <th>حالة الخطة</th>
                                <th>عدد المتاجر المشتركة</th>
                                <th>تنفيذ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($plans->isNotEmpty()): ?>
                                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($plan->name); ?></td>
                                        <td><?php echo e(number_format($plan->price, 2)); ?></td>
                                        <td><?php echo e($plan->duration_days); ?> يوم</td>
                                        <td>
                                            <?php if($plan->is_trial): ?>
                                                <p class="bg-success text-white p-1 rounded d-inline-block">مجانية</p>                                                
                                            <?php else: ?>
                                                <p class="bg-danger text-white p-1 rounded d-inline-block">مدفوعة</p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(ucfirst($plan->status == "active")): ?>
                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>                                        
                                            <?php else: ?>
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($plan->store_subscriptions_count); ?></td>
                                        <td>
                                            
                                                <a href="<?php echo e(route('subscription-plans.edit', $plan->id)); ?>" class="btn btn-sm btn-primary">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                                <form action="<?php echo e(route('subscription-plans.delete', $plan->id)); ?>" method="POST" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger btn-sm " style="border: none;" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                                                                viewBox="0 0 20 20" aria-hidden="true">
                                                                <path fill-rule="evenodd" 
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" 
                                                                clip-rule="evenodd">
                                                                </path>
                                                            </svg>
                                                    </button>
                                                </form>
                                            
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">Records Not Found</td>
                                </tr>
                            <?php endif; ?>                                                                                  
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    
                    
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
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/subscription_plans/index.blade.php ENDPATH**/ ?>