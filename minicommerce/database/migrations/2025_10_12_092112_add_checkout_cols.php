<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            if (!Schema::hasColumn('orders','shipping_method')) {
                $t->string('shipping_method')->nullable();
            }
            if (!Schema::hasColumn('orders','shipping_cost')) {
                $t->decimal('shipping_cost', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('orders','service_fee')) {
                $t->decimal('service_fee', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('orders','total_amount')) {
                $t->decimal('total_amount', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('orders','payment_method')) {
                $t->string('payment_method')->nullable();
            }
            if (!Schema::hasColumn('orders','payment_status')) {
                $t->string('payment_status')->default('pending');
            }
            if (!Schema::hasColumn('orders','paid_at')) {
                $t->timestamp('paid_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            if (Schema::hasColumn('orders','shipping_method')) $t->dropColumn('shipping_method');
            if (Schema::hasColumn('orders','shipping_cost'))   $t->dropColumn('shipping_cost');
            if (Schema::hasColumn('orders','service_fee'))     $t->dropColumn('service_fee');
            if (Schema::hasColumn('orders','total_amount'))    $t->dropColumn('total_amount');
            if (Schema::hasColumn('orders','payment_method'))  $t->dropColumn('payment_method');
            if (Schema::hasColumn('orders','payment_status'))  $t->dropColumn('payment_status');
            if (Schema::hasColumn('orders','paid_at'))         $t->dropColumn('paid_at');
        });
    }
};
