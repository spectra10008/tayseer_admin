@extends('layouts.app')
@section('title', 'إضافة منتج')
@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> إضافة منتج</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" action="/panel-admin/loans-products" method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">إسم المنتج</label>
                                                <input type="text"
                                                    class="form-control @error('product_name') is-invalid @enderror"
                                                    name="product_name" placeholder="إسم المنتج"
                                                    value="{{ old('product_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">وصف المنتج</label>
                                                <textarea name="product_desc" class="ckeditor form-control @error('product_desc') is-invalid @enderror" required>{{ old('product_desc') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">شروط المنتج</label>
                                                <textarea name="product_requirments" class="ckeditor form-control @error('product_requirments') is-invalid @enderror"
                                                    required>{{ old('product_requirments') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">إنشاء</button>
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
