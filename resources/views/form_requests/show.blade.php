@extends('layouts.app')
@section('title', 'عرض بيانات الطلب')
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
            <div class="col-12 mb-2">
                @if (Auth::user()->user_type_id == 1)
                    <a href="/panel-admin/form-requets/{{ $formRequest->id }}/edit" class="btn btn-primary mr-1"><i
                            class="feather icon-edit-1"></i> تعديل</a>
                    <a href="/panel-admin/form-sms/{{ $formRequest->id }}" class="btn btn-info mr-1"><i
                            class="fa fa-envelope"></i>
                        الرسائل</a>
                @endif
            </div>
            <!-- account start -->
            <div class="col-12">
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
                        <div class="card-title">معلومات الطلب</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">الإسم</td>
                                        <td>{{ $formRequest->beneficiary->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">البريد الألكتروني</td>
                                        <td>
                                            {{ $formRequest->beneficiary->email ?? 'لا يوجد' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">رقم الهاتف</td>
                                        <td>{{ $formRequest->beneficiary->phone }}</td>
                                    </tr>
                                    @if ($formRequest->mfi_provider_id != null)
                                        <tr>
                                            <td class="font-weight-bold">مؤسسة التمويل</td>
                                            <td>{{ $formRequest->mfi_provider->name_ar }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="font-weight-bold">رقم الطلب</td>
                                        <td>{{ $formRequest->project_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">حالة الطلب</td>
                                        <td>
                                            @if ($formRequest->status_id == 1)
                                                <span
                                                    class="badge badge-info">{{ $formRequest->status->status_desc }}</span>
                                            @elseif($formRequest->status_id == 2)
                                                <span class="badge badge-primary">
                                                    {{ $formRequest->status->status_desc }}</span>
                                            @elseif($formRequest->status_id == 3)
                                                <span
                                                    class="badge badge-primary">{{ $formRequest->status->status_desc }}</span>
                                            @elseif($formRequest->status_id == 3)
                                                <span
                                                    class="badge badge-info">{{ $formRequest->status->status_desc }}</span>
                                            @elseif($formRequest->status_id == 4)
                                                <span
                                                    class="badge badge-info">{{ $formRequest->status->status_desc }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <table class="ml-0 ml-sm-0 ml-lg-0">

                                    <tr>
                                        <td class="font-weight-bold">محول الطلب</td>
                                        <td>{{ $formRequest->operation->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">الخبير التقني</td>
                                        <td>{{ $formRequest->technical_expert->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">تاريخ الإنشاء</td>
                                        <td>{{ $formRequest->created_at }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 mt-2">
                                @if (in_array(Auth::user()->user_type_id, [1, 2]))
                                    @if ($formRequest->status_id == 1 || $formRequest->status_id == 2)
                                        <a href="app-user-edit.html" class="btn btn-success mr-1" data-toggle="modal"
                                            data-target="#approved"><i class="fa fa-check"></i> تحويل</a>
                                    @endif
                                @endif
                                @if (in_array(Auth::user()->user_type_id, [1, 3]))
                                    @if ($formRequest->status_id == 3)
                                        <a href="app-user-edit.html" class="btn btn-success mr-1" data-toggle="modal"
                                            data-target="#mfi_submit"><i class="fa fa-check"></i> ارسال</a>
                                    @endif
                                @endif
                                @if ($formRequest->status_id < 4)
                                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#reject"><i
                                            class="fa fa-times-circle"></i> رفض</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">المعلومات الشخصية</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">العنوان</td>
                                        <td>{{ $formRequest->beneficiary->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">الرقم الوطني</td>
                                        <td>{{ $formRequest->beneficiary->id_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">الجنس</td>
                                        <td>
                                            @if ($formRequest->beneficiary->gender == 'male')
                                                ذكر
                                            @else
                                                أنثى
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">العمر</td>
                                        <td>{{ $formRequest->beneficiary->age }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">الحالة الاجتماعية</td>
                                        <td>{{ $formRequest->beneficiary->social_status->situation_desc }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">عدد الأطفال</td>
                                        <td>{{ $formRequest->beneficiary->children_no }}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">عن المشروع</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-9 col-md-12 col-lg-12">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">إسم المشروع</td>
                                        <td>{{ $formRequest->project_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">القطاع</td>
                                        <td>{{ $formRequest->sector->sector_desc }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-sm-9 col-md-12 col-lg-12">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">نوع التمويل</td>
                                        <td>{{ $formRequest->fund_type->type_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold"> التمويل المطلوب</td>
                                        <td>{{ $formRequest->project_fund_need }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">معلومات المشروع</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                {!! $formRequest->project_desc !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">ملاحظات المشروع</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-9 col-md-12 col-lg-12">
                                {!! $formRequest->notes ?? 'لا توجد ملاحظات' !!}
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
                                    @if ($formRequest->bank_id == 1)
                                        نعم
                                    @else
                                        لا
                                    @endif
                                </td>
                            </tr>
                            @if ($formRequest->bank_id == 1)
                                <tr>
                                    <td class="font-weight-bold">اسم البنك</td>
                                    <td>
                                        {{ $formRequest->bank->bank_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">اسم الفرع </td>
                                    <td> {{ $formRequest->branch_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">رقم الحساب</td>
                                    <td>{{ $formRequest->account_no }}
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
                        <div class="card-title">الملفات</div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            اضافة
                        </button>
                    </div>
                    <div class="card-body">
                        @php($feasibility_study_file = Str::substr($formRequest->feasibility_study_file, 7))
                        @php($personal_image = Str::substr($formRequest->personal_image, 7))
                        @php($id_file = Str::substr($formRequest->id_image, 7))
                        <table>
                            <tr>
                                <td class="font-weight-bold">دراسة الجدوى</td>
                                <td>
                                    <a href="{{ asset('storage/' . $feasibility_study_file) }}" class="btn btn-primary"
                                        download> <i class="fa fa-download"></i> </a>
                                </td>

                            </tr>
                            <tr>
                                <td class="font-weight-bold">ملف الهوية</td>
                                <td>
                                    <a href="{{ asset('storage/' . $id_file) }}" class="btn btn-primary" download> <i
                                            class="fa fa-download"></i> </a>
                                </td>

                            </tr>
                            <tr>
                                <td class="font-weight-bold">صورة شخصية</td>
                                <td>
                                    <a href="{{ asset('storage/' . $personal_image) }}" class="btn btn-primary" download>
                                        <i class="fa fa-download"></i> </a>
                                </td>

                            </tr>
                            @if ($formRequest->files->count() != 0)
                                @foreach ($formRequest->files as $file)
                                    @php($file_path = Str::substr($file->file, 7))
                                    <tr>
                                        <td class="font-weight-bold">{{ $file->file_name }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $file_path) }}" class="btn btn-primary"
                                                download> <i class="fa fa-download"></i> </a>

                                            <a href="/panel-admin/delete-form-requets-file/{{ $file->id }}"
                                                onclick="if(!confirm('هل أنت متأكد ؟')){event.preventDefault();}"
                                                class="btn btn-danger"> <i class="fa fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">اضافة ملاحظات </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNote">
                            اضافة
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                                <table class="table zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الملاحظة</th>
                                            <th>النوع</th>
                                            <th>الحالة</th>
                                            <th>المسؤول</th>
                                            <th>تغيير الحالة</th>
                                            <th>حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($formRequest->form_notes as $key => $note)
                                            <tr>
                                                <th scope="row">{{ ++$key }}</th>
                                                <td>{{ $note->note }}</td>
                                                <td>{{ $note->type }}</td>
                                                <td>
                                                    @if ($note->status == 1)
                                                        <span class="badge badge-success">تمت المعالجة</span>
                                                    @else
                                                        <span class="badge badge-danger">لم تتم المعالجة</span>
                                                    @endif
                                                </td>
                                                <td>{{ $note->user->name }}</td>
                                                <td>
                                                    @if (Auth::user()->user_type->user_type_desc == $note->type)
                                                        @if ($note->status == 1)
                                                            <a href="/panel-admin/form-requets/note-change-status/{{ $note->id }}/0"
                                                                class="btn btn-danger"
                                                                onclick="if(!confirm('هل أنت متأكد ؟')){event.preventDefault();}">
                                                                <i class="fa fa-times-circle"></i>
                                                            </a>
                                                        @else
                                                            <a href="/panel-admin/form-requets/note-change-status/{{ $note->id }}/1"
                                                                class="btn btn-success"
                                                                onclick="if(!confirm('هل أنت متأكد ؟')){event.preventDefault();}">
                                                                <i class="fa fa-check-circle"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger mr-2"
                                                        onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $note->id }}').submit();}else{
                                        event.preventDefault();}"><i
                                                            class="fa fa-trash"></i> </button>
                                                    <form id="delete-users_{{ $note->id }}"
                                                        action="/panel-admin/form-requets/remove-note/{{ $note->id }}"
                                                        method="POST" class="d-none">
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
            @php($locations = explode(',', $formRequest->location_on_map))
            <div class="col-md-12 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-2">موقع المستفيد على الخريطة</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-none">
                                <div class="form-group">
                                    <label for="autocomplete"> موقع المتجر على الخريطة</label>
                                    <input type="text" name="autocomplete" id="autocomplete" class="form-control"
                                        placeholder="الموقع">
                                </div>
                            </div>
                            <div class="col-4 d-none">
                                <div class="form-group">
                                    <label for="contact-info-vertical">latitude</label>
                                    <input type="text" name="latitude" id="latitude" readonly class="form-control"
                                        value="{{ old('latitude', (array_key_exists(0,$locations)) ? $locations[0] : '-') }}" required>
                                </div>
                            </div>
                            <div class="col-4 d-none">
                                <div class="form-group">
                                    <label for="contact-info-vertical">longitude</label>
                                    <input type="text" name="longitude" id="longitude" readonly class="form-control"
                                        value="{{ old('longitude', (array_key_exists(1,$locations)) ? $locations[1] : '-') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div id='map_canvas'></div>
                                    {{-- <div id="current">Nothing yet...</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- permissions start -->

            <!-- permissions end -->
        </div>
    </section>
    <!-- page users view end -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة ملف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/add-form-requets-file" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $formRequest->id }}" name="request_id">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical"> اسم الملف</label>
                                        <input type="text"
                                            class="form-control @error('file_name') is-invalid @enderror" name="file_name"
                                            required value="{{ old('file_name') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical"> الملف</label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror"
                                            name="file" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">رفع</button>
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
    <div class="modal fade" id="addNote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة ملاحظة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/form-requets/add-note" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $formRequest->id }}" name="request_id">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical"> الملاحظة </label>
                                        <textarea name="note" class="form-control @error('note') is-invalid @enderror" required>{{ old('note') }}</textarea>
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
    <div class="modal fade text-left" id="approved" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">تحويل الطلب</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/form-requets/transferـreview" method="POST">
                        @csrf
                        <input type="hidden" name="request_id" value="{{ $formRequest->id }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">تحويل الى</label>
                                        <select name="technical_expert_id" id="" class="form-control select2">
                                            <option value="">اختار</option>
                                            @foreach ($t_experts as $t_expert)
                                                <option value="{{ $t_expert->id }}">{{ $t_expert->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">تحويل</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="mfi_submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">ارسال الطلب</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/form-requets/transfer-mfi" method="POST">
                        @csrf
                        <input type="hidden" name="request_id" value="{{ $formRequest->id }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">ارسال الى</label>
                                        <select name="mfi_provider_id" id="" class="form-control select2">
                                            <option value="">اختار</option>
                                            @foreach ($mfis as $mfi)
                                                <option value="{{ $mfi->id }}">{{ $mfi->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">ارسال</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="reject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">رفض الطلب</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/form-requets/reject" method="POST">
                        @csrf
                        <input type="hidden" name="request_id" value="{{ $formRequest->id }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">الملاحظات</label>
                                        <textarea name="sms_content" class="form-control @error('sms_content') is-invalid @enderror" required>{{ old('sms_content') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">ارسال</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptjs')
<script
src="https://maps.google.com/maps/api/js?key=AIzaSyA-CFZMuoj6iTzpFJCGUrQUmrQuuw-ZZiE&libraries=places&callback=initAutocomplete"
type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $("#lat_area").addClass("d-none");
            $("#long_area").addClass("d-none");
        });
    </script>



    <?php
    if (count($locations) != 0 && array_key_exists(0,$locations) ) {
        $lat = $locations[0];
    } else {
        $lat = '15.5745709';
    }
    if (count($locations) != 0 && array_key_exists(1,$locations)) {
        $lng = $locations[1];
    } else {
        $lng = '32.5485763';
    }
    // print_r(getLocationsInRadius($lat,$lng,100));
    ?>
    <script>
        var lat = @json($lat);
        var lng = @json($lng);

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;

        var input = document.getElementById('autocomplete');
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 15,
            center: new google.maps.LatLng(lat, lng),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var myMarker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            draggable: false,
            title: 'Click to zoom'
        });
        var geocoder = new google.maps.Geocoder;

        // enter lat lng manually
        $('#latitude, #longitude').on('change keyup', function() {
            var lat = $('#latitude').val();
            var lng = $('#longitude').val();

            var latlng = new google.maps.LatLng(lat, lng);
            myMarker.setPosition(latlng);
            map.setCenter(latlng);

            geocoder.geocode({
                'latLng': latlng
            }, (results, status) => {
                if (status !== google.maps.GeocoderStatus.OK) {
                    alert('No results found');
                }
                // This is checking to see if the Geoeode Status is OK before proceeding
                if (status == google.maps.GeocoderStatus.OK) {
                    var address = (results[0].formatted_address);
                    input.value = address;
                }
            });
        });

        google.maps.event.addListener(myMarker, 'dragend', function(evt) {

            document.getElementById("latitude").value = evt.latLng.lat();
            document.getElementById("longitude").value = evt.latLng.lng();

            var latLng = evt.latLng;
            currentLatitude = latLng.lat();
            currentLongitude = latLng.lng();

            var latlng = {
                lat: currentLatitude,
                lng: currentLongitude
            };

            geocoder.geocode({
                'location': latlng
            }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        input.value = results[0].formatted_address;
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });

            // console.log(evt.domEvent);
        });

        google.maps.event.addListener(myMarker, 'dragstart', function(evt) {
            document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
        });

        // auto complete function
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            $('#latitude').val(place.geometry['location'].lat());
            $('#longitude').val(place.geometry['location'].lng());
            console.log(place);
            // address_detail

            lat = place.geometry['location'].lat();
            lng = place.geometry['location'].lng();

            var latlng = new google.maps.LatLng(lat, lng);
            myMarker.setPosition(latlng);
            map.setCenter(latlng);
        });

        map.setCenter(myMarker.position);
        myMarker.setMap(map);
    </script>
@endsection
