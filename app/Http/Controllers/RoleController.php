<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
//   use Spatie\Permission\Models\{Role, Permission};

class RoleController extends Controller
{
 public function index()
    {
        $roles = Role::with('permissions')->orderBy('created_at', 'desc')->get();
        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::orderBy('created_at','ASC')->get();
        return view('roles.create',compact('permissions'));
    }

public function edit($id)
{
    $role = Role::findById($id); // use singular for clarity
    $permissions = Permission::orderBy('created_at', 'ASC')->get();

    // Get the IDs of permissions assigned to this role
    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
}

    public function show($id)
    {
        $roles= Role::findById($id);
        return view('roles.show', compact('roles')); 
    }
    public function destroy($id)
    {
        $role = Role::findById($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        //
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);
        // Permission::create(['name' => $request->name]);
        Role::create(['name' => $validated['name']]);
        if($request->has('permissions')){
            $role = Role::findByName($validated['name']);
            $role->syncPermissions($request->input('permissions'));
        }
         
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        //
    }
    public function update(Request $request, $id)
    {
      $roles = Role::findById($id);
      $validated = $request->validate([
          'name' => 'required|string|max:255|unique:roles,name,'.$id,
      ]);
        $roles->name = $validated['name'];
        $roles->save();
        if($request->has('permissions')){
            $roles->syncPermissions($request->input('permissions'));    
        }  
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        //

    }
    
}
