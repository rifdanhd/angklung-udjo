<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index()
    {
        $shows = Show::where('is_active', true)
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->paginate(12);

        return view('shows.index', compact('shows'));
    }

    public function show(Show $show)
    {
        return view('shows.show', compact('show'));
    }
}
