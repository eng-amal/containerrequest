<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaltemplatedtl extends Model
{
    public $timestamps = false;
    protected $table = 'evaltemplatedtl';
    protected $fillable=['temid','name','mark'];
}
