<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    public $timestamps = false;
    protected $table = 'customer';
    protected $fillable=['fullname','phone','whatappno','balance','status','accountid'];
}
