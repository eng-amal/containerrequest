<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class street extends Model
{
    public $timestamps = false;
    protected $table = 'street';
    protected $fillable=['name','enname','cityid'];
}
