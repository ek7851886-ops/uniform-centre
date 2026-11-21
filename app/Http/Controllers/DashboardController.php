<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\QuotationRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pendingQuotations = QuotationRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'under_review', 'quoted'])->count();
        $approvedQuotations = QuotationRequest::where('user_id', $user->id)->where('status', 'approved')->count();
        $activeOrders = Order::where('user_id', $user->id)->where('status', '!=', 'delivered')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'delivered')->count();

        $recentQuotations = QuotationRequest::where('user_id', $user->id)->latest()->take(5)->get();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'user', 'pendingQuotations', 'approvedQuotations', 'activeOrders', 'completedOrders',
            'recentQuotations', 'recentOrders'
        ));
    }
}
