@extends('layouts.app')
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
                    <a href="/panel-admin/form-requets/create" class="btn btn-primary">إضافة </a>
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
                                            <td>{{ $form_request->name }}</td>
                                            <td>{{ $form_request->email }}</td>
                                            <td>{{ $form_request->phone }}</td>
                                            <td>{{ $form_request->age }}</td>
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
    <!-- Modal -->
    <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">إضافة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/sectors" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">إسم القطاع</label>
                                        <input type="text" class="form-control @error('sector_desc') is-invalid @enderror"
                                            name="sector_desc" placeholder="إسم القطاع" value="{{ old('sector_desc') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">إضافة</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit Modal -->
    <div class="modal fade text-left" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">تعديل </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-section">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptjs')
    <script>
        $(document).ready(function() {
            $("button[name='edit_button']").click(function() {

                var edit_val = this.value;

                $(".form-section").html(" ");
                $(".form-section").append(
                    "<center><img src='{{ asset('loader.gif') }}'  width='300px'/></center>"
                );
                $.get("/panel-admin/sectors/" + edit_val + "/edit", function(data, status) {
                    $(".form-section").html(data);
                }).fail(function() {
                    $(".form-section").html(" ");
                    $(".form-section").append(
                        "<div class='alert alert-danger' role='alert'>عذراً , حصل خطأ ما !!</div>"
                    );
                });
            });
        });
    </script>
@endsection
