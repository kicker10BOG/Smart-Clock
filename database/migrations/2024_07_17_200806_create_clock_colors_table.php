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
        Schema::create('clock_colors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('clock_id')->constrained();
            $table->time('start_time', 0)->default('08:00:00');
            $table->string('background', 7)->default('#000000');
            $table->string('text', 7)->default('#ffffff');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clock_colors');
    }
};
