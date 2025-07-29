<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SplitController extends Controller
{
    public function handle(Request $request)
    {
        return response()->json(['result' => 'ok']);
    }
}
