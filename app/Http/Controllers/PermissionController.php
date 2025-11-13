<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware() :array
    {
        // return [
        //     new Middleware('permission:view permissions', ['only' => ['index', 'show']]),
        //     new Middleware('permission:create permissions', ['only' => ['create', 'store']]),
        //     new Middleware('permission:edit permissions', ['only' => ['edit', 'update']]),
        //     new Middleware('permission:delete permissions', ['only' => ['destroy']]),

        // ]
        return ['auth'];
    }
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('created_at','DESC')->paginate(10);
        return view('permissions.index',compact('permissions'));
    }
    public function create()
    {
        return view('permissions.create');
    }
    public function edit($id)
    {
        $permissions= Permission::findById($id);

        return view('permissions.edit', compact('permissions'));
    }
    public function show($id)
    {
        // return view('permissions.show', compact('id'));
    }
    public function destroy($id)
    {
        $permission = Permission::findById($id);
        $permission->delete();

        // Logic to delete permission
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);
        Permission::create(['name' => $validated['name']]);

                // Logic to store new permission
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,'.$id,
        ]);
        $permission = Permission::findById($id);
        $permission->name = $validated['name'];
        $permission->save();        

        // Logic to update permission
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');     
    }
}
