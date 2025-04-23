<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
    public $timestamps = false;
    protected $table = 'vendor';
    protected $fillable=['fullname','mobno','email','address','cityid','streetid','detail','accountid'];
}
