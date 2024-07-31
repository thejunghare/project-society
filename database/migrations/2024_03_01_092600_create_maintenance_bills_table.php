<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->integer('status');
            $table->date('due_date');
            $table->unsignedBigInteger('payment_mode_id')->default(1);
            $table->integer('billing_month');
            $table->integer('billing_year');
            $table->boolean('advance')->default(0);
            $table->timestamps();

            $table->foreign('payment_mode_id')->references('id')->on('payment_modes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_bills');
    }
};

