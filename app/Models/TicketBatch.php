<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TicketBatch extends Model { protected $fillable=['user_id','start_number','end_number','quantity','per_sheet','file_pdf','file_docx']; public function user(){return $this->belongsTo(User::class);} public function getTotalAttribute(){return $this->end_number-$this->start_number+1;} }
