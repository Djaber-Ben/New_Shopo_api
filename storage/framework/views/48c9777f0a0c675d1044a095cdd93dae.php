<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mلا-2">
            <div class="col-sm-6">
                <?php echo $__env->make('admin.message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <h4>معلومات الموقع</h4>
                <ul class="list-group mt-3">
                    <li class="list-group-item"><a href="<?php echo e(route('siteInfos.contact')); ?>">اتصل بنا</a></li>
                    <li class="list-group-item"><a href="<?php echo e(route('faqs.index')); ?>">الأسئلة الشائعة</a></li>
                    <li class="list-group-item"><a href="<?php echo e(route('siteInfos.about')); ?>">من نحن؟</a></li>
                </ul>
            </div>
        </div>
    </div>    
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/siteInfos/index.blade.php ENDPATH**/ ?>