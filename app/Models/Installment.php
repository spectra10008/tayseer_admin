<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function form_request()
    {
        return $this->belongsTo(FormRequest::class,'request_id','id');
    }

    public function status()
    {
        return $this->hasOne(InstallmentStatus::class,'id','status_id');
    }
}
