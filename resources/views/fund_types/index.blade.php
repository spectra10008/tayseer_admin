@extends('layouts.app')
@section('title', 'انواع التمويل')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> انواع التمويل</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">انواع التمويل</h4>
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
                                        <th>نوع التمويل</th>
                                        <th>خياراتي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($types as $key => $type)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $type->type_name }}</td>
                                            <td>
                                                <button class="btn btn-success" name="edit_button"
                                                    value="{{ $type->id }}" data-toggle="modal"
                                                    data-target="#edit_modal"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger mr-2"
                                                    onclick="if(!confirm('هل أنت متأكد ؟')){event.preventDefault();}"><i
                                                        class="fa fa-trash"></i></button>
                                                <form id="delete-users_{{ $type->id }}"
                                                    action="/panel-admin/fund-types/{{ $type->id }}" method="POST"
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
                    <h4 class="modal-title" id="myModalLabel1">إضافة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-vertical" action="/panel-admin/fund-types" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">نوع التمويل</label>
                                        <input type="text" class="form-control @error('type_name') is-invalid @enderror"
                                            name="type_name" placeholder="نوع التمويل" value="{{ old('type_name') }}"
                                            required>
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
                $.get("/panel-admin/fund-types/" + edit_val + "/edit", function(data, status) {
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
