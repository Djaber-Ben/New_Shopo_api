@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>إنشاء لوحة</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('sliders.index') }}" class="btn btn-primary" style="float: left !important">رجوع</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('sliders.store') }}" 
              method="post" 
              enctype="multipart/form-data" 
              id="sliderForm">
            @csrf
            <div class="card">
                <div class="card-body">                                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title">إسم</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="إسم">
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
                                <label for="link">الرابط</label>    
                                <input type="text" name="link" id="link" class="form-control" placeholder="الرابط">
                                <p></p> 
                            </div>
                        </div> 

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">الحالة</label>    
                                <select name="status" id="status" class="form-control">
                                    <option value="1">نشط</option>
                                    <option value="0">موقف</option>
                                </select>
                            </div>
                        </div>                                                                        
                    </div>
                </div>                            
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">إنشاء</button>
                <a href="{{ route('sliders.index') }}" class="btn btn-outline-dark ml-3">إلغاء</a>
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
    url: "{{ route('sliders.upload') }}", // new upload route
    maxFiles: 1,
    paramName: "image",
    acceptedFiles: "image/jpeg,image/png,image/gif",
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
        console.log(response.errors);

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
$("#sliderForm").submit(function(event){
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: "{{ route('sliders.store') }}",
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response){
            if(response.status === true){
                window.location.href = "{{ route('sliders.index') }}";
            } else {
                var errors = response.errors;
                if(errors.title){
                    $('#title').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors.title);
                } else {
                    $('#title').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                }
                if(errors.link){
                    $('#link').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors.link);
                } else {
                    $('#link').removeClass('is-invalid')
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

