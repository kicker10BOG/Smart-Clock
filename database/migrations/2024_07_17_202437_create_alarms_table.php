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
        Schema::create('alarms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('clock_id')->constrained();
            $table->string('name', 255)->nullable()->default(null);
            $table->unsignedTinyInteger('hour')->default(8);
            $table->unsignedTinyInteger('minute')->default(0);
            $table->boolean('active')->default(true);
            $table->unsignedTinyInteger('sleep_length')->default(10);
            $table->unsignedTinyInteger('sleep_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alarms');
    }
};
