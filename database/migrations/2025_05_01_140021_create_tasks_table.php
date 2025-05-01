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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('status', ['pending', 'in progress', 'completed']);
            $table->date('deadline')->nullable(); 
            $table->string('matricul_employer');
            $table->foreign('matricul_employer')->references('matricul_employer')->on('employers')->onDelete('cascade');
            $table->string('matricul_manager');
            $table->foreign('matricul_manager')->references('matricul_manager')->on('managers')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};