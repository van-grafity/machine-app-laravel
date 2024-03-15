<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'location_type',
        'location_id'
    ];

    public function locationable()
    {
        return $this->morphTo();
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
