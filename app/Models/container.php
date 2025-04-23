<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\containerrequest;
class container extends Model
{
    public $timestamps = false;
    protected $table = 'container';
    protected $fillable=['no','sizeid'];
    public function latestRequest()
{
    return $this->hasOne(containerrequest::class, 'contid', 'id')
                ->orderBy('id', 'desc');
}
    
}

