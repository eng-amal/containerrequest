<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contractformdtl extends Model
{
    public $timestamps = false;
    protected $table = 'contractformdtl';
    protected $fillable=['contractformid','name','descr','rank','val'];
}
