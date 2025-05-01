<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // In the generated migration file
// In the generated migration file
public function up()
{
    Schema::create('vacation_requests', function (Blueprint $table) {
        $table->id();
        $table->string('matricul_employer');
        $table->date('start_date');
        $table->date('end_date');
        $table->text('reason');
        $table->string('status')->default('pending');
        $table->timestamps();
        
        $table->foreign('matricul_employer')
              ->references('matricul_employer')
              ->on('employers');
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
