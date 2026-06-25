<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE exit_requests MODIFY final_type ENUM('payable', 'no_due') DEFAULT 'payable'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE exit_requests MODIFY final_type ENUM('payable', 'refundable') DEFAULT 'payable'");
    }
};