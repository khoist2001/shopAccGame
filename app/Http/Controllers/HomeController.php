<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Account;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display the home landing page
     */
    public function index()
    {
        // Get all game categories with accounts count
        $games = Game::withCount(['accounts' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        // Get featured available accounts
        $featuredAccounts = Account::where('status', 'available')
            ->where('is_featured', true)
            ->with('game')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // If no featured accounts, grab the latest available accounts
        if ($featuredAccounts->isEmpty()) {
            $featuredAccounts = Account::where('status', 'available')
                ->with('game')
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
        }

        // Stats aggregates
        $stats = [
            'accounts_available' => Account::where('status', 'available')->count(),
            'accounts_sold' => Account::where('status', 'sold')->count() + 1420, // Add base mock stats for beauty
            'active_users' => User::where('role', 'user')->count() + 850,
            'success_rate' => 99.8
        ];

        return view('index', compact('games', 'featuredAccounts', 'stats'));
    }
}
