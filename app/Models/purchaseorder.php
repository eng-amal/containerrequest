<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseorder extends Model
{
    public $timestamps = false;
    protected $table = 'purchaseorder';
    protected $fillable=['purchdate','total','faccount','daccount'];
}
