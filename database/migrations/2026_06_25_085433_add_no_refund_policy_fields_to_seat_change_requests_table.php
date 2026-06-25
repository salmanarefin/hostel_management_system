<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seat_change_requests', function (Blueprint $table) {
            $table->integer('remaining_days')->default(0)->after('payment_difference');
            $table->decimal('unused_credit', 10, 2)->default(0)->after('remaining_days');
            $table->integer('extra_days')->default(0)->after('unused_credit');
            $table->decimal('minimum_payable', 10, 2)->default(0)->after('extra_days');
            $table->text('adjustment_note')->nullable()->after('minimum_payable');
        });
    }

    public function down(): void
    {
        Schema::table('seat_change_requests', function (Blueprint $table) {
            $table->dropColumn([
                'remaining_days',
                'unused_credit',
                'extra_days',
                'minimum_payable',
                'adjustment_note',
            ]);
        });
    }
};