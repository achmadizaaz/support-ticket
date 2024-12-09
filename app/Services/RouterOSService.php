<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use RouterOS\Client;
use RouterOS\Exceptions\ClientException;
use RouterOS\Query;

class RouterOSService
{
    protected $client;

    public function __construct()
    {
         // Inisialisasi client untuk koneksi ke MikroTik
         try {
            $this->client = new Client([
                'host' => env('MIKROTIK_HOST'),
                'user' => env('MIKROTIK_USER'),
                'pass' => env('MIKROTIK_PASS'),
                'port' => (int) env('MIKROTIK_PORT', 8728), // Port default adalah 8728
            ]);
        } catch (ClientException $e) {
            // Tangani error jika tidak bisa terhubung ke MikroTik
            throw new \Exception('Could not connect to MikroTik: ' . $e->getMessage());
        }
    }

    public function getUserHotspot($user)
    {
        try {
             // Query untuk mengambil semua user active
             $query = (new Query('/ip/hotspot/users/print'))->where('name', $user);
             return  $this->client->query($query)->read();
        } catch (\Exception $e) {
            throw new \Exception('Error fetching hotspot active users: ' . $e->getMessage());
        }
    }

    public function createHotspotUser($username, $password, $profile = 'mahasiswa')
    {
        try {
            // Query untuk menambah user hotspot
            $query = (new Query('/ip/hotspot/user/add'))
                        ->equal('name', $username)
                        ->equal('password', $password)
                        ->equal('profile', $profile);

            $this->client->query($query)->read();
            return true; // Berhasil menambahkan user
        } catch (\Exception $e) {
            // Tangani error jika terjadi
            throw new \Exception('Error creating hotspot user: ' . $e->getMessage());
        }
    }

    public function getUserProfileHotspot()
    {
        try {
            // dd($id);
             // Hapus user dengan id tertentu dari active hotspot
            $query = (new Query('/ip/hotspot/user/profile/print'));
            
            return $this->client->query($query)->read();
        } catch (\Exception $e) {
             // Jika terjadi error, tangani error
            throw new \Exception('Failed to get user profile hotspot: ' . $e->getMessage());
        }
    }

    public function getHotspotActives($search, $perPage = 10, $page = 1)
    {
        // dd(Cache::has('hotspot_user_profiles_' . $search . '_' . $page));
        // return Cache::remember('hotspot_user_actives_' . $search . '_' . $page, 3600, function () use ($search, $perPage, $page) {
            try {
                // Query untuk mengambil semua user active
                $query = (new Query('/ip/hotspot/active/print'));
                $activeUsers = $this->client->query($query)->read();
    
                // Filter berdasarkan query input (username atau address)
                $filteredUsers = array_filter($activeUsers, function ($user) use ($search) {
                    return stripos($user['user'], $search) !== false || stripos($user['address'], $search) !== false;
                });
    
                // Paginasi manual
                $offset = ($page - 1) * $perPage;
                $paginatedData = array_slice($filteredUsers, $offset, $perPage);
    
                // Membuat paginasi
                return new LengthAwarePaginator(
                    $paginatedData, // Data saat ini
                    count($filteredUsers), // Total data
                    $perPage, // Per halaman
                    $page, // Halaman saat ini
                    ['path' => request()->url(), 'query' => request()->query()] // URL untuk pagination
                );
    
            } catch (\Exception $e) {
                throw new \Exception('Error fetching hotspot active users: ' . $e->getMessage());
            }
        // });
       
    }

     // Fungsi untuk menghapus user active hotspot berdasarkan user
     public function removeHotspotActiveUser($id)
     {
        try {
            // dd($id);
             // Hapus user dengan id tertentu dari active hotspot
            $query = (new Query('/ip/hotspot/active/remove'))
                         ->equal('.id', $id);
 
            $this->client->query($query)->read();
            return true; // Berhasil
        } catch (\Exception $e) {
             // Jika terjadi error, tangani error
            throw new \Exception('Failed to remove active hotspot user: ' . $e->getMessage());
        }
    }
}
