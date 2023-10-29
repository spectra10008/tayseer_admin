@extends('layouts.app')
@section('title', 'عرض بيانات المستفيد')
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
                        <div class="card-title">معلومات المستفيد</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php($img = Str::substr($beneficiary->image, 7))
                            <div class="users-view-image">
                                <img src="{{ asset('storage/' . $img) }}"
                                    class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                            </div>
                            <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                <table>
                                    <tr>
                                        <td class="font-weight-bold">الإسم</td>
                                        <td>{{ $beneficiary->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">البريد الألكتروني</td>
                                        <td>{{ $beneficiary->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">رقم الهاتف</td>
                                        <td>{{ $beneficiary->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">العنوان</td>
                                        <td>{{ $beneficiary->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">الرقم الوطني</td>
                                        <td>{{ $beneficiary->id_number }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <table class="ml-0 ml-sm-0 ml-lg-0">
                                    <tr>
                                        <td class="font-weight-bold">الجنس</td>
                                        <td>
                                            @if ($beneficiary->gender == 'male')
                                                ذكر
                                            @else
                                                أنثى
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">العمر</td>
                                        <td>{{ $beneficiary->age }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">الحالة الاجتماعية</td>
                                        <td>{{ $beneficiary->social_status->situation_desc }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">عدد الأطفال</td>
                                        <td>{{ $beneficiary->children_no }}</td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-12 mt-3">
                                <a href="/panel-admin/beneficiaries/{{ $beneficiary->id }}/edit"
                                    class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> تعديل</a>
                                <button class="btn btn-outline-danger"
                                    onclick="if(confirm('هل أنت متأكد ؟')){document.getElementById('delete-users_{{ $beneficiary->id }}').submit();}else{
                                event.preventDefault();}"><i
                                        class="feather icon-trash-2"></i> حذف</button>
                                <form id="delete-users_{{ $beneficiary->id }}"
                                    action="/panel-admin/beneficiaries/{{ $beneficiary->id }}" method="POST"
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
                                    @if ($beneficiary->bank_id == 1)
                                        نعم
                                    @else
                                        لا
                                    @endif
                                </td>
                            </tr>
                            @if ($beneficiary->bank_id == 1)
                                <tr>
                                    <td class="font-weight-bold">اسم البنك</td>
                                    <td>
                                        {{ $beneficiary->bank->bank_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">اسم الفرع </td>
                                    <td> {{ $beneficiary->branch_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">رقم الحساب</td>
                                    <td>{{ $beneficiary->account_no }}
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
                        @php($id_file = Str::substr($beneficiary->id_image, 7))
                        <table>
                            <tr>
                                <td class="font-weight-bold">الرقم الوطني</td>
                                <td>
                                    <a href="{{ asset('storage/' . $id_file) }}" class="btn btn-primary" download> <i
                                            class="fa fa-download"></i> </a>
                                </td>

                            </tr>
                            @foreach ($beneficiary->files as $file)
                            @php($file_path = Str::substr($file->file, 7))
                            <tr>
                                <td class="font-weight-bold">{{$file->file_name}}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $file_path) }}" class="btn btn-primary" download> <i
                                            class="fa fa-download"></i> </a>

                                    <a href="/panel-admin/delete-beneficiaries-file/{{ $file->id }}" onclick="if(!confirm('هل أنت متأكد ؟')){event.preventDefault();}" class="btn btn-danger"> <i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            @php($locations = explode(',', $beneficiary->location_on_map))
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
                                        value="{{ old('latitude', $locations[0]) }}" required>
                                </div>
                            </div>
                            <div class="col-4 d-none">
                                <div class="form-group">
                                    <label for="contact-info-vertical">longitude</label>
                                    <input type="text" name="longitude" id="longitude" readonly class="form-control"
                                        value="{{ old('longitude', $locations[1]) }}" required>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom mx-2 px-0">
                        <h6 class="border-bottom py-1 mb-0 font-medium-2"><i class="fa fa-file-pdf-o mr-50 "></i>طلبات التمويل
                        </h6>
                    </div>
                    <div class="card-body px-75">
                        <div class="table-responsive users-view-permission">
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
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
                                    @if($beneficiary->beneficiary_requests->count() != 0)
                                        @foreach ($beneficiary->beneficiary_requests as $key => $form_request)
                                            <tr>
                                                <td>{{ $form_request->requests->id }}</td>
                                                <td>{{ $form_request->requests->name }}</td>
                                                <td>{{ $form_request->requests->email }}</td>
                                                <td>{{ $form_request->requests->phone }}</td>
                                                <td>{{ $form_request->requests->age }}</td>
                                                <td>
                                                    @if ($form_request->requests->status_id == 1)
                                                    <span class="badge badge-info">{{$form_request->requests->status->status_desc}}</span>
                                                    @elseif($form_request->requests->status_id == 2)
                                                    <span class="badge badge-light">
                                                        {{$form_request->requests->status->status_desc}}</span>
                                                    @elseif($form_request->requests->status_id == 3)
                                                        <span class="badge badge-success">
                                                            {{$form_request->requests->status->status_desc}}</span>
                                                    @elseif($form_request->requests->status_id == 4)
                                                    <span class="badge badge-danger">{{$form_request->requests->status->status_desc}}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $form_request->requests->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="/panel-admin/form-requets/{{$form_request->requests->id}}" class="btn btn-info">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="9">لا تتوفر طلبات للمستفيد</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
                    <form class="form form-vertical" action="/panel-admin/add-beneficiaries-file" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $beneficiary->id }}" name="beneficiary_id">
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
@section('scriptjs')
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
