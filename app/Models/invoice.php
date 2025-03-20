<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    public $timestamps = false;
    protected $table = 'invoice';
    protected $fillable=['total','img','contractid','bankid','transferimg',
    'ispay','paytypeid'];
}
