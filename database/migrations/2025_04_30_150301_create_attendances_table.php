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
            $table->date('date');
            $table->time('arrival_time')->nullable();
            $table->time('leave_time')->nullable();  // Changed from departure_time
            $table->string('status')->default('absent');
            $table->timestamps();
            
            $table->foreign('matricul_employer')
                  ->references('matricul_employer')
                  ->on('employers')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};