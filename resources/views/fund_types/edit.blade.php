<form class="form form-vertical" action="/panel-admin/fund-types/{{$fundType->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="first-name-vertical">نوع التمويل</label>
                    <input type="text" class="form-control @error('type_name') is-invalid @enderror"
                        name="type_name" placeholder="نوع التمويل" value="{{ old('type_name',$fundType->type_name) }}"
                        required>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success mr-1 mb-1">تعديل</button>
            </div>
        </div>
    </div>
</form>
