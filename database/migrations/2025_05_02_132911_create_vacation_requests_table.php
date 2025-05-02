<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vacation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('matricul_employer');
            $table->string('validated_by_manager')->nullable(); // Manager who approved/rejected
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->string('status')->default('pending');
            $table->text('manager_comment')->nullable(); // Optional comment from manager
            $table->timestamp('validated_at')->nullable(); // When the request was processed
            $table->timestamps();
            
            // Foreign key for employer
            $table->foreign('matricul_employer')
                  ->references('matricul_employer')
                  ->on('employers')
                  ->onDelete('cascade');
            
            // Foreign key for manager who validated
            $table->foreign('validated_by_manager')
                  ->references('matricul_manager')
                  ->on('managers')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacation_requests');
    }
};