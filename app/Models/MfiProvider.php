<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfiProvider extends Model
{
    use HasFactory;


    public function form_request()
    {
        return $this->hasMany(FormRequest::class,'mfi_provider_id','id');
    }

    public function mfi_users()
    {
        return $this->hasMany(MfiProviderUser::class,'mfi_provider_id','id');
    }
}
