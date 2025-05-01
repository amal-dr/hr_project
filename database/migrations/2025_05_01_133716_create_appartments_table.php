<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appartments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('matricul_manager'); // Foreign key to managers
            $table->timestamps();
            
            $table->foreign('matricul_manager')
                  ->references('matricul_manager')
                  ->on('managers')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('apartments');
    }
};