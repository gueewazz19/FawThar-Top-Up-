<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FAQ;
use App\Models\Game;
use App\Models\Promotion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $popularGames = Game::with(['category', 'products'])
            ->where('is_active', true)
            ->take(8)
            ->get();
        $promotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->take(4)
            ->get();
        $faqs = FAQ::where('is_active', true)->orderBy('sort_order', 'asc')->take(6)->get();

        return view('home', compact('categories', 'popularGames', 'promotions', 'faqs'));
    }
}
