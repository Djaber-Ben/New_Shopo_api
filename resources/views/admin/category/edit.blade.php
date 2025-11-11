@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>تعديل الفئة</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('categories.index') }}" class="btn btn-primary" style="float: left !important">رجوع</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{ route('categories.update', $category->id) }}" 
              method="post" 
              enctype="multipart/form-data" 
              id="categoryForm">
            @csrf
             @method('PUT')
            <div class="card">
                <div class="card-body">                                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">إسم</label>
                                <input type="text" name="name" id="name" value="{{ $category->name }}" class="form-control" placeholder="إسم">
                                <p></p>    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image">صورة</label>
                                <div id="imageUpload" class="dropzone"></div>
                                <input type="hidden" name="image" id="image"> {{-- store filename --}}
                            </div>
                                @if(!empty($category->image))
                                    <div>
                                        <img width="250" src="{{ asset('storage/'.$category->image) }}" alt="">
                                    </div>
                                @endif
                        </div>                                
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">الحالة</label>    
                                <select name="status" id="status" class="form-control">
                                    <option value="active" {{ ($category->status == 'active') ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ ($category->status == 'inactive') ? 'selected' : '' }}>موقف</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="show">إظهار الفئة</label>    
                                <select name="show" id="show" class="form-control">
                                    <option {{ ($category->show == '1') ? 'selected' : '' }} value="1">نعم</option>
                                    <option {{ ($category->show == '0') ? 'selected' : '' }} value="0">لا</option>
                                </select>
                            </div>
                        </div>                                     
                    </div>
                </div>                            
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">تحديث</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">إلغاء</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
Dropzone.autoDiscover = false;

let uploadedImage = "{{ $category->image }}"; // prefill with DB value

const dropzone = new Dropzone("#imageUpload", {
    url: "{{ route('categories.upload') }}", // new upload route
    maxFiles: 1,
    paramName: "image",
    acceptedFiles: "image/jpeg,image/png,image/gif",
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    init: function () {
        // Prefill if category already has an image
        @if($category->image)
            const mockFile = { name: "Current Image", size: 12345 };
            this.emit("addedfile", mockFile);
            this.emit("thumbnail", mockFile, "{{ asset('storage/'.$category->image) }}");
            this.emit("complete", mockFile);
            $("#image").val("{{ $category->image }}"); // keep old path in hidden input
        @endif
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
        url: "{{ route('categories.update', $category->id) }}",
        type: 'Post',
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