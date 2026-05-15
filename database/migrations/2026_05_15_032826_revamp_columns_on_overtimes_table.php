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
        Schema::table('overtimes', function (Blueprint $table) {
             $table->renameColumn('user_id', 'employee_id');
             $table->dropColumn('task');
             $table->string('start_time', 50);
             $table->string('end_time', 50);
             $table->dropColumn('PIC');
             $table->unsignedBigInteger('project_manager_id');
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
