<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contractform extends Model
{
    public $timestamps = false;
    protected $table = 'contractform';
    protected $fillable=['contracttemid'];
}
