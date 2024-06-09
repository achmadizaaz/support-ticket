<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\AddtionalInformation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    protected $model, $addtionalInformation;

    public function __construct(User $user, AddtionalInformation $addtionalInformation)
    {
        $this->model = $user;
        $this->addtionalInformation = $addtionalInformation;
    }

    public function index()
    {
        $users = $this->model->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
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
            $this->addtionalInformation->create([
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

            DB::commit();
        }catch(\Exception $exception){
            DB::rollBack();
            // Menyimpan log kegagalan sistem
            Log::error($exception->getMessage());
            return back()->withInput($request->all())->with('failed', 'Terjadi kesalahan sistem, silakan coba nanti');
        }

        return to_route('users')->with('success', 'User telah berhasil ditambahkan');
    }

    public function show($slug)
    {
        $this->model->where('slug', $slug)->first();
        return view('users.show', compact('user'));
    }
    public function edit($slug)
    {
        $this->model->where('slug', $slug)->first();
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, $slug)
    {
        try{
            $user = $this->model->where('slug', $slug)->first();
            $image = $user->image;
            // Jika terdapat file upload image
            // Update image 
            if($request->image){
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $filenameWithExt. '-'. time().'.'.$extension;
                $image = $request->file('image')->storeAs('users/images', $fileNameToStore, 'public');

                // Menghapus image user lama
                // Jika user memiliki image sebelumnya
                if($user->image){
                    Storage::delete($user->image);
                }
            }
            // Update data user
            $user->update([ 
                'image' => $image,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'is_active' => $request->is_active,
            ]);
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->withInput($request->all())->with('failed', 'Terjadi kesalahan sistem, silakan coba nanti');
        }
        return to_route('users.show', $slug)->with('success', 'Data user berhasil diupdate!');
    }

    public function destroy($slug)
    {
        $user = $this->model->where('slug', $slug)->first();
        $user->delete();

        return to_route('users')->with('success',' User telah berhasil dihapus!');
    }

    public function changePassword(UserRequest $request, $slug)
    {
        try{
            $user = $this->model->where('slug', $slug)->first();
            // Update password user
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('failed', 'Terjadi kesalahan sistem, silakan coba nanti');
        }

        return back()->with('success', 'Katasandi berhasil diupdate!');
    }

    // End User Controller
}
