<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $newsletter = Newsletter::firstOrNew(['email' => $validated['email']]);

        if ($newsletter->exists && $newsletter->is_subscribed) {
            return back()->with('info', 'You are already subscribed to our newsletter.');
        }

        $newsletter->is_subscribed = true;
        $newsletter->subscribed_at = now();
        $newsletter->unsubscribed_at = null;
        $newsletter->save();

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    public function unsubscribe($email): View|RedirectResponse
    {
        $newsletter = Newsletter::where('email', $email)->first();

        if ($newsletter) {
            $newsletter->unsubscribe();

            /** @phpstan-ignore-next-line */
            return view('frontend.newsletter.unsubscribed');
        }

        return redirect()->route('home')->with('error', 'Email not found in our newsletter list.');
    }
}
