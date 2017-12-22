<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Auth;

class ReviewsController extends Controller {

    public function index() {
        $reveiws = Auth::guard('supplier')->user()->reviews;
        return view('Supplier.Reviews_all', ['reviews' => $reveiws]);
    }

    public function show($id) {
        $review = Review::find($id);
        return view('Supplier.Reviews_one', ['review' => $review]);
    }



}
