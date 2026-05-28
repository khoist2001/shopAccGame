<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Account;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display listing of accounts with filters & search
     */
    public function index(Request $request)
    {
        $query = Account::where('status', 'available')->with('game');

        // Filter by Game slug
        if ($request->filled('game')) {
            $gameSlug = $request->game;
            $query->whereHas('game', function($q) use ($gameSlug) {
                $q->where('slug', $gameSlug);
            });
        }

        // Filter by Rank
        if ($request->filled('rank')) {
            $query->where('rank', 'LIKE', '%' . $request->rank . '%');
        }

        // Filter by Price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Search title or description
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('rank', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Order and Paginate
        $sort = $request->get('sort', 'latest');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $accounts = $query->paginate(9)->withQueryString();
        $games = Game::all();

        // Get unique ranks across accounts to populate select filter
        $ranks = Account::whereNotNull('rank')->distinct()->pluck('rank');

        // Check if AJAX request, return partial view of card grid for seamless filtering
        if ($request->ajax()) {
            return view('accounts.partials.grid', compact('accounts'))->render();
        }

        return view('accounts.index', compact('accounts', 'games', 'ranks'));
    }

    /**
     * Display specific account details
     */
    public function show($id)
    {
        $account = Account::with('game')->findOrFail($id);
        
        // Related Accounts (same game, available, exclude current)
        $relatedAccounts = Account::where('game_id', $account->game_id)
            ->where('status', 'available')
            ->where('id', '!=', $account->id)
            ->take(4)
            ->get();

        // Check if user has wishlisted this account
        $isWishlisted = false;
        if (Auth::check()) {
            $isWishlisted = Wishlist::where('user_id', Auth::id())
                ->where('account_id', $account->id)
                ->exists();
        }

        return view('accounts.show', compact('account', 'relatedAccounts', 'isWishlisted'));
    }

    /**
     * Toggle wishlist status (AJAX or HTTP)
     */
    public function toggleWishlist($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập để thực hiện.'], 401);
        }

        $userId = Auth::id();
        $account = Account::findOrFail($id);

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('account_id', $account->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Đã xóa khỏi danh sách yêu thích!';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'account_id' => $account->id
            ]);
            $status = 'added';
            $message = 'Đã thêm vào danh sách yêu thích!';
        }

        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Show wishlisted accounts
     */
    public function wishlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $accounts = Auth::user()->wishlistedAccounts()->paginate(9);
        return view('user.wishlist', compact('accounts'));
    }
}
