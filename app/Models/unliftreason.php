<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unliftreason extends Model
{
    public $timestamps = false;
    protected $table = 'unliftreason';
    protected $fillable=['name','enname'];
}
