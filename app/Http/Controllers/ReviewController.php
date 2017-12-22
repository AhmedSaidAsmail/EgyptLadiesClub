<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Item;

class ReviewController extends Controller {

    public function index() {
        $reviews = Review::all();
        return view('Admin.AllReviews', ['reviews' => $reviews]);
    }

    public function store(Request $request, $item_id) {
        $item = Item::find($item_id);
        $lastReviews=$item->reviews()->where('confirm',1)->orderBy('created_at','DESC')->limit(3)->get();
        if ($item->remember_token == $request->item_token) {
            return view('Web.20_review_write', ['item' => $item,'lastReviews'=>$lastReviews]);
        }
        throw new \Exception('Opps, something went wrong');
    }

    public function edit(Request $request) {
        $this->validate($request, [
            'item_id' => 'integer|required',
            'overall_rating' => 'integer|required',
            'customer_id'=>'integer|required'
        ]);
        $review = $request->all();
        Review::create($review);
        return redirect()->route('home')->with('reviewSuccess', 'Your_Review_has_been_Submited');
    }

    public function showAll() {
        $reviews = Review::where('confirm', 1)->get();
        return view('Web.allReviews', ['reviews' => $reviews]);
    }



}
