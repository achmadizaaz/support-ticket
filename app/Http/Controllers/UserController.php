<?php

namespace App\Http\Controllers;

use App\Exports\TemplateUserExport;
use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Imports\UserImport;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class UserController extends Controller
{

    protected $model, $role, $homebase;

    public function __construct(User $user, Role $role, Unit $homebase)
    {
        $this->model = $user;
        $this->role = $role;
        $this->homebase = $homebase;
    }

    public function index(Request $request)
    {
        $showPage = Session::get('showPageUsers');
        $users = $this->model->latest()->filter(request(['search']))->paginate( $showPage ?? 10);
        $trashed = $this->model->onlyTrashed()->count();
        return view('users.index', compact('users', 'trashed'));
    }

    public function create()
    {
        $roles = $this->role->all();
        $homebases = $this->homebase->all();
        return view('users.create', compact('roles', 'homebases'));
    }

    public function store(UserRequest $request)
    {
        // dd($request->homebase);
        try{
            DB::beginTransaction();
            $image = NULL;
            // Jika terdapat upload file image
            if($request->image){
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $fileNameToStore = time().'-'.$filenameWithExt;
                $image = $request->file('image')->storeAs('users/images', $fileNameToStore, 'public');
            }
            
            // Menambahkan data ke database
            $user = $this->model->create([
                'image'    => $image,
                'username' => $request->username,
                'name'     => $request->name,
                'email'    => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_active'=> 1,
                'unit_id'=> $request->homebase,
            ]);

            // Assign role user
            $user->assignRole($request->role);
            DB::commit();
        }catch(\Exception $exception){
            DB::rollBack();
            // Menyimpan log kegagalan sistem
            Log::error($exception->getMessage());
            return back()->withInput($request->all())->with('failed', 'A system error occurred, please try later');
        }

        return to_route('users')->with('success', 'User '.$user->name.' has been successfully added!');
    }

    public function show($slug)
    {
        return view('users.show', ['user' => $this->model->with(['homebase'])->where('slug', $slug)->first()]);
    }
    public function edit($slug)
    {
        // Get user
        $user = $this->model->where('slug', $slug)->first();
        // Get all roles
        $roles = $this->role->all();
        $homebases = $this->homebase->all();

        return view('users.edit', compact('user', 'roles', 'homebases'));
    }

    public function update(UserRequest $request, $id)
    {
        try{
            $user = $this->model->findOrFail($id);
            $image = $user->image;
            // Jika terdapat file upload image
            // Update image 
            if(isset($request->image)){
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $fileNameToStore = time().'-'.$filenameWithExt;
                $image = $request->file('image')->storeAs('users/images', $fileNameToStore, 'public');

                // Menghapus image user lama
                // Jika user memiliki image sebelumnya
                if(isset($user->image)){
                    Storage::disk('public')->delete($user->image);
                }
            }
            // Update data user
            $user->update([ 
                'image' => $image,
                'name' => $request->name,
                'email' => $request->email,
                'unit_id' => $request->homebase,
                'is_active' => $request->is_active,
            ]);

            // Change role user
            $user->syncRoles($request->role);

        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return to_route('users.show', $user->slug)->with('failed', 'A system error occurred, please try later');
        }
        return to_route('users.show', $user->slug)->with('success', $user->name.' user data has been successfully updated!');
    }

    public function destroy(Request $request, $id)
    {
        $user = $this->model->findOrFail($id);
        // Check confirmation
        if($user->username != $request->confirm){
            return back()->with('failed', 'Confirmation code to remove the user is incorrect');
        }

        // Check level role user
        if(Auth::user()->roles()->max('level') < $user->roles()->max('level')){
            return  back()->with('failed', 'Users cannot be deleted, because the user is of a higher level.');
        }

        // Remove user
        $user->delete();

        return to_route('users')->with('success',' The user has been successfully deleted!');
    }

    public function changePassword(UserChangePasswordRequest $request, $id)
    {
        try{
            // Get user
            $user = $this->model->findOrFail($id);
            // Update password user
            $user->update([
                'password' => Hash::make($request->change_password),
            ]);
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('failed', 'A system error occurred, please try later');
        }

        return back()->with('success', $user->name.' user password has been updated!');
    }

    public function showPage(Request $request)
    {
        // Add session show page users
        Session::put('showPageUsers', $request->show);
        return back();
    }

    public function trashed(Request $request)
    {
        $trashed = $this->model->onlyTrashed()->filter(request(['search']))->paginate( $showPage ?? 10);
        return view('users.trashed', compact('trashed'));
    }

    // Restore all users
    public function restoreAll()
    {
        $this->model->onlyTrashed()->restore();

        return back()->with('success', 'All user data has been successfully recovered');
    }

    // Restore user
    public function trashRestore($id)
    {
        $user = $this->model->withTrashed()->find($id);
        $user->restore();

        return back()->with('success', 'User has been successfully recovered');
    }

    // Remove permanent all users
    public function forceDeleteAll()
    {
        $this->model->onlyTrashed()->forceDelete();

        return back()->with('success', 'All user data has been successfully permanent deleted');
    }

    // Remove permanent user
    public function forceDelete($id)
    {
        $user = $this->model->withTrashed()->find($id);
        $user->forceDelete();

        return back()->with('success', 'User has been successfully permanent deleted');
    }

    public function import(Request $request)
    {
        try{
            Excel::import(new UserImport, $request->file('file'));
        }catch(ValidationException $exception){
            Log::error($exception->getMessage());
            return back()->with('failed', $exception->getMessage());
        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('failed', $exception->getMessage());
        }
        return back()->with('success', 'Import user berhasil dilakukan!');
    }
    
    public function downloadTemplateUserExport()
    {
        return Excel::download(new TemplateUserExport, now().'-Template import user.xlsx');
    }

    // End User Controller
}
