<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\city;
use App\Models\street;
use App\Models\employee;
class containerrequest extends Model
{
    public $timestamps = false;
    protected $table = 'containerrequest';
    protected $fillable=['reqdate','custname','mobno','whatno','rent','remainamount',
'contsizeid','reqtypeid','cost','cityid','streetid','paytypeid',
'payamount','empid','contid','conno',
'fromdate','todate','bankid','transferimg','latitude', 'longitude','contlocation','contractid'];
// Assuming that the 'cityid' is the foreign key linking to the 'City' table
public function city()
{
    return $this->belongsTo(City::class, 'cityid');
}

// Assuming that the 'streetid' is the foreign key linking to the 'Street' table
public function street()
{
    return $this->belongsTo(Street::class, 'streetid');
}
public function employee()
{
    return $this->belongsTo(employee::class, 'empid');
}

}
