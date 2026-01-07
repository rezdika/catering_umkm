<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactReplyNotification;
use App\Notifications\FeedbackReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        return view('admin.pages.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('admin.pages.contacts.show', compact('contact'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'reply_message' => 'required|string'
        ]);

        $contact->update([
            'reply_message' => $request->reply_message,
            'status' => 'replied',
            'replied_at' => now()
        ]);

        // Tentukan jenis notifikasi berdasarkan subjek
        $isFeedback = $this->isFeedback($contact);
        $notificationClass = $isFeedback ? FeedbackReplyNotification::class : ContactReplyNotification::class;
        
        // Kirim notifikasi ke user berdasarkan email
        $user = User::where('email', $contact->email)->first();
        if ($user) {
            $user->notify(new $notificationClass($contact));
        } else {
            // Jika user tidak terdaftar, kirim email langsung
            Notification::route('mail', $contact->email)
                       ->notify(new $notificationClass($contact));
        }

        $messageType = $isFeedback ? 'feedback' : 'pesan';
        return redirect()->back()->with('success', "Balasan {$messageType} berhasil dikirim dan notifikasi telah dikirim ke user");
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Pesan berhasil dihapus');
    }

    private function isFeedback(Contact $contact)
    {
        $feedbackKeywords = ['saran', 'kritik', 'feedback', 'masukan'];
        
        foreach ($feedbackKeywords as $keyword) {
            if (stripos($contact->subject, $keyword) !== false || 
                stripos($contact->message, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }
}