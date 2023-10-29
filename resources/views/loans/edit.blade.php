@extends('layouts.app')
@section('title', 'تعديل')
@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
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
                        <h4 class="card-title">تعديل</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" action="/panel-admin/loans/{{ $loan->id }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">طلب التمويل</label>
                                                <select name="request_id" class="form-control @error('request_id') is-invalid @enderror" id="" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($form_requests as $form_request)
                                                    <option value="{{$form_request->id}}" @selected($form_request->id == old('request_id',$loan->request_id))>{{$form_request->uuid}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">منتج التمويل</label>
                                                <select name="product_id" class="form-control @error('product_id') is-invalid @enderror" id="" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($products as $product)
                                                    <option value="{{$product->id}}" @selected($product->id == old('product_id',$loan->product_id))>{{$product->product_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">قيمة القرض</label>
                                                <input type="text"
                                                    class="form-control @error('loan_amount') is-invalid @enderror"
                                                    name="loan_amount" placeholder="قيمة القرض"
                                                    value="{{ old('loan_amount',$loan->loan_amount) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">تاريخ القرض</label>
                                                <input type="date"
                                                    class="form-control @error('released_date') is-invalid @enderror"
                                                    name="released_date" placeholder="قيمة القرض"
                                                    value="{{ old('released_date',\Carbon\Carbon::parse($loan->released_date)->format('Y-m-d')) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">الفائدة </label>
                                                <input type="number"
                                                    class="form-control @error('loan_interest') is-invalid @enderror"
                                                    name="loan_interest" placeholder="الفائدة "
                                                    value="{{ old('loan_interest',$loan->loan_interest) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">فائدة كل : </label>
                                                <select name="loan_interest_per" class="form-control @error('loan_interest_per') is-invalid @enderror" id="" required>
                                                    <option value="">إختار</option>
                                                    <option value="Month"  @selected(old('loan_interest_per',$loan->loan_interest_per) == "Month")>شهور</option>
                                                    <option value="Year"  @selected(old('loan_interest_per',$loan->loan_interest_per) == "Year")>سنة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">مدة القرض / بالشهور</label>
                                                <input type="number"
                                                    class="form-control @error('loan_duration') is-invalid @enderror"
                                                    name="loan_duration" placeholder=" مدة القرض / بالشهور"
                                                    value="{{ old('loan_duration',$loan->loan_duration) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">مؤسسة التمويل</label>
                                                <select name="mfi_provider_id" class="form-control @error('mfi_provider_id') is-invalid @enderror">
                                                    <option value="">إختار</option>
                                                    @foreach($mfis as $key => $mfi)
                                                    <option value="{{ $mfi->id }}"@selected(old('mfi_provider_id',$loan->mfi_provider_id) == $mfi->id )>{{ $mfi->name_ar }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">وصف القرض</label>
                                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                                    required>{{ old('description',$loan->description) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">ملف القرض</label>
                                                <input type="file"
                                                    class="form-control @error('loan_file') is-invalid @enderror" name="loan_file">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">حالة القرض</label>
                                                <select name="status_id" class="form-control @error('status_id') is-invalid @enderror" id="" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($statuses as $status)
                                                    <option value="{{$status->id}}" @selected($status->id == old('status_id',$loan->status_id))>{{$status->status_desc}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">مسؤول القرض</label>
                                                <select name="loan_manager" class="form-control @error('loan_manager') is-invalid @enderror" id="" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($users as $user)
                                                    <option value="{{$user->id}}" @selected($user->id == old('loan_manager',$loan->loan_manager))>{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success mr-1 mb-1">تحديث</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('scriptjs')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection
