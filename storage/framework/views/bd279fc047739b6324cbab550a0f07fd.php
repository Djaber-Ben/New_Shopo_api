<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6 mb-3">
                    <h1>الفئات</h1>
                </div>
                <div class="col-sm-12 text-right">
                    <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary">إنشاء فئة جديدة</a>
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
                                    <button class="btn btn-dark" type="button" onclick="window.location.href='<?php echo e(route('categories.index')); ?>'">إعادة التعيين</button>
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
                                <th>اسم</th>
                                
                                <th>صورة</th>
                                <th width="100">الحالة</th>
                                <th width="100">تنفيذ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($categories->isNotEmpty()): ?>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($category->id); ?></td>
                                        <td><?php echo e($category->name); ?></td>
                                        
                                        <td>
                                            <?php if(!empty($category->image)): ?>
                                                <div>
                                                    <img width="50" src="<?php echo e(asset('storage/'.$category->image)); ?>" alt="">
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($category->status == "active"): ?>
                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>                                        
                                            <?php else: ?>
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-6">
                                                <a href="<?php echo e(route('categories.edit', $category->id)); ?>" class="btn btn-sm btn-primary">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                </a>

                                                <button type="button" onclick="deleteCategory(<?php echo e($category->id); ?>)" class="btn btn-sm btn-danger">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">لايوجد فئات بعد</td>
                                </tr>
                            <?php endif; ?>                                                                                  
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    <?php echo e($categories->links()); ?>

                    
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('customJs'); ?>

<script>
    function deleteCategory(id){
        var url= '<?php echo e(route("categories.delete", "ID")); ?>';
        var newUrl = url.replace('ID',id)
        if(confirm("هل أنت متأكد من الحذف؟")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response.status ){
                        window.location.href="<?php echo e(route('categories.index')); ?>";
                    }
                }
            });
        }
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\A\Desktop\Shopo\Shopo\Shopo_api\resources\views/admin/category/list.blade.php ENDPATH**/ ?>