<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paytype extends Model
{
    public $timestamps = false;
    protected $table = 'paytype';
    protected $fillable=['name','enname'];
}
