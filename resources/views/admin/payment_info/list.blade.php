@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>معلومات حساب الدفع</h1>
            </div>
            @if($payment)
            <div class="col-sm-6 text-right">
                <a href="{{ route('offline-payments.edit',$payment->id) }}" class="btn btn-primary"  style="float: left !important">تعديل</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    @include('admin.message')
    <!-- Default box -->
    <div class="container-fluid">
        <form>
            <div class="card">
                <div class="card-body">                                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">الإسم</label>
                                <input type="text" name="name" id="name" value="{{ $payment->name }}" class="form-control" placeholder="الإسم" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="family_name">اللقب</label>
                                <input type="text" name="family_name" id="family_name" value="{{ $payment->family_name }}" class="form-control" placeholder="اللقب" readonly>
                                    
                            </div>
                        </div>                                     
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ccp_number">CCP رقم</label>
                                <input type="text" name="ccp_number" id="ccp_number" value="{{ $payment->ccp_number }}" class="form-control" placeholder="CCP رقم" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cle">Cle</label>
                                <input type="text" name="cle" id="cle" value="{{ $payment->cle }}" class="form-control" placeholder="Cle" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rip">Rip</label>
                                <input type="text" name="rip" id="rip" value="{{ $payment->rip }}" class="form-control" placeholder="Rip" readonly>
                                    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address">العنوان</label>
                                <input type="text" name="address" id="address" value="{{ $payment->address }}" class="form-control" placeholder="العنوان" readonly>
                                    
                            </div>
                        </div>
                    </div>
                </div>                            
            </div>
            <div class="pb-5 pt-3">
                <a href="{{ route('offline-payments.edit',$payment->id) }}" class="btn btn-primary ml-3">تعديل</a>
            </div>
        </form>
        @else
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
                    <a href="{{ route('offline-payments.index') }}" class="btn btn-outline-dark ml-3">إلغاء</a>
                </div>
            </form>
        @endif
    </div>
    <!-- /.card -->
</section>

<!-- /.content -->
@endsection

@section('customJs')
<script>
// Handle form submit
$("#paymentForm").submit(function(event){
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: "{{ route('offline-payments.update') }}",
        type: 'POST',
        data: formData,
        dataType: 'json',

        success: function(response){
            if(response.status === true){
                window.location.href = "{{ route('offline-payments.index') }}";
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
@endsection