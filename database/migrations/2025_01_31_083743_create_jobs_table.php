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
        Schema::create('job', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('company');
            $table->text('description');
            $table->string('location');
            $table->string('category');
            $table->string('salary');
            $table->string('benefits');
            $table->string('type');
            $table->string('work_condition');
            $table->foreignUuid('business_id')->constrained('business');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job');
    }
};
