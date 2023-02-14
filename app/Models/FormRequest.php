<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormRequest extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->hasOne(FormRequestStatus::class,'id','status_id');
    }

    public function social_status()
    {
        return $this->hasOne(SocialSituation::class,'id','social_situation_id');
    }

    public function bank()
    {
        return $this->hasOne(Bank::class,'id','bank_id');
    }

    public function sector()
    {
        return $this->hasOne(Sector::class,'id','project_sector_id');
    }

    public function fund_type()
    {
        return $this->hasOne(FundType::class,'id','fund_type_id');
    }


    public function files()
    {
        return $this->hasMany(FormRequestFile::class,'request_id','id');
    }
}
