<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>معلومات حساب الدفع</h1>
            </div>
            <?php if($payment): ?>
            <div class="col-sm-6 text-right">
                <a href="<?php echo e(route('offline-payments.edit',$payment->id)); ?>" class="btn btn-primary"  style="float: left !important">تعديل</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <?php echo $__env->make('admin.message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Default box -->
    <div class="container-fluid">
        <form>
            <div class="card">
                <div class="card-body">                                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">الإسم</label>
                                <input type="text" name="name" id="name" value="<?php echo e($payment->name); ?>" class="form-control" placeholder="الإسم" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="family_name">اللقب</label>
                                <input type="text" name="family_name" id="family_name" value="<?php echo e($payment->family_name); ?>" class="form-control" placeholder="اللقب" readonly>
                                    
                            </div>
                        </div>                                     
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ccp_number">CCP رقم</label>
                                <input type="text" name="ccp_number" id="ccp_number" value="<?php echo e($payment->ccp_number); ?>" class="form-control" placeholder="CCP رقم" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cle">Cle</label>
                                <input type="text" name="cle" id="cle" value="<?php echo e($payment->cle); ?>" class="form-control" placeholder="Cle" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rip">Rip</label>
                                <input type="text" name="rip" id="rip" value="<?php echo e($payment->rip); ?>" class="form-control" placeholder="Rip" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address">العنوان</label>
                                <input type="text" name="address" id="address" value="<?php echo e($payment->address); ?>" class="form-control" placeholder="العنوان" readonly>
                                    
                            </div>
                        </div>
                    </div>
                </div>                            
            </div>
            <div class="pb-5 pt-3">
                <a href="<?php echo e(route('offline-payments.edit',$payment->id)); ?>" class="btn btn-primary ml-3">تعديل</a>
            </div>
        </form>
        <?php else: ?>
        </div>
    <!-- Default box -->
    <div class="container-fluid">
            <form id="paymentForm">
                <div class="card">
                    <div class="card-body">                                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">الإسم</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="الإسم">
                                    <p></p>    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="family_name">اللقب</label>
                                    <input type="text" name="family_name" id="family_name" class="form-control" placeholder="اللقب">
                                    <p></p>    
                                </div>
                            </div>                                     
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ccp_number">CCP رقم</label>
                                    <input type="text" name="ccp_number" id="ccp_number" class="form-control" placeholder="CCP رقم">
                                    <p></p>    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cle">Cle</label>
                                    <input type="text" name="cle" id="cle" class="form-control" placeholder="Cle">
                                    <p></p>    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rip">Rip</label>
                                    <input type="text" name="rip" id="rip" class="form-control" placeholder="Rip">
                                    <p></p>    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address">العنوان</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="العنوان">
                                    <p></p>    
                                </div>
                            </div>
                        </div>
                    </div>                            
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">تحديث</button>
                    <a href="<?php echo e(route('offline-payments.index')); ?>" class="btn btn-outline-dark ml-3">إلغاء</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
    <!-- /.card -->
</section>

<!-- /.content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('customJs'); ?>
<script>
// Handle form submit
$("#paymentForm").submit(function(event){
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: "<?php echo e(route('offline-payments.update')); ?>",
        type: 'POST',
        data: formData,
        dataType: 'json',

        success: function(response){
            if(response.status === true){
                window.location.href = "<?php echo e(route('offline-payments.index')); ?>";
            }
        },

        error: function(jqXHR){
            if (jqXHR.status === 422) {
                var errors = jqXHR.responseJSON.errors;
                $('input').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                $.each(errors, function(field, messages) {
                    $('#' + field).addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(messages[0]);
                });
            } else {
                console.log("Unexpected error:", jqXHR.responseText);
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/payment_info/list.blade.php ENDPATH**/ ?>