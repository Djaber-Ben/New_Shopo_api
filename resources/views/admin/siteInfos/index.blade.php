@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mلا-2">
            <div class="col-sm-6">
                @include('admin.message')
                <h4>معلومات الموقع</h4>
                <ul class="list-group mt-3">
                    <li class="list-group-item"><a href="{{ route('siteInfos.contact') }}">اتصل بنا</a></li>
                    <li class="list-group-item"><a href="{{ route('faqs.index') }}">الأسئلة الشائعة</a></li>
                    <li class="list-group-item"><a href="{{ route('siteInfos.about') }}">من نحن؟</a></li>
                </ul>
            </div>
        </div>
    </div>    
</section>
@endsection