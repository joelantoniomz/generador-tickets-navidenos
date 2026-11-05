<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
class AuthController extends Controller { public function show(){return view('auth.login');} public function login(Request $r){$data=$r->validate(['email'=>'required|email','password'=>'required|string']); if(!Auth::attempt($data,$r->boolean('remember'))){return back()->withErrors(['email'=>'Credenciales incorrectas.'])->onlyInput('email');} $r->session()->regenerate(); return redirect()->intended('/');} public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('login');} }
