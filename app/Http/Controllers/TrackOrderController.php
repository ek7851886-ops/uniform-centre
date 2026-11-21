<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index()
    {
        return view('orders.track', ['order' => null, 'notFound' => false]);
    }

    public function track(Request $request)
    {
        $data = $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::with('user', 'quotation')
            ->where('order_number', $data['order_number'])
            ->whereHas('user', fn ($q) => $q->where('email', $data['email']))
            ->first();

        return view('orders.track', [
            'order' => $order,
            'notFound' => $order === null,
        ]);
    }
}
