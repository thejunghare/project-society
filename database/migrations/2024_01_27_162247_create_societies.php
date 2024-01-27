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
        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->unique();

            // President details
            $table->string('president_name');
            $table->string('president_phone_number')->unique();
            $table->string('president_email')->nullable()->unique();

            // Vice president details
            $table->string('vice_president_name');
            $table->string('vice_president_phone_number')->unique();
            $table->string('vice_president_email')->nullable()->unique();

            // Secretary details
            $table->string('secretary_name');
            $table->string('secretary_phone_number')->unique();
            $table->string('secretary_email')->nullable()->unique();

            // Treasurer details
            $table->string('treasurer_name');
            $table->string('treasurer_phone_number')->unique();
            $table->string('treasurer_email')->nullable()->unique();

            // Auditor details
            $table->unsignedBigInteger('auditor_id');
            $table->foreign('auditor_id')->references('id')->on('auditors');

            // Accountant details
            $table->unsignedBigInteger('accountant_id');
            $table->foreign('accountant_id')->references('id')->on('accountants');

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
