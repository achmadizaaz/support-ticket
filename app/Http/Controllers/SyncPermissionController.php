<?php

namespace App\Http\Controllers;

use App\Http\Requests\SyncPermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $roles = $this->role->whereNotIn('name', ['Super Administrator'])->get();
        return view('sync.index', compact('roles'));
    }
    public function assign(SyncPermissionRequest $request)
    {
        $roles = $this->role->whereNotIn('name', ['Super Administrator'])->get();
        $currentRole = $this->role->findOrFail($request->role);
        $permissions = $this->permission->all();

        return view('sync.assign', compact('roles', 'currentRole', 'permissions'));
    }

    public function store(SyncPermissionRequest $request)
    {
        DB::beginTransaction();
        try{
            $role = $this->role->findOrFail($request->role);
            $role->syncPermissions($request->permission);
            DB::commit();
        }catch(\Exception $exception){
            DB::rollBack();
            Log::error($exception->getMessage());
            return back()->with('failed', 'Terjadi kesalahan pada sistem, silakan hubungi Administrator');
        }
        
        return back()->with('success', 'Sync permission pada role <b>'.$role->name.'</b> telah berhasil!');
    }

}
