<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OilFilling extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'jobcard_id',
        'oil_type',
        'quantity',
        'filling_date',
        'moc_id',
        'flange_id',
        'capillary_id',
        'filled_by',
        'user_id'
    ];

    public function jobcard()
    {
        return $this->belongsTo(jobcard::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moc()
    {
        return $this->belongsTo(MOC::class, 'moc_id');
    }

    public function flange()
    {
        return $this->belongsTo(Flange::class, 'flange_id');
    }

    public function capillary()
    {
        return $this->belongsTo(Capillary::class, 'capillary_id');
    }
}
