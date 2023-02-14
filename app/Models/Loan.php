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

    public function status()
    {
        return $this->belongsTo(LoanStatus::class,'id','status_id');
    }
}
