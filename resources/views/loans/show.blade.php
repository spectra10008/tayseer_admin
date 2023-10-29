@extends('layouts.app')
@section('title', 'عرض بيانات الطلب')
@section('content')
    <style>
        #map_canvas {

            max-width: 100%;

            height: 300px;

        }

        .iti {
            width: 100%;
        }
    </style>
    <!-- page users view start -->
    <section class="page-users-view">
        <div class="row">
            <div class="col-12 mb-2">
                <a href="/panel-admin/loans/{{ $loan->id }}/edit" class="btn btn-primary mr-1"><i
                        class="feather icon-edit-1"></i> تعديل</a>
            </div>
            <!-- account start -->
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger mb-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">معلومات القرض</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">رقم القرض</td>
                                        <td>{{ $loan->loan_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">رقم الطلب</td>
                                        <td>
                                            <a href="/panel-admin/form-requets/{{ $loan->request->id }}"
                                                target="_blank">{{ $loan->request->form_request_id }} <i
                                                    class="fa fa-external-link"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">منتج التمويل</td>
                                        <td>{{ $loan->product->product_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">مؤسسة التمويل</td>
                                        <td>{{ $loan->mfi_provider->name_ar }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <table class="ml-0 ml-sm-0 ml-lg-0">
                                    <tr>
                                        <td class="font-weight-bold">الوصف</td>
                                        <td>{{ $loan->description }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">حالة القرض</td>
                                        <td>
                                            @if ($loan->status_id == 1)
                                                <span class="badge badge-info">{{ $loan->status->status_desc }}</span>
                                            @elseif($loan->status_id == 2)
                                                <span class="badge badge-success">
                                                    {{ $loan->status->status_desc }}</span>
                                            @elseif($loan->status_id == 3)
                                                <span class="badge badge-danger">
                                                    {{ $loan->status->status_desc }}</span>
                                            @elseif($loan->status_id == 4)
                                                <span class="badge badge-light">{{ $loan->status->status_desc }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">تاريخ الإنشاء</td>
                                        <td>{{ $loan->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">معلومات صاحب القرض</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">الإسم</td>
                                        <td>{{ $loan->request->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">البريد الألكتروني</td>
                                        <td>
                                            @if ($loan->request->email != null)
                                                {{ $loan->request->email }}
                                            @else
                                                لا يوجد
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">رقم الهاتف</td>
                                        <td>{{ $loan->request->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">تاريخ الإنشاء</td>
                                        <td>{{ $loan->request->created_at }}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                @if ($errors->any())
                    <div class="alert alert-danger mb-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">معلومات اخرى</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">مبلغ القرض</td>
                                        <td>{{ $loan->loan_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">تاريخ التمويل</td>
                                        <td>{{ \Carbon\Carbon::parse($loan->released_date)->format('Y-m-d') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">فائدة القرض</td>
                                        <td>{{ $loan->loan_interest }}</td>
                                    </tr>
                                    <tr>
                                        @php($loan_file = Str::substr($loan->loan_file, 7))
                                        <td class="font-weight-bold">ملف القرض</td>
                                        <td>
                                            <a href="{{ asset('storage/' .$loan_file) }}" class="btn btn-primary"
                                                target="_blank">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <table class="ml-0 ml-sm-0 ml-lg-0">
                                    <tr>
                                        <td class="font-weight-bold">الفائده بال </td>
                                        <td>{{ $loan->loan_interest_per }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">مدة القرض</td>
                                        <td>{{ $loan->loan_duration }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">مدير القرض</td>
                                        <td>{{ $loan->user->name }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- permissions end -->
        </div>
    </section>
    <!-- page users view end -->
@endsection
