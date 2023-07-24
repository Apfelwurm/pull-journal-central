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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('deviceidentifier')->unique();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_from')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->timestamp('last_api_call')->nullable();
            $table->foreignId('organisation_id')->default(1)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
