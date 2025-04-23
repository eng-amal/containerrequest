<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class basicclass extends Model
{
    public $timestamps = false;
    protected $table = 'basicclass';
    protected $fillable=['name','enname'];
}
