@extends('layouts.app')
@section('title', 'عرض بيانات المشروع')
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
                        <div class="card-title">معلومات المشروع</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php($img = Str::substr($project->image, 7))
                            <div class="users-view-image">
                                <img src="{{ asset('storage/' . $img) }}"
                                    class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                            </div>
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">إسم المشروع:</td>
                                        <td>{{ $project->project_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">العنوان:</td>
                                        <td>{{ $project->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">حالة المشروع:</td>
                                        <td>
                                            @if ($project->status == 'running')
                                                <span class="badge badge-success">يعمل الأن</span>
                                            @elseif($project->status == 'not_working')
                                                <span class="badge badge-success">لا يعمل</span>
                                            @elseif($project->status == 'no_start_yet')
                                                <span class="badge badge-success">لم يبدأ بعد</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($project->status != 'no_start_yet')
                                    <tr>
                                        <td class="font-weight-bold">تاريخ البداية:</td>
                                        <td>{{ $project->start_date }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <table class="ml-0 ml-sm-0 ml-lg-0">
                                    <tr>
                                        <td class="font-weight-bold">قيمة التمويل المطلوبة:</td>
                                        <td>
                                            {{ $project->fund_amount_need_sdg }} ج.س
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 mt-3">
                                <a href="/panel-admin/projects/{{ $project->id }}/edit" class="btn btn-primary mr-1"><i
                                        class="feather icon-edit-1"></i> تعديل</a>
                                <button class="btn btn-outline-danger"
                                    onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $project->id }}').submit();}else{
                                event.preventDefault();}"><i
                                        class="feather icon-trash-2"></i> حذف</button>
                                <form id="delete-users_{{ $project->id }}" action="/panel-admin/projects/{{ $project->id }}"
                                    method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- account end -->
            <div class="col-md-12 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-2">وصف المشروع</div>
                    </div>
                    <div class="card-body">
                        {!! $project->desc !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-2">احتياجات المشروع</div>
                    </div>
                    <div class="card-body">
                        {!! $project->need !!}
                    </div>
                </div>
            </div>
            @if($project->notes != null)
            <div class="col-md-12 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-2">ملاحظات</div>
                    </div>
                    <div class="card-body">
                        {!! $project->notes !!}
                    </div>
                </div>
            </div>
            @endif
            <!-- permissions start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom mx-2 px-0">
                        <h6 class="border-bottom py-1 mb-0 font-medium-2"><i class="fa fa-users mr-50 "></i>المشتركين في المشروع
                        </h6>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            إضافة
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive users-view-permission">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم المستفيد</th>
                                        <th>البريد الالكتروني</th>
                                        <th>رقم الهاتف</th>
                                        <th>العمر</th>
                                        <th>خياراتي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->beneficiary_project as $key => $beneficiary)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $beneficiary->name }}</td>
                                        <td>{{ $beneficiary->email }}</td>
                                        <td>{{ $beneficiary->phone }}</td>
                                        <td>{{ $beneficiary->age }}</td>
                                        <td>
                                            <a href="/panel-admin/delete-beneficiaries-project/{{ $beneficiary->id }}" class="btn btn-danger mr-2"
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
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">الملفات</div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadfile">
                            اضافة
                        </button>
                    </div>
                    <div class="card-body">
                        <table>
                            @if($project->files->count() != 0)
                            @foreach ($project->files as $file)
                            @php($file_path = Str::substr($file->file, 7))
                            <tr>
                                <td class="font-weight-bold">{{$file->file_name}}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $file_path) }}" class="btn btn-primary" download> <i
                                            class="fa fa-download"></i> </a>

                                    <a href="/panel-admin/delete-project-file/{{ $file->id }}" onclick="if(!confirm('هل أنت متأكد ؟')){event.preventDefault();}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            لا يوجد ملف
                            @endif
                        </table>
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
                    <h5 class="modal-title" id="exampleModalLabel">إضافة مشتركين للمشروع</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/add-beneficiaries-project" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value={{ $project->id }}>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">الاسم</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">البريد الالكتروني</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">رقم الهاتف</label>
                                        <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">العمر</label>
                                        <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">العنوان</label>
                                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" required>
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
        <!-- Modal -->
        <div class="modal fade" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form class="form form-vertical" action="/panel-admin/add-project-file" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $project->id }}" name="project_id">
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
@endsection
