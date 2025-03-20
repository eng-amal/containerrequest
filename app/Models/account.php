<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account extends Model
{
    public $timestamps = false;
    protected $table = 'account';
    protected $fillable=['name','enname','code','type','parentid','balance'];
}
