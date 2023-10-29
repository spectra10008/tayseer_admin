@extends('mfi_providers.layouts.app')
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
                                        <th>رقم القسط</th>
                                        <th>رقم القرض</th>
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
                                            <td>{{ $installment->payment_receipt_number }}</td>
                                            <td>{{ $installment->loan->id }}</td>
                                            <td>{{ $installment->deserved_amount }}</td>
                                            <td>{{ $installment->date_payment_installment }}</td>
                                            <td>
                                                @if ($installment->status_id == 1)
                                                    <span
                                                        class="badge badge-info">{{ $installment->ins_status->status_desc }}</span>
                                                @elseif($installment->status_id == 2)
                                                    <span
                                                        class="badge badge-success">{{ $installment->ins_status->status_desc }}</span>
                                                @elseif($installment->status_id == 3)
                                                    <span
                                                        class="badge badge-warning">{{ $installment->ins_status->status_desc }}</span>
                                                @elseif($installment->status_id == 4)
                                                    <span
                                                        class="badge badge-danger">{{ $installment->ins_status->status_desc }}</span>
                                                @elseif($installment->status_id == 5)
                                                    <span
                                                        class="badge badge-default">{{ $installment->ins_status->status_desc }}</span>
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
                                                <a href="/panel-mfi/installments/{{ $installment->id }}/edit"
                                                    class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                {{-- <button class="btn btn-danger mr-2"
                                                    onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $installment->id }}').submit();}else{
                                            event.preventDefault();}"><i
                                                        class="fa fa-trash"></i></button>
                                                <form id="delete-users_{{ $installment->id }}"
                                                    action="/panel-admin/banks/{{ $installment->id }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form> --}}
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
                            <form class="form form-vertical" action="/panel-mfi/installments" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">رقم القرض</label>
                                                <select class="select2 form-control" name="loan_id" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($loans as $loan)
                                                        <option value="{{ $loan->id }}"@selected($loan->id == old('loan_id'))>
                                                            {{ $loan->loan_no }}</option>
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
                                                <input type="text"
                                                    class="form-control @error('date_payment_installment') is-invalid @enderror"
                                                    name="date_payment_installment" required
                                                    value="{{ old('date_payment_installment') }}" id="datepicker">
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
                            <form class="form form-vertical" action="/panel-mfi/system-installments" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">رقم القرض</label>
                                                <select class="select2 form-control" name="loan_id" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($loans as $loan)
                                                        <option value="{{ $loan->id }}"@selected($loan->id == old('loan_id'))>
                                                            {{ $loan->loan_no }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">كامل المبلغ</label>
                                                <input type="number"
                                                    class="form-control @error('deserved_amount') is-invalid @enderror"
                                                    name="deserved_amount" required value="{{ old('deserved_amount') }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">عدد الاقساط</label>
                                                <input type="number"
                                                    class="form-control @error('installments_no') is-invalid @enderror"
                                                    name="installments_no" required value="{{ old('installments_no') }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">تاريخ اول قسط</label>
                                                <input type="text"
                                                    class="form-control datepicker @error('date_payment_installment') is-invalid @enderror"
                                                    name="date_payment_installment" required id="datepicker2"
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
        function get_details(val) {

            var edit_val = val.value;

            $(".form-section").html(" ");
            $(".form-section").append(
                "<center><img src='{{ asset('loader.gif') }}'  width='300px'/></center>"
            );
            $.get("/panel-admin/installments/" + edit_val + "/edit", function(data, status) {
                $(".form-section").html(data);
            }).fail(function() {
                $(".form-section").html(" ");
                $(".form-section").append(
                    "<div class='alert alert-danger' role='alert'>عذراً , حصل خطأ ما !!</div>"
                );
            });
        }
    </script>
@endsection
