<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Import library pelacak lokasi

class BudayaController extends Controller
{
    public function index(Request $request) {
    return view('welcome', ['location' => null]);
}
}


