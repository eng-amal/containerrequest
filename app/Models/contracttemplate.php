<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contracttemplate extends Model
{
    public $timestamps = false;
    protected $table = 'contracttemplate';
    protected $fillable=['name'];
}
