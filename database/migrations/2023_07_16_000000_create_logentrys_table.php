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
        Schema::create('log_entries', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            /** ENUM */
            $table->string('class')->default('info');
            /** end ENUM */
            $table->foreignId('device_id')->default(1)->constrained()->onDelete('cascade');
            $table->longText('content');
            $table->timestamp('acknowledged_at')->nullable();
            $table->foreignId('acknowledged_from')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_entries');
    }
};
