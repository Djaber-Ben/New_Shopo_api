@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h3>الأسئلة الشائعة</h3>

                <form action="{{ route('faqs.update', $faq->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="question" class="form-label">السؤال</label>
                        <input type="text" name="question" id="question" class="form-control" value="{{ $faq->question }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="answer" class="form-label">الجواب</label>
                        <textarea name="answer" id="answer" class="form-control wysiwyg" rows="3" required>{{ $faq->answer }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">تحديث</button>
                </form>
            </div>
        </div>
    </div>
@endsection