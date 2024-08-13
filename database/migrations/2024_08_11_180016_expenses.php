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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_id');
            $table->unsignedBigInteger('expense_type_id');
            $table->decimal('amount', 10, 2);
            $table->text('remark')->nullable(); // Corrected line
            $table->timestamps();

            $table->foreign('society_id')->references('id')->on('societies');
            $table->foreign('expense_type_id')->references('id')->on('expense_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
