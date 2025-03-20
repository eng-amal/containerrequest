<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class decision extends Model
{
    public $timestamps = false;
    protected $table = 'decision';
    protected $fillable=['decisiontype','decisiondate','decisionimg','amount','peroid','empid'];
}
