<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable {
    use Notifiable, HasFactory;
    protected $fillable = ['name','email','password','role'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array { return ['password'=>'hashed','email_verified_at'=>'datetime']; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
}
