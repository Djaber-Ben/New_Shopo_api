@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="text-center">الأسئلة الشائعة</h4>
                {{-- <h3>FAQ List</h3> --}}
                <a href="{{ route('faqs.create') }}" class="btn btn-primary mb-3">إنشاء أسئلة جديدة</a>

                {{-- @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif --}}
                @include('admin.message')

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>السؤال</th>
                            <th>الجواب</th>
                            <th width="180">تنفيذ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr>
                                <td>{{ $faq->id }}</td>
                                <td>{{ $faq->question }}</td>
                                <td>{{ Str::limit(strip_tags($faq->answer), 80) }}</td>
                                <td>
                                    <a href="{{ route('faqs.edit', $faq) }}" class="btn btn-sm btn-warning">تغيير</a>
                                    <form action="{{ route('faqs.destroy', $faq) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this FAQ?')">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4">لايوجد أي أسئلة بعد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection