<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    public $timestamps = false;
    protected $table = 'car';
    protected $fillable=['model','no','empid'];
}
