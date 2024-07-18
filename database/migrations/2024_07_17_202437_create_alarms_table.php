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
            $table->time('time', 0)->default('08:00:00');
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
