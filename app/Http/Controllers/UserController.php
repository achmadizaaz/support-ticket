<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\AdditionalInformation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    protected $model, $additionalInformation, $role;

    public function __construct(User $user, AdditionalInformation $additionalInformation, Role $role)
    {
        $this->model = $user;
        $this->additionalInformation = $additionalInformation;
        $this->role = $role;
    }

    public function index()
    {
        $users = $this->model->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->role->all();
        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try{
            DB::beginTransaction();
            $image = NULL;
            // Jika terdapat upload file image
            if($request->image){
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $filenameWithExt. '-'. time().'.'.$extension;
                $image = $request->file('image')->storeAs('users/images', $fileNameToStore, 'public');
            }
            
            // Menambahkan data ke database
            $user = $this->model->create([
                'image'    => $image,
                'username' => $request->username,
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'is_active'=> $request->is_active,
            ]);

            // Relation addtional informasi user
            $this->additionalInformation->create([
                'user_id'   => $user->id,
                'phone'     => $request->phone,
                'mobile'    => $request->mobile,
                'country'   => $request->country,
                'address'   => $request->address,
                'bio'       => $request->bio,
                'website'   => $request->website,
                'instagram' => $request->instagram,
                'facebook'  => $request->facebook,
                'twitter'   => $request->twitter,
                'youtube'   => $request->youtube,
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
        return view('users.show', ['user' => $this->model->where('slug', $slug)->first()]);
    }
    public function edit($slug)
    {
        // Get user
        $user = $this->model->where('slug', $slug)->first();
        // Get all roles
        $roles = $this->role->all();

        return view('users.edit', compact('user', 'roles'));
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
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $filenameWithExt. '-'. time().'.'.$extension;
                $image = $request->file('image')->storeAs('users/images', $fileNameToStore, 'public');

                // Menghapus image user lama
                // Jika user memiliki image sebelumnya
                if(isset($user->image)){
                    Storage::delete($user->image);
                }
            }
            // Update data user
            $user->update([ 
                'image' => $image,
                'name' => $request->name,
                'is_active' => $request->is_active,
            ]);

            // Update or create additional information user
            $this->additionalInformation->updateOrInsert(
                ['user_id'  => $user->id],
                ['phone'    => $request->phone,
                'mobile'    => $request->mobile,
                'country'   => $request->country,
                'address'   => $request->address,
                'bio'       => $request->bio,
                'website'   => $request->website,
                'instagram' => $request->instagram,
                'facebook'  => $request->facebook,
                'twitter'   => $request->twitter,
                'youtube'   => $request->youtube,
                'updated_at'=> now(),]
            );
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

        // Remove image user
        if(isset($user->image)){
            Storage::delete($user->image);
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

    // End User Controller
}
