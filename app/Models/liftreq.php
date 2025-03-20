<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class liftreq extends Model
{
    public $timestamps = false;
    protected $table = 'liftreq';
    protected $fillable=['conreqid','liftreasonid','liftprorityid','empid','conimg','conlocation','liftdate'];
}
