<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seat_change_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('current_branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('current_room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('current_seat_id')->nullable()->constrained('seats')->nullOnDelete();

            $table->foreignId('requested_branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('requested_room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('requested_seat_id')->constrained('seats')->cascadeOnDelete();

            $table->decimal('current_rent', 10, 2)->default(0);
            $table->decimal('new_rent', 10, 2)->default(0);
            $table->decimal('payment_difference', 10, 2)->default(0);

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seat_change_requests');
    }
};