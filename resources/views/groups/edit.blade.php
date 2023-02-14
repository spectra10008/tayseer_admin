@extends('layouts.app')
@section('title', 'تعديل بيانات مجموعة')
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
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تعديل بيانات مجموعة</h2>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">تعديل بيانات مجموعة</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger mb-2">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="form form-vertical" action="/panel-admin/groups/{{$group->id}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">إسم المجموعة</label>
                                                <input type="text" class="form-control @error('group_name') is-invalid @enderror" name="group_name" placeholder="اسم المجموعة" value="{{ old('group_name',$group->group_name) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">العنوان</label>
                                                <input type="text" class="form-control @error('group_address') is-invalid @enderror" name="group_address" placeholder="العنوان" value="{{ old('group_address',$group->group_address) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">رقم الهاتف</label>
                                                <input type="number"
                                                    class="form-control @error('group_contact') is-invalid @enderror"
                                                    name="group_contact" placeholder="رقم الهاتف" value="{{ old('group_contact',$group->group_contact) }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">حالة التسجيل</label>
                                                <select name="is_registered" class="form-control @error('is_registered') is-invalid @enderror" required>
                                                    <option value="">إختار</option>
                                                    <option value="0" @selected(old('is_registered',$group->is_registered) == 0)>غير مسجلة</option>
                                                    <option value="1" @selected(old('is_registered',$group->is_registered) == 1)>مسجلة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4 register_type_id d-none">
                                            <div class="form-group">
                                                <label for="first-name-vertical">نوع التسجيل</label>
                                                <select name="register_type_id" class="form-control @error('register_type_id') is-invalid @enderror" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($types as $type)
                                                    <option value="{{$type->id}}"@selected($type->id == old('register_type_id ',$group->register_type_id))>{{$type->type_desc}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">قائد المجموعة</label>
                                                <select name="group_leader_id" class="form-control @error('group_leader_id') is-invalid @enderror" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($beneficiaries as $beneficiary)
                                                    <option value="{{$beneficiary->id}}"@selected($beneficiary->id == old('group_leader_id',$group->group_leader_id))>{{$beneficiary->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12">
                                            <h5>
                                                المعلومات البنكية
                                            </h5>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">حساب بنكي ؟</label>
                                                <select name="is_bank_account" class="form-control @error('is_bank_account') is-invalid @enderror" required>
                                                    <option value="">إختار</option>
                                                    <option value="0" @selected(old('is_bank_account',$group->is_bank_account) == 0)>لا</option>
                                                    <option value="1" @selected(old('is_bank_account',$group->is_bank_account) == 1)>نعم</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4 bank_id d-none">
                                            <div class="form-group">
                                                <label for="first-name-vertical">اسم البنك</label>
                                                <select name="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                                    <option value="">إختار</option>
                                                    @foreach ($banks as $bank)
                                                    <option value="{{$bank->id}}" @selected(old('bank_id',$group->bank_id) == $bank->id)>{{$bank->bank_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4 branch_name d-none">
                                            <div class="form-group">
                                                <label for="first-name-vertical">اسم الفرع</label>
                                                <input type="text" class="form-control @error('branch_name') is-invalid @enderror" name="branch_name" placeholder="اسم الفرع" value="{{ old('branch_name',$group->branch_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-4 account_no d-none">
                                            <div class="form-group">
                                                <label for="first-name-vertical">رقم الحساب</label>
                                                <input type="number" class="form-control @error('account_no') is-invalid @enderror" name="account_no" placeholder="رقم الحساب" value="{{ old('account_no',$group->account_no) }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12">
                                            <h5>
                                                ملفات
                                            </h5>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">شهادة التأسيس</label>
                                                <input type="file"
                                                    class="form-control @error('foundation_certificate') is-invalid @enderror"
                                                    name="foundation_certificate" value="{{old('foundation_certificate',$group->foundation_certificate)}}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success mr-1 mb-1">تعديل</button>
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
</div>
@endsection
@section('scriptjs')
    <?php $old_is_bank = $group->is_bank_account; ?>
    <script>
        $(document).ready(function(){
            if(@json($old_is_bank) == 1)
            {
                $('.bank_id').removeClass('d-none');
                $('.branch_name').removeClass('d-none');
                $('.account_no').removeClass('d-none');
            }
          $("select[name='is_bank_account']").change(function(){
            var select_id = this.value;
            if(select_id == 1)
            {
                $('.bank_id').removeClass('d-none');
                $('.branch_name').removeClass('d-none');
                $('.account_no').removeClass('d-none');
            }else
            {
                $('.bank_id').addClass('d-none');
                $('.branch_name').addClass('d-none');
                $('.account_no').addClass('d-none');
            }
          });
        });
        </script>


<?php $old_is_registered = old('is_registered',$group->is_registered); ?>
<script>
    $(document).ready(function(){
        if(@json($old_is_registered) == 1)
        {
            $('.register_type_id').removeClass('d-none');
        }
      $("select[name='is_registered']").change(function(){
        var select_id = this.value;
        if(select_id == 1)
        {
            $('.register_type_id').removeClass('d-none');
        }else
        {
            $('.register_type_id').addClass('d-none');
        }
      });
    });
    </script>
@endsection
