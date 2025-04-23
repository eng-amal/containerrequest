<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maintinancerequest extends Model
{
    public $timestamps = false;
    protected $table = 'maintinancerequest';
    protected $fillable=['carid','contid','status','drivernote','processnote','closenote'
    ,'driverid','empprocessid','empcloseid','contsizeid'];
}

