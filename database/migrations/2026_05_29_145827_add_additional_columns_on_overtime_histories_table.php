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
        Schema::table('overtime_histories', function (Blueprint $table) {
            $table->string('overtime_title')->after('overtime_id');
            $table->date('date')->nullable()->after('overtime_title');
            $table->string('start_time',50)->after('date');
            $table->string('end_time',50)->after('start_time');
            $table->integer('duration')->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};