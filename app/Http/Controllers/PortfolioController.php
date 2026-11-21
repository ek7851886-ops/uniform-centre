<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', '');

        $query = PortfolioItem::active();
        if ($category !== '' && $category !== 'All') {
            $query->where('category', $category);
        }
        $items = $query->latest()->get();
        $categories = array_merge(['All'], PortfolioItem::categories());

        return view('portfolio.index', compact('items', 'categories', 'category'));
    }
}
