<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4 class="text-center">Edit <?php echo e(ucfirst($siteInfo->key)); ?></h4>

                
                <?php echo $__env->make('admin.message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <form action="<?php echo e(route('siteInfos.update', $siteInfo->key)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group mt-3">
                        <label for="content">Content</label>
                        <textarea name="content" id="editor" rows="10" class="form-control"><?php echo e(old('content', $siteInfo->content)); ?></textarea>
                        <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('customJs'); ?>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [
                'undo', 'redo', '|',
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'blockQuote', 'insertTable', 'mediaEmbed'
            ]
        })
        .catch(error => {
            console.error(error);
        });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/siteInfos/edit.blade.php ENDPATH**/ ?>