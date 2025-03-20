<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    public $timestamps = false;
    protected $table = 'employee';
    protected $fillable=['empimg','mainsal','fullname','birthdate','nationality','hiredate','department_id','position_id','address','mobileno','enfullname'];
}
