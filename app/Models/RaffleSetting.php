<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RaffleSetting extends Model { protected $fillable=['store_name','minimum_purchase','prize','draw_date','accent_color','show_draw_date','date_replacement','logo_path','prize_image_path','font_family','font_color','font_size','ribbon_text','thanks_text']; protected $casts=['draw_date'=>'date','minimum_purchase'=>'decimal:2','show_draw_date'=>'boolean']; }
