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
            $table->text('phone')->unique();
            $table->text('address')->unique();

            $table->integer('member_count');

            // President details
            $table->unsignedBigInteger('president_id');

            // Vice president details
            $table->unsignedBigInteger('vice_president_id');

            // Secretary details
            $table->unsignedBigInteger('secretary_id');

            // Treasurer details
            $table->unsignedBigInteger('treasurer_id');

            // Accountant details
            $table->unsignedBigInteger('accountant_id');

            $table->foreign('president_id')->references('id')->on('president_details');
            $table->foreign('vice_president_id')->references('id')->on('vice_president_details');
            $table->foreign('secretary_id')->references('id')->on('secretary_details');
            $table->foreign('treasurer_id')->references('id')->on('treasurer_details');
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
