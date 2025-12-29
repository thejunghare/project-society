<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) { // Add expense_type_id as a foreign key
            $table->boolean('is_credit')->default(false);
            
            // $table->foreign('expense_type_id')->references('id')->on('expense_types');// Add is_credit column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // $table->dropForeign(['expense_type_id']);
            // $table->dropColumn('expense_type_id');
            $table->dropColumn('is_credit');
        });
    }
};
