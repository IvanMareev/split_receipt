<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::all(); // Можно добавить фильтрацию, пагинацию и т.д.
         return response()->json(['result' => 'ok']);
    }
}
