<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Events\BidHasCreated;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function index($productId)
    {
        $bids = Bid::whereProductId($productId)->get();

        return response()->json([
            'bids' => $bids,
            'highestBid' => $bids->max('amount')
        ]);
    }

    public function store(Request $request)
    {
        $bid = Bid::create([
            'user_id' => auth()->id(),
            'product_id' => $request->input('productId'),
            'amount' => $request->input('amount'),
        ]);

        broadcast(new BidHasCreated($bid, $request->input('productId')))->toOthers();

        return $bid;
    }
}
