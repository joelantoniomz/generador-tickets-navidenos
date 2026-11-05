<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('raffle_settings', function (Blueprint $table): void {
            $table->string('font_family')->default('Arial');
            $table->string('font_color')->default('#123e76');
            $table->string('font_size')->default('normal');
            $table->string('ribbon_text')->default('GRAN SORTEO NAVIDEÑO 2026');
            $table->string('thanks_text')->default('¡Gracias por tu preferencia!');
        });
    }

    public function down(): void
    {
        Schema::table('raffle_settings', function (Blueprint $table): void {
            $table->dropColumn(['font_family', 'font_color', 'font_size', 'ribbon_text', 'thanks_text']);
        });
    }
};
