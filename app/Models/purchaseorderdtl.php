<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseorderdtl extends Model
{
    public $timestamps = false;
    protected $table = 'purchaseorderdtl';
    protected $fillable=['purchid','itemid','num','price','tprice'];
}
