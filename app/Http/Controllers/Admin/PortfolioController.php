<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::latest()->get();

        return view('admin.portfolio.index', compact('items'));
    }

    public function create()
    {
        return view('admin.portfolio.form', ['item' => null, 'categories' => PortfolioItem::categories()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['image_path'] = $request->file('image')->store('portfolio', 'public');

        PortfolioItem::create($data);

        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio item added.');
    }

    public function edit(PortfolioItem $portfolio)
    {
        return view('admin.portfolio.form', ['item' => $portfolio, 'categories' => PortfolioItem::categories()]);
    }

    public function update(Request $request, PortfolioItem $portfolio)
    {
        $data = $this->validateData($request, false);
        if ($request->hasFile('image')) {
            if ($portfolio->image_path) {
                Storage::disk('public')->delete($portfolio->image_path);
            }
            $data['image_path'] = $request->file('image')->store('portfolio', 'public');
        }

        $portfolio->update($data);

        return redirect()->route('admin.portfolio.index')->with('success', 'Portfolio item updated.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        if ($portfolio->image_path) {
            Storage::disk('public')->delete($portfolio->image_path);
        }
        $portfolio->delete();

        return back()->with('success', 'Portfolio item removed.');
    }

    private function validateData(Request $request, bool $imageRequired = true): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'description' => 'nullable|string',
            'client_name' => 'nullable|string|max:150',
            'is_active' => 'nullable|boolean',
            'image' => ($imageRequired ? 'required' : 'nullable') . '|image|max:4096',
        ]);
        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active', true);

        return $data;
    }
}
