<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('deco_services', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('deco_services', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

};
