@extends('layouts.app')
@section('title', 'عرض بيانات المجموعة')
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
            <!-- account start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">معلومات المجموعة</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">الإسم</td>
                                        <td>{{ $group->group_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">رقم الهاتف</td>
                                        <td>{{ $group->group_contact }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">العنوان</td>
                                        <td>{{ $group->group_address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">مسجلة ؟</td>
                                        <td>
                                            @if ($group->is_registered == 1)
                                                نعم
                                            @else
                                                لا
                                            @endif

                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <table class="ml-0 ml-sm-0 ml-lg-0">
                                    <tr>
                                        <td class="font-weight-bold">نوع التسجيل</td>
                                        <td>{{ $group->register_type->type_desc }}</td>
                                    </tr>
                                    @php($name = $group->beneficiary_group->where('is_leader',1)->first())
                                    <tr>
                                        <td class="font-weight-bold">قائد المجموعة</td>
                                        <td>
                                            {{ $name->beneficiary->name ?? '-'  }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">عدد أعضاء المجموعة</td>
                                        <td>{{ $group->beneficiary->count()  }}</td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-12 mt-3">
                                <a href="/panel-admin/groups/{{ $group->id }}/edit" class="btn btn-primary mr-1"><i
                                        class="feather icon-edit-1"></i> تعديل</a>
                                <button class="btn btn-outline-danger"
                                    onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $group->id }}').submit();}else{
                                event.preventDefault();}"><i
                                        class="feather icon-trash-2"></i> حذف</button>
                                <form id="delete-users_{{ $group->id }}"
                                    action="/panel-admin/groups/{{ $group->id }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- account end -->
            <div class="col-md-6 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-2">المعلومات البنكية</div>
                    </div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <td class="font-weight-bold">لديه حساب بنكي ؟ </td>
                                <td>
                                    @if ($group->bank_id == 1)
                                        نعم
                                    @else
                                        لا
                                    @endif
                                </td>
                            </tr>
                            @if ($group->bank_id == 1)
                                <tr>
                                    <td class="font-weight-bold">اسم البنك</td>
                                    <td>
                                        {{ $group->bank->bank_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">اسم الفرع </td>
                                    <td> {{ $group->branch_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">رقم الحساب</td>
                                    <td>{{ $group->account_no }}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-2">الملفات</div>
                    </div>
                    <div class="card-body">
                        @php($id_file = Str::substr($group->foundation_certificate, 7))
                        <table>
                            <tr>
                                <td class="font-weight-bold">شهادة التأسيس</td>
                                <td>
                                    <a href="{{ asset('storage/' . $id_file) }}" class="btn btn-primary" download> <i
                                            class="fa fa-download"></i> </a>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
                <!-- permissions start -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom mx-2 px-0">
                            <h6 class="border-bottom py-1 mb-0 font-medium-2"><i class="fa fa-users mr-50 "></i>أعضاء المجموعة
                            </h6>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                إضافة
                              </button>
                        </div>
                        <div class="card-body px-75">
                            <div class="table-responsive users-view-permission">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th></th>
                                            <th>اسم المستفيد</th>
                                            <th>البريد الالكتروني</th>
                                            <th>رقم الهاتف</th>
                                            <th>العمر</th>
                                            <th>خياراتي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($group->beneficiary_group as $key => $beneficiary)
                                        <tr>
                                            <td width="10px">{{ ++$key }}</td>
                                            @php($img = Str::substr($beneficiary->beneficiary->image, 7))
                                            <td>
                                                <div class="avatar avatar-xl">
                                                    <img src="{{ asset('storage/'.$img) }}" alt="avtar img holder" style="object-fit: cover">
                                                </div>
                                            </td>
                                            <td>{{ $beneficiary->beneficiary->name }}</td>
                                            <td>{{ $beneficiary->beneficiary->email }}</td>
                                            <td>{{ $beneficiary->beneficiary->phone }}</td>
                                            <td>{{ $beneficiary->beneficiary->age }}</td>
                                            <td>
                                                <a href="/panel-admin/beneficiaries/{{$beneficiary->beneficiary->id}}" class="btn btn-info">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                <a href="/panel-admin/delete-beneficiaries-group/{{ $beneficiary->id }}" class="btn btn-danger mr-2"
                                                onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $beneficiary->id }}').submit();}else{
                                        event.preventDefault();}"><i
                                                    class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- permissions end -->
        </div>
    </section>
    <!-- page users view end -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">إضافة أعضاء للمجموعة</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" action="/panel-admin/add-beneficiaries-group" method="POST">
                    @csrf
                    <input type="hidden" name="group_id" value={{$group->id}}>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="first-name-vertical">اختار</label>
                                    <select class="select2 form-control" multiple="multiple" name="beneficiary_id[]" required>
                                        @foreach ($beneficiaries as $beneficiary)
                                            <option value="{{$beneficiary->id}}">{{$beneficiary->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">حفظ</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
          </div>
        </div>
      </div>
@endsection

