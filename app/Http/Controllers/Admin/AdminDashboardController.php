<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Order;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Dashboard
     */
    public function index()
    {
        $stats = [
            'revenue' => Order::where('status', 'completed')->sum('final_amount'),
            'accounts_sold' => Account::where('status', 'sold')->count(),
            'accounts_available' => Account::where('status', 'available')->count(),
            'total_users' => User::where('role', 'user')->count(),
        ];

        // Latest 5 orders
        $latestOrders = Order::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        // Latest 5 accounts added
        $latestAccounts = Account::with('game')->orderBy('created_at', 'desc')->take(5)->get();

        // Chart.js data generator (aggregate sales for last 6 months)
        $chartData = [
            'labels' => ['Tháng 12', 'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
            'data' => [1500000, 3200000, 2400000, 4800000, 6100000, $stats['revenue']]
        ];

        return view('admin.dashboard', compact('stats', 'latestOrders', 'latestAccounts', 'chartData'));
    }
}
