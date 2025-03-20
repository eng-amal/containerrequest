<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contract extends Model
{
    public $timestamps = false;
    protected $table = 'contract';
    protected $fillable=['contractdate','custname','mobileno','whatno','duedate',
'Commregister','address','contsizeid','contnum','fromdate','todate',
'cost','paytypeid','location','note','cityid','streetid','emptycost','Wastetypeid',
'emptynum','payperoidid'];
}
