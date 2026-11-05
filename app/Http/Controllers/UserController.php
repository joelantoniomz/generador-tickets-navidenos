<?php
namespace App\Http\Controllers;
use App\Models\User; use Illuminate\Http\Request;
class UserController extends Controller { public function index(){return view('users.index',['users'=>User::latest()->paginate(15)]);} public function store(Request $r){$data=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email','password'=>'required|string|min:12','role'=>'required|in:admin,operator']);User::create($data);return back()->with('success','Usuario creado.');} }
