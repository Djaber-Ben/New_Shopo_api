<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>تعديل المتجر</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="<?php echo e(route('stores.index')); ?>" class="btn btn-primary" style="float: left !important">رجوع</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-8">
                <?php echo $__env->make('admin.message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-12 invoice-col">
                                <h1 class="h5 mb-3">معلومات المتجر</h1>
                                <p>
                                    الإسم: <strong><?php echo e($store->store_name); ?></strong><br>
                                    رقم الهاتف: <strong><?php echo e($store->phone_number); ?></strong><br>
                                    العنوان: <strong><?php echo e($store->address_url); ?></strong><br>
                                    تاريخ الإنشاء:
                                    <strong>
                                        <?php if(!empty($store->created_at)): ?>
                                        <?php echo e(\Carbon\Carbon::parse($store->created_at)->format('Y - M -  d')); ?>

                                        <?php else: ?>
                                        N/A
                                        <?php endif; ?>
                                    </strong>
                                    <br>
                                    حالة المتجر: <strong> <?php echo e(($store->status)); ?></strong>
                                </p>
                            </div>
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <p></p>    
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>                           
                </div>
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="invoice-info text-right" style="line-height: 2;"> 
                            <h1 class="h5 mb-4 text-center">إشتراك المتجر</h1>

                            <b>رقم إشتراك المتجر:</b> <?php echo e($store->latestSubscription?->id ?? 'لا يوجد اشتراك'); ?><br>
                            <b>خطة الإشتراك الخاصة بالمتجر:</b> <?php echo e($store->latestSubscription?->subscriptionPlan?->name ?? 'لا يوجد خطة'); ?><br>
                            <b>سعر خطة الإشتراك:</b> <?php echo e($store->latestSubscription?->subscriptionPlan?->price ?? 'لا يوجد خطة'); ?><br>
                            <b>الحالة الخاصة بخطة الإشتراك:</b> <?php echo e($store->latestSubscription?->subscriptionPlan?->status ?? 'لا يوجد خطة'); ?><br>

                            <b>صورة الوصل الخاصة بتسديد مستحقات إشتراك المتجر:</b>
                            <?php if(!empty($store->latestSubscription?->payment_receipt_image)): ?>
                                <div class="text-center my-3"> 
                                    <img 
                                        width="250" 
                                        class="img-fluid rounded shadow-sm" 
                                        src="<?php echo e(asset('storage/'.$store->latestSubscription->payment_receipt_image)); ?>" 
                                        alt="صورة وصل الدفع"
                                    >
                                </div>
                            <?php else: ?>
                                <p class="text-muted text-center mt-3">لا توجد صورة وصل متاحة</p>
                            <?php endif; ?>
                                        <br>
                                        <b>حالة إشتراك المتجر:</b>
                                            <?php if(!empty($store->latestSubscription->status)): ?>
                                                <?php if($store->latestSubscription->status == 'expired' ?? 'No Subscription'): ?>
                                                    <span class="bg-muted p-1 rounded d-inline-block"><strong> منتهية الصلاحية </strong></span>
                                                <?php elseif($store->latestSubscription->status == 'cancelled' ?? 'No Subscription'): ?>
                                                    <span class="bg-info p-1 rounded d-inline-block"><strong> ملغات </strong></span>
                                                <?php elseif($store->latestSubscription->status == 'pending' ?? 'No Subscription'): ?>
                                                    <span class="bg-danger p-1 rounded d-inline-block"><strong> قيد الإنتظار </strong></span>
                                                <?php elseif($store->latestSubscription->status == 'active' ?? 'No Subscription'): ?>
                                                    <span class="bg-success p-1 rounded d-inline-block"><strong> نشطة </strong></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <br>
                                    
                                
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <form action="<?php echo e(route('stores.update', $store->id)); ?>" method="post" id="storeForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="card-body">
                            <div class="mb-3">
                                <h2 class="h4 mb-3" for="status">حالة المتجر</h2>   
                                <select name="status" id="status" class="form-control">
                                    <option value="active" <?php echo e(($store->status == 'active') ? 'selected' : ''); ?>>نشط</option>
                                    <option value="inactive" <?php echo e(($store->status == 'inactive') ? 'selected' : ''); ?>>موقف</option>
                                </select>
                                <p></p>    
                            </div>
                            <h2 class="h4 mb-3">حالة إشتراك المتجر</h2>
                            <div class="mb-3">
                                <select name="subscription_status" class="form-control">
                                    <option value="">حدد حالة إشتراك المتجر</option>
                                    <?php if(!empty($store->latestSubscription)): ?>
                                        <option value="active" <?php echo e($store->latestSubscription->status == 'active' ? 'selected' : ''); ?>>نشطة</option>
                                        <option value="pending" <?php echo e($store->latestSubscription->status == 'pending' ? 'selected' : ''); ?>>قيد الإنتظار </option>
                                        <option value="cancelled" <?php echo e($store->latestSubscription->status == 'cancelled' ? 'selected' : ''); ?>>ملغات</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">تحديث</button>
                                <a href="<?php echo e(route('stores.index')); ?>" class="btn btn-outline-dark ml-3">إلغاء</a>
                            </div>
                        </div>
                    </form>
                </div>
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
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/store/edit.blade.php ENDPATH**/ ?>