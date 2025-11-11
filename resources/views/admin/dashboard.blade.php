@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إحصائيات</h1>
                </div>
                <div class="col-sm-6">
                    
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row justify-content-center">
            
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{ $totalUsers }}</h3>
                  <p>مجموع المستخدمين</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3>{{ $totalClients }}</h3>
                  <p>عدد الزبائن</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{ $totalStores }}</h3>
                  <p>عدد المتاجر</p>
                </div>
                <div class="icon">
                  <i class="fas fa-store"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i></a>
              </div>
            </div><!-- ./col -->
            
            {{-- <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>۶۵</h3>
                  <p>عدد المتاجر</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i></a>
              </div>
            </div><!-- ./col --> --}}

        </div><!-- /.row -->
        <div class="row">
            <!-- Subscription Stats Donut -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">إحصائيات الاشتراكات</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="subscriptionChart" style="min-height: 300px; height: 300px; max-height: 400px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Store Status Donut -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">حالة المتاجر</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="storeChart" style="min-height: 300px; height: 300px; max-height: 400px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('customJs')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // === Subscription Donut ===
            const subCtx = document.getElementById('subscriptionChart').getContext('2d');
            new Chart(subCtx, {
                type: 'doughnut',
                data: {
                    labels: ['نشط', 'منتهي', 'ملغى', 'قيد الانتظار'],
                    datasets: [{
                        data: [
                            {{ $subscriptionStats['active'] }},
                            {{ $subscriptionStats['expired'] }},
                            {{ $subscriptionStats['cancelled'] }},
                            {{ $subscriptionStats['pending'] }}
                        ],
                        backgroundColor: ['#28a745', '#dc3545', '#6c757d', '#ffc107'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: ctx => ctx.label + ': ' + ctx.formattedValue
                            }
                        }
                    }
                }
            });

            // === Store Donut ===
            const storeCtx = document.getElementById('storeChart').getContext('2d');
            new Chart(storeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['نشط', 'غير نشط'],
                    datasets: [{
                        data: [
                            {{ $storeStats['active'] }},
                            {{ $storeStats['inactive'] }}
                        ],
                        backgroundColor: ['#007bff', '#adb5bd'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: ctx => ctx.label + ': ' + ctx.formattedValue
                            }
                        }
                    }
                }
            });
        });
    </script>

@endsection