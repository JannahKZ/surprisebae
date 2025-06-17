<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_deco_service_dates_table.php

    public function up()
    {
        Schema::create('deco_service_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deco_service_id')->constrained('deco_services')->onDelete('cascade');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deco_service_dates');
    }
};
