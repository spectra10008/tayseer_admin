<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryRequest extends Model
{
    use HasFactory;

    public function requests()
    {
        return $this->belongsTo(FormRequest::class,'request_id','id');
    }
}
