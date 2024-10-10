<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $units = Unit::whereNotIn('id', [1])->get();
        return view('auth.register', compact('units'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'username' => ['required', 'string', 'min:13', 'max:13', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'numeric', 'digits_between:8,14' ],
            'program_studi' => ['required', 'exists:units,slug'],
        ]);

        $unit = Unit::where('slug', $request->program_studi)->first();

        $options = Option::whereIn('name', ['default-role', 'default-is-active'])->get()->keyBy('name');

        // String yang berisi angka
        $codeNIMProdi = substr($request->username, 2, 5); 
        
        if($unit->code != $codeNIMProdi){
            return back()->withInput($request->all())->with('failed', 'Pendaftaran akun gagal, terdapat data yang tidak sesuai');
        }

        $user = User::create([
            'unit_id' => $unit->id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_active' => isset($options['default-is-active']->value),
        ]);

        
        // Assign role user
        if(isset($options['default-role']->value)){
            $user->syncRoles($options['default-role']->value);
        }
        
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
