<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class AdminContactInquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactInquiry::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contactInquiries = $query->latest()->paginate(15);

        return view('admin.contact-inquiries.index', compact('contactInquiries'));
    }

    public function show(ContactInquiry $contactInquiry)
    {
        if ($contactInquiry->status === 'new') {
            $contactInquiry->markAsRead();
        }

        return view('admin.contact-inquiries.show', compact('contactInquiry'));
    }

    public function markRead(ContactInquiry $contactInquiry)
    {
        $contactInquiry->markAsRead();

        return back()->with('success', 'Inquiry marked as read.');
    }

    public function markReplied(ContactInquiry $contactInquiry)
    {
        $contactInquiry->markAsReplied();

        return back()->with('success', 'Inquiry marked as replied.');
    }

    public function destroy(ContactInquiry $contactInquiry)
    {
        $contactInquiry->delete();

        return redirect()->route('admin.contact-inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
