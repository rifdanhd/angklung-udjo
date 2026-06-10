<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');

        $query = Gallery::ordered();

        if ($type === 'photo') {
            $query->photos();
        } elseif ($type === 'video') {
            $query->videos();
        }

        $galleries = $query->paginate(12);

        return view('gallery.index', compact('galleries', 'type'));
    }
}
