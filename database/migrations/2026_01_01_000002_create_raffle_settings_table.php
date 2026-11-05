<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){Schema::create('raffle_settings',function(Blueprint $t){$t->id();$t->string('store_name')->default('Portátiles Perú');$t->decimal('minimum_purchase',10,2)->default(50);$t->string('prize')->default('Canasta navideña');$t->date('draw_date');$t->string('accent_color')->default('#0b6b52');$t->timestamps();});} public function down(){Schema::dropIfExists('raffle_settings');} };
