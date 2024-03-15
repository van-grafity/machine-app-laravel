<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'machine_type_id',
        'brand_id', 'model',
        'serial_number'
    ];

    public function type()
    {
        return $this->belongsTo(MachineType::class, 'machine_type_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function statuses()
    {
        return $this->hasMany(MachineStatus::class);
    }

    public function location()
    {
        return $this->morphOne(MachineLocation::class, 'locationable');
    }

    public function repairRecords()
    {
        return $this->hasMany(RepairRecord::class);
    }
}