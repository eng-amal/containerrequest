<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class secclass extends Model
{
    public $timestamps = false;
    protected $table = 'secclass';
    protected $fillable=['name','enname','parentid','minimum'];
}
