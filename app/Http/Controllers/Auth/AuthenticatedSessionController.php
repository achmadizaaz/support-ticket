<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $clientIp = $this->getIpClient($request);

        $request->user()->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $clientIp,
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Get ip address user login.
     */
    public function getIpClient($request)
    {
        $clientIp = $request->getClientIp();
        // Jika server menggunakan reverse proxy
        $reserveProxy = $request->header('X-Forwarded-For');
        // Cek jika terdapat reserve proxy
       	if(isset($reserveProxy)){
            // Membagi header jika terdapat beberapa alamat IP dan mengambil yang pertama
            $ipReserveProxy = explode(',', $reserveProxy);
            // Mengambil alamat IP pertama
            $clientIp = trim($ipReserveProxy[0]); 
        }
        return $clientIp;
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
