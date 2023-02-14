<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryProject extends Model
{
    use HasFactory;

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class,'beneficiary_id','id');
    }
}
