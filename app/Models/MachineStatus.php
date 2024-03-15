<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineStatus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'machine_id',
        'status',
        'status_date',
        'service_mechanic',
        'spare_part_required'
    ];

    protected $dates = [
        'status_date'
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function getServiceMechanicAttribute($value)
    {
        return $value ?: 'No mechanic assigned';
    }

    public function getStatusDateFormattedAttribute()
    {
        return $this->status_date->format('Y-m-d H:i:s');
    }

    public function getSparePartRequiredAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }
}