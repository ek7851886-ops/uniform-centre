<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->get();

        return view('admin.messages.index', compact('messages'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);

        return back();
    }
}
