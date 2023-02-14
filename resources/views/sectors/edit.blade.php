<form class="form form-vertical" action="/panel-admin/sectors/{{$sector->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="first-name-vertical">إسم القطاع</label>
                    <input type="text" class="form-control @error('sector_desc') is-invalid @enderror"
                        name="sector_desc" placeholder="إسم القطاع" value="{{ old('sector_desc',$sector->sector_desc) }}"
                        required>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success mr-1 mb-1">تعديل</button>
            </div>
        </div>
    </div>
</form>
