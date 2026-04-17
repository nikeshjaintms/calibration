<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalibrationPoint extends Model
{
    //
    public function calibration()
{
    return $this->belongsTo(Calibration::class);
}
}
