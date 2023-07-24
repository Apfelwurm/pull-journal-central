<?php

use App\Models\Organisation;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('registrationpassword')->default("");
            $table->timestamps();
        });

        Organisation::insert([[
            'name' => 'Default Organisation',
            'registrationpassword' => Str::random(16),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
