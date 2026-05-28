<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Account;

class ApiController extends Controller
{
    /**
     * Get all game categories
     */
    public function games()
    {
        $games = Game::withCount(['accounts' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Fetched game categories successfully',
            'data' => $games
        ]);
    }

    /**
     * Get list of accounts with basic filtering
     */
    public function accounts(Request $request)
    {
        $query = Account::where('status', 'available')->with('game');

        if ($request->filled('game')) {
            $gameSlug = $request->game;
            $query->whereHas('game', function($q) use ($gameSlug) {
                $q->where('slug', $gameSlug);
            });
        }

        if ($request->filled('rank')) {
            $query->where('rank', 'LIKE', '%' . $request->rank . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $accounts = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Fetched accounts successfully',
            'data' => $accounts
        ]);
    }

    /**
     * Get specific account details
     */
    public function showAccount($id)
    {
        $account = Account::with('game')->where('status', 'available')->find($id);

        if (!$account) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account not found or no longer available'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fetched account details successfully',
            'data' => [
                'id' => $account->id,
                'game' => $account->game,
                'title' => $account->title,
                'price' => $account->price,
                'rank' => $account->rank,
                'images' => $account->images,
                'description' => $account->description,
                'created_at' => $account->created_at
            ]
        ]);
    }
}
