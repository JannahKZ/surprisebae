<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetDefaultItemTypeInOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Modify item_type to have default 'product'
            $table->string('item_type')->default('product')->change();
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Remove default if rollback
            $table->string('item_type')->default(null)->change();
        });
    }
}
