@extends('layouts.app')
@section('title', 'الرئيسية')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">لوحة التحكم</h2>

                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        @if (Auth::user()->user_type_id == 3)
            <div class="row">
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="fa fa-folder-open text-info font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">{{ $review_requests->count() }}</h2>
                                <p class="mb-0 line-ellipsis">الطلبات المحولة</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">طلبات التمويل </h4>
                        </div>

                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>رقم الطلب</th>
                                                <th>اسم المستفيد</th>
                                                <th>البريد الالكتروني</th>
                                                <th>رقم الهاتف</th>
                                                <th>العمر</th>
                                                <th>حالة الطلب</th>
                                                <th>تاريخ الإنشاء</th>
                                                <th>خياراتي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($review_requests as $key => $form_request)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $form_request->beneficiary->form_request_id }}</td>
                                                    <td>{{ $form_request->beneficiary->name }}</td>
                                                    <td>{{ $form_request->beneficiary->email ?? '-' }}</td>
                                                    <td>{{ $form_request->beneficiary->phone }}</td>
                                                    <td>{{ $form_request->beneficiary->age }}</td>
                                                    <td>
                                                        @if ($form_request->status_id == 1)
                                                        <span class="badge badge-info">{{$form_request->status->status_desc}}</span>
                                                        @elseif($form_request->status_id == 2)
                                                        <span class="badge badge-light">
                                                            {{$form_request->status->status_desc}}</span>
                                                        @elseif($form_request->status_id == 3)
                                                            <span class="badge badge-success">
                                                                {{$form_request->status->status_desc}}</span>
                                                        @elseif($form_request->status_id == 4)
                                                        <span class="badge badge-danger">{{$form_request->status->status_desc}}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $form_request->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <a href="/panel-admin/form-requets/{{$form_request->id}}" class="btn btn-info">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->user_type_id == 1)
            <div class="row">
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="feather icon-eye text-info font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">{{ $visitors->count() }}</h2>
                                <p class="mb-0 line-ellipsis">مجموع الزيارات</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="fa fa-industry text-danger font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">{{ $mfis->count() }}</h2>
                                <p class="mb-0 line-ellipsis">مؤسسات التمويل</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="feather icon-message-square text-warning font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">{{ $form_requests->count() }}</h2>
                                <p class="mb-0 line-ellipsis">طلبات التمويل</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">{{ $loans->count() }}</h2>
                                <p class="mb-0 line-ellipsis">القروض</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="feather icon-heart text-primary font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">{{ $beneficiaries->count() }}</h2>
                                <p class="mb-0 line-ellipsis">المستفيدين</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i class="feather icon-award text-success font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">{{ $installments->count() }}</h2>
                                <p class="mb-0 line-ellipsis">الاقساط</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">كل الزيارات</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-body pl-0">
                                    <div class="height-300">
                                        <canvas id="site-visitor-line-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">اوقات الزيارات / بالساعة</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-body pl-0">
                                    <div class="height-300">
                                        <canvas id="time-site-visitor-line-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
@section('scriptjs')
    <script src="{{ asset('/app-assets/vendors/js/charts/chart.min.js') }}"></script>
    <script src="{{ asset('/app-assets/js/scripts/charts/chart-chartjs.js') }}"></script>

    <script>
        $(window).on("load", function() {
            var visits = " {{ $visites_count }} ";
            visit_spilt = visits.split(',');

            var dates = " {{ $visit_dates }} ";
            dates_spilt = dates.split(',');
            var hours_visites_count = @json($hours_visites_count);
            var visit_hours = @json($visit_hours);
            var $primary = '#7367F0';
            var $success = '#28C76F';
            var $danger = '#EA5455';
            var $warning = '#FF9F43';
            var $label_color = '#1E1E1E';
            var $mango_primary_color = '#206761';
            var $mango_secondry_color = '#fdd02c';
            var $mango_sub_secondry_color = '#65ad2d';
            var grid_line_color = '#dae1e7';
            var scatter_grid_color = '#f3f3f3';
            var $scatter_point_light = '#D1D4DB';
            var $scatter_point_dark = '#5175E0';
            var $white = '#fff';
            var $black = '#000';

            var themeColors = [$primary, $success, $danger, $warning, $label_color, $mango_primary_color,
                $mango_secondry_color, $mango_sub_secondry_color
            ];

            //Get the context of the Chart canvas element we want to select
            var lineChartctx = $("#site-visitor-line-chart");

            // Chart Options
            var linechartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'top',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }]
                },
                title: {
                    display: true,
                }
            };

            // Chart Data
            var linechartData = {
                labels: dates_spilt,
                datasets: [{
                    label: "Site Visites",
                    data: visit_spilt,
                    borderColor: '#206761',
                    fill: false
                }]
            };

            var lineChartconfig = {
                type: 'line',

                // Chart Options
                options: linechartOptions,

                data: linechartData
            };

            // Create the chart
            var lineChart = new Chart(lineChartctx, lineChartconfig);
            ////////////////////////////////////////////////////////////////////////////////// hours visits/////////////////////////////////


            //Get the context of the Chart canvas element we want to select
            var lineChartctx = $("#time-site-visitor-line-chart");

            // Chart Options
            var linechartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'top',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }]
                },
                title: {
                    display: true,
                }
            };

            // Chart Data
            var linechartData = {
                labels: visit_hours,
                datasets: [{
                    label: "Site Visites",
                    data: hours_visites_count,
                    borderColor: '#fdd02c',
                    fill: false
                }]
            };

            var lineChartconfig = {
                type: 'line',

                // Chart Options
                options: linechartOptions,

                data: linechartData
            };

            // Create the chart
            var lineChart = new Chart(lineChartctx, lineChartconfig);
        });
    </script>


    <script>
        $('.excel-html5-selectors').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    charset: 'utf-8',
                    bom: true,
                    filename: 'الزيارات',
                    exportOptions: {
                        // columns: ':visible',
                        columns: [0, 1, 2],
                    }
                }
            ]
        });
    </script>
@endsection
