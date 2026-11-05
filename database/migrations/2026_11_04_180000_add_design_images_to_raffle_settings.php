<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('raffle_settings', function (Blueprint $table): void {
            $table->string('logo_path')->nullable();
            $table->string('prize_image_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('raffle_settings', function (Blueprint $table): void {
            $table->dropColumn(['logo_path', 'prize_image_path']);
        });
    }
};
