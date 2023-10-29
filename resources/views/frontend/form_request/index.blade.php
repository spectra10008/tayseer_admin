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
                        <div class="all-steps" id="all-steps"> <span class="step"></span> <span class="step"></span>
                            <span class="step"></span> <span class="step"></span>
                        </div>
                        <form id="regForm" method="POST" action="/form-request" enctype="multipart/form-data">
                            @csrf
                            <div class="tab">
                                <div class="row mt-2">
                                    <h5 class="mb-4">المعلومات الشخصية</h4>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">الاسم <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror required"
                                                name="name" placeholder="اسمك الرباعي" value="{{ old('name') }}"
                                                required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputPassword1" class="form-label">الجنس <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                                                <option value="">إختار</option>
                                                <option value="male"@selected(old('gender') == 'male')>ذكر</option>
                                                <option value="female"@selected(old('gender') == 'female')>أنثى</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">البريد الالكتروني </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" placeholder="بريدك الألكتروني" value="{{ old('email') }}">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">رقم الهاتف <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="number" class="form-control @error('phone') is-invalid @enderror required"
                                                name="phone" placeholder="رقم هاتفك" value="{{ old('phone') }}" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">العمر <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="number" class="form-control @error('age') is-invalid @enderror required"
                                                name="age" placeholder="عمرك" value="{{ old('age') }}" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">الرقم الوطني <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="number"
                                                class="form-control @error('id_number') is-invalid @enderror required"
                                                name="id_number" placeholder="رقمك الوطني" value="{{ old('id_number') }}"
                                                required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">الحالة الاجتماعية <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <select name="social_situation_id"
                                                class="form-select @error('social_situation_id') is-invalid @enderror required"
                                                required>
                                                <option value="">إختار</option>
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}"@selected($status->id == old('social_situation_id'))>
                                                        {{ $status->situation_desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">عدد الاولاد  <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="number"
                                                class="form-control @error('children_no') is-invalid @enderror required"
                                                name="children_no" placeholder="عدد الأولاد"
                                                value="{{ old('children_no') }}" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">العنوان <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror required" name="address"
                                                placeholder="عنوانك" value="{{ old('address') }}" required>
                                        </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="row">
                                    <h5 class="mb-4 mt-2">المعلومات البنكية</h4>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">لديك حساب بنكي ؟ <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <select name="is_bank_account"
                                                class="form-select @error('is_bank_account') is-invalid @enderror required"
                                                required>
                                                <option value="">إختار</option>
                                                <option value="0" @selected(old('is_bank_account') == 0)>لا</option>
                                                <option value="1" @selected(old('is_bank_account') == 1)>نعم</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3 bank_id d-none">
                                            <label for="exampleInputPassword1" class="form-label">البنك <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <select name="bank_id"
                                                class="form-select @error('bank_id') is-invalid @enderror">
                                                <option value="">إختار</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}" @selected(old('bank_id') == $bank->id)>
                                                        {{ $bank->bank_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3 account_no d-none">
                                            <label for="exampleInputEmail1" class="form-label">رقم الحساب <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="number"
                                                class="form-control @error('account_no') is-invalid @enderror"
                                                name="account_no" placeholder="رقم الحساب"
                                                value="{{ old('account_no') }}">
                                        </div>
                                        <div class="col-6 mb-3 branch_name d-none">
                                            <label for="exampleInputEmail1" class="form-label">الفرع <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="text"
                                                class="form-control @error('branch_name') is-invalid @enderror"
                                                name="branch_name" placeholder="اسم الفرع"
                                                value="{{ old('branch_name') }}">
                                        </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="row">
                                    <h5 class="mb-4 mt-2">معلومات المشروع والتمويل</h4>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">اسم المشروع <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="text"
                                                class="form-control @error('project_name') is-invalid @enderror required"
                                                name="project_name" placeholder="اسم المشروع"
                                                value="{{ old('project_name') }}" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputPassword1" class="form-label">القطاع <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <select name="project_sector_id"
                                                class="form-select @error('project_sector_id') is-invalid @enderror required"
                                                required>
                                                <option value="">إختار</option>
                                                @foreach ($sectors as $sector)
                                                    <option value="{{ $sector->id }}"@selected($sector->id == old('project_sector_id'))>
                                                        {{ $sector->sector_desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputPassword1" class="form-label">نوع التمويل <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <select name="fund_type_id"
                                                class="form-select @error('fund_type_id') is-invalid @enderror required" required>
                                                <option value="">إختار</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}"@selected($type->id == old('fund_type_id'))>
                                                        {{ $type->type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">قيمة التمويل المطلوبة
                                                بالجنيه <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="text"
                                                class="form-control @error('project_fund_need') is-invalid @enderror required"
                                                name="project_fund_need"
                                                placeholder="قيمة التمويل المطلوب بالجنيه السوداني"
                                                value="{{ old('project_fund_need') }}" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">تفاصيل المشروع <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <textarea name="project_desc" class="ckeditor form-control @error('project_desc') is-invalid @enderror required" required
                                                rows="10">{{ old('project_desc') }}</textarea>
                                        </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="row">
                                    <h5 class="mb-4 mt-2">ملفات المشروع</h4>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">الصورة الشخصية <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="file"
                                                class="form-control @error('personal_image') is-invalid @enderror required"
                                                name="personal_image" required value="{{ old('personal_image') }}">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">صورة الهوية <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="file"
                                                class="form-control @error('id_file') is-invalid @enderror required"
                                                name="id_file" value="{{ old('id_file') }}">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="exampleInputEmail1" class="form-label">دراسة الجدوى <span class="asterisk"><i class="fa fa-asterisk"></i> </span> </label>
                                            <input type="file"
                                                class="form-control @error('feasibility_study_file') is-invalid @enderror required"
                                                name="feasibility_study_file"
                                                value="{{ old('feasibility_study_file') }}">
                                        </div>
                                </div>
                            </div>
                            <div style="overflow:auto;" id="nextprevious" class="mt-4">
                                <div style="float:right;"><button type="button" id="prevBtn"
                                        onclick="nextPrev(-1)">السابق</button>
                                    <button type="button" id="nextBtn" onclick="nextPrev(1)">التالي</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
