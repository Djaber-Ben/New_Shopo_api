<?php if(Session::has('error')): ?>    
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4> <?php echo e(Session::get('error')); ?>

    </div>
<?php endif; ?>

<?php if(Session::has('success')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4> <?php echo e(Session::get('success')); ?>

    </div>
<?php endif; ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/message.blade.php ENDPATH**/ ?>