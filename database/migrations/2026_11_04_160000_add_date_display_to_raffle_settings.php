<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('raffle_settings', function (Blueprint $table): void {
            $table->boolean('show_draw_date')->default(true);
            $table->string('date_replacement')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('raffle_settings', function (Blueprint $table): void {
            $table->dropColumn(['show_draw_date', 'date_replacement']);
        });
    }
};
