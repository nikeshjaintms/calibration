<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'jobcard_id',
        'body_condition',
        'display_status',
        'motherboard_status',
        'power_card_status',
        'sensor_status',
        'remarks',
        'photo'
    ];

    public function jobcard()
    {
        return $this->belongsTo(jobcard::class);
    }
}
