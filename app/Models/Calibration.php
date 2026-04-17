<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    //
    public function points()
{
    return $this->hasMany(CalibrationPoint::class);
}
}
