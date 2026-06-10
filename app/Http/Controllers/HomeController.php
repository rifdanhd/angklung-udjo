<?php
namespace App\Http\Controllers;
use App\Models\Show;
use App\Models\Gallery;
use App\Models\Article;
use App\Models\Testimonial;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\HeroSlide;
use App\Models\Event;

// use Stevebauman\Location\Facades\Location; // COMMENT DULU

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Logika Pelacak Lokasi - DISABLED SEMENTARA
        $ip = '8.8.8.8';
        $location = null; // TEMPORARY FIX
        
        $events = Event::active()->get();

         $slides = HeroSlide::active()->get(); // ← tambah ini
        $upcomingShows = Show::where('is_active', true)
            ->orderBy('id', 'asc')
            ->take(3)
            ->get();
            
        $featuredGallery = Gallery::featured()->ordered()->take(6)->get();
        $latestArticles = Article::published()->latest('published_at')->take(10)->get();
        $testimonials = Testimonial::approved()->recent()->get();
        $featuredProducts = Product::featured()->available()->take(4)->get();
        
        return view('home', compact(
                 'slides',
                 'events',
            'upcomingShows',
            'featuredGallery',
            'latestArticles',
            'testimonials',
            'featuredProducts',
            'location' 
        ));
    }
    
    public function about()
    {
        return view('about');
    }
    
    public function contact()
    {
        return view('contact');
    }
}