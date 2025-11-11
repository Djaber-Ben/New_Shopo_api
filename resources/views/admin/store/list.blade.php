@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>المتاجر</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.message')
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 450px;">
                                <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                                
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="card-titel" style="margin-left: 5px">
                                    <button class="btn btn-dark" type="button" onclick="window.location.href='{{ route('stores.index') }}'">إعادة التعيين</button>
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
                                <th width="100">اسم</th>
                                {{-- <th width="100">Slug</th> --}}
                                <th width="100">شعار</th>
                                <th width="100">حالة المتجر</th>
                                <th width="100">إسم الخطة</th>
                                <th width="100">حالة إشتراك المتجر</th>
                                <th width="50">تنفيذ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($stores->isNotEmpty())
                                @foreach ($stores as $store)
                                    <tr>
                                        <td>{{ $store->id }}</td>
                                        <td>{{ $store->store_name }}</td>
                                        {{-- <td>{{ $store->slug }}</td> --}}
                                        <td>
                                            @if(!empty($store->image))
                                                <div>
                                                    <img width="50" src="{{ asset('storage/'.$store->image) }}" alt="">
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($store->status == "active")
                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>                                        
                                            @else
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </td>
                                        <td>{{ $store->latestSubscription?->subscriptionPlan?->name ?? 'No plan' }}</td>
                                        <td>
                                            @if(!empty($store->latestSubscription->status))
                                                @if ($store->latestSubscription->status == 'expired' ?? 'No Subscription')
                                                    <span class="bg-secondary p-1 rounded d-inline-block"><strong> منتهية الصلاحية </strong></span>
                                                @elseif($store->latestSubscription->status == 'cancelled' ?? 'No Subscription')
                                                    <span class="bg-info p-1 rounded d-inline-block"><strong> ملغات </strong></span>
                                                @elseif($store->latestSubscription->status == 'pending' ?? 'No Subscription')
                                                    <span class="bg-danger p-1 rounded d-inline-block"><strong> قيد الإنتظار </strong></span>
                                                @elseif($store->latestSubscription->status == 'active' ?? 'No Subscription')
                                                    <span class="bg-success p-1 rounded d-inline-block"><strong> نشطة </strong></span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <div class="d-flex gap-6"> --}}
                                                <a href="{{ route('stores.edit',$store->id) }}" class="btn btn-sm btn-primary">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                            {{-- </div> --}}
                                        </td>
                                    </tr>
                                @endforeach                                
                            @else
                                <tr>
                                    <td colspan="5">لايوجد متاجر بعد</td>
                                </tr>
                            @endif                                                                                  
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">
                    {{ $stores->links() }}
                    {{-- <ul class="pagination pagination m-0 float-right">
                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul> --}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection


@section('customJs')

<script>
    
</script>

@endsection