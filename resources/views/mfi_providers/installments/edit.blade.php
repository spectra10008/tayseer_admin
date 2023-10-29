@extends('mfi_providers.layouts.app')
@section('title', 'تعديل القسط ' . $installment->payment_receipt_number)
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> تعديل قسط {{ $installment->payment_receipt_number }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
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
                        <form class="form form-vertical" action="/panel-mfi/installments/{{ $installment->id }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="first-name-vertical">المبلغ المستحق</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('deserved_amount') is-invalid @enderror"
                                                name="deserved_amount" required
                                                value="{{ old('deserved_amount', $installment->deserved_amount) }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="first-name-vertical">تاريخ دفع القسط</label>
                                            <input type="text"
                                                class="form-control @error('date_payment_installment') is-invalid @enderror"
                                                name="date_payment_installment" required id="datepicker"
                                                value="{{ old('date_payment_installment', $installment->date_payment_installment) }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="first-name-vertical">الحالة القسط </label>
                                            <select class="select2 form-control" name="status_id" required>
                                                <option value="">إختار</option>
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}" @selected(old('status_id', $installment->status_id) == $status->id)>
                                                        {{ $status->status_desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 d-none receipt_file">
                                        <div class="form-group">
                                            <label for="first-name-vertical">الملف</label>
                                            <input type="file"
                                                class="form-control @error('receipt_file') is-invalid @enderror"
                                                name="receipt_file"
                                                value="{{ old('receipt_file', $installment->receipt_file) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success mr-1 mb-1">تحديث</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scriptjs')

    <script>
        $(document).ready(function() {
            $("select[name='status_id']").change(function() {
              var val = this.value;
              if(val == 2)
              {
                $('.receipt_file').removeClass('d-none');
                $("input[name='receipt_file']"). attr("required", true);
              }else
              {
                $('.receipt_file').addClass('d-none');
                $("input[name='receipt_file']"). attr("required", false);
              }
            });
        });
    </script>
@endsection
