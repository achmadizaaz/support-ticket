<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $collect)
        {
            $user = User::create([
                'id' => strtolower(Str::ulid()),
                'name' => $collect['name'],
                'username' => $collect['username'],
                'slug' => Str::slug($collect['username']),
                'email'=> $collect['email'],
                'password' => Hash::make($collect['password']),
                'is_active' => $collect['is_active'],
                'phone' => $collect['phone'],
                'unit_id' => $collect['homebase'],
            ]);
            $role = Role::find($collect['role_id']);
            $user->assignRole($role);
        }

        // $users = [];
        // foreach ($collection as $collect) 
        // {
        //     $users[] = [
        //         'id' => strtolower(Str::ulid()),
        //         'name' => $collect['name'],
        //         'username' => $collect['username'],
        //         'slug' => Str::slug($collect['username']),
        //         'email'=> $collect['email'],
        //         'password' => Hash::make($collect['password']),
        //         'is_active' => $collect['is_active'],
        //         'unit_id' => $collect['homebase'],
        //     ];
        // }
        // User::insert($users);
    }

    public function rules(): array
    {
        return [
            '*.name'    => 'required',
            '*.username'=> 'required|unique:users,username',
            '*.email'   => 'required|email|unique:users,email',
            '*.password'=> 'required|min:5',
            '*.is_active'=> 'required|numeric|min:0|max:1',
            '*.phone'=> 'nullable|numeric',
            '*.homebase'=> 'nullable|exists:units,id',
        ];
    }
}
