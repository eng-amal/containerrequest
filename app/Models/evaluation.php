<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaluation extends Model
{
    public $timestamps = false;
    protected $table = 'evaluation';
    protected $fillable=['temid','temname'];
}
