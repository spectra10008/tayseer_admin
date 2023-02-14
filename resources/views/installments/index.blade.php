@extends('layouts.app')
@section('title', 'الأقساط')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> الأقساط </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الأقساط </h4>
                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#default">إضافة </a>
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
                                        <th>إسم المستفيد</th>
                                        <th>رقم القسط</th>
                                        <th>رقم الطلب</th>
                                        <th>المبلغ المستحق</th>
                                        <th>تاريخ دفع القسط</th>
                                        <th>حالة القسط</th>
                                        <th>المبلغ المدفوع</th>
                                        <th>طريقة الدفع</th>
                                        <th>تاريخ الدفع</th>
                                        <th>الملف</th>
                                        <th>خياراتي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($installments as $key => $installment)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $installment->beneficiary->name }}</td>
                                            <td>{{ $installment->payment_receipt_number }}</td>
                                            <td>{{ $installment->form_request->id }}</td>
                                            <td>{{ $installment->deserved_amount }}</td>
                                            <td>{{ $installment->date_payment_installment }}</td>
                                            <td>
                                                @if ($installment->status_id == 1)
                                                    <span
                                                        class="badge badge-info">{{ $installment->status->status_desc }}</span>
                                                @elseif($installment->status_id == 2)
                                                    <span
                                                        class="badge badge-success">{{ $installment->status->status_desc }}</span>
                                                @elseif($installment->status_id == 3)
                                                    <span
                                                        class="badge badge-warning">{{ $installment->status->status_desc }}</span>
                                                @elseif($installment->status_id == 4)
                                                    <span
                                                        class="badge badge-danger">{{ $installment->status->status_desc }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($installment->amount_paid != null)
                                                    {{ $installment->amount_paid }}
                                                @else
                                                    لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                                @if ($installment->payment_type != null)
                                                    @if ($installment->payment_type == 'cash')
                                                        <span class="badge badge-danger">كاش</span>
                                                    @elseif($installment->payment_type == 'e-payment')
                                                        <span class="badge badge-success">دفع الكتروني</span>
                                                    @endif
                                                @else
                                                    لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                                @if ($installment->date_amount_paid != null)
                                                    {{ $installment->date_amount_paid }}
                                                @else
                                                    لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                                @if ($installment->receipt_file != null)
                                                    @php($receipt_file = Str::substr($installment->receipt_file, 7))
                                                    <a href="{{ asset('storage/' . $receipt_file) }}"
                                                        class="btn btn-primary" download> <i class="fa fa-download"></i>
                                                    </a>
                                                @else
                                                    لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-success" name="edit_button"
                                                    value="{{ $installment->id }}" data-toggle="modal"
                                                    data-target="#edit_modal"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger mr-2"
                                                    onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $installment->id }}').submit();}else{
                                            event.preventDefault();}"><i
                                                        class="fa fa-trash"></i></button>
                                                <form id="delete-users_{{ $installment->id }}"
                                                    action="/panel-admin/banks/{{ $installment->id }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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
                    <h4 class="modal-title" id="myModalLabel1">إضافة قسط </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home"
                                role="tab" aria-selected="true">تقسيم يدوي</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile"
                                role="tab" aria-selected="false">تقسيم النظام</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                            <form class="form form-vertical" action="/panel-admin/installments" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">رقم الطلب</label>
                                                <select class="select2 form-control" name="request_id" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($form_requests as $form_request)
                                                        <option
                                                            value="{{ $form_request->id }}"@selected($form_request->id == old('request_id'))>
                                                            {{ $form_request->id }} - {{ $form_request->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">المستفيدين</label>
                                                <select class="select2 form-control" name="beneficiary_id" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($beneficiaries as $beneficiary)
                                                        <option
                                                            value="{{ $beneficiary->id }}"@selected($beneficiary->id == old('beneficiary_id'))>
                                                            {{ $beneficiary->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">المبلغ المستحق</label>
                                                <input type="text"
                                                    class="form-control @error('deserved_amount') is-invalid @enderror"
                                                    name="deserved_amount" required value="{{ old('deserved_amount') }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">تاريخ دفع القسط</label>
                                                <input type="date"
                                                    class="form-control @error('date_payment_installment') is-invalid @enderror"
                                                    name="date_payment_installment" required
                                                    value="{{ old('date_payment_installment') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">إضافة</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                            <p>Pudding candy canes sugar plum cookie chocolate cake powder croissant. Carrot cake tiramisu
                                danish
                                candy cake muffin croissant tart dessert. Tiramisu caramels candy canes chocolate cake sweet
                                roll
                                liquorice icing cupcake.</p>
                        </div>
                    </div>

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
                $.get("/panel-admin/banks/" + edit_val + "/edit", function(data, status) {
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
