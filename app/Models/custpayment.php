<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class custpayment extends Model
{
    public $timestamps = false;
    protected $table = 'custpayment';
    protected $fillable=['custid','amount','paytype','bankid','transferno'];
}
