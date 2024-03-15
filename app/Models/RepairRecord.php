<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'user_id',
        'repair_type',
        'repair_date',
        'description',
        'status_id',
        'sparepart_used'
    ];
    
    protected $dates = ['repair_date'];
    
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(RepairStatus::class);
    }
}