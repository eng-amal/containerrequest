<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_mstr extends Model
{
    public $timestamps = false;
    protected $table = 'stock_mstr';
    protected $fillable=['entrydate','entrytype'];
}
