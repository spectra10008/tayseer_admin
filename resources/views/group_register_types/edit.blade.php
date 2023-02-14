<form class="form form-vertical" action="/panel-admin/group-register-types/{{$type->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="first-name-vertical">إسم النوع</label>
                    <input type="text" class="form-control @error('type_desc') is-invalid @enderror"
                        name="type_desc" placeholder="إسم النوع" value="{{ old('type_desc',$type->type_desc) }}"
                        required>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success mr-1 mb-1">تعديل</button>
            </div>
        </div>
    </div>
</form>
