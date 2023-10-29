@extends('layouts.app')
@section('title', 'معلومات المؤسسة')
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
                        <div class="card-title">معلومات المؤسسة</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="users-view-image">
                                <img src="{{ asset('storage/' . $mfiProvider->profile_pic) }}"
                                    class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                            </div>
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">إسم :</td>
                                        <td>{{ $mfiProvider->name_ar }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">البريد الالكتروني:</td>
                                        <td>{{ $mfiProvider->business_email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">رقم الهاتف:</td>
                                        <td>{{ $mfiProvider->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">تاريخ الانشاء:</td>
                                        <td>{{ $mfiProvider->created_at->format('Y-m-d') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">العنوان:</td>
                                        <td>{{ $mfiProvider->address }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <table class="ml-0 ml-sm-0 ml-lg-0">
                                    <tr>
                                        <td class="font-weight-bold">حالة المؤسسة:</td>
                                        <td>
                                            @if ($mfiProvider->is_active == 1)
                                                <span class="badge badge-success">نشط</span>
                                            @else
                                                <span class="badge badge-danger">غير نشط</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">الوصف:</td>
                                        <td>
                                            {{ $mfiProvider->description_ar }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 mt-3">
                                <a href="/panel-admin/mfis/{{ $mfiProvider->id }}/edit" class="btn btn-primary mr-1"><i
                                        class="feather icon-edit-1"></i> تعديل</a>
                                <button class="btn btn-outline-danger"
                                    onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $mfiProvider->id }}').submit();}else{
                                event.preventDefault();}"><i
                                        class="feather icon-trash-2"></i> حذف</button>
                                <form id="delete-users_{{ $mfiProvider->id }}"
                                    action="/panel-admin/mfis/{{ $mfiProvider->id }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom mx-2 px-0">
                        <h6 class="border-bottom py-1 mb-0 font-medium-2"><i class="fa fa-users mr-50 "></i>طلبات التمويل
                        </h6>
                    </div>
                    <div class="card-body">
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
                                    @foreach ($mfiProvider->form_request as $key => $form_request)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $form_request->form_request_id }}</td>
                                            <td>{{ $form_request->beneficiary->name }}</td>
                                            <td>{{ $form_request->beneficiary->email ?? '-' }}</td>
                                            <td>{{ $form_request->beneficiary->phone }}</td>
                                            <td>{{ $form_request->beneficiary->age }}</td>
                                            <td>
                                                @if ($form_request->status_id == 1)
                                                    <span
                                                        class="badge badge-info">{{ $form_request->status->status_desc }}</span>
                                                @elseif($form_request->status_id == 2)
                                                    <span class="badge badge-light">
                                                        {{ $form_request->status->status_desc }}</span>
                                                @elseif($form_request->status_id == 3)
                                                    <span class="badge badge-success">
                                                        {{ $form_request->status->status_desc }}</span>
                                                @elseif($form_request->status_id == 4)
                                                    <span
                                                        class="badge badge-danger">{{ $form_request->status->status_desc }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $form_request->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="/panel-admin/form-requets/{{ $form_request->id }}"
                                                    class="btn btn-info">
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
            <!-- permissions start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom mx-2 px-0">
                        <h6 class="border-bottom py-1 mb-0 font-medium-2"><i class="fa fa-users mr-50 "></i>المستخدمين
                        </h6>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            إضافة
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive users-view-permission">
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th>الإسم</th>
                                        <th>البريد الألكتروني</th>
                                        <th>رقم الهاتف</th>
                                        <th>حالة الحساب</th>
                                        <th>خياراتي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mfiProvider->mfi_users as $key => $user)
                                        <tr>
                                            <td style="min-width: 60px;">{{ ++$key }}</td>
                                            <td>
                                                <div class="avatar mr-1 avatar-xl">
                                                    <img src="{{ asset('storage/' . $user->profile_pic) }}"
                                                        alt="avtar img holder" style="object-fit: cover">
                                                </div>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
                                                @if ($user->is_active == 1)
                                                    <span class="badge badge-success">نشط</span>
                                                @else
                                                    <span class="badge badge-danger">غير نشط</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-success" name="edit_button"
                                                    value="{{ $user->id }}" data-toggle="modal"
                                                    data-target="#edit_modal"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger mr-2"
                                                    onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-mfis-users_{{ $user->id }}').submit();}else{
                                            event.preventDefault();}"><i
                                                        class="fa fa-trash"></i></button>
                                                <form id="delete-mfis-users_{{ $user->id }}"
                                                    action="/panel-admin/mfis-users/{{ $user->id }}" method="POST"
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

            <!-- permissions end -->
        </div>
    </section>
    <!-- page users view end -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة مستخدمين </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/mfis-users" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $mfiProvider->id }}" name="mfi_provider_id">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">الإسم</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" placeholder="الإسم" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">البريد الألكتروني</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" placeholder="البريد الألكتروني" value="{{ old('email') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">رقم الهاتف</label>
                                        <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" placeholder="رقم الهاتف" value="{{ old('phone') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">كلمة السر</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="كلمة السر" value="{{ old('password') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">الصورة</label>
                                        <input type="file"
                                            class="form-control @error('profile_pic') is-invalid @enderror"
                                            name="profile_pic" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">حالة الحساب</label>
                                        <select name="is_active" class="form-control" required>
                                            <option value="1" @selected(old('is_active') == 1)>نشط</option>
                                            <option value="0" @selected(old('is_active') == 0)>غير نشط</option>
                                        </select>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
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
                $.get("/panel-admin/mfis-users/" + edit_val + "/edit", function(data, status) {
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
