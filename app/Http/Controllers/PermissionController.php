<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    protected $model;

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function index(Request $request)
    {
        $showPage = Session::get('showPagePermissions');
        $permissions = $this->model->filter(request(['search']))->paginate( $showPage ?? 10);
        return view('permissions.index', compact('permissions'));
    }

    public function showPage(Request $request)
    {
        // Add session show page
        Session::put('showPageRoles', $request->show);
        return back();
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionRequest $request)
    {
        try{
            $this->model->create([
                'name' => $request->name,
            ]);
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->withInput($request->all())->with('failed','Terjadi kesalahan sistem, silakan coba nanti');
        }
        return to_route('permissions')->with('success', 'Permission '.$request->name.', berhasil ditambahkan!');
    }

    public function show($id)
    {
        $permission = $this->model->findOrFail($id);
        return response()->json($permission);
    }

    public function update(PermissionRequest $request, $id)
    {
        try{
            $permission = $this->model->find($id);
            $permission->update([
                'name' => $request->name,
            ]);
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('failed', 'Terjadi kesalahan sistem, silakan coba nanti');
        }

        return back()->with('success', 'Permission berhasil diupdate!');
    }

    public function destroy(Request $request, $id)
    {
        $permission = $this->model->findOrFail($id);
        // Check confirmation deleted
        if($permission->name != $request->confirm){
            return back()->with('failed', 'Konfirmasi penghapusan tidak sesuai');
        }
        $permission->delete();

        return back()->with('success', 'Permission '.$request->confirm.', berhasil dihapus!');
    }
}
