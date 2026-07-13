<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UserProfile extends Controller
{
     public function viewprofile(){

        $user = auth()->user();        
        $bookings = $user->bookings;
        $prescriptions = $user->prescriptions;

        return view('user.profile', compact('user', 'bookings', 'prescriptions'));
        
    }

    public function updateprofile(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'Contact_Number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

}
