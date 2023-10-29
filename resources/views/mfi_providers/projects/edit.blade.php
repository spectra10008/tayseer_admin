@extends('layouts.app')
@section('title', 'تعديل بيانات مشروع')
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
                    <h2 class="content-header-title float-left mb-0">تعديل بيانات مشروع</h2>
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
                            <h4 class="card-title">تعديل بيانات مشروع</h4>
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
                                <form class="form form-vertical" action="/panel-admin/projects/{{ $project->id }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">إسم المشروع</label>
                                                    <input type="text"
                                                        class="form-control @error('project_name') is-invalid @enderror"
                                                        name="project_name" placeholder="اسم المجموعة"
                                                        value="{{ old('project_name', $project->project_name) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">العنوان</label>
                                                    <input type="text"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        name="address" placeholder="العنوان"
                                                        value="{{ old('address', $project->address) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-4 sector_id">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">القطاع</label>
                                                    <select name="sector_id"
                                                        class="form-control @error('sector_id') is-invalid @enderror"
                                                        required>
                                                        <option value="">إختار</option>
                                                        @foreach ($sectors as $sector)
                                                            <option value="{{ $sector->id }}"@selected($sector->id == old('sector_id', $project->sector_id))>
                                                                {{ $sector->sector_desc }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">حالة المشروع</label>
                                                    <select name="status"
                                                        class="form-control @error('status') is-invalid @enderror" required>
                                                        <option value="">إختار</option>
                                                        <option value="running"@selected(old('status', $project->status) == 'running')>يعمل</option>
                                                        <option value="not_working"@selected(old('status', $project->status) == 'not_working')>توقف
                                                        </option>
                                                        <option value="no_start_yet"@selected(old('status', $project->status) == 'no_start_yet')>لم يبدأ بعد
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 start_date d-none">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">تاريخ بداية المشروع</label>
                                                    <input type="date"
                                                        class="form-control @error('start_date') is-invalid @enderror"
                                                        name="start_date" placeholder="تاريخ بداية المشروع"
                                                        value="{{ old('start_date', $project->start_date) }}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">قيمة التمويل المطلوب بالجنيه
                                                        السوداني</label>
                                                    <input type="text"
                                                        class="form-control @error('fund_amount_need_sdg') is-invalid @enderror"
                                                        name="fund_amount_need_sdg"
                                                        placeholder="قيمة التمويل المطلوب بالجنيه السوداني"
                                                        value="{{ old('fund_amount_need_sdg', $project->fund_amount_need_sdg) }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">معلومات المشروع</label>
                                                    <textarea name="desc" class="ckeditor form-control @error('desc') is-invalid @enderror" required>{{ old('desc', $project->desc) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">الأحتياجات</label>
                                                    <textarea name="need" class="ckeditor form-control @error('need') is-invalid @enderror" required>{{ old('need', $project->need) }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">ملاحظات</label>
                                                    <textarea name="notes" class=" ckeditor form-control @error('notes') is-invalid @enderror">{{ old('notes', $project->notes) }}</textarea>
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
                                                    <label for="first-name-vertical">صورة المشروع </label>
                                                    <input type="file"
                                                        class="form-control @error('image') is-invalid @enderror"
                                                        name="image" value="{{ old('image') }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <hr>
                                            </div>
                                            @php($locations = explode(',', $project->location))
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="autocomplete"> موقع المتجر على الخريطة</label>
                                                    <input type="text" name="autocomplete" id="autocomplete"
                                                        class="form-control" placeholder="الموقع"
                                                        value="{{ old('autocomplete', $project->address) }}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="contact-info-vertical">latitude</label>
                                                    <input type="text" name="latitude" id="latitude" readonly
                                                        class="form-control"
                                                        value="{{ old('latitude', $locations[0]) }}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="contact-info-vertical">longitude</label>
                                                    <input type="text" name="longitude" id="longitude" readonly
                                                        class="form-control"
                                                        value="{{ old('longitude', $locations[0]) }}">
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

    <?php $old_status = old('status'); ?>
    <script>
        $(document).ready(function() {
            if (@json($old_status) != "no_start_yet" && @json($old_status) != null) {
                $('.start_date').removeClass('d-none');
            } else {
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
