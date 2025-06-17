<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBuyMethodEnumInOrdersTable extends Migration
{
    public function up()
    {
        // Raw query to modify enum values
        DB::statement("ALTER TABLE orders MODIFY buy_method ENUM('online', 'in-store', 'cash') NOT NULL DEFAULT 'online'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY buy_method ENUM('online', 'in-store') NOT NULL DEFAULT 'online'");
    }
}
