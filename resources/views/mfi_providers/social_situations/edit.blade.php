<form class="form form-vertical" action="/panel-admin/social-situations/{{$socialSituation->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="first-name-vertical">إسم الحالة</label>
                    <input type="text" class="form-control @error('situation_desc') is-invalid @enderror"
                        name="situation_desc" placeholder="إسم الحالة" value="{{ old('situation_desc',$socialSituation->situation_desc) }}" required>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success mr-1 mb-1">تعديل</button>
            </div>
        </div>
    </div>
</form>
