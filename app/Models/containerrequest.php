<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class containerrequest extends Model
{
    public $timestamps = false;
    protected $table = 'containerrequest';
    protected $fillable=['reqdate','custname','mobno','whatno','rent','remainamount',
'contsizeid','reqtypeid','cost','cityid','streetid','paytypeid',
'payamount','empid','contid','conno',
'fromdate','todate','bankid','transferimg','latitude', 'longitude','contlocation','contractid'];


}
