@extends('layouts.app')
@section('title', 'تعديل بيانات الطلب')
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
                <h2 class="content-header-title float-left mb-0">تعديل بيانات الطلب</h2>
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
                        <h4 class="card-title">تعديل بيانات الطلب</h4>
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
                            <form class="form form-vertical" action="/panel-admin/form-requets/{{$formRequest->id}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">إسم مستفيد</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="اسم مستفيد" value="{{ old('name',$formRequest->name) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">الجنس</label>
                                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                                    <option value="">إختار</option>
                                                    <option value="male"@selected(old('gender',$formRequest->gender) == 'male')>ذكر</option>
                                                    <option value="female"@selected(old('gender',$formRequest->gender) == 'female')>أنثى</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">البريد الألكتروني</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" placeholder="البريد الألكتروني" value="{{ old('email',$formRequest->email) }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">رقم الهاتف</label>
                                                <input type="number"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" placeholder="رقم الهاتف" value="{{ old('phone',$formRequest->phone) }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">العمر</label>
                                                <input type="number" class="form-control @error('age') is-invalid @enderror" name="age" placeholder="العمر" value="{{ old('age',$formRequest->age) }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">الرقم الوطني</label>
                                                <input type="number" class="form-control @error('id_number') is-invalid @enderror" name="id_number" placeholder="الرقم الوطني" value="{{ old('id_number',$formRequest->id_number) }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">الحالة الاجتماعية</label>
                                                <select name="social_situation_id" class="form-control @error('social_situation_id') is-invalid @enderror" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($statuses as $status)
                                                    <option value="{{$status->id}}"@selected($status->id == old('social_situation_id',$formRequest->social_situation_id))>{{$status->situation_desc}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">عدد الأولاد</label>
                                                <input type="number" class="form-control @error('children_no') is-invalid @enderror" name="children_no" placeholder="عدد الأولاد" value="{{ old('children_no',$formRequest->children_no) }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">العنوان</label>
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="العنوان" value="{{ old('address',$formRequest->address) }}" required>
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
                                                    <option value="0" @selected(old('is_bank_account',$formRequest->is_bank_account) == 0)>لا</option>
                                                    <option value="1" @selected(old('is_bank_account',$formRequest->is_bank_account) == 1)>نعم</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4 bank_id d-none">
                                            <div class="form-group">
                                                <label for="first-name-vertical">اسم البنك</label>
                                                <select name="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                                    <option value="">إختار</option>
                                                    @foreach ($banks as $bank)
                                                    <option value="{{$bank->id}}" @selected(old('bank_id',$formRequest->bank_id) == $bank->id)>{{$bank->bank_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4 branch_name d-none">
                                            <div class="form-group">
                                                <label for="first-name-vertical">اسم الفرع</label>
                                                <input type="text" class="form-control @error('branch_name') is-invalid @enderror" name="branch_name" placeholder="اسم الفرع" value="{{ old('branch_name',$formRequest->branch_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-4 account_no d-none">
                                            <div class="form-group">
                                                <label for="first-name-vertical">رقم الحساب</label>
                                                <input type="number" class="form-control @error('account_no') is-invalid @enderror" name="account_no" placeholder="رقم الحساب" value="{{ old('account_no',$formRequest->account_no) }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12">
                                            <h5>
                                                معلومات المشروع والتمويل
                                            </h5>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">إسم المشروع</label>
                                                <input type="text"
                                                    class="form-control @error('project_name') is-invalid @enderror"
                                                    name="project_name" placeholder="اسم المجموعة"
                                                    value="{{ old('project_name',$formRequest->project_name) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4 sector_id">
                                            <div class="form-group">
                                                <label for="first-name-vertical">القطاع</label>
                                                <select name="project_sector_id"
                                                    class="form-control @error('project_sector_id') is-invalid @enderror"
                                                    required>
                                                    <option value="">إختار</option>
                                                    @foreach ($sectors as $sector)
                                                        <option value="{{ $sector->id }}"@selected($sector->id == old('project_sector_id',$formRequest->project_sector_id))>
                                                            {{ $sector->sector_desc }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">نوع التمويل</label>
                                                <select name="fund_type_id"
                                                    class="form-control @error('fund_type_id') is-invalid @enderror"
                                                    required>
                                                    <option value="">إختار</option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}"@selected($type->id == old('fund_type_id',$formRequest->fund_type_id))>
                                                            {{ $type->type_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">قيمة التمويل المطلوب بالجنيه
                                                    السوداني</label>
                                                <input type="text"
                                                    class="form-control @error('project_fund_need') is-invalid @enderror"
                                                    name="project_fund_need"
                                                    placeholder="قيمة التمويل المطلوب بالجنيه السوداني"
                                                    value="{{ old('project_fund_need',$formRequest->project_fund_need) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">معلومات المشروع</label>
                                                <textarea name="project_desc" class="ckeditor form-control @error('project_desc') is-invalid @enderror" required>{{ old('project_desc',$formRequest->project_desc) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">ملاحظات</label>
                                                <textarea name="notes" class=" ckeditor form-control @error('notes') is-invalid @enderror">{{ old('notes',$formRequest->notes) }}</textarea>
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
                                                <label for="first-name-vertical">الصورة الشخصية</label>
                                                <input type="file"
                                                    class="form-control @error('personal_image') is-invalid @enderror"
                                                    name="personal_image" value="{{old('personal_image')}}">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">صورة الهوية</label>
                                                <input type="file"
                                                    class="form-control @error('id_file') is-invalid @enderror"
                                                    name="id_file" value="{{old('id_file')}}">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">دراسة الجدوى </label>
                                                <input type="file"
                                                    class="form-control @error('feasibility_study_file') is-invalid @enderror"
                                                    name="feasibility_study_file" value="{{old('feasibility_study_file')}}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <?php if($formRequest->location_on_map != null){$locations=explode(',',$formRequest->location_on_map);}else{$locations=array("15.5745709", "32.5485763");} ?>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="autocomplete"> موقع المتجر على الخريطة</label>
                                                <input type="text" name="autocomplete" id="autocomplete"
                                                    class="form-control" placeholder="الموقع" value="{{old('autocomplete',$formRequest->address)}}">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">latitude</label>
                                                <input type="text" name="latitude" id="latitude" readonly
                                                    class="form-control" value="{{ old('latitude',$locations[0]) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">longitude</label>
                                                <input type="text" name="longitude" id="longitude" readonly
                                                    class="form-control" value="{{ old('longitude',$locations[1]) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div id='map_canvas'></div>
                                                {{-- <div id="current">Nothing yet...</div> --}}
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
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyCgBcmRxPDyddm0cL8jqRm9ZMGKRtFpw78&libraries=places&callback=initAutocomplete"
        type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $("#lat_area").addClass("d-none");
            $("#long_area").addClass("d-none");
        });
    </script>



    <?php
        if ($locations[0] != null) {
        $lat = $locations[0];
    } else {
        $lat = '15.5745709';
    }
    if ($locations[1] != null) {
        $lng = $locations[1];
    } else {
        $lng = '32.5485763';
    }
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
            draggable: true,
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
    <script>
        $(document).ready(function(){
        $("select[name='city_id']").change(function(){
            var city_id = this.value;
            $('select[name="area_id"]').html(" ");
            $('select[name="area_id"]').append($('<option>', {
                        value: " ",
                        text : "إختار"
                    }));
            $.get("/admin/get-areas/"+city_id, function(data, status){
                $('.areas').removeClass('d-none');
                $.each(data, function (i, item) {
                    $('select[name="area_id"]').append($('<option>', {
                        value: item.id,
                        text : item.area_name
                    }));
                });
            });
        });
        });
    </script>
    <?php $old_is_bank = $formRequest->is_bank_account; ?>
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
@endsection
