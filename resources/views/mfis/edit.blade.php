@extends('layouts.app')
@section('title', 'تعديل مؤسسة تمويل')
@section('content')
    {{-- <style>
        #map_canvas {

            max-width: 100%;

            height: 300px;

        }

        .iti {
            width: 100%;
        }
    </style> --}}
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل مؤسسة تمويل</h2>
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
                            <h4 class="card-title">تعديل مؤسسة تمويل</h4>
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
                                <form class="form form-vertical" action="/panel-admin/mfis/{{ $mfiProvider->id }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $mfiProvider->id }}">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">إسم المؤسسة عربي</label>
                                                    <input type="text"
                                                        class="form-control @error('name_ar') is-invalid @enderror"
                                                        name="name_ar" placeholder="اسم المؤسسة عربي"
                                                        value="{{ old('name_ar',$mfiProvider->name_ar) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">إسم المؤسسة انجليزي</label>
                                                    <input type="text"
                                                        class="form-control @error('name_en') is-invalid @enderror"
                                                        name="name_en" placeholder="اسم المؤسسة انجليزي"
                                                        value="{{ old('name_en',$mfiProvider->name_en) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">البريد الالكتروني</label>
                                                    <input type="text"
                                                        class="form-control @error('business_email') is-invalid @enderror"
                                                        name="business_email" placeholder="البريد الالكتروني"
                                                        value="{{ old('business_email',$mfiProvider->business_email) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">رقم الهاتف</label>
                                                    <input type="text"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        name="phone" placeholder="رقم الهاتف"
                                                        value="{{ old('phone',$mfiProvider->phone) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">تفاصيل المؤسسة عربي</label>
                                                    <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror" required>{{ old('description_ar',$mfiProvider->description_ar) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">تفاصيل المؤسسة انجليزي</label>
                                                    <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" required>{{ old('description_en',$mfiProvider->description_en) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">العنوان</label>
                                                    <input type="text"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        name="address" placeholder="العنوان" value="{{ old('address',$mfiProvider->address) }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">صورة البروفايل </label>
                                                    <input type="file"
                                                        class="form-control @error('profile_pic') is-invalid @enderror"
                                                        name="profile_pic" value="{{ old('profile_pic',$mfiProvider->profile_pic) }}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">حالة الحساب</label>
                                                    <select name="is_active" class="form-control" required>
                                                        <option value="">اختار</option>
                                                        <option value="1" @selected(old('is_active',$mfiProvider->is_active) == 1)>نشط</option>
                                                        <option value="0" @selected(old('is_active',$mfiProvider->is_active) == 0)>غير نشط</option>
                                                    </select>
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
        $(document).ready(function() {
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
    if (old('latitude') != null) {
        $lat = old('latitude');
    } else {
        $lat = '15.5745709';
    }
    if (old('longitude') != null) {
        $lng = old('longitude');
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

    <?php $old_status = old('status'); ?>
    <script>
        $(document).ready(function() {
            if (@json($old_status) != "no_start_yet" && @json($old_status) != null) {
                $('.start_date').removeClass('d-none');
            }else {
                    $('.start_date').addClass('d-none');
            }
            $("select[name='status']").change(function() {
                var select_id = this.value;
                if (select_id != "no_start_yet") {
                    $('.start_date').removeClass('d-none');
                } else {
                    $('.start_date').addClass('d-none');
                }
            });
        });
    </script>
@endsection
