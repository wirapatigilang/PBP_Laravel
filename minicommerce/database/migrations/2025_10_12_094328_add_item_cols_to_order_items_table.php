<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $t) {
            if (!Schema::hasColumn('order_items','name'))     $t->string('name')->nullable()->after('product_id');
            if (!Schema::hasColumn('order_items','price'))    $t->decimal('price', 15, 2)->default(0)->after('name');
            if (!Schema::hasColumn('order_items','qty'))      $t->unsignedInteger('qty')->default(1)->after('price');
            if (!Schema::hasColumn('order_items','subtotal')) $t->decimal('subtotal', 15, 2)->default(0)->after('qty');
            // store_name sudah ada di DB-mu, jadi tidak diulang
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $t) {
            foreach (['subtotal','qty','price','name'] as $col) {
                if (Schema::hasColumn('order_items', $col)) $t->dropColumn($col);
            }
        });
    }
};
