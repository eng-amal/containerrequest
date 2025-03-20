<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class containersize extends Model
{
    public $timestamps = false;
    protected $table = 'containersize';
    protected $fillable=['name','enname'];
    
}
