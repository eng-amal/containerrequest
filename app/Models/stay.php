<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stay extends Model
{
    public $timestamps = false;
    protected $table = 'stay';
    protected $fillable=['staynum','fromdate','todate','empid'];
}
