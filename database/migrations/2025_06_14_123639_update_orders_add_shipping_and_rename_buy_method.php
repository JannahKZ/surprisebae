<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersAddShippingAndRenameBuyMethod extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Rename buy_method to payment_method
            if (Schema::hasColumn('orders', 'buy_method')) {
                $table->renameColumn('buy_method', 'payment_method');
            }

            // Add shipping-related columns
            $table->string('shipping_option')->nullable()->after('status'); // 'pickup' or 'delivery'
            $table->string('pickup_name')->nullable()->after('shipping_option');
            $table->string('pickup_phone')->nullable()->after('pickup_name');
            $table->string('delivery_name')->nullable()->after('pickup_phone');
            $table->string('delivery_phone')->nullable()->after('delivery_name');
            $table->text('delivery_address')->nullable()->after('delivery_phone');
            $table->date('date')->nullable()->after('delivery_address');
            $table->time('time')->nullable()->after('date');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Reverse the renaming
            if (Schema::hasColumn('orders', 'payment_method')) {
                $table->renameColumn('payment_method', 'buy_method');
            }

            // Drop the added columns
            $table->dropColumn([
                'shipping_option',
                'pickup_name',
                'pickup_phone',
                'delivery_name',
                'delivery_phone',
                'delivery_address',
                'date',
                'time',
            ]);
        });
    }
}
