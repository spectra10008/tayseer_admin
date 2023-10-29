@extends('mfi_providers.layouts.app')
@section('title', 'القروض')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">القروض</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">القروض</h4>
                    <a href="/panel-mfi/loans/create" class="btn btn-primary">إضافة </a>
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
                                        <th>رقم التمويل</th>
                                        <th>رقم الطلب</th>
                                        <th>المنتج</th>
                                        <th>الحالة</th>
                                        <th>قيمة القرض</th>
                                        <th>تاريخ التمويل</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>خياراتي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $key => $loan)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $loan->loan_no }}</td>
                                            <td>{{ $loan->request->form_request_id }}</td>
                                            <td>{{ $loan->product->product_name }}</td>
                                            <td>
                                                @if ($loan->status_id == 1)
                                                <span class="badge badge-info">{{$loan->status->status_desc}}</span>
                                                @elseif($loan->status_id == 2)
                                                <span class="badge badge-success">
                                                    {{$loan->status->status_desc}}</span>
                                                @elseif($loan->status_id == 3)
                                                    <span class="badge badge-danger">
                                                        {{$loan->status->status_desc}}</span>
                                                @elseif($loan->status_id == 4)
                                                <span class="badge badge-light">{{$loan->status->status_desc}}</span>
                                                @endif
                                            </td>
                                            <td>{{ $loan->loan_amount }}</td>
                                            <td>{{ \Carbon\Carbon::parse($loan->released_date)->format('Y-m-d') }}</td>
                                            <td>{{ $loan->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="/panel-mfi/loans/{{$loan->id}}" class="btn btn-info"><i class="fa fa-info"></i></a>

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
                    <form class="form form-vertical" action="/panel-admin/fund-types" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">نوع التمويل</label>
                                        <input type="text" class="form-control @error('type_name') is-invalid @enderror"
                                            name="type_name" placeholder="نوع التمويل" value="{{ old('type_name') }}"
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
                $.get("/panel-admin/fund-types/" + edit_val + "/edit", function(data, status) {
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
