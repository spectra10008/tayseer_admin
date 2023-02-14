<form class="form form-vertical" action="/panel-admin/banks/{{$bank->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="first-name-vertical">إسم البنك</label>
                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                        name="bank_name" placeholder="إسم البنك" value="{{ old('bank_name',$bank->bank_name) }}"
                        required>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success mr-1 mb-1">تعديل</button>
            </div>
        </div>
    </div>
</form>
