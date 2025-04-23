<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contracttemdtl extends Model
{
    public $timestamps = false;
    protected $table = 'contracttemdtl';
    protected $fillable=['contemid','name','descr','rank','val'];
}
