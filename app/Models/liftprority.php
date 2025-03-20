<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class liftprority extends Model
{
    public $timestamps = false;
    protected $table = 'liftprority';
    protected $fillable=['name','enname','prority'];
}
