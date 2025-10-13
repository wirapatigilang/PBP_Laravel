<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $t) {
            $t->string('address')->nullable()->change();
            $t->string('status')->default('paid')->change();
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $t) {
            $t->string('address')->nullable(false)->change();
            $t->string('status')->default(null)->change();
        });
    }
};
