<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Permission;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

public function dashboard()
{
    $userCount = User::count();
    $doctorCount = Doctor::count();
    $appointmentCount = Booking::count();
    $roleCount = role::count();
    $permissionCount = Permission::count();

    $recentUsers = User::with('roles')->latest()->limit(4)->get();
    $recentAppointments = Booking::with(['user', 'doctor.user'])->latest()->limit(4)->get();

    return view('admin.dashboard', compact(
        'userCount',
        'doctorCount',
        'appointmentCount',
        'roleCount',
        'permissionCount',
        'recentUsers',
        'recentAppointments'
    ));
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
    
    
    $users = User::with('roles')->latest()->paginate(config('site.pagination.default', 10));

    return response()->json($users);

}





public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'Contact_Number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'role_id' => 'nullable|exists:roles,id',
    ]);

    $updateData = $validated;
    unset($updateData['role_id']);

    $user->update($updateData);

    if (isset($validated['role_id'])) {
        $user->roles()->sync([$validated['role_id']]);
    }

    $role = $user->roles()->first();

    if ($role && $role->name == 'doctor'){
        $doctor = Doctor::create([
            'user_id' => $user->id,
        ]);
    }

    return response()->json([
        'message' => 'User details updated successfully',
        'user' => $user->load('roles'),
        'doctor' => isset($doctor) ? $doctor : null,
    ]);
}

public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}

public function createUser(Request $request)
{
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|string|email|max:255|unique:users',
        'password'      => 'required|string|min:8|confirmed',
        'Contact_Number'=> 'required|string|max:20|unique:users,Contact_Number',
        'address'       => 'required|string|max:255',
    ]);

    $user = User::create([
        'name'           => $validated['name'],
        'email'          => $validated['email'],
        'password'       => bcrypt($validated['password']),
        'Contact_Number' => $validated['Contact_Number'],
        'address'        => $validated['address'],
    ]);

    $userRole = role::where('name', 'user')->first();
    if ($userRole) {
        $user->roles()->attach($userRole->id);
    }

    return response()->json([
        'message' => 'User created successfully.',
        'user'    => $user->load('roles'),
    ], 201);
}

public function searchUsers(Request $request)
{
    $query = $request->input('query', '');

    $users = User::with('roles')
                 ->where(function ($q) use ($query) {
                     $q->where('name', 'like', "%{$query}%")
                       ->orWhere('email', 'like', "%{$query}%")
                       ->orWhere('Contact_Number', 'like', "%{$query}%")
                       ->orWhere('address', 'like', "%{$query}%");
                 })
                 ->latest()
                 ->paginate(config('site.pagination.default', 10));

    return response()->json($users);


}


//Roles


public function createRole(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:roles',
        'status' => 'nullable|in:active,inactive',
    ]);

    if (!isset($validated['status'])) {
        $validated['status'] = 'active';
    }

    $role = role::create($validated);

    return response()->json([
        'message' => 'Role created successfully',
        'role' => $role,
    ]);

}

public function editRole(Request $request, $id)
{
    $role = role::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        'status' => 'nullable|in:active,inactive',
        'permissions' => 'nullable|array',
        'permissions.*' => 'integer|exists:permissions,id',
    ]);

    $role->update([
        'name' => $validated['name'],
        'status' => $validated['status'] ?? $role->status,
    ]);

    $role->permissions()->sync($validated['permissions'] ?? []);

    return response()->json([
        'message' => 'Role updated successfully',
        'role' => $role->load('permissions'),
    ]);
}

public function deleteRole($id)
{
    $role = role::findOrFail($id);
    $role->delete();

    return response()->json(['message' => 'Role deleted successfully']);
}

public function Roles(){
    return view('admin.roles');
}

public function getRoles()
{
    $roles = role::with('permissions')->latest()->paginate(config('site.pagination.default', 10));

    return response()->json($roles);
}

public function getRoleOptions()
{
    $roles = role::select('id', 'name')->orderBy('name')->get();

    return response()->json($roles);
}


public function getPermissions()
{
    $permissions = Permission::orderBy('group')->orderBy('name')->get();

    return response()->json($permissions);

}


}