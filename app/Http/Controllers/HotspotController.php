<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotspotRequest;
use App\Models\Hotspot;
use App\Models\User;
use App\Services\RouterOSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use RouterOS\Client;
use RouterOS\Query;

class HotspotController extends Controller
{
    protected $model, $routerOSService;
    public function __construct(Hotspot $model, RouterOSService $routerOSService)
    {
        $this->model = $model;
        $this->routerOSService = $routerOSService;
    }

    public function index()
    {
        $users = User::get();
        return view('hotspots.index', [
            'users' => $users,
            'hotspots' => $this->model->with(['user'])->paginate(10),
            // 'profile_users' => $this->routerOSService->getUserProfileHotspot(),
            // 'userHotspot' => $userHotspot,
        ]);
    }

    public function store(HotspotRequest $request)
    {
        $user = $request->user_id ?? Auth::user()->id;
        $status = $request->status ?? 'pending' ;

        $this->model->create([
            'user_id' => $user,
            'username' => $request->username,
            'password' => $request->password,
            'verify' => json_encode([
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]),
            'status' => $status,
            'user_profile' => $request->user_profile,
        ]);
        return back()->with('success', 'Data hotspot telah berhasil ditambahkan!');
    }

    public function active(Request $request)
    {
        $perPage = Session::get('showPerPage') ?? 20;
        // $read = $this->routerOSService->getHotspotActives();
        $search = $request->get('search', ''); // Ambil query dari form pencarian
        $page = $request->get('page', 1); // Halaman saat ini (default halaman 1)
        // $perPage = 10; // Jumlah item per halaman
        // dd($perPage);
        $routerOSService = new RouterOSService();

        // Panggil service untuk mencari user aktif berdasarkan query
        $actives = $this->routerOSService->getHotspotActives($search, $perPage, $page);
        dd(Cache::get('hotspot_user_actives_' . $search . '_' . $page));

        return view('hotspots.active', compact('actives', 'search'));
    }

    public function showPerPage(Request $request)
    {
        // Add session show page
        Session::put('showPerPage', $request->show);
        return back();
    }

    public function verify(Request $request, $id)
    {
        try{
            $hotspot = $this->model->findOrFail($id);
            // Check user hotspot
            $user = $this->routerOSService->getUserHotspot($hotspot->username);
            // Jika tidak ada user hotspot buat akun user hotspot pada mikrotik
            if(!isset($user) && $request->status == 'approved'){
                $this->routerOSService->createHotspotUser($hotspot->username, $hotspot->password, $hotspot->user_profile);
            }
            $hotspot->update(['status' => $request->status]);
            return back()->with('success', 'Verify data di '.$request->status);
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function logOutUser($id)
    {
        // dd($user);
        $routerOSService = new RouterOSService();
        try {
            // Hapus user active hotspot berdasarkan ID
            $success = $routerOSService->removeHotspotActiveUser($id);
            if ($success) {
                return redirect()->back()->with('success', 'User berhasil dihapus dari active hotspot.');
            } else {
                return redirect()->back()->with('error', 'Gagal menghapus user.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
