<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;


    public function product()
    {
        return $this->belongsTo(LoanProduct::class,'product_id','id');
    }

    public function request()
    {
        return $this->belongsTo(FormRequest::class,'request_id','id');
    }

    public function status()
    {
        return $this->belongsTo(LoanStatus::class,'status_id','id');
    }

    public function user()
    {
        return $this->belongsTo(MfiProviderUser::class,'loan_manager','id');
    }

    public function mfi_provider()
    {
        return $this->belongsTo(MfiProvider::class,'mfi_provider_id','id');
    }
}
