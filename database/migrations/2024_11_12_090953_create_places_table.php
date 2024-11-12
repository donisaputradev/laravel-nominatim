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
        Schema::create('places', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->integer('place_id')->unique();
            $table->string('licence')->nullable();
            $table->string('osm_type')->nullable();
            $table->integer('osm_id')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('type')->nullable();
            $table->integer('place_rank')->nullable();
            $table->integer('importance')->nullable();
            $table->string('addresstype')->nullable();
            $table->string('name')->nullable();
            $table->string('display_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
