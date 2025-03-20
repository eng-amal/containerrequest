<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contractpaytype extends Model
{
    public $timestamps = false;
    protected $table = 'contractpaytype';
    protected $fillable=['name','enname'];
}
