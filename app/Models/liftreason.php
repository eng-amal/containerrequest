<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class liftreason extends Model
{
    public $timestamps = false;
    protected $table = 'liftreason';
    protected $fillable=['name','enname'];
}
