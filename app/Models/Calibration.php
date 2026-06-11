<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    protected $fillable = [
        'user_id',
        'jobcard_id',
        'calibration_by',
        'date',
        'instrument',
        'certificate_number',
        'temperature',
        'humidity',
        'result',
        'po_no',
        'po_date',
        'warranty',
        'warranty_due_date',
        'pressure_unit',
        'master_accuracy',
        'calibration_method',
        'communicator_make',
        'activity',
        'work_details'
    ];

    public function jobcard()
    {
        return $this->belongsTo(jobcard::class);
    }

    public function points()
    {
        return $this->hasMany(CalibrationPoint::class);
    }
}
