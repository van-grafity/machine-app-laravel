# NOTE
```
login per user untuk mechanic
leader mesin
```

### Repair Type
```
Preventive Maintenance adalah perawatan yang dilakukan secara berkala untuk mencegah kerusakan mesin atau peralatan.
Corrective Maintenance adalah perawatan yang dilakukan setelah terjadi kerusakan pada mesin atau peralatan.
Predictive Maintenance adalah perawatan yang dilakukan berdasarkan prediksi atau perhitungan terhadap kondisi mesin atau peralatan.
```

```
class ChangeStatusColumnInMachineStatusesTable extends Migration
{
    public function up()
    {
        Schema::table('machine_statuses', function (Blueprint $table) {
            $table->enum('status', ['ready', 'sedang_digunakan', 'rusak'])->change();
        });
    }

    public function down()
    {
        Schema::table('machine_statuses', function (Blueprint $table) {
            $table->string('status')->change();
        });
    }
}
```

```
class AddUserIdToRepairRecords extends Migration
{
    public function up()
    {
        Schema::table('repair_records', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('machine_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('repair_records', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
```