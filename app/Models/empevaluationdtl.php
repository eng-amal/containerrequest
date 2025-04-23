<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empevaluationdtl extends Model
{
    public $timestamps = false;
    protected $table = 'empevaluationdtl';
    protected $fillable=['empevalation_id','evaluation_name','empmark','mark'];
}
