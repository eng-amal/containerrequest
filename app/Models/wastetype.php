<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wastetype extends Model
{
    public $timestamps = false;
    protected $table = 'wastetype';
    protected $fillable=['name','enname'];
}
