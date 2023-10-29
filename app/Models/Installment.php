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

    public function loan()
    {
        return $this->belongsTo(Loan::class,'loan_id','id');
    }

    public function ins_status()
    {
        return $this->hasOne(InstallmentStatus::class,'id','status_id');
    }

    public function mfis()
    {
        return $this->belongsTo(MfiProvider::class,'mfi_provider_id','id');
    }
}
