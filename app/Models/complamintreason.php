<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class complamintreason extends Model
{
    public $timestamps = false;
    protected $table = 'complamintreason';
    protected $fillable=['name','enname'];
}
