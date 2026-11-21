<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\QuotationRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalQuoteRequests = QuotationRequest::count();
        $pendingQuotes = QuotationRequest::whereIn('status', ['pending', 'under_review'])->count();
        $approvedQuotes = QuotationRequest::where('status', 'approved')->count();
        $activeOrders = Order::where('status', '!=', 'delivered')->count();
        $completedOrders = Order::where('status', 'delivered')->count();
        $totalProducts = Product::count();
        $totalClients = Client::count();
        $unreadMessages = ContactMessage::where('is_read', false)->count();

        $recentQuotations = QuotationRequest::latest()->take(6)->get();

        $quotesLast7Days = QuotationRequest::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')->orderBy('day')->get();

        return view('admin.dashboard', compact(
            'totalCustomers', 'totalQuoteRequests', 'pendingQuotes', 'approvedQuotes',
            'activeOrders', 'completedOrders', 'totalProducts', 'totalClients',
            'unreadMessages', 'recentQuotations', 'quotesLast7Days'
        ));
    }
}
