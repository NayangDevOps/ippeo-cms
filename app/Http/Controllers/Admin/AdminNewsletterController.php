<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminNewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = Newsletter::query();

        if ($request->filled('subscription')) {
            $query->where('is_subscribed', $request->subscription === 'subscribed');
        }

        $newsletters = $query->latest('subscribed_at')->paginate(15);

        return view('admin.newsletters.index', compact('newsletters'));
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return back()->with('success', 'Newsletter subscriber deleted successfully.');
    }

    public function export()
    {
        $newsletters = Newsletter::where('is_subscribed', true)
            ->get(['email', 'subscribed_at']);

        $csv = "Email,Subscribed At\n";
        foreach ($newsletters as $newsletter) {
            $csv .= "{$newsletter->email},{$newsletter->subscribed_at}\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter-subscribers.csv"',
        ]);
    }
}
