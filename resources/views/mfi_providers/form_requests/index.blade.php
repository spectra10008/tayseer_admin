@extends('mfi_providers.layouts.app')
@section('title', 'طلبات التمويل')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> طلبات التمويل </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">طلبات التمويل </h4>
                    {{-- <a href="/panel-admin/form-requets/create" class="btn btn-primary">إضافة </a> --}}
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
                                    @foreach ($form_requests as $key => $form_request)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $form_request->id }}</td>
                                            <td>{{ $form_request->beneficiary->name }}</td>
                                            <td>{{ $form_request->beneficiary->email ?? '-' }}</td>
                                            <td>{{ $form_request->beneficiary->phone }}</td>
                                            <td>{{ $form_request->beneficiary->age }}</td>
                                            <td>
                                                @if ($form_request->status_id == 1)
                                                <span
                                                    class="badge badge-info">{{ $form_request->status->status_desc }}</span>
                                            @elseif($form_request->status_id == 2)
                                                <span class="badge badge-primary">
                                                    {{ $form_request->status->status_desc }}</span>
                                            @elseif($form_request->status_id == 3)
                                                <span
                                                    class="badge badge-info">{{ $form_request->status->status_desc }}</span>
                                            @elseif($form_request->status_id == 4)
                                                <span
                                                    class="badge badge-info">{{ $form_request->status->status_desc }}</span>
                                            @elseif($form_request->status_id == 5)
                                                <span
                                                    class="badge badge-success">{{ $form_request->status->status_desc }}</span>
                                            @elseif($form_request->status_id == 6)
                                                <span
                                                    class="badge badge-danger">{{ $form_request->status->status_desc }}</span>
                                            @elseif($form_request->status_id == 7)
                                                <span
                                                    class="badge badge-light">{{ $form_request->status->status_desc }}</span>
                                            @endif
                                            </td>
                                            <td>{{ $form_request->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="/panel-mfi/form-requets/{{$form_request->id}}" class="btn btn-info">
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
@endsection
