<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sand extends Model
{
    public $timestamps = false;
    protected $table = 'sand';
    protected $fillable=['sanddate','saccountid','raccountid','amount','type','reason'];
}
