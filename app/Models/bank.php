<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    public $timestamps = false;
    protected $table = 'bank';
    protected $fillable=['name','enname'];
}
