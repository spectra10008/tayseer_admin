@extends('frontend.form_request.layouts.app')
@section('content')
    <section class="form_section mb-5">
        <div class="container">
            <div class="col-12">
                <div class="col-6 mx-auto mb-4">
                    <h4 class="text-center mb-3">
                        استمارة طلب تمويل
                    </h4>
                </div>
                <div class="col-6 mx-auto">
                    <p class="text-center">
                        الرجاء ملء الفورم ادناه حتى نحصل على فهم افضل لاحتياجات العمل الخاص بك ومنتجاتك ، احد اعضاء الفريق
                        الخاص بنا
                        سوف يتواصل معك خلال ٢٤ ساعه
                    </p>
                </div>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    @php(toastr()->error($error))
                @endforeach
            @endif
            <div class="col-8 mx-auto mt-5">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="col-12 mb-5 mt-5">
                            <img src="{{ asset('frontend/form_request/images/check.png') }}" alt="" style="width:150px" class="mx-auto d-block">
                        </div>
                         <h4 class="text-center mb-3">تم استلام طلبك بنجاح !!</h4>
                         <p class="text-center mb-5">سيقوم الفريق العامل بالتواصل معك خلال ٢٤ ساعة قادمة </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
