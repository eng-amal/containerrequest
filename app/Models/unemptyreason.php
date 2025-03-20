<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unemptyreason extends Model
{
    public $timestamps = false;
    protected $table = 'unemptyreason';
    protected $fillable=['name','enname'];
}
