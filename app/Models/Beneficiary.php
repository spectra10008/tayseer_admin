<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    public function social_status()
    {
        return $this->hasOne(SocialSituation::class,'id','social_situation_id');
    }
    public function bank()
    {
        return $this->hasOne(Bank::class,'id','bank_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }

    public function files()
    {
        return $this->hasMany(BeneficiaryFile::class,'beneficiary_id','id');
    }

    public function beneficiary_requests()
    {
        return $this->hasMany(BeneficiaryRequest::class,'beneficiary_id','id');
    }
}
