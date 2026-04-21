<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalibrationPoint extends Model
{
    protected $fillable = [
        'calibration_id',
        'set_point_percentage',
        'expected',
        'as_found',
        'as_left',
        'error',
        'error_percentage'
    ];

    public function calibration()
    {
        return $this->belongsTo(Calibration::class);
    }
}
