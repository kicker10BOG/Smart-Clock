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
            $table->string('name', 255)->nullable()->default(null);
            $table->unsignedTinyInteger('hour')->default(8);
            $table->unsignedTinyInteger('minute')->default(0);
            $table->string('background', 7)->default('#000000');
            $table->string('text', 7)->default('#ffffff');
            $table->boolean('enabled')->default(true);
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
