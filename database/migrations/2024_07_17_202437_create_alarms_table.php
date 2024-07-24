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
            $table->boolean('enabled')->default(true);
            $table->boolean('sunday')->default(false);
            $table->boolean('monday')->default(true);
            $table->boolean('tuesday')->default(true);
            $table->boolean('wednesday')->default(true);
            $table->boolean('thursday')->default(true);
            $table->boolean('friday')->default(true);
            $table->boolean('saturday')->default(false);
            $table->unsignedTinyInteger('snooze_length')->default(10);
            $table->unsignedTinyInteger('snooze_count')->default(0);
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
