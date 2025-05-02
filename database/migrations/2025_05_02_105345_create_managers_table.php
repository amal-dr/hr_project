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
        Schema::create('managers', function (Blueprint $table) {
            $table->string('matricul_manager')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('passwordM');
            $table->string('appartment_id')->index(); // Add index first
            
            $table->rememberToken();
            $table->timestamps();
        });
    
        // Add the foreign key constraint in a separate statement
        Schema::table('managers', function (Blueprint $table) {
            $table->foreign('appartment_id')
                  ->references('id')
                  ->on('appartments')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
