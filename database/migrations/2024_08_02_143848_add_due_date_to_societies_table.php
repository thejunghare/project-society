<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDueDateToSocietiesTable extends Migration
{
    public function up()
    {
        Schema::table('societies', function (Blueprint $table) {
            $table->unsignedTinyInteger('due_date')->after('name')->default(1);
        });
    }

    public function down()
    {
        Schema::table('societies', function (Blueprint $table) {
            $table->dropColumn('due_date');
        });
    }
}