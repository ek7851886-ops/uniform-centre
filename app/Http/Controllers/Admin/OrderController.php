<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', '');

        $query = Order::with('user');
        if ($status !== '') {
            $query->where('status', $status);
        }
        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'quotation.product', 'statusHistory');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', Order::statusSteps()),
            'expected_delivery_date' => 'nullable|date',
            'internal_notes' => 'nullable|string',
            'status_note' => 'nullable|string',
        ]);

        $statusChanged = $order->status !== $data['status'];

        $order->update([
            'status' => $data['status'],
            'expected_delivery_date' => $data['expected_delivery_date'] ?? $order->expected_delivery_date,
            'internal_notes' => $data['internal_notes'] ?? $order->internal_notes,
            'delivered_at' => $data['status'] === 'delivered' ? now() : $order->delivered_at,
        ]);

        if ($statusChanged) {
            $order->statusHistory()->create([
                'status' => $data['status'],
                'note' => $data['status_note'] ?? null,
            ]);
        }

        return back()->with('success', 'Order ' . $order->order_number . ' updated.');
    }
}
