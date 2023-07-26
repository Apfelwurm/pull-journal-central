<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('notification_settings', 'enable_device_created_notification')) {
            Schema::table('notification_settings', function (Blueprint $table) {
                $table->boolean('enable_device_created_notification')
                    ->after('enable_log_entry_created_notification')
                    ->default(false);
            });
        }
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('notification_settings', 'enable_device_created_notification')) {
            Schema::table('notification_settings', function (Blueprint $table) {
                $table->dropColumn('enable_device_created_notification');
            });
        }
    }
};