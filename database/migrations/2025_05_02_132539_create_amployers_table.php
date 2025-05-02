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
        Schema::create('employers', function (Blueprint $table) {
            $table->string('matricul_employer')->primary();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('passwordE');
            $table->string('role');
            $table->datetime('date_embauche');
            $table->string('post');
            $table->string('appartment_id')->nullable(); // Foreign key column
            $table->timestamps();
            
            // Add foreign key constraint
            $table->foreign('appartment_id')
                  ->references('id')
                  ->on('appartments')
                  ->onDelete('set null'); // or 'cascade' depending on your needs
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};