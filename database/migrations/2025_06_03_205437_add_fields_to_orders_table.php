<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_type', ['pickup', 'delivery'])->default('pickup')->after('id');
            $table->enum('buy_method', ['online', 'in-store'])->default('online')->after('order_type');
            $table->decimal('total_amount', 10, 2)->default(0)->after('buy_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_type', 'buy_method', 'total_amount']);
        });
    }
};
