<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

public function dashboard(){
    return view('admin.dashboard');
    //
}

public function viewUsers(){

    return view('admin.users');
}

public function countUsers(){
    $userCount = User::count();
    return response()->json(['userCount' => $userCount]);

}

public function countRoles(){ 
    $roleCount = role::count();
    return response()->json(['roleCount' => $roleCount]);

}

public function getUsers(){
    
    
    $users = User::latest()->paginate(env('PAGINATION_VALUE', 10)); // Default to 10 if PAGINATION_VALUE is not setENV

    return response()->json($users);

}

public function assignRole(Request $request, $userId)
{
    $user = User::findOrFail($userId);
    $role = $request->input('role');
    
    $user->assignRole($role);

    return response()->json(['message' => 'Role assigned successfully']);

}



public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'Contact_Number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ]);

    $user->update($validated);

    return response()->json([
        'message' => 'User details updated successfully',
        'user' => $user,
    ]);
}

public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);

}

public function searchUsers(Request $request)
{
    $query = $request->input('query', '');

    $users = User::where(function ($q) use ($query) {
                     $q->where('name', 'like', "%{$query}%")
                       ->orWhere('email', 'like', "%{$query}%")
                       ->orWhere('Contact_Number', 'like', "%{$query}%")
                       ->orWhere('address', 'like', "%{$query}%");
                 })
                 ->latest()
                 ->paginate(env('PAGINATION_VALUE_SEARCH', 2)); // Default to 2 if PAGINATION_VALUE_SEARCH is not setENV

    return response()->json($users);

}



}