@extends('layouts.app')
@section('title', 'عرض التجار')
@section('content')
 <!-- page users view start -->
 <section class="page-users-view">
    <div class="row">
        <!-- account start -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">معلومات التاجر</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php($img = Str::substr($vendor->profile_pic, 7))
                        <div class="users-view-image">
                            <img src="{{ asset('storage/'.$img) }}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                        </div>
                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">اسم التاجر</td>
                                    <td>{{$vendor->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">البريد الألكتروني</td>
                                    <td>{{$vendor->email}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">رقم الهاتف</td>
                                    <td>{{$vendor->phone}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                <tr>
                                    <td class="font-weight-bold">العنوان</td>
                                    <td>{{$vendor->address}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 mt-3">
                            <a href="/panel-admin/vendors/{{$vendor->id}}/edit" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> تعديل</a>
                            <button class="btn btn-outline-danger" onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $vendor->id }}').submit();}else{
                                event.preventDefault();}"><i class="feather icon-trash-2"></i> حذف</button>
                                <form id="delete-users_{{ $vendor->id }}"
                                    action="/panel-admin/vendors/{{ $vendor->id }}" method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- account end -->
        <!-- information start -->
        <div class="col-md-12 col-12 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-2">معلومات البيع</div>
                </div>
                <div class="card-body">
                    {!! $vendor->sale_info !!}
                </div>
            </div>
        </div>
        <!-- information start -->
    </div>
</section>
<!-- page users view end -->

@endsection
