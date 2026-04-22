<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class jobcard extends Model
{
    use SoftDeletes;

    protected $fillable = ['client_id', 'customer_name', 'tag_no', 'model_no', 'serial_no', 'start_range', 'end_range', 'status', 'jobcard_date', 'jobcard_number', 'reciving_date', 'bill_no','bill_date', 'body_condition', 'display_status', 'motherboard_status', 'power_card_status', 'sensor_status'];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function inspections()
    {
        return $this->hasMany(Inspection::class, 'jobcard_id');
    }

    public function latestInspection()
    {
        return $this->hasOne(Inspection::class, 'jobcard_id')->latestOfMany();
    }

    public function oil_filling()
    {
        return $this->hasOne(OilFilling::class, 'jobcard_id');
    }

    public function calibration()
    {
        return $this->hasOne(Calibration::class, 'jobcard_id');
    }
}
