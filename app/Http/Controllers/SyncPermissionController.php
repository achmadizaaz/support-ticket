<?php

namespace App\Http\Controllers;

use App\Http\Requests\SyncPermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class SyncPermissionController extends Controller
{
    protected $role, $permission;
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }
    public function index()
    {
        $roles = $this->role->latest()->get();
        return view('sync.index', compact('roles'));
    }
    public function assign(Request $request)
    {
        $roles = $this->role->latest()->get();
        $role = $this->role->findOrFail($request->role);
        return view('sync.assign', compact('roles', 'role'));
    }

    public function create($role){
        $role = $this->role->find($role);
        $permissions = $this->permission->get();

        return view('sync.create', compact('role', 'permissions'));
    }

    public function store(SyncPermissionRequest $request, $role)
    {
        $role = $this->role->find($role);

        $role->syncPermissions($request->permissions);

        return to_route('sync.permissions')->with('success', 'Sync permission role telah berhasil!');
    }

}
