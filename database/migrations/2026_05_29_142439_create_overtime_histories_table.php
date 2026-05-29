<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overtime_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('overtime_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('actor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('action');
            // approved / declined / hr_approved / resubmitted

            $table->text('notes')->nullable();

            $table->string('status_before')->nullable();
            $table->string('status_after')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overtime_histories');
    }
};
