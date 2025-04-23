<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class complamint extends Model
{
    public $timestamps = false;
    protected $table = 'complamint';
    protected $fillable=['reqid','comstatusid','comreasonid','descr'];
}
