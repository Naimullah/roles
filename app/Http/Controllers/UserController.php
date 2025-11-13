<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddlewaare;
use Illuminate\Routing\Controller\Middleware;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::latest()->paginate(10);
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles=Role::orderBy('name','asc')->get();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'confirmed', 'min:6'],
        'roles' => ['nullable', 'array'],
        'roles.*' => ['exists:roles,id'],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    if (!empty($validated['roles'])) {
        $user->roles()->sync($validated['roles']); // multi checkbox support
    }

    return redirect()->route('users.index')
        ->with('success', 'User created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user=User::findOrFail($id);
        $roles=Role::orderBy('name','asc')->get();
        $hasRoles=$user->roles->pluck('name')->toArray();
        return view('users.edit',compact('user','roles','hasRoles'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user=User::findOrFail($id);
        // dd($user);
        $validatedData=$request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email,'.$id,
          
        ]);
        $user->name=$validatedData['name'];
        $user->email=$validatedData['email'];
        $user->save();
        // Sync roles
        if($request->has('roles')){
            $user->syncRoles($request->input('roles'));
        }else{
            $user->roles()->detach();       
        }
        return redirect()->route('users.index')->with('success','User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully.');  
    }
}
