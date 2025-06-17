<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecoServicesTable extends Migration
{
    public function up()
    {
        Schema::create('deco_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('image_url')->nullable();
            $table->string('category')->nullable();
            $table->date('date')->nullable(); // ← Add this line for availability date
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('deco_services');
    }
}
