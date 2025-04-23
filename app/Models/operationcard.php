<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class operationcard extends Model
{
    public $timestamps = false;
    protected $table = 'operationcard';
    protected $fillable=['name','idnumber','cardno','fromdate','todate','maker','model','patenumber','color','modelyear','carid'];
}
