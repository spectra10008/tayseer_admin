<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function sector()
    {
        return $this->hasOne(Sector::class,'id','sector_id');
    }

    public function beneficiary_project()
    {
        return $this->hasMany(BeneficiaryProject::class,'project_id','id');
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class,'project_id','id');
    }
}
