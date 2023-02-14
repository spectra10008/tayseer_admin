<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function beneficiary()
    {
        return $this->hasManyThrough(Beneficiary::class,BeneficiaryGroup::class,'group_id','id','id','beneficiary_id');
    }

    public function beneficiary_group()
    {
        return $this->hasMany(BeneficiaryGroup::class,'group_id','id');
    }


    public function register_type()
    {
        return $this->hasOne(GroupRegisterType::class,'id','register_type_id');
    }

    public function bank()
    {
        return $this->hasOne(Bank::class,'id','bank_id');
    }
}
