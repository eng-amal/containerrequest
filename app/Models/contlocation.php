<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contlocation extends Model
{
    public $timestamps = false;
    protected $table = 'contlocation';
    protected $fillable=['name','enname'];
}
