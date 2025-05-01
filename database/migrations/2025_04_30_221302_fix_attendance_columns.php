<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('attendances', 'arrival_time')) {
                $table->time('arrival_time')->nullable();
            }
            if (!Schema::hasColumn('attendances', 'departure_time')) {
                $table->time('departure_time')->nullable();
            }
            if (!Schema::hasColumn('attendances', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down()
    {
        // No need to drop columns in this fix migration
    }
};