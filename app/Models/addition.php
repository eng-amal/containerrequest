<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addition extends Model
{
    public $timestamps = false;
    protected $table = 'addition';
    protected $fillable=['additiontype','isadd','empid','amount','ispercent'];
}
