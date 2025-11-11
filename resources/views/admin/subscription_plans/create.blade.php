@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إنشاء خطة إشتراك</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('subscription-plans.index') }}" class="btn btn-outline-dark" style="float: left !important">رجوع</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </section>
    <!-- Main content -->
        <!-- Default box -->
        <form action="{{ route('subscription-plans.store') }}" method="POST" id="planForm">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name">إسم</label>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        id="name" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('name') }}" 
                                        placeholder="إسم"
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description">الوصف</label>
                                    <textarea 
                                        name="description" 
                                        id="description" 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        {{-- class="summernote"  --}}
                                        placeholder="الوصف"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price">السعر</label>
                                    <input 
                                        type="number" 
                                        name="price" 
                                        id="price" 
                                        class="form-control @error('price') is-invalid @enderror" 
                                        value="{{ old('price') }}" 
                                        placeholder="السعر"
                                    >
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="compare_price">السعر السابق</label>
                                    <input 
                                        type="number" 
                                        name="compare_price" 
                                        id="compare_price" 
                                        class="form-control @error('compare_price') is-invalid @enderror" 
                                        value="{{ old('compare_price') }}" 
                                        placeholder="السعر السابق"
                                    >
                                    @error('compare_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Duration & Status -->
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                {{-- <h2 class="h4 mb-3">Duration</h2> --}}

                                {{-- <div class="mb-3">
                                    <label for="duration">Duration</label>
                                    <select name="duration" id="duration" class="form-control">
                                        <option value="daily" {{ old('duration') == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="monthly" {{ old('duration') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="yearly" {{ old('duration') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    </select>
                                </div> --}}

                                <div class="mb-3">
                                    <label for="duration_days">المدة بالأيام</label>
                                    <input 
                                        type="number" 
                                        name="duration_days" 
                                        id="duration_days" 
                                        class="form-control @error('duration_days') is-invalid @enderror" 
                                        value="{{ old('duration_days') }}" 
                                        placeholder="المدة بالأيام"
                                    >
                                    @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="is_trial">نوع الخطة</label>
                                    <select name="is_trial" id="is_trial" class="form-control">
                                        <option value="0" {{ old('is_trial') == '0' ? 'selected' : '' }}>مدفوعة</option>
                                        <option value="1" {{ old('is_trial') == '1' ? 'selected' : '' }}>مجانية</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="status">حالة خطة الإشتراك</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>موقف</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">إنشاء</button>
                    <a href="{{ route('subscription-plans.index') }}" class="btn btn-outline-dark ml-3">إلغاء</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection


@section('customJs')
<script>

</script>
@endsection

