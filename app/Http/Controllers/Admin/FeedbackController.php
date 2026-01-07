<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        // Filter pesan yang berisi kata kunci feedback/saran/kritik
        $feedbacks = Contact::where(function($query) {
                                $query->where('subject', 'like', '%saran%')
                                      ->orWhere('subject', 'like', '%kritik%')
                                      ->orWhere('subject', 'like', '%feedback%')
                                      ->orWhere('subject', 'like', '%masukan%')
                                      ->orWhere('message', 'like', '%saran%')
                                      ->orWhere('message', 'like', '%kritik%');
                            })
                           ->latest()
                           ->paginate(15);
        
        return view('admin.pages.feedbacks.index', compact('feedbacks'));
    }
}