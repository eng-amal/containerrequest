<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contsizecost extends Model
{
    public $timestamps = false;
    protected $table = 'contsizecost';
    protected $fillable=['fday','tday','cost','contsizeid'];
}
