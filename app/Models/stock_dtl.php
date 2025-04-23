<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_dtl extends Model
{
    public $timestamps = false;
    protected $table = 'stock_dtl';
    protected $fillable=['itemid','amount','stockmstr_id'];
}
