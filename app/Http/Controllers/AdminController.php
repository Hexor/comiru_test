<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function me(Request $request)
    {
        return $request->admin;
    }
}
