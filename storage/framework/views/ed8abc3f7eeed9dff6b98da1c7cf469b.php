<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="text-center">الأسئلة الشائعة</h4>
                
                <a href="<?php echo e(route('faqs.create')); ?>" class="btn btn-primary mb-3">إنشاء أسئلة جديدة</a>

                
                <?php echo $__env->make('admin.message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>السؤال</th>
                            <th>الجواب</th>
                            <th width="180">تنفيذ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($faq->id); ?></td>
                                <td><?php echo e($faq->question); ?></td>
                                <td><?php echo e(Str::limit(strip_tags($faq->answer), 80)); ?></td>
                                <td>
                                    <a href="<?php echo e(route('faqs.edit', $faq)); ?>" class="btn btn-sm btn-warning">تغيير</a>
                                    <form action="<?php echo e(route('faqs.destroy', $faq)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this FAQ?')">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4">لايوجد أي أسئلة بعد</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/siteInfos/faqs/index.blade.php ENDPATH**/ ?>