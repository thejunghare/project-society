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
        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('address')->unique();
            $table->text('bank_name');
            $table->text('bank_ifsc_code');
            $table->string('bank_account_number')->unique();
            $table->integer('member_count');
            $table->text('president_name')->nullable();
            $table->text('vice_president_name')->nullable();
            $table->text('treasurer_name')->nullable();
            $table->text('secretary_name')->nullable();
            $table->date('renews_at');

            $table->string('upi_id')->unique();
            $table->string('upi_number')->unique();
            $table->decimal('parking_charges', 8, 2)->nullable();
            $table->decimal('service_charges', 8, 2)->nullable();
            $table->decimal('maintenance_amount_owner', 8, 2)->nullable();
            $table->decimal('maintenance_amount_rented', 8, 2)->nullable();
            // $table->date('maintenance_due_date')->nullable();
            $table->decimal('registered_balance', 10, 2)->default(0);
            $table->decimal('updated_balance', 10, 2)->default(0);
            // $table->decimal('late_fee', 8, 2)->nullable(); // Adding the late_fee field

            $table->unsignedBigInteger('accountant_id');

            $table->foreign('accountant_id')->references('user_id')->on('accountants');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societies');
    }
};
