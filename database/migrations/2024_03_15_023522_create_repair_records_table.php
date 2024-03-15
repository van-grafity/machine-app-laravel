<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// class RepairRecord extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'machine_id',
//         'user_id',
//         'repair_type',
//         'repair_date',
//         'description',
//         'status_id',
//         'sparepart_used'
//     ];

//     public function machine()
//     {
//         return $this->belongsTo(Machine::class);
//     }
// }


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repair_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machine_id');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('repair_type', ['preventive', 'corrective', 'predictive']);
            $table->date('repair_date');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->text('sparepart_used')->nullable();
            $table->timestamps();

            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('machine_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_records');
    }
};
