<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class drivercard extends Model
{
    public $timestamps = false;
    protected $table = 'drivercard';
    protected $fillable=['cardno','driverno','drivername','driverid','fromdate','todate','category','moinumber','moiname','empid'];
}
