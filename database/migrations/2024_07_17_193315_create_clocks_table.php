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
        Schema::create('clocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
            $table->string('name', 255)->nullable()->default(null);
            $table->enum('month_format', ['short', 'long'])->default('short');
            $table->enum('weekday_format', ['short', 'long', 'hide'])->default('short');
            $table->boolean('show_date')->default(true);
            $table->boolean('show_next_alarm')->default(true);
            $table->boolean('show_seconds')->default(false);
            $table->boolean('use_12hr')->default(true);
            $table->boolean('show_ampm')->default(true);
            $table->boolean('shorten_ampm')->default(true);
            $table->unsignedSmallInteger('width')->default(1024);
            $table->unsignedSmallInteger('height')->default(600);
            $table->smallInteger('date_x')->default(0);
            $table->smallInteger('clock_x')->default(0);
            $table->smallInteger('alarm_x')->default(0);
            $table->smallInteger('date_y')->default(175);
            $table->smallInteger('clock_y')->default(0);
            $table->smallInteger('alarm_y')->default(-155);
            $table->unsignedSmallInteger('date_size')->default(100);
            $table->unsignedSmallInteger('clock_size')->default(310);
            $table->unsignedSmallInteger('alarm_size')->default(80);
            $table->enum('date_font', ['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])->default('sans-serif');
            $table->enum('clock_font', ['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])->default('math');
            $table->enum('alarm_font', ['sans-serif', 'serif', 'monospace', 'cursive', 'fantasy', 'system-ui', 'math'])->default('sans-serif');
            $table->unsignedBigInteger('other_clock_alarms')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clocks');
    }
};
