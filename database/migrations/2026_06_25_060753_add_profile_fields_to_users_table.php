<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('nid')->nullable()->after('phone');
            $table->enum('role', ['admin', 'customer'])->default('customer')->after('password');

            $table->foreignId('branch_id')->nullable()->after('role')->constrained('branches')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->after('branch_id')->constrained('rooms')->nullOnDelete();
            $table->foreignId('seat_id')->nullable()->after('room_id')->constrained('seats')->nullOnDelete();

            $table->decimal('deposit_amount', 10, 2)->default(0)->after('seat_id');
            $table->decimal('balance', 10, 2)->default(0)->after('deposit_amount');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['room_id']);
            $table->dropForeign(['seat_id']);

            $table->dropColumn([
                'phone',
                'nid',
                'role',
                'branch_id',
                'room_id',
                'seat_id',
                'deposit_amount',
                'balance',
            ]);
        });
    }
};