<?php
namespace App\Http\Controllers;
use App\Models\{RaffleSetting,TicketBatch};
class DashboardController extends Controller { public function index(){return view('dashboard.index',['setting'=>RaffleSetting::firstOrCreate(['id'=>1],['store_name'=>'Portátiles Perú','minimum_purchase'=>50,'prize'=>'Canasta navideña','draw_date'=>now()->setDate(2026,12,24)]),'batches'=>TicketBatch::latest()->take(5)->get(),'total'=>TicketBatch::sum('quantity'),'users'=>\App\Models\User::latest()->take(5)->get()]);} }
