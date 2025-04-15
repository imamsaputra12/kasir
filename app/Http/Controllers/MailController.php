<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestEmail()
    {
        Mail::raw('Testing email', function ($message) {
            $message->to('recipient@example.com')->subject('Test Email');
        });

        return "Email berhasil dikirim!";
    }
}
