<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    protected $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function index(Request $request)
    {
        $showPage = Session::get('showPageRoles');
        $roles = $this->model->latest()->filter(request(['search']))->paginate( $showPage ?? 10);
        return view('roles.index', compact('roles'));
    }

    public function showPage(Request $request)
    {
        // Add session show page
        Session::put('showPageRoles', $request->show);
        return back();
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(RoleRequest $request)
    {
        try{
            $this->model->create([
                'name' => $request->name,
                'level'=> $request->level,
                'guard_name' => 'web',
            ]);
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->withInput($request->all())->with('failed','Terjadi kesalahan sistem, silakan coba nanti');
        }
        return to_route('roles')->with('success', 'Role '.$request->name.', berhasil ditambahkan!');
    }

    public function show($id)
    {
        $role = $this->model->findOrFail($id);
        return response()->json($role);
    }

    public function update(RoleRequest $request, $id)
    {
        try{
            $role = $this->model->find($id);
            $role->update([
                'name' => $request->name,
                'level' => $request->level,
            ]);
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('failed', 'Terjadi kesalahan sistem, silakan coba nanti');
        }

        return back()->with('success', 'Role berhasil diupdate!');
    }

    public function destroy(Request $request, $id)
    {
        $role = $this->model->findOrFail($id);
        // Check confirmation deleted
        if($role->name != $request->confirm){
            return back()->with('failed', 'Konfirmasi penghapusan tidak sesuai');
        }
        $role->delete();

        return back()->with('success', 'Role '.$request->confirm.', berhasil dihapus!');
    }
}
