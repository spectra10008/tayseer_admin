<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function mfis()
    {
        return $this->belongsTo(MfiProvider::class,'mfi_provider_id','id');
    }
}
