<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    public $timestamps = false;
    protected $table = 'stock';
    protected $fillable=['itemid','itemname','balance','minimum'];
}
