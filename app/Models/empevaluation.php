<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empevaluation extends Model
{
    public $timestamps = false;
    protected $table = 'empevaluation';
    protected $fillable=['empid','temid','empmark','temmark','evaname'];
}
