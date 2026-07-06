<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnquiryReceived;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    //

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'service' => 'required|string|max:255',
        ]);

        $enquiry = Enquiry::create($validatedData);
        
        $targetEmail = config('mail.admin_address', env('MAIL_ADMIN_ADDRESS'));

        Mail::to($targetEmail)->send(new EnquiryReceived($enquiry));

        return response()->json([
            'message' => 'Enquiry submitted successfully',
            'enquiry' => $enquiry,
        ]);
    }
}
