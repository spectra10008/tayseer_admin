@extends('layouts.app')
@section('title', 'انشاء تاجر')
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
                <h2 class="content-header-title float-left mb-0">إنشاء تاجر</h2>
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
                        <h4 class="card-title">إنشاء تاجر</h4>
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
                            <form class="form form-vertical" action="/panel-admin/vendors" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">مؤسسة التمويل</label>
                                                <select class="select2 form-control" name="mfi_provider_id" required>
                                                    <option value="">إختار</option>
                                                    @foreach ($mfis as $mfi)
                                                        <option value="{{ $mfi->id }}"@selected($mfi->id == old('mfi_provider_id'))>
                                                            {{ $mfi->name_ar }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">إسم التاجر</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name" placeholder="اسم التاجر" value="{{ old('name') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">البريد الألكتروني</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" placeholder="البريد الألكتروني" value="{{ old('email') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">رقم الهاتف</label>
                                                <input type="number"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" placeholder="رقم الهاتف" value="{{ old('phone') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">العنوان</label>
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    name="address" placeholder="العنوان" value="{{ old('address') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="first-name-vertical">صورة</label>
                                                <input type="file"
                                                    class="form-control @error('profile_pic') is-invalid @enderror"
                                                    name="profile_pic">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">معلومات البيع</label>
                                                <textarea name="sale_info" class="form-control ckeditor"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="autocomplete"> موقع المتجر على الخريطة</label>
                                                <input type="text" name="autocomplete" id="autocomplete"
                                                    class="form-control" placeholder="الموقع">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">latitude</label>
                                                <input type="text" name="latitude" id="latitude" readonly
                                                    class="form-control" value="{{ old('latitude') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">longitude</label>
                                                <input type="text" name="longitude" id="longitude" readonly
                                                    class="form-control" value="{{ old('longitude') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div id='map_canvas'></div>
                                                {{-- <div id="current">Nothing yet...</div> --}}
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
        src="https://maps.google.com/maps/api/js?key=AIzaSyA-CFZMuoj6iTzpFJCGUrQUmrQuuw-ZZiE&libraries=places&callback=initAutocomplete"
        type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $("#lat_area").addClass("d-none");
            $("#long_area").addClass("d-none");
        });
    </script>



    <?php
    $lat = 15.5745709;
    $lng = 32.5485763;
    // print_r(getLocationsInRadius($lat,$lng,100));
    ?>
    <script>
        var lat = '15.5745709';
        var lng = '32.5485763';

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
@endsection
