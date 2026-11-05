<?php
namespace Database\Seeders;
use App\Models\{User,RaffleSetting}; use Illuminate\Database\Seeder; use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder { public function run(){User::updateOrCreate(['email'=>'admin@portatilesperu.pe'],['name'=>'Administrador','password'=>Hash::make('Cambiar-esta-clave-2026!'),'role'=>'admin']); RaffleSetting::updateOrCreate(['id'=>1],['store_name'=>'Portátiles Perú','minimum_purchase'=>50,'prize'=>'Canasta navideña','draw_date'=>'2026-12-24','accent_color'=>'#0b6b52']);} }
