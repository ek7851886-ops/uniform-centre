<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\QuotationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    const SIZE_OPTIONS = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

    public function create(Request $request)
    {
        $categories = Category::active()->orderBy('name')->get();
        $products = Product::active()->orderBy('name')->get();
        $selectedProduct = $request->filled('product_id') ? Product::find($request->query('product_id')) : null;

        return view('quotations.create', [
            'categories' => $categories,
            'products' => $products,
            'selectedProduct' => $selectedProduct,
            'sizeOptions' => self::SIZE_OPTIONS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:150',
            'contact_person' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'company_address' => 'nullable|string',

            'product_id' => 'nullable|exists:products,id',
            'category' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:1',
            'preferred_fabric' => 'nullable|string|max:100',
            'preferred_color' => 'nullable|string|max:100',

            'sizes' => 'nullable|array',
            'sizes.*' => 'nullable|integer|min:0',
            'custom_size_label' => 'nullable|string|max:60',
            'custom_size_qty' => 'nullable|integer|min:0',

            'logo_required' => 'nullable|in:yes,no',
            'logo' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:5120',
            'embroidery_required' => 'nullable|in:yes,no',
            'printing_required' => 'nullable|in:yes,no',
            'reflective_strips_required' => 'nullable|in:yes,no',
            'name_embroidery_required' => 'nullable|in:yes,no',
            'additional_requirements' => 'nullable|string',

            'required_delivery_date' => 'nullable|date',
            'delivery_city' => 'nullable|string|max:80',
            'delivery_address' => 'nullable|string',
        ]);

        $sizes = collect($data['sizes'] ?? [])->filter(fn ($qty) => (int) $qty > 0)->all();
        if (!empty($data['custom_size_label']) && (int) ($data['custom_size_qty'] ?? 0) > 0) {
            $sizes['Custom: ' . $data['custom_size_label']] = (int) $data['custom_size_qty'];
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('quote-logos', 'public');
        }

        $quotation = QuotationRequest::create([
            'quote_number' => QuotationRequest::generateQuoteNumber(),
            'user_id' => Auth::id(),
            'product_id' => $data['product_id'] ?? null,
            'company_name' => $data['company_name'],
            'contact_person' => $data['contact_person'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'company_address' => $data['company_address'] ?? null,
            'category' => $data['category'] ?? null,
            'quantity' => $data['quantity'],
            'preferred_fabric' => $data['preferred_fabric'] ?? null,
            'preferred_color' => $data['preferred_color'] ?? null,
            'sizes' => $sizes,
            'logo_required' => ($data['logo_required'] ?? 'no') === 'yes',
            'logo_path' => $logoPath,
            'embroidery_required' => ($data['embroidery_required'] ?? 'no') === 'yes',
            'printing_required' => ($data['printing_required'] ?? 'no') === 'yes',
            'reflective_strips_required' => ($data['reflective_strips_required'] ?? 'no') === 'yes',
            'name_embroidery_required' => ($data['name_embroidery_required'] ?? 'no') === 'yes',
            'additional_requirements' => $data['additional_requirements'] ?? null,
            'required_delivery_date' => $data['required_delivery_date'] ?? null,
            'delivery_city' => $data['delivery_city'] ?? null,
            'delivery_address' => $data['delivery_address'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('quotations.success', $quotation);
    }

    public function success(QuotationRequest $quotation)
    {
        return view('quotations.success', compact('quotation'));
    }

    public function myIndex()
    {
        $quotations = QuotationRequest::where('user_id', Auth::id())->latest()->get();

        return view('quotations.index', compact('quotations'));
    }

    public function show(QuotationRequest $quotation)
    {
        abort_unless($quotation->user_id === Auth::id(), 403);

        return view('quotations.show', compact('quotation'));
    }

    public function approve(QuotationRequest $quotation)
    {
        abort_unless($quotation->user_id === Auth::id(), 403);
        abort_unless($quotation->status === 'quoted', 400);

        $quotation->update(['status' => 'approved']);

        return back()->with('success', 'Quotation approved. Our team will convert this to an order shortly.');
    }

    public function reject(QuotationRequest $quotation)
    {
        abort_unless($quotation->user_id === Auth::id(), 403);
        abort_unless($quotation->status === 'quoted', 400);

        $quotation->update(['status' => 'rejected']);

        return back()->with('info', 'Quotation rejected.');
    }
}
