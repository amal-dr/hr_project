<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            
            // Relationship with managers (assuming tasks are assigned to managers)
            $table->string('manager_id'); // Matches managers.primaryKey type
            $table->foreign('manager_id')
                  ->references('matricul_manager')
                  ->on('managers')
                  ->onDelete('cascade');
            
            // Relationship with appartments (if tasks are related to specific appartments)
            $table->string('appartment_id'); // Matches appartments.id type
            $table->foreign('appartment_id')
                  ->references('id')
                  ->on('appartments')
                  ->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes(); // Optional: for soft deletion
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};