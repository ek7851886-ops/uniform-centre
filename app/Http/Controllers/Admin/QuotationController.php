<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\QuotationRequest;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', '');
        $search = trim((string) $request->query('q', ''));

        $query = QuotationRequest::with('user', 'product');
        if ($status !== '') {
            $query->where('status', $status);
        }
        if ($search !== '') {
            $query->where(function ($qq) use ($search) {
                $qq->where('quote_number', 'like', "%{$search}%")
                   ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $quotations = $query->latest()->paginate(15)->withQueryString();

        return view('admin.quotations.index', compact('quotations', 'status', 'search'));
    }

    public function show(QuotationRequest $quotation)
    {
        $quotation->load('user', 'product', 'order');

        return view('admin.quotations.show', compact('quotation'));
    }

    public function update(Request $request, QuotationRequest $quotation)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,under_review,quoted,approved,rejected',
            'price_per_unit' => 'nullable|numeric|min:0',
            'embroidery_charges' => 'nullable|numeric|min:0',
            'printing_charges' => 'nullable|numeric|min:0',
            'delivery_charges' => 'nullable|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        $quotation->fill($data);

        if ($quotation->price_per_unit !== null) {
            $quotation->grand_total = $quotation->calculateGrandTotal();
        }

        $quotation->save();

        return back()->with('success', 'Quotation ' . $quotation->quote_number . ' updated.');
    }

    public function convertToOrder(QuotationRequest $quotation)
    {
        abort_unless($quotation->status === 'approved', 400, 'Only approved quotations can be converted to an order.');
        abort_if($quotation->order()->exists(), 400, 'This quotation already has an order.');

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'quotation_id' => $quotation->id,
            'user_id' => $quotation->user_id,
            'total_amount' => $quotation->grand_total ?? $quotation->calculateGrandTotal(),
            'status' => 'order_confirmed',
        ]);

        $order->statusHistory()->create([
            'status' => 'order_confirmed',
            'note' => 'Order created from approved quotation ' . $quotation->quote_number . '.',
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order ' . $order->order_number . ' created.');
    }
}
