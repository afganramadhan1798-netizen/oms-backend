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
            $table->unsignedBigInteger('human_resource_id')->nullable();
            $table->timestamp('human_resource_reviewed_at')->nullable();
            $table->text('human_resource_notes')->nullable();
            $table->string('human_resource_status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overtimes', function (Blueprint $table) {
            //
        });
    }
};