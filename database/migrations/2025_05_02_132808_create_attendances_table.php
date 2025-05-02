<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('matricul_employer');
            $table->string('matricul_manager')->nullable(); // New column for manager reference
            $table->date('date');
            $table->time('arrival_time')->nullable();
            $table->time('leave_time')->nullable();
            $table->string('status')->default('absent');
            $table->timestamps();
            
            // Foreign key for employer
            $table->foreign('matricul_employer')
                  ->references('matricul_employer')
                  ->on('employers')
                  ->onDelete('cascade');
                  
            // Foreign key for manager
            $table->foreign('matricul_manager')
                  ->references('matricul_manager')
                  ->on('managers')
                  ->onDelete('set null'); // or 'cascade' depending on your needs
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};