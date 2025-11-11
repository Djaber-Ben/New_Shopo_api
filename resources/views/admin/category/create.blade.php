@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>إنشاء فئة</h1>
            </div>
            <div class="col-sm-6 text-start">
                <a href="{{ route('categories.index') }}" class="btn btn-primary" style="float: left !important">رجوع</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('categories.store') }}" 
              method="post" 
              enctype="multipart/form-data" 
              id="categoryForm">
            @csrf
            <div class="card">
                <div class="card-body">                                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">إسم</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="إسم">
                                <p></p>    
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image">صورة</label>
                                <div id="imageUpload" class="dropzone"></div>
                                <input type="hidden" name="image" id="image"> {{-- store filename --}}
                                <p></p>
                            </div>
                        </div>                                

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">الحالة</label>    
                                <select name="status" id="status" class="form-control">
                                    <option value="active">نشط</option>
                                    <option value="inactive">موقف</option>
                                </select>
                            </div>
                        </div>                                    

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="show">إظهار الفئة</label>    
                                <select name="show" id="show" class="form-control">
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div>
                        </div>                                    
                    </div>
                </div>                            
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">إنشاء</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">إلغاء</a>
            </div>
        </form>
    </div>
</section>
@endsection


@section('customJs')
<script>
Dropzone.autoDiscover = false;

let uploadedImage = "";

const dropzone = new Dropzone("#imageUpload", {
    url: "{{ route('categories.upload') }}", // new upload route
    maxFiles: 1,
    paramName: "image",
    acceptedFiles: "image/jpeg,image/png,image/gif",
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
        if(response.status === true){
            uploadedImage = response.file_path;
            $("#image").val(uploadedImage); // store filename in hidden input
        }
    },
    removedfile: function(file) {
        file.previewElement.remove();
        uploadedImage = "";
        $("#image").val("");
    }
});

// Handle form submit
$("#categoryForm").submit(function(event){
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: "{{ route('categories.store') }}",
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response){
            if(response.status === true){
                window.location.href = "{{ route('categories.index') }}";
            } else {
                var errors = response.errors;
                if(errors.name){
                    $('#name').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors.name);
                } else {
                    $('#name').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                }
                if(errors.image){
                    $('#image').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors.image);
                } else {
                    $('#image').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                }
            }
        },
        error: function(jqXHR){
            console.log("Error:", jqXHR.responseText);
        }
    });
});
</script>
@endsection

