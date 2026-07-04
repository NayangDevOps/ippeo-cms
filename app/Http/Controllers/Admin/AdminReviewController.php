<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user']);

        if ($request->filled('status')) {
            $isApproved = $request->status === 'approved';
            $query->where('is_approved', $isApproved);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => ! $review->is_approved]);
        /** @var Product $product */
        $product = $review->product;
        $product->updateRating();

        return back()->with('success', 'Review status updated.');
    }

    public function destroy(Review $review)
    {
        /** @var Product $product */
        $product = $review->product;
        $review->delete();
        $product->updateRating();

        return back()->with('success', 'Review deleted successfully.');
    }
}
