<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carexamin extends Model
{
    public $timestamps = false;
    protected $table = 'carexamin';
    protected $fillable=['carexaminnum','carid','fromdate','todate'];
}
